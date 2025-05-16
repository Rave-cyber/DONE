<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $activeOrders = Order::where('is_archived', false)
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('id', 'like', "%$search%")
                      ->orWhere('order_name', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6);  // Changed from get() to paginate()
                           
        $archivedOrders = Order::where('is_archived', true)
            ->orderBy('updated_at', 'desc')
            ->get();
                             
        return view('orders.index', compact('activeOrders', 'archivedOrders', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.1',
            'date' => 'required|date',
            'service_type' => 'required|array',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
            'special_instructions' => 'nullable|string',
        ]);

        // Create the order
        $order = Order::create([
            'order_name' => $validated['order_name'],
            'weight' => $validated['weight'],
            'date' => $validated['date'],
            'service_type' => json_encode($validated['service_type']),
            'status' => 'Pending',
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'amount' => $validated['amount'],
            'special_instructions' => $validated['special_instructions'] ?? null,
            'is_archived' => false,
        ]);
        $order->save();
        $order->updateStatus('Pending'); // Log initial status

        $receiptContent = $this->generateReceiptContent($order);
        
        $receiptFilename = 'receipt_'.$order->id.'_'.time().'.txt';
        Storage::put('receipts/'.$receiptFilename, $receiptContent);

        return Storage::download('receipts/'.$receiptFilename, 'Laundry_Receipt_'.$order->id.'.txt');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Washing,Drying,Ironing,Ready,Completed'
        ]);
        
        $order = Order::findOrFail($id);
        $order->updateStatus($request->status);

        return response()->json(['success' => 'Order status updated successfully!']);
    }

    public function markAsPaid(Order $order)
{
    if ($order->status !== 'Completed') {
        return response()->json([
            'error' => 'Order must be completed before marking as paid.'
        ], 422);
    }

    $order->update([
        'payment_status' => 'paid',
        'is_archived' => true
    ]);

    return response()->json([
        'message' => 'Order marked as paid and archived successfully.'
    ]);
}

    // Removed duplicate archiveOrder method to avoid redeclaration error.

    public function archiveOrder($id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status !== 'Completed' || $order->payment_status !== 'paid') {
            return response()->json([
                'error' => 'Order must be completed and paid before archiving.'
            ], 422);
        }
        
        $order->update(['is_archived' => true]);
        
        return response()->json(['message' => 'Order archived successfully']);
    }

    public function unarchiveOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['is_archived' => false]);
        
        return response()->json(['message' => 'Order restored from archive']);
    }

    public function show($id)
    {
        try {
            $order = Order::with('statusLogs.user', 'employees')->findOrFail($id);
            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve order: ' . $e->getMessage()], 404);
        }
    }

    public function showAssignForm($id)
    {
        $order = Order::findOrFail($id);
        $employees = Employee::where('status', 'active')->get();
        return view('orders.assign', compact('order', 'employees'));
    }

    // New method: Assign employees to order
    public function assignEmployees(Request $request, $id)
    {
        $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        $order = Order::findOrFail($id);
        $order->employees()->sync($request->employee_ids);

        return redirect()->route('orders.index')->with('success', 'Employees assigned successfully.');
    }

    protected function generateReceiptContent(Order $order)
    {
        if (is_array($order->service_type)) {
            $services = implode(', ', $order->service_type);
        } else {
            // If it's not an array, just use it as a string or handle it differently
            $services = $order->service_type;
        }
        
        $receipt = "================================\n";
        $receipt .= "        LAUNDRY RECEIPT         \n";
        $receipt .= "================================\n";
        $receipt .= "Order ID: #" . $order->id . "\n";
        $receipt .= "Date: " . $order->date . "\n";
        $receipt .= "Customer: " . $order->order_name . "\n";
        $receipt .= "--------------------------------\n";
        $receipt .= "Services: " . $services . "\n";
        $receipt .= "Weight: " . $order->weight . " kg\n";
        $receipt .= "Payment Method: " . $order->payment_method . "\n";
        $receipt .= "Status: " . $order->status . "\n";
        $receipt .= "Payment Status: " . $order->payment_status . "\n";
        
        if ($order->special_instructions) {
            $receipt .= "Special Instructions: " . $order->special_instructions . "\n";
        }
        
        $receipt .= "--------------------------------\n";
        $receipt .= "Total Amount: $" . number_format($order->amount, 2) . "\n";
        $receipt .= "================================\n";
        $receipt .= "Thank you for your business!\n";
        $receipt .= "================================\n";

        return $receipt;
    }
}