<?php

namespace App\Http\Controllers\Employee;

use App\Models\supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Supplier_Controller extends Controller
{
    public function index()
    {
        $supplier = supplier::all();
        return view('employee.supplier.index', compact('supplier'));
    }

    public function show(supplier $supplier)
    {
        return view('employee.supplier.show', compact('supplier'));
    }
}
