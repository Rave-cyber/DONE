<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePrice;
use Illuminate\Http\Request;

class ServicePriceController extends Controller
{
    public function index()
    {
        $prices = ServicePrice::all()->keyBy('service_name')->map(function ($price) {
            return (object)['base_price' => $price->base_price];
        })->toArray();

        $servicePrices = [
            'Wash' => (object)['base_price' => $prices['Wash']->base_price ?? 10],
            'Fold' => (object)['base_price' => $prices['Fold']->base_price ?? 6],
            'Ironing' => (object)['base_price' => $prices['Ironing']->base_price ?? 8],
        ];

        return view('admin.dashboard', compact('servicePrices'));
    }

    public function update(Request $request)
    {
        // Remove the dd() line
        $validated = $request->validate([
            'wash_base_price' => 'required|numeric|min:0',
            'fold_base_price' => 'required|numeric|min:0',
            'ironing_base_price' => 'required|numeric|min:0',
        ]);

        ServicePrice::updateOrCreate(
            ['service_name' => 'Wash'],
            ['base_price' => $validated['wash_base_price']]
        );
        ServicePrice::updateOrCreate(
            ['service_name' => 'Fold'],
            ['base_price' => $validated['fold_base_price']]
        );
        ServicePrice::updateOrCreate(
            ['service_name' => 'Ironing'],
            ['base_price' => $validated['ironing_base_price']]
        );

        return back()->with('success', 'Prices updated successfully');
    }

    public function getJson()
    {
        $prices = ServicePrice::all();
        return response()->json($prices);
    }
}