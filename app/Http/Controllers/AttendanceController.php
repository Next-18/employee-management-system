<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'employee') {
            $employeeId = auth()->user()->employee_id;
            $attendances = Attendance::with('employee')
                ->where('employee_id', $employeeId)
                ->orderBy('date', 'desc')
                ->paginate(15);
        } else {
            $attendances = Attendance::with('employee')->orderBy('date', 'desc')->paginate(15);
        }
        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->employee_id) {
            return redirect()->back()->withErrors(['You must be logged in as an employee to mark attendance.']);
        }
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Late,On Leave',
        ]);
        $employeeId = auth()->user()->employee_id;
        Attendance::create([
            'employee_id' => $employeeId,
            'date' => $request->date,
            'status' => $request->status,
            'approved' => false,
        ]);
        return redirect()->route('attendance.create')->with('message', 'Attendance marked successfully!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->approved = true;
        $attendance->save();
        return redirect()->back()->with('message', 'Attendance approved!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
