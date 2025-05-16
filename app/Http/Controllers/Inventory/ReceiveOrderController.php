<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\ReceiveOrder;
use App\Models\ReceiveOrderItem;
use App\Http\Controllers\Controller;

class ReceiveOrderController extends Controller
{
    public function index()
    {
        $receiveOrders = ReceiveOrder::with('supplier')->latest()->paginate(8);
        return view('employee.ReceiveOrder.index', compact('receiveOrders'));
    }

    public function show($id)
    {
        $receiveOrder = ReceiveOrder::with(['supplier', 'items.inventoryItem'])->findOrFail($id);

        return view('employee.ReceiveOrder.show', compact('receiveOrder'));
    }
    
    public function create()
    {
        $suppliers = Supplier::where(function($query) {
            $query->where('status', 'active')
                  ->orWhereNull('status'); // For backwards compatibility
        })->get();
        $items = InventoryItem::all();
        return view('employee.ReceiveOrder.ReceiveOrder', compact('suppliers', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Start a database transaction to ensure both Receive Order and Items are saved together
        \DB::beginTransaction();

        try {
            $lastOrder = ReceiveOrder::latest()->first();
            $nextId = $lastOrder ? $lastOrder->id + 1 : 1;
            $orderNumber = 'RO-' . $nextId; // Changed prefix to 'RO' for Receive Order

            $totalPrice = 0;
            foreach ($request->items as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            // Create the Receive Order
            $receiveOrder = ReceiveOrder::create([
                'supplier_id' => $request->supplier_id,
                'order_number' => $orderNumber,
                'order_date' => now(),
                'status' => 'pending', // Set a default status for now
                'total_price' => $totalPrice,
            ]);

            // Loop through the items and create ReceiveOrderItems
            foreach ($request->items as $item) {
                ReceiveOrderItem::create([
                    'receive_order_id' => $receiveOrder->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);
            }

            // Commit the transaction
            \DB::commit();

            // Redirect back with a success message
            return redirect()->route('employee.receive-orders.create')->with('success', 'Receive Order created successfully!');
        } catch (\Exception $e) {
            // Rollback if there is an error
            \DB::rollBack();
            return redirect()->route('employee.receive-orders.create')
                     ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}