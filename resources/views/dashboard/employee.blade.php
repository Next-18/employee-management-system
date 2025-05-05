@extends('layouts.main')

@section('content')
<div class="container my-5 px-3 px-md-4">
    {{-- Welcome Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-semibold text-dark mb-1">Welcome, {{ auth()->user()->employee->first_name }}!</h2>
            <p class="text-muted small mb-0">Here's your dashboard overview</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('leave.create') }}" class="btn btn-primary btn-sm px-3 py-2 rounded-1 shadow-sm">
                <i class="fas fa-calendar-plus me-2"></i>Request Leave
            </a>
            <a href="{{ route('profile') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 rounded-1 shadow-sm">
                <i class="fas fa-user me-2"></i>View Profile
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('message'))
        <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show rounded-1 mb-4 border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('message') }}</div>
            </div>
        </div>
    @endif

    {{-- Quick Stats --}}
    <div class="row g-4 mb-4">
        {{-- Attendance Status --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted small mb-1">Today's Status</h6>
                            <h5 class="mb-0 fw-semibold">Present</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Leave Balance --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-calendar-check text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted small mb-1">Leave Balance</h6>
                            <h5 class="mb-0 fw-semibold">12 days</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Requests --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-hourglass-half text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted small mb-1">Pending Requests</h6>
                            <h5 class="mb-0 fw-semibold">2</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Upcoming Leaves --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-calendar-alt text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted small mb-1">Upcoming Leaves</h6>
                            <h5 class="mb-0 fw-semibold">3</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity and Quick Actions --}}
    <div class="row g-4">
        {{-- Recent Leaves --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-semibold">Recent Leaves</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="py-3 px-3 text-start fw-medium small text-uppercase">Date</th>
                                    <th class="py-3 px-3 text-start fw-medium small text-uppercase">Type</th>
                                    <th class="py-3 px-3 text-start fw-medium small text-uppercase">Status</th>
                                    <th class="py-3 px-3 text-start fw-medium small text-uppercase">Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-3 px-3">15 Jan 2024</td>
                                    <td class="py-3 px-3">Vacation</td>
                                    <td class="py-3 px-3">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Approved</span>
                                    </td>
                                    <td class="py-3 px-3">3 days</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-3">20 Jan 2024</td>
                                    <td class="py-3 px-3">Sick Leave</td>
                                    <td class="py-3 px-3">
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">Pending</span>
                                    </td>
                                    <td class="py-3 px-3">1 day</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-semibold">Quick Actions</h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('leave.create') }}" class="btn btn-outline-primary btn-sm rounded-1 shadow-sm">
                            <i class="fas fa-calendar-plus me-2"></i>Request Leave
                        </a>
                        <a href="{{ route('profile') }}" class="btn btn-outline-secondary btn-sm rounded-1 shadow-sm">
                            <i class="fas fa-user me-2"></i>Update Profile
                        </a>
                        <a href="#" class="btn btn-outline-info btn-sm rounded-1 shadow-sm">
                            <i class="fas fa-file-alt me-2"></i>View Payslip
                        </a>
                        <a href="#" class="btn btn-outline-success btn-sm rounded-1 shadow-sm">
                            <i class="fas fa-download me-2"></i>Download Documents
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 