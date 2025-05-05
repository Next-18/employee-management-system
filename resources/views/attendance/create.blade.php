@extends('layouts.main')

@section('content')
<div class="container my-5 px-3 px-md-4">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold text-dark mb-0">Mark Attendance</h2>
    </div>

    {{-- Flash Message --}}
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show rounded-1 mb-4 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-1 mb-4 border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf

                {{-- Employee Info --}}
                <div class="mb-4">
                    <label class="form-label fw-medium">Employee</label>
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-1">
                        <img src="{{ auth()->user()->employee->profile_picture ? asset('storage/' . auth()->user()->employee->profile_picture) : asset('images/default-avatar.png') }}"
                             alt="Profile Picture"
                             class="rounded-circle"
                             style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #eee;">
                        <div>
                            <div class="fw-medium">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="small text-muted">
                                <i class="fas fa-envelope me-1"></i>{{ auth()->user()->email }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Date --}}
                <div class="mb-4">
                    <label for="date" class="form-label fw-medium">Date</label>
                    <input type="date" name="date" id="date" class="form-control rounded-1 shadow-sm"
                           value="{{ date('Y-m-d') }}" required>
                    <div class="form-text text-muted">Attendance will be recorded for this date</div>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label for="status" class="form-label fw-medium">Status</label>
                    <select name="status" id="status" class="form-select rounded-1 shadow-sm" required>
                        <option value="">Select Status</option>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Late">Late</option>
                        <option value="On Leave">On Leave</option>
                    </select>
                    <div class="form-text text-muted">Select your attendance status for the day</div>
                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-dark px-4 py-2 rounded-1 shadow-sm">
                        <i class="fas fa-check-circle me-2"></i>Mark Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.15rem rgba(79, 70, 229, 0.15);
    }

    .form-label {
        color: #333;
        font-size: 0.9rem;
    }

    .form-text {
        font-size: 0.8rem;
    }

    .card {
        border-radius: 0.5rem;
    }
</style>
@endsection
