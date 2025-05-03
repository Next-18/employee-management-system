<!-- filepath: c:\wamp64\www\project\resources\views\profile\profile.blade.php -->
@extends('layouts.main')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f7f8fa 0%, #e3e9f0 100%);
    }
    .profile-header {
        background: linear-gradient(90deg, #2c2c54 60%, #4e54c8 100%);
        color: #fff;
        border-radius: 18px 18px 0 0;
        padding: 2.5rem 1.5rem 1.5rem 1.5rem;
        text-align: center;
        margin-bottom: -60px;
        box-shadow: 0 4px 24px rgba(44,44,84,0.08);
        position: relative;
    }
    .profile-avatar {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 4px 24px rgba(44,44,84,0.12);
        margin-top: -65px;
        background: #fff;
    }
    .profile-edit-btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        font-size: 1rem;
        background: linear-gradient(90deg, #2c2c54 60%, #4e54c8 100%);
        color: #fff;
        border: none;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .profile-edit-btn:hover {
        background: linear-gradient(90deg, #4e54c8 60%, #2c2c54 100%);
        color: #fff;
        box-shadow: 0 2px 8px rgba(44,44,84,0.10);
    }
    .profile-info-label {
        font-weight: 600;
        color: #2c2c54;
        font-size: 1rem;
        margin-bottom: 0.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .profile-info-icon {
        color: #4e54c8;
        font-size: 1.1rem;
        min-width: 1.3rem;
        text-align: center;
    }
    .profile-info-value {
        background: #f7f8fa;
        border-radius: 8px;
        padding: 0.7rem 1rem;
        font-size: 1.05rem;
        margin-bottom: 1.1rem;
        box-shadow: 0 1px 4px rgba(44,44,84,0.04);
        color: #333;
    }
    @media (max-width: 600px) {
        .profile-header { padding: 1.5rem 0.5rem 1rem 0.5rem; }
        .profile-avatar { width: 90px; height: 90px; margin-top: -45px; }
    }
</style>
<div class="container py-3" style="max-width: 900px;">
    <!-- Profile Header -->
    <div class="profile-header mb-0">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <img src="{{ ($user->employee && $user->employee->profile_picture) ? asset('storage/' . $user->employee->profile_picture) : ($user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png')) }}" 
                 alt="Profile Picture" class="profile-avatar mb-2">
            <h3 class="fw-bold mb-1" style="font-family: 'Lora', serif;">{{ $user->first_name ?? 'First Name Not Set' }} {{ $user->middle_name ?? '' }} {{ $user->last_name ?? 'Last Name Not Set' }}</h3>
            <div class="text-light small mb-2">{{ $user->email }}</div>
            <a href="{{ route('profile.edit') }}" class="profile-edit-btn mt-2"><i class="fas fa-user-edit me-1"></i> Edit Profile</a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success mx-auto shadow-sm mb-3 fade show" role="alert"
            style="max-width: 800px; background: #f0f7f0; border: 1px solid #d1e7dd; color: #2e7d32; border-radius: 10px; margin-top: 1.5rem;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Profile Info Card -->
    <div class="card mx-auto shadow" style="max-width: 850px; border-radius: 0 0 18px 18px; background: #ffffff; box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06); margin-top: 0;">
        <div class="card-body px-4 py-4">
            <div class="row gy-2">
                <!-- Mobile Number -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-mobile-alt"></i></span>Mobile Number</div>
                    <div class="profile-info-value">{{ $user->contact_number ?? 'No mobile number provided' }}</div>
                </div>
                <!-- Gender -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-venus-mars"></i></span>Gender</div>
                    <div class="profile-info-value">{{ $user->gender === 'Custom' ? ($user->custom_gender ?? 'Gender not specified') : ($user->gender ?? 'Gender not specified') }}</div>
                </div>
                <!-- Member Since -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-calendar-alt"></i></span>Member Since</div>
                    <div class="profile-info-value d-flex justify-content-between align-items-center">
                        <span>{{ $user->created_at->format('F j, Y') }}</span>
                        <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                <!-- Full Name -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-user"></i></span>Full Name</div>
                    <div class="profile-info-value">{{ $user->first_name ?? 'First Name Not Set' }} {{ $user->middle_name ?? '' }} {{ $user->last_name ?? 'Last Name Not Set' }}</div>
                </div>
                <!-- Email Address -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-envelope"></i></span>Email Address</div>
                    <div class="profile-info-value">{{ $user->email }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection