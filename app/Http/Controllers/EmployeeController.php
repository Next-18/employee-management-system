<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Show the Add Employee Form
     */
    public function index()
    {
        return view('employee.add');
    }

    /**
     * Store Employee Data
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'FirstName' => ['required', 'min:1', 'max:255'],
            'MiddleName' => ['nullable', 'max:255'],
            'LastName' => ['required', 'min:1', 'max:255'],
            'Suffix' => ['nullable', 'max:50'],
            'Birthday' => ['required', 'date'],
            'PhoneNumber' => ['required', 'unique:employees,PhoneNumber'],
            'Address' => ['required', 'min:1', 'max:500'],
            'Gender' => ['required', 'in:Male,Female,Other'],
            'Salary' => ['required', 'numeric', 'min:0'],
        ]);

        // Create the employee
        Employee::create($validated);

        return redirect()->route('employee.add')->with('message', "{$request->FirstName} {$request->LastName} successfully added!");
    }

    /**
     * Show the Employee Master List (includes soft-deleted records)
     */
    public function master()
    {
        // Fetch employees ordered by LastName
        $employees = Employee::withTrashed()->orderBy('last_name', 'asc')->get();
        return view('employee.master', compact('employees'));
    }

    /**
     * Show the Edit Employee Form
     */
    public function edit($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        return view('employee.edit', compact('employee'));
    }

    /**
     * Update Employee Data
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // Validate the request data
        $validated = $request->validate([
            'FirstName' => ['required', 'min:1', 'max:255'],
            'MiddleName' => ['nullable', 'max:255'],
            'LastName' => ['required', 'min:1', 'max:255'],
            'Suffix' => ['nullable', 'max:50'],
            'Birthday' => ['required', 'date'],
            'PhoneNumber' => ['required', 'unique:employees,PhoneNumber,' . $id],
            'Address' => ['required', 'min:1', 'max:500'],
            'Gender' => ['required', 'in:Male,Female,Other'],
            'Salary' => ['required', 'numeric', 'min:0'],
        ]);

        // Update the employee
        $employee->update($validated);

        return redirect()->route('employee.master')->with('message', "{$request->FirstName} {$request->LastName} successfully updated!");
    }

    /**
     * Soft Delete an Employee
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        // Soft delete the employee
        $employee->delete();

        // Generate the full name
        $fullName = trim("{$employee->FirstName} {$employee->LastName}");

        return redirect()->route('employee.master')->with([
            'message' => "{$fullName} has been deleted!",
            'alert-type' => 'danger', // Bootstrap's "danger" class for red alerts
        ]);
    }

    /**
     * Restore a Soft Deleted Employee
     */
    public function restore($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);

        // Restore the employee
        $employee->restore();

        // Generate the full name
        $fullName = trim("{$employee->FirstName} {$employee->LastName}");

        return redirect()->route('employee.master')->with('message', "{$fullName} has been restored!");
    }

    /**
     * Search Employees (AJAX Request)
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if(empty($query)) {
            return response()->json([]);
        }

        // Fetch employees matching the query, ordered by LastName
        $employees = Employee::withTrashed()
            ->where('FirstName', 'LIKE', "%{$query}%")
            ->orWhere('LastName', 'LIKE', "%{$query}%")
            ->orWhere('PhoneNumber', 'LIKE', "%{$query}%")
            ->orderBy('LastName', 'asc')
            ->paginate(10);  // Paginate the results

        return response()->json($employees);
    }
}
