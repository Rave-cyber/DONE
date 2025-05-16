<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::latest()->paginate(10);
        return view('admin.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the employee data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',  // Ensure the email is unique in employees table
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
        ]);

        // Create the User record first (the employee will be linked to this user)
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,  // Combining first and last names for user name
            'email' => $request->email,
            'password' => bcrypt(str_random(16)),  // Generate a random password for new employee (or you could generate one here)
            'role' => 'employee',  // Default role is 'employee'
        ]);

        // Create the Employee record and link it to the user
        $employee = Employee::create([
            'user_id' => $user->id,  // Link employee to the user via user_id
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'hire_date' => $validated['hire_date'],
            'status' => 'active',  // Default status is active
        ]);

        return redirect()->route('admin.employee.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {

        if ($employee->hire_date && is_object($employee->hire_date)) {
            $employee->hire_date = $employee->hire_date->format('Y-m-d');
        }

        return view('admin.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        // Validate the employee and user data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,  // Ensure email is unique except for the current employee
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        // Update the Employee record
        $employee->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'hire_date' => $validated['hire_date'],
            'status' => $validated['status'],
        ]);

        // Update the associated User record (for example, the email and role)
        $employee->user->update([
            'email' => $validated['email'],  // Update the user email (syncs with employee email)
            // You can add more user-related fields here if needed, such as role or name.
        ]);

        return redirect()->route('admin.employee.index')
            ->with('success', 'Employee updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // Delete the associated user first (to avoid orphaned user records)
        $employee->user()->delete(); // Deletes the related user record
        
        // Now delete the employee record
        $employee->delete();

        return redirect()->route('admin.employee.index')
            ->with('success', 'Employee and associated user deleted successfully.');
    }
}
