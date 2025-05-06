@extends('layouts.main')

@section('content')
<div class="container py-4">
    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-semibold text-dark">Edit Employee Profile</h2>
            <p class="text-muted small">Modify and update employee information below.</p>
        </div>

        <!-- Alerts -->
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <form method="POST" action="{{ route('employee.update', $employee->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                        <img src="{{ $employee->profile_picture ? asset('storage/' . $employee->profile_picture) : asset('images/default-avatar.png') }}"
                             alt="Profile"
                             class="rounded-circle border border-3 shadow"
                             id="profilePicturePreview"
                             style="width: 120px; height: 120px; object-fit: cover;">
                        <label for="profilePictureInput" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm cursor-pointer" style="cursor: pointer;">
                            <i class="fas fa-camera"></i>
                            <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*" class="d-none">
                        </label>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="mb-4">
                    <h6 class="section-title">Personal Information</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $employee->first_name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $employee->last_name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $employee->middle_name) }}">
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mb-4">
                    <h6 class="section-title">Contact Information</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Birthday</label>
                            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $employee->birthday) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control" value="{{ old('phone_number', $employee->phone_number) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $employee->user->email ?? '') }}" required>


                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Gender</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender', $employee->gender) == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender', $employee->gender) == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ old('gender', $employee->gender) == 'other' ? 'checked' : '' }}>
                                <label class="form-check-label" for="other">Other</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address & Salary -->
                <div class="mb-4">
                    <h6 class="section-title">Address & Salary</h6>
                    <div class="row g-3">
                        <div class="col-md-9">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2" required>{{ old('address', $employee->address) }}</textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" class="form-control" value="{{ old('salary', $employee->salary) }}" required>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between mt-4 border-top pt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-save me-1"></i> Update Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f5f6f8;
        font-family: 'Inter', sans-serif;
    }

    .section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        border-left: 4px solid #4f46e5;
        padding-left: 0.6rem;
        margin-bottom: 1rem;
    }

    .form-control {
        border-radius: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-dark {
        background-color: #111827;
        border: none;
    }

    .btn-dark:hover {
        background-color: #1f2937;
    }

    .btn-outline-secondary {
        border-radius: 0.5rem;
    }

    .card {
        border-radius: 1rem;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('profilePictureInput');
        const preview = document.getElementById('profilePicturePreview');

        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endsection
