<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use Carbon\Carbon;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'employee') {
            $employeeId = auth()->user()->employee_id;
            $leaves = Leave::with('employee')
                ->where('employee_id', $employeeId)
                ->orderBy('start_date', 'desc')
                ->paginate(15);
        } else {
            $leaves = Leave::with('employee')
                ->orderBy('start_date', 'desc')
                ->paginate(15);
        }

        return view('leave.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('leave.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        Leave::create([
            'employee_id' => $request->employee_id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'Pending',
        ]);

        return redirect()->route('leave.create')->with('message', 'Leave request submitted successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $newStatus = $request->status;
        $originalStatus = $leave->status;

        $employee = $leave->employee;

        $daysRequested = Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;

        // Handle approval
        if ($originalStatus === 'Pending' && $newStatus === 'Approved') {
            if ($employee->leave_balance < $daysRequested) {
                return redirect()->back()->with('message', 'Employee does not have enough leave balance.');
            }
            $employee->leave_balance -= $daysRequested;
            $employee->save();
        }

        // Handle rejection of previously approved leave (restore balance)
        if ($originalStatus === 'Approved' && $newStatus === 'Rejected') {
            $employee->leave_balance += $daysRequested;
            $employee->save();
        }

        $leave->status = $newStatus;
        $leave->save();

        return redirect()->back()->with('message', "Leave has been {$newStatus}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
