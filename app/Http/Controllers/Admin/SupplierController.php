<?php

namespace App\Http\Controllers\Admin;

use App\Models\supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = supplier::all();
        return view('admin.suppliers.index', compact('supplier'));
    }
    public function create()
    {
        return view('admin.suppliers.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:suppliers',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        $data = $request->all();
        // Set default status to active if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        supplier::create($data);

        return redirect()->route('admin.suppliers.index')->with('success', 'Suppliers added successfully.');
    }
    public function edit(supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }
    public function update(Request $request, supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier Updated successfully.');
    }
    public function destroy(supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
    
    public function toggleStatus(Request $request, supplier $supplier)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);
        
        $supplier->status = $request->status;
        $supplier->save();
        
        return response()->json([
            'success' => true,
            'message' => "Supplier status updated to " . ucfirst($request->status)
        ]);
    }
}
