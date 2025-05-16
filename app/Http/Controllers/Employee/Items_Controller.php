<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Controllers\Controller;

class Items_Controller extends Controller
{
    public function index()
    {
        $inventoryitem = InventoryItem::all();
        return view('employee.items.index', compact('inventoryitem'));
    }

    public function create()
    {
        return view('employee.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|in:In Stock,Low Stock,Out of Stock',
        ]);

        // Create new inventory item
        InventoryItem::create($validated);

        // Redirect to inventory index page with success message
        return redirect()->route('employee.items.index')
            ->with('success', 'Inventory item created successfully.');

    }

    public function edit(InventoryItem $inventoryitem)
    {
        return view('employee.items.edit', compact('inventoryitem'));
    }

    public function update(Request $request, InventoryItem $inventoryitem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255', 
            'status' => 'required|string|in:In Stock,Low Stock,Out of Stock',
        ]);

        // Update the inventory item
        $inventoryitem->update($validated);

        // Redirect to inventory index page with success message
        return redirect()->route('employee.items.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryItem $inventoryitem)
    {
        $inventoryitem->delete();

        return redirect()->route('employee.items.index')->with('success', 'Item deleted successfully.');
    }
}
