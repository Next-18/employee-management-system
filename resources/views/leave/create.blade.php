@extends('layouts.main')

@section('content')
<div class="container my-5 px-3 px-md-4">
    <h2 class="fw-semibold text-dark mb-4">Request Leave</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('leave.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-select" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->FirstName }} {{ $employee->LastName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="leave_type" class="form-label">Leave Type</label>
                    <input type="text" name="leave_type" id="leave_type" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" id="reason" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-dark">Request Leave</button>
            </form>
        </div>
    </div>
</div>
@endsection 