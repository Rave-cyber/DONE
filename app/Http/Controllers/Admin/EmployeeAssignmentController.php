<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeAssignment; // You'll need to create this model

class EmployeeAssignmentController extends Controller
{
    public function index()
    {
        $assignments = EmployeeAssignment::latest()->get();
        return view('admin.employee-assignment', compact('assignments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required',
            'employee_name' => 'required',
            'task' => 'required',
            'date' => 'required|date'
        ]);

        EmployeeAssignment::create($validatedData);

        return redirect()->route('admin.employee.assignment')
            ->with('success', 'Employee assignment created successfully');
    }
}