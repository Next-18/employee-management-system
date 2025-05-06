<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.add');
    }

    public function store(Request $request)
    {
        \Log::info('Store method called.');
        \Log::info('Request all:', $request->all());
        \Log::info('Has file profile_picture:', [$request->hasFile('profile_picture')]);

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

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

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

        // Mail::to($user->email)->send(new EmployeeCredentialsMail($user->name, $user->email, $password));

        return redirect()->route('employee.master')->with('message', 'Employee and user account created! Temporary password: <strong>' . $password . '</strong>');
    }

    public function master()
    {
        $employees = Employee::with('user')->withTrashed()->orderBy('last_name', 'asc')->get();
        return view('employee.master', compact('employees'));
    }

    public function edit($id)
    {
        $employee = Employee::with(['user'])->withTrashed()->findOrFail($id);
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::where('employee_id', $employee->id)->firstOrFail();

        $validated = $request->validate([
            'first_name' => ['required', 'min:1', 'max:255'],
            'middle_name' => ['nullable', 'max:255'],
            'last_name' => ['required', 'min:1', 'max:255'],
            'suffix' => ['nullable', 'max:50'],
            'birthday' => ['required', 'date'],
            'phone_number' => ['required', 'unique:employees,phone_number,' . $employee->id],
            'address' => ['required', 'min:1', 'max:500'],
            'gender' => ['required', 'in:male,female,other'],
            'salary' => ['required', 'numeric', 'min:0'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $employee->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'suffix' => $validated['suffix'] ?? null,
            'birthday' => $validated['birthday'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'],
            'profile_picture' => $validated['profile_picture'] ?? $employee->profile_picture,
        ]);

        $user->update([
            'email' => $validated['email'],
            'name' => trim($validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name']),
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
        ]);

        return redirect()->route('employee.master')->with('message', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        $fullName = trim("{$employee->first_name} {$employee->last_name}");

        return redirect()->route('employee.master')->with([
            'message' => "{$fullName} has been deleted!",
            'alert-type' => 'danger',
        ]);
    }

    public function restore($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        $employee->restore();
        $fullName = trim("{$employee->first_name} {$employee->last_name}");

        return redirect()->route('employee.master')->with('message', "{$fullName} has been restored!");
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $employees = Employee::withTrashed()
            ->where('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->orWhere('phone_number', 'LIKE', "%{$query}%")
            ->orderBy('last_name', 'asc')
            ->paginate(10);

        return response()->json($employees);
    }

    public function show($id)
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        return view('employee.profile', compact('employee'));
    }
}
