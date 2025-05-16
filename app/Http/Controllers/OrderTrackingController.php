<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function trackOrder(Request $request)
    {
        // If no order_id provided, just show the welcome page
        if (!$request->has('order_id') || empty($request->order_id)) {
            return view('welcome');
        }

        $request->validate([
            'order_id' => 'required|string',
        ]);

        // Try to find the order by ID or receipt number
        $order = Order::where('id', $request->order_id)
                    //   ->orWhere('receipt_number', $request->order_id)
                      ->first();

        if (!$order) {
            return redirect()->route('welcome')->with('error', 'Order not found. Please check your order ID or receipt number.');
        }

        // Get the progress percentage based on status
        $statusProgress = $this->calculateStatusProgress($order->status);

        return view('orders.track', compact('order', 'statusProgress'));
    }

    /**
     * Calculate the progress percentage based on order status
     */
    private function calculateStatusProgress($status)
    {
        $statuses = [
            'received' => 10,
            'sorting' => 20,
            'washing' => 40,
            'drying' => 60,
            'folding' => 80,
            'quality_check' => 90,
            'ready' => 95,
            'delivered' => 100
        ];

        return $statuses[strtolower($status)] ?? 0;
    }
}