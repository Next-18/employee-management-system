@extends('layouts.main')

@section('content')
<div class="container my-5 px-3 px-md-4">
    <h2 class="fw-semibold text-dark mb-4">Leave Requests</h2>

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
                            <th>Employee</th>
                            <th>Leave Balance</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                        <tr>
                            <td>{{ $leave->id }}</td>

                            {{-- Employee full name --}}
                            <td>
                                {{ implode(' ', array_filter([
                                    $leave->employee->first_name ?? '',
                                    $leave->employee->middle_name ?? '',
                                    $leave->employee->last_name ?? '',
                                    $leave->employee->suffix ?? ''
                                ])) }}
                            </td>

                            {{-- Leave Balance --}}
                            <td>
                                {{ $leave->employee->leave_balance ?? 'N/A' }} days
                            </td>

                            <td>{{ $leave->leave_type }}</td>
                            <td>{{ $leave->start_date }}</td>
                            <td>{{ $leave->end_date }}</td>
                            <td>{{ $leave->reason }}</td>

                            {{-- Leave Status --}}
                            <td>
                                @if($leave->status === 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($leave->status === 'Rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            {{-- Action Buttons --}}
                            <td>
                                @if($leave->status === 'Pending')
                                <form action="{{ route('leave.update', $leave->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Approved">
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>

                                <form action="{{ route('leave.update', $leave->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Rejected">
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $leaves->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
