@extends('layouts.main')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="text-center mb-4">
        <h2 class="fw-semibold text-dark">Edit Employee</h2>
        <p class="text-muted small">Update the employee's details below</p>
    </div>

    <!-- Alerts -->
    <div class="row justify-content-center mb-3">
        <div class="col-lg-10">
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
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body px-4 py-4 bg-white">
                    <form method="POST" action="{{ route('employee.update', $employee->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Picture -->
                        <div class="text-center mb-4">
                            <div class="profile-picture-container">
                                <img src="{{ $employee->profile_picture ? asset('storage/' . $employee->profile_picture) : asset('images/default-avatar.png') }}" 
                                     alt="Profile Picture" 
                                     class="profile-picture-preview rounded-circle mb-2"
                                     id="profilePicturePreview">
                                <div class="profile-picture-upload">
                                    <input type="file" 
                                           name="profile_picture" 
                                           id="profilePictureInput" 
                                           class="d-none" 
                                           accept="image/*">
                                    <label for="profilePictureInput" class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-camera me-1"></i> Change Photo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Info -->
                        <div class="mb-4">
                            <h6 class="form-section-title">Personal Information</h6>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name', $employee->first_name) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name', $employee->last_name) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="middle_name" class="form-control" placeholder="Middle Name (optional)" value="{{ old('middle_name', $employee->middle_name) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="mb-4">
                            <h6 class="form-section-title">Contact Information</h6>
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $employee->birthday) }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="tel" name="phone_number" class="form-control" placeholder="Phone Number" value="{{ old('phone_number', $employee->phone_number) }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $employee->email }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" value="********" disabled>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label small">Gender</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" {{ old('gender', $employee->gender) == 'male' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="gender_male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" {{ old('gender', $employee->gender) == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender_female">Female</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="gender_other" value="other" {{ old('gender', $employee->gender) == 'other' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gender_other">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address & Salary -->
                        <div class="mb-4">
                            <h6 class="form-section-title">Address & Salary</h6>
                            <div class="row g-2">
                                <div class="col-md-9">
                                    <textarea name="address" class="form-control" rows="2" placeholder="Full Address" required>{{ old('address', $employee->address) }}</textarea>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="salary" class="form-control" placeholder="Salary" value="{{ old('salary', $employee->salary) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-between mt-4 border-top pt-3">
                            <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-dark">Update Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f5f6f8;
        font-family: 'Inter', sans-serif;
    }

    .form-control {
        border-radius: 0.5rem;
        font-size: 0.875rem;
        border: 1px solid #d0d7de;
        transition: all 0.2s ease-in-out;
    }

    .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.15rem rgba(79, 70, 229, 0.15);
    }

    .form-section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.75rem;
        border-left: 4px solid #4f46e5;
        padding-left: 0.6rem;
    }

    .card {
        border-radius: 1rem;
    }

    .btn-dark {
        background-color: #111827;
        border: none;
        transition: 0.2s;
    }

    .btn-dark:hover {
        background-color: #1f2937;
    }

    .btn-light {
        border: 1px solid #cbd5e1;
        background-color: #f8fafc;
    }

    h2 {
        font-size: 1.5rem;
    }

    /* Profile Picture Styles */
    .profile-picture-container {
        position: relative;
        display: inline-block;
    }

    .profile-picture-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-picture-upload {
        position: absolute;
        bottom: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.9);
        padding: 5px;
        border-radius: 50%;
    }

    .profile-picture-upload label {
        margin: 0;
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profilePictureInput = document.getElementById('profilePictureInput');
        const profilePicturePreview = document.getElementById('profilePicturePreview');

        profilePictureInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePicturePreview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endsection
