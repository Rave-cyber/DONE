<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::all();
        return view('admin.inventory.index', compact('inventoryItems'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:In Stock,Low Stock,Out of Stock',
        ]);

        InventoryItem::create($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item created successfully.');
    }

    public function edit(InventoryItem $inventory)
    {
        $inventoryItem = $inventory;
        return view('admin.inventory.edit', compact('inventoryItem'));
    }

    public function update(Request $request, InventoryItem $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:In Stock,Low Stock,Out of Stock',
        ]);

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventory)
    {
        $inventory->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item deleted successfully.');
    }
}