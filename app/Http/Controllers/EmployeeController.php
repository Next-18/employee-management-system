<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\EmployeeCredentialsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        \Log::info('Store method called.');
        \Log::info('Request all:', $request->all());
        \Log::info('Has file profile_picture:', [$request->hasFile('profile_picture')]);

        // Validate the request data
        $validated = $request->validate([
            'first_name'      => 'required|min:1|max:255',
            'middle_name'     => 'nullable|max:255',
            'last_name'       => 'required|min:1|max:255',
            'suffix'          => 'nullable|max:50',
            'birthday'        => 'required|date',
            'phone_number'    => 'required|unique:employees,phone_number',
            'address'         => 'required|min:1|max:500',
            'gender'          => 'required|in:male,female,other',
            'salary'          => 'required|numeric|min:0',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|string|min:6',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        \Log::info('Validation passed.');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            \Log::info('Profile picture file detected.');
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
            \Log::info('Profile picture stored at: ' . $path);
        } else {
            \Log::info('No profile picture file detected.');
        }

        // Create the employee
        $employee = Employee::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'suffix' => $validated['suffix'] ?? null,
            'birthday' => $validated['birthday'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'],
            'profile_picture' => $validated['profile_picture'] ?? null,
        ]);

        // Use provided password
        $password = $validated['password'];
        $user = User::create([
            'name' => trim($validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name']),
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($password),
            'role' => 'employee',
            'employee_id' => $employee->id,
        ]);

        // Optionally, email the credentials to the employee
        // \Mail::to($user->email)->send(new \App\Mail\EmployeeCredentialsMail($user->name, $user->email, $password));

        return redirect()->route('employee.master')->with('message', 'Employee and user account created! Temporary password: <strong>' . $password . '</strong>');
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
            'first_name' => ['required', 'min:1', 'max:255'],
            'middle_name' => ['nullable', 'max:255'],
            'last_name' => ['required', 'min:1', 'max:255'],
            'suffix' => ['nullable', 'max:50'],
            'birthday' => ['required', 'date'],
            'phone_number' => ['required', 'unique:employees,phone_number,' . $id],
            'address' => ['required', 'min:1', 'max:500'],
            'gender' => ['required', 'in:male,female,other'],
            'salary' => ['required', 'numeric', 'min:0'],
            'email' => 'required|email',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($employee->profile_picture) {
                \Storage::disk('public')->delete($employee->profile_picture);
            }
            // Store new picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $employee->update($validated);

        return redirect()->route('employee.master')
            ->with('message', 'Employee updated successfully!');
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
        $fullName = trim("{$employee->first_name} {$employee->last_name}");

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
        $fullName = trim("{$employee->first_name} {$employee->last_name}");

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
            ->where('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->orWhere('phone_number', 'LIKE', "%{$query}%")
            ->orderBy('last_name', 'asc')
            ->paginate(10);  // Paginate the results

        return response()->json($employees);
    }
}
