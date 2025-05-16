@extends('layouts.main')

@section('content')
<div class="container my-5 px-3 px-md-4">
    <h2 class="fw-semibold text-dark mb-4">Pending Attendance Approvals</h2>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Employee</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr @if(!$attendance->employee) style="background:#fff3cd;" @endif>
                            <td>{{ $attendance->id }}</td>
                            <td>
                                @if($attendance->employee && $attendance->employee->profile_picture)
                                    <img src="{{ asset('storage/' . $attendance->employee->profile_picture) }}" alt="Profile Picture" class="rounded-circle" width="40" height="40">
                                @else
                                    <img src="{{ asset('default-profile.png') }}" alt="No Photo" class="rounded-circle" width="40" height="40">
                                @endif
                            </td>
                            <td>
                                @if($attendance->employee)
                                    {{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}
                                @else
                                    <span class="badge bg-warning text-dark">Employee Not Found</span>
                                @endif
                            </td>
                            <td>{{ $attendance->employee?->user?->email ?? 'N/A' }}</td>
                            <td>{{ $attendance->employee?->phone_number ?? 'N/A' }}</td>
                            <td>{{ $attendance->date }}</td>
                            <td>{{ $attendance->status }}</td>
                            <td>
                                <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No pending attendance records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
