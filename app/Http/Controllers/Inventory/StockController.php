<?php

namespace App\Http\Controllers\Inventory;

use App\Models\supplier;
use App\Models\StockLevel;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\ReceiveOrder;
use App\Models\StockTransaction;
use App\Models\ReceiveOrderItem;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    
    public function index()
    {
        $stockIns = StockTransaction::with(['item', 'supplier'])
            ->where('transaction_type', 'stock_in')
            ->latest()
            ->paginate(10);

        return view('employee.stock.stock_in_index', compact('stockIns'));
    }
    
    public function stockOutIndex()
    {
        $stockOuts = StockTransaction::with('item')
            ->where('transaction_type', 'stock_out')
            ->latest()
            ->paginate(10);

        return view('employee.stock.stock_out_index', compact('stockOuts'));
    }


    public function stockInForm(Request $request)
    {
        $items = InventoryItem::all();  // Get all inventory items
        $suppliers = supplier::all();  // Get all suppliers

        $receiveOrders = ReceiveOrder::with('supplier')->where('status', '!=', 'complete')->get();
        $selectedOrder = null;

        if ($request->has('receive_order_id')) {
            $selectedOrder = ReceiveOrder::with(['supplier', 'items.inventoryItem'])
                                ->find($request->receive_order_id);
        }
    
        return view('employee.stock.stock_in', compact('items', 'suppliers', 'receiveOrders', 'selectedOrder'));
    }

    public function stockIn(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:inventory_items,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        \DB::beginTransaction();

        try {
            $stockTransaction = StockTransaction::create([
                'item_id' => $request->item_id,
                'supplier_id' => $request->supplier_id,
                'transaction_type' => 'stock_in',
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);

            $stockLevel = StockLevel::where('item_id', $request->item_id)->first();

            if ($stockLevel) {
                $stockLevel->quantity += $request->quantity;
            } else {
                $stockLevel = StockLevel::create([
                    'item_id' => $request->item_id,
                    'quantity' => $request->quantity,
                ]);
            }

            $item = InventoryItem::where('id', $request->item_id)->first();

            if ($item) {
                $item->quantity += $request->quantity;
            } else {
                throw new \Exception("Inventory item not found.");
            }

            $stockLevel->save();
            $item->save();

            \DB::commit();

            return redirect()->route('employee.stock-in.form')->with('success', 'Stock-in successful!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('stock-in.form')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function stockInFromReceiveOrderForm(Request $request)
    {
        $receiveOrders = ReceiveOrder::with('supplier')->whereIn('status', ['pending', 'approved', 'received'])->get();

        $selectedOrder = null;
        if ($request->receive_order_id) {
            $selectedOrder = ReceiveOrder::with(['supplier', 'items.inventoryItem'])
                                ->findOrFail($request->receive_order_id);
        }

        return view('employee.stock.stock_in', [
            'receiveOrders' => $receiveOrders,
            'receiveOrder' => $selectedOrder
        ]);
    }

    public function stockInFromReceiveOrderSubmit(Request $request, $receiveOrderId)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:receive_order_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        \DB::beginTransaction();

        try {
            $receiveOrder = ReceiveOrder::findOrFail($receiveOrderId);

            foreach ($request->items as $itemData) {
                $roItem = ReceiveOrderItem::findOrFail($itemData['id']);
                $quantityToStockIn = (int) $itemData['quantity'];

                $stockLevel = StockLevel::firstOrNew(['item_id' => $roItem->item_id]);
                $stockLevel->quantity += $quantityToStockIn;
                $stockLevel->save();

                $item = InventoryItem::findOrFail($roItem->item_id);
                $item->quantity += $quantityToStockIn;
                $item->save();

                StockTransaction::create([
                    'item_id' => $roItem->item_id,
                    'supplier_id' => $receiveOrder->supplier_id,
                    'transaction_type' => 'stock_in',
                    'quantity' => $quantityToStockIn,
                    'price' => $roItem->unit_price,
                ]);

                $roItem->stocked_in_quantity += $quantityToStockIn;
                $roItem->save();
            }

            $allStockedIn = $receiveOrder->items->every(function ($item) {
                return $item->stocked_in_quantity >= $item->quantity;
            });

            if ($allStockedIn) {
                $receiveOrder->status = 'received';
                $receiveOrder->save();
            }

            \DB::commit();
            return redirect()->route('employee.stock-in.form')->with('success', 'Stock-in completed.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function stockOutForm()
    {
        $items = InventoryItem::all();
        return view('employee.stock.stock_out', compact('items'));
    }

    public function stockOutSubmit(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        \DB::beginTransaction();
        try {
            $item = InventoryItem::findOrFail($request->item_id);
            $stockLevel = StockLevel::where('item_id', $item->id)->first();

            if (!$stockLevel || $stockLevel->quantity < $request->quantity) {
                throw new \Exception("Insufficient stock.");
            }

            $stockLevel->quantity -= $request->quantity;
            $item->quantity -= $request->quantity;
            $stockLevel->save();
            $item->save();

            StockTransaction::create([
                'item_id' => $item->id,
                'supplier_id' => null,
                'transaction_type' => 'stock_out',
                'quantity' => $request->quantity,
                'price' => null,
                'reason' => $request->reason,
            ]);

            \DB::commit();
            return redirect()->route('employee.stock-out.form')->with('success', 'Stock-out successful.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
