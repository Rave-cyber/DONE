<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index()
    {
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(30);
        
        return view('admin.sales_report.index', [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d')
        ]);
    }
    
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        $orders = Order::whereBetween('created_at', [
                Carbon::parse($validated['start_date'])->startOfDay(),
                Carbon::parse($validated['end_date'])->endOfDay()
            ])
            ->orderBy('created_at', 'desc')
            ->get();
    
        $totals = [
            'Wash' => 0,
            'Fold' => 0,
            'Ironing' => 0,
            'All' => 0
        ];
    
        foreach ($orders as $order) {
            // Safely handle service_type
            $services = [];
            if ($order->service_type) {
                $services = is_array($order->service_type) 
                    ? $order->service_type 
                    : json_decode($order->service_type, true) ?? [];
            }
    
            if (is_array($services)) {
                if (in_array('Wash', $services)) $totals['Wash'] += $order->amount;
                if (in_array('Fold', $services)) $totals['Fold'] += $order->amount;
                if (in_array('Ironing', $services)) $totals['Ironing'] += $order->amount;
            }
            $totals['All'] += $order->amount;
        }
    
        return view('admin.sales_report.result', [
            'orders' => $orders,
            'totals' => $totals,
            'startDate' => $validated['start_date'],
            'endDate' => $validated['end_date']
        ]);
    }
}