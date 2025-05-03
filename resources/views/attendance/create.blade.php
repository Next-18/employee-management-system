@extends('layouts.main')

@section('content')
<div class="container my-5 px-3 px-md-4">
    <h2 class="fw-semibold text-dark mb-4">Mark Attendance</h2>
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
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
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Employee</label>
                    <div class="form-control-plaintext fw-semibold">
                        {{ auth()->user()->name }}
                        @if(auth()->user()->email)
                            ({{ auth()->user()->email }})
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">Select Status</option>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Late">Late</option>
                        <option value="On Leave">On Leave</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark">Mark Attendance</button>
            </form>
        </div>
    </div>
</div>
@endsection 