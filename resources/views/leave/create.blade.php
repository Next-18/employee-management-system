@extends('layouts.main')

@section('content')
<div class="container my-5 px-3 px-md-4">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold text-dark mb-0">Request Leave</h2>
        <a href="{{ route('leave.index') }}" class="btn btn-outline-dark btn-sm px-3 py-2 rounded-1 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Leaves
        </a>
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

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-1 mb-4 border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>
                    <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('leave.store') }}" method="POST">
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
                                {{ implode(' ', array_filter([
                                    auth()->user()->employee->first_name,
                                    auth()->user()->employee->middle_name,
                                    auth()->user()->employee->last_name,
                                    auth()->user()->employee->suffix
                                ])) }}
                            </div>
                            <div class="small text-muted">
                                <i class="fas fa-envelope me-1"></i>{{ auth()->user()->email }}
                                <span class="ms-3">
                                    <i class="fas fa-phone me-1"></i>{{ auth()->user()->employee->phone_number }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">
                </div>

                {{-- Leave Type --}}
                <div class="mb-4">
                    <label for="leave_type" class="form-label fw-medium">Leave Type</label>
                    <select name="leave_type" id="leave_type" class="form-select rounded-1 shadow-sm" required>
                        <option value="">Select leave type...</option>
                        <option value="vacation" {{ old('leave_type') == 'vacation' ? 'selected' : '' }}>Vacation Leave</option>
                        <option value="sick" {{ old('leave_type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                        <option value="personal" {{ old('leave_type') == 'personal' ? 'selected' : '' }}>Personal Leave</option>
                        <option value="bereavement" {{ old('leave_type') == 'bereavement' ? 'selected' : '' }}>Bereavement Leave</option>
                        <option value="other" {{ old('leave_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <div class="form-text text-muted">Choose the type of leave being requested</div>
                </div>

                {{-- Custom Leave Type (shown when "Other" is selected) --}}
                <div class="mb-4" id="customLeaveTypeContainer" style="display: none;">
                    <label for="custom_leave_type" class="form-label fw-medium">Specify Leave Type</label>
                    <input type="text" name="custom_leave_type" id="custom_leave_type" 
                           class="form-control rounded-1 shadow-sm" 
                           placeholder="Enter the type of leave..."
                           value="{{ old('custom_leave_type') }}">
                    <div class="form-text text-muted">Please specify the type of leave you are requesting</div>
                </div>

                {{-- Date Range --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label fw-medium">Start Date</label>
                        <input type="date" name="start_date" id="start_date" 
                               class="form-control rounded-1 shadow-sm" 
                               value="{{ old('start_date') }}"
                               min="{{ date('Y-m-d') }}"
                               required>
                        <div class="form-text text-muted">When does the leave begin?</div>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label fw-medium">End Date</label>
                        <input type="date" name="end_date" id="end_date" 
                               class="form-control rounded-1 shadow-sm" 
                               value="{{ old('end_date') }}"
                               min="{{ date('Y-m-d') }}"
                               required>
                        <div class="form-text text-muted">When does the leave end?</div>
                    </div>
                </div>

                {{-- Reason --}}
                <div class="mb-4">
                    <label for="reason" class="form-label fw-medium">Reason for Leave</label>
                    <textarea name="reason" id="reason" class="form-control rounded-1 shadow-sm" 
                              rows="4" placeholder="Please provide details about your leave request..."
                              required>{{ old('reason') }}</textarea>
                    <div class="form-text text-muted">Provide a brief explanation for your leave request</div>
                </div>

                {{-- Submit Button --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-dark px-4 py-2 rounded-1 shadow-sm">
                        <i class="fas fa-paper-plane me-2"></i>Submit Leave Request
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum end date based on start date
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const leaveType = document.getElementById('leave_type');
        const customLeaveTypeContainer = document.getElementById('customLeaveTypeContainer');
        const customLeaveType = document.getElementById('custom_leave_type');

        // Handle leave type change
        leaveType.addEventListener('change', function() {
            if (this.value === 'other') {
                customLeaveTypeContainer.style.display = 'block';
                customLeaveType.required = true;
            } else {
                customLeaveTypeContainer.style.display = 'none';
                customLeaveType.required = false;
                customLeaveType.value = '';
            }
        });

        // Initialize the custom leave type field based on current selection
        if (leaveType.value === 'other') {
            customLeaveTypeContainer.style.display = 'block';
            customLeaveType.required = true;
        }

        startDate.addEventListener('change', function() {
            endDate.min = this.value;
            if (endDate.value && endDate.value < this.value) {
                endDate.value = this.value;
            }
        });
    });
</script>
@endsection 