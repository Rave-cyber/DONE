<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            ->paginate(6);
                           
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
        
        $order->updateStatus('Pending'); // Log initial status

        $receiptContent = $this->generateReceiptContent($order);
        
        $receiptFilename = 'receipt_'.$order->id.'_'.time().'.txt';
        Storage::put('receipts/'.$receiptFilename, $receiptContent);

        return Storage::download('receipts/'.$receiptFilename, 'Laundry_Receipt_'.$order->id.'.txt');
    }

    public function show($id)
{
    try {
        $order = Order::with([
            'statusLogs.user', 
            'employees', 
            'payments' // Now this relationship exists
        ])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $order,
            'amount' => $order->amount,
            'payment_status' => $order->payment_status
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Failed to retrieve order: ' . $e->getMessage()
        ], 500);
    }
}
    public function showPaymentForm(Order $order)
    {
        return view('orders.payment', compact('order'));
    }

   public function processPayment(Request $request, Order $order)
{
    $request->validate([
        'cash_received' => [
            'required',
            'numeric',
            'min:' . $order->amount,
            function ($attribute, $value, $fail) use ($order) {
                if ($value < $order->amount) {
                    $fail('The amount received must be at least the order amount.');
                }
            }
        ],
        'payment_method' => 'required|string|in:Cash,GCash,Credit Card,Bank Transfer'
    ]);

    DB::beginTransaction();
    try {
        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $order->amount,
            'cash_received' => $request->cash_received,
            'change' => $request->cash_received - $order->amount,
            'payment_method' => $request->payment_method,
            'user_id' => auth()->id(),
        ]);

        // Update order status to mark it as paid and archive it
        $order->update([
            'payment_status' => 'paid',
            'payment_method' => $request->payment_method,
            'status' => 'Completed',
            'is_archived' => true
        ]);
        
        // Extra check to ensure the order is archived
        DB::table('orders')->where('id', $order->id)->update(['is_archived' => true]);

        // Create a status log entry for payment
        $order->statusLogs()->create([
            'status' => 'Payment Completed',
            'notes' => 'Payment processed via ' . $request->payment_method . '. Order archived.',
            'user_id' => auth()->id(),
        ]);

        DB::commit();

        // Reload the order with payment information to ensure it's available for receipt
        $order = Order::with('payments')->find($order->id);

        // Generate receipt content
        $receiptContent = $this->generateReceiptContent($order);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully!',
            'receipt' => $receiptContent
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Failed to process payment: ' . $e->getMessage()
        ], 500);
    }
}

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Washing,Drying,Ironing,Ready,Completed'
        ]);
        
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

        DB::transaction(function () use ($order) {
            $order->update([
                'payment_status' => 'paid',
                'is_archived' => true
            ]);

            // Create a basic payment record
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->amount,
                'cash_received' => $order->amount,
                'change' => 0,
                'payment_method' => $order->payment_method,
                'user_id' => auth()->id(),
            ]);
        });

        // Reload the order with payment information to ensure it's available for receipt
        $order = Order::with('payments')->find($order->id);

        // Generate receipt content
        $receiptContent = $this->generateReceiptContent($order);

        return response()->json([
            'message' => 'Order marked as paid and archived successfully.',
            'receipt' => $receiptContent
        ]);
    }

    public function archiveOrder(Order $order)
    {
        if ($order->status !== 'Completed' || $order->payment_status !== 'paid') {
            return response()->json([
                'error' => 'Order must be completed and paid before archiving.'
            ], 422);
        }
        
        $order->update(['is_archived' => true]);
        
        return response()->json(['message' => 'Order archived successfully']);
    }

    public function unarchiveOrder(Order $order)
    {
        $order->update(['is_archived' => false]);
        
        return response()->json(['message' => 'Order restored from archive']);
    }

    public function showAssignForm(Order $order)
    {
        $employees = Employee::where('status', 'active')->get();
        return view('orders.assign', compact('order', 'employees'));
    }

    public function assignEmployees(Request $request, Order $order)
    {
        $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        $order->employees()->sync($request->employee_ids);

        return redirect()->route('orders.index')->with('success', 'Employees assigned successfully.');
    }

    public function tracking($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.tracking', compact('order'));
    }

    protected function generateReceiptContent(Order $order)
    {
        $services = is_array($order->service_type) 
            ? implode(', ', $order->service_type)
            : $order->service_type;
        
        // Calculate VAT (12%)
        $subtotal = $order->amount / 1.12;
        $vatAmount = $order->amount - $subtotal;
        
        // Generate tracking ID
        $trackingId = 'TRK-' . $order->id . '-' . substr(md5($order->created_at), 0, 6);
        
        $receipt = "================================\n";
        $receipt .= "        LAUNDRY RECEIPT         \n";
        $receipt .= "================================\n";
        $receipt .= "Order ID: #" . $order->id . "\n";
        $receipt .= "Tracking ID: " . $trackingId . "\n";
        $receipt .= "Date: " . $order->date->format('Y-m-d H:i') . "\n";
        $receipt .= "Customer: " . $order->order_name . "\n";
        if ($order->contact) {
            $receipt .= "Contact: " . $order->contact . "\n";
        }
        $receipt .= "================================\n";
        $receipt .= "Services: " . $services . "\n";
        $receipt .= "Weight: " . $order->weight . " kg\n";
        $receipt .= "Status: " . $order->status . "\n";
        
        if ($order->special_instructions) {
            $receipt .= "Special Instructions: " . $order->special_instructions . "\n";
        }
        
        $receipt .= "================================\n";
        $receipt .= "Subtotal: ₱" . number_format($subtotal, 2) . "\n";
        $receipt .= "VAT (12%): ₱" . number_format($vatAmount, 2) . "\n";
        $receipt .= "Total Amount: ₱" . number_format($order->amount, 2) . "\n";
        
        // Add payment details if paid - improved to ensure payment details are always shown when paid
        if ($order->payment_status === 'paid') {
            $payment = $order->payments->first();
            
            $receipt .= "================================\n";
            $receipt .= "Payment Information:\n";
            $receipt .= "--------------------------------\n";
            $receipt .= "Payment Method: " . $order->payment_method . "\n";
            
            if ($payment) {
                $receipt .= "Cash Received: ₱" . number_format($payment->cash_received, 2) . "\n";
                $receipt .= "Change: ₱" . number_format($payment->change, 2) . "\n";
                $receipt .= "Paid On: " . $payment->created_at->format('Y-m-d H:i') . "\n";
            }
        }
        
        $receipt .= "================================\n";
        $receipt .= "  For order tracking, visit:\n";
        $receipt .= "  https://laundrysite.com/track\n";
        $receipt .= "  and enter your Tracking ID\n";
        $receipt .= "================================\n";
        $receipt .= "Thank you for your business!\n";
        $receipt .= "================================\n";

        return $receipt;
    }
}