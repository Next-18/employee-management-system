@extends('layouts.main')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4>{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }} {{ $employee->suffix }}</h4>
            <p>Email: {{ $employee->user->email ?? 'N/A' }}</p>
            <p>Birthday: {{ \Carbon\Carbon::parse($employee->birthday)->toFormattedDateString() }}</p>
            <p>Phone: {{ $employee->phone_number }}</p>
            <p>Address: {{ $employee->address }}</p>
            <p>Gender: {{ ucfirst($employee->gender) }}</p>
            <p>Salary: ${{ number_format($employee->salary, 2) }}</p>
        </div>
    </div>
</div>
@endsection
