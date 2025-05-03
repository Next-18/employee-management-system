<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $employeeCount = \App\Models\Employee::count();
            $attendanceCount = \App\Models\Attendance::count();
            $leaveCount = \App\Models\Leave::count();
            $recentEmployees = \App\Models\Employee::orderBy('created_at', 'desc')->take(5)->get();
            $recentAttendance = \App\Models\Attendance::with('employee')->orderBy('date', 'desc')->take(5)->get();
            $recentLeaves = \App\Models\Leave::with('employee')->orderBy('start_date', 'desc')->take(5)->get();
            return view('dashboard.admin', compact('employeeCount', 'attendanceCount', 'leaveCount', 'recentEmployees', 'recentAttendance', 'recentLeaves'));
        } else {
            return view('dashboard.employee');
        }
    }
}
