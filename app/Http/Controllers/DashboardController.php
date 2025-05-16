<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingCount = Order::where('status', 'Pending')
                           ->where('is_archived', false)
                           ->count();
        
        $washingCount = Order::where('status', 'Washing')
                          ->where('is_archived', false)
                          ->count();
        
        $readyCount = Order::where('status', 'Ready')
                         ->where('is_archived', false)
                         ->count();

        return view('dashboard_emp', compact('pendingCount', 'washingCount', 'readyCount'));
    }
}