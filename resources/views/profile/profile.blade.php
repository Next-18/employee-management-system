<!-- filepath: c:\wamp64\www\project\resources\views\profile\profile.blade.php -->
@extends('layouts.main')

@section('content')
<div class="container py-3" style="background: linear-gradient(to bottom, #f7f8fa, #eef2f5); font-family: 'Raleway', sans-serif;">
    <!-- Heading -->
    <header class="text-center mb-2">
        <h2 class="display-6 fw-semibold" style="color: #2c2c54; font-family: 'Lora', serif; margin-bottom: 0.5rem;">Your Profile</h2>
        <p class="text-muted fs-6" style="margin-top: 0.2rem; font-size: 0.9rem;">Manage your personal information below</p>
    </header>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success mx-auto shadow-sm mb-3 fade show" role="alert"
            style="max-width: 800px; background: #f0f7f0; border: 1px solid #d1e7dd; color: #2e7d32; border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Profile Card -->
    <div class="card mx-auto shadow" style="max-width: 850px; border-radius: 16px; background: #ffffff; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);">
        <div class="card-header d-flex justify-content-between align-items-center" 
             style="border-radius: 16px 16px 0 0; background: #2c2c54; color: white; padding: 0.5rem 1rem;">
            <h5 class="mb-0" style="font-family: 'Lora', serif; font-size: 1.1rem;">Profile Information</h5>
            <a href="{{ route('profile.edit') }}" 
               class="btn btn-outline-light btn-sm fw-semibold" 
               style="border-radius: 6px; padding: 0.25rem 0.5rem;">
                <i class="fas fa-user-edit me-1"></i> Edit
            </a>
        </div>

        <div class="card-body px-3 py-3">
            <div class="row gy-3">
                <!-- Profile Picture -->
                <div class="col-12 text-center mb-4">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}" 
                         alt="Profile Picture" 
                         class="border" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #2c2c54; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                </div>

                <!-- Full Name -->
                <div class="col-12">
                    <label class="form-label fw-bold text-muted">Full Name</label>
                    <div class="form-control bg-light border-0 shadow-sm" style="border-radius: 10px;" readonly>
                        {{ $user->first_name ?? 'First Name Not Set' }} 
                        {{ $user->middle_name ?? '' }}
                        {{ $user->last_name ?? 'Last Name Not Set' }}
                    </div>
                </div>

                <!-- Email Address -->
                <div class="col-12">
                    <label class="form-label fw-bold text-muted">Email Address</label>
                    <div class="form-control bg-light border-0 shadow-sm" style="border-radius: 10px;" readonly>
                        {{ $user->email }}
                    </div>
                </div>

                <!-- Mobile Number -->
                <div class="col-12">
                    <label class="form-label fw-bold text-muted">Mobile Number</label>
                    <div class="form-control bg-light border-0 shadow-sm" style="border-radius: 10px;" readonly>
                        {{ $user->contact_number ?? 'No mobile number provided' }}
                    </div>
                </div>

                <!-- Gender -->
                <div class="col-12">
                    <label class="form-label fw-bold text-muted">Gender</label>
                    <div class="form-control bg-light border-0 shadow-sm" style="border-radius: 10px;" readonly>
                        {{ $user->gender === 'Custom' ? ($user->custom_gender ?? 'Gender not specified') : ($user->gender ?? 'Gender not specified') }}
                    </div>
                </div>

                <!-- Member Since -->
                <div class="col-12">
                    <label class="form-label fw-bold text-muted">Member Since</label>
                    <div class="form-control bg-light border-0 shadow-sm d-flex justify-content-between align-items-center" style="border-radius: 10px;" readonly>
                        <span>{{ $user->created_at->format('F j, Y') }}</span>
                        <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection