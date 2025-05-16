@extends('layouts.main')

@section('content')
<div class="container my-5 px-3 px-md-4">
    <h2 class="fw-semibold text-dark mb-4">Attendance Summary</h2>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Photo</th>
                            <th>Employee</th>
                            <th>Email</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Late</th>
                            <th>On Leave</th>
                            <th>Total Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($summary as $data)
                        <tr>
                            <td>
                                @if($data['profile_picture'])
                                    <img src="{{ asset('storage/' . $data['profile_picture']) }}" alt="Profile" class="rounded-circle" width="40" height="40">
                                @else
                                    <img src="{{ asset('default-profile.png') }}" alt="Default" class="rounded-circle" width="40" height="40">
                                @endif
                            </td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['email'] }}</td>
                            <td>{{ $data['present'] }}</td>
                            <td>{{ $data['absent'] }}</td>
                            <td>{{ $data['late'] }}</td>
                            <td>{{ $data['on_leave'] }}</td>
                            <td>{{ $data['total'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No attendance data found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
