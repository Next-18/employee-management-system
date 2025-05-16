<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the attendance records.
     */
    public function index()
    {
        if (Auth::user()->role === 'employee') {
            $employeeId = Auth::user()->employee_id;
            $attendances = Attendance::with('employee')
                ->where('employee_id', $employeeId)
                ->orderBy('date', 'desc')
                ->paginate(15);
        } else {
            $attendances = Attendance::with('employee')
                ->orderBy('date', 'desc')
                ->paginate(15);
        }

        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for marking attendance.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a new attendance record.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->employee_id) {
            return redirect()->back()->withErrors(['You must be logged in as an employee to mark attendance.']);
        }

        $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Late,On Leave',
        ]);

        Attendance::create([
            'employee_id' => Auth::user()->employee_id,
            'date' => $request->date,
            'status' => $request->status,
            'approved' => false,
        ]);

        return redirect()->route('attendance.create')->with('message', 'Attendance marked successfully!');
    }

    /**
     * Approve an attendance record (Admin).
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->approved = true;
        $attendance->save();

        return redirect()->back()->with('message', 'Attendance approved!');
    }

    /**
     * Show unapproved attendance records (Admin only).
     */
    public function pending()
    {
        $attendances = Attendance::with(['employee.user'])
            ->where('approved', false)
            ->latest()
            ->paginate(10);

        return view('attendance.pending', compact('attendances'));
    }

    /**
     * Show attendance summary (Admin only).
     */
    public function summary()
    {
        $employees = Employee::with(['user', 'attendances'])->get();

        $summary = $employees->map(function ($employee) {
            return [
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'email' => $employee->user->email ?? 'N/A',
                'profile_picture' => $employee->profile_picture,
                'present' => $employee->attendances->where('status', 'Present')->where('approved', true)->count(),
                'absent' => $employee->attendances->where('status', 'Absent')->where('approved', true)->count(),
                'late' => $employee->attendances->where('status', 'Late')->where('approved', true)->count(),
                'on_leave' => $employee->attendances->where('status', 'On Leave')->where('approved', true)->count(),
                'total' => $employee->attendances->where('approved', true)->count(),
            ];
        });

        return view('attendance.summary', compact('summary'));
    }

    // Optional placeholders for RESTful controller completeness
    public function show(string $id) { /* Optional */ }
    public function edit(string $id) { /* Optional */ }
    public function destroy(string $id) { /* Optional */ }
}
