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
        text-decoration: none;
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
    <!-- Header -->
    <div class="profile-header mb-0">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <img src="{{ $employee->profile_picture ? asset('storage/' . $employee->profile_picture) : asset('images/default-profile.png') }}"
                 alt="Employee Photo" class="profile-avatar mb-2">
            <h3 class="fw-bold mb-1" style="font-family: 'Lora', serif;">
                {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }} {{ $employee->suffix }}
            </h3>
            <div class="text-light small mb-2">{{ $employee->user->email ?? 'Email Not Available' }}</div>
            <a href="{{ route('admin.employees.edit', $employee->id) }}" class="profile-edit-btn mt-2">
                <i class="fas fa-user-edit me-1"></i> Edit Employee Profile
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card mx-auto shadow" style="max-width: 850px; border-radius: 0 0 18px 18px; background: #ffffff; margin-top: 0;">
        <div class="card-body px-4 py-4">
            <div class="row gy-2">
                <!-- Email -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-envelope"></i></span>Email</div>
                    <div class="profile-info-value">{{ $employee->user->email ?? 'N/A' }}</div>
                </div>
                <!-- Birthday -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-birthday-cake"></i></span>Birthday</div>
                    <div class="profile-info-value">{{ \Carbon\Carbon::parse($employee->birthday)->toFormattedDateString() }}</div>
                </div>
                <!-- Phone -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-phone-alt"></i></span>Phone</div>
                    <div class="profile-info-value">{{ $employee->phone_number }}</div>
                </div>
                <!-- Address -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-map-marker-alt"></i></span>Address</div>
                    <div class="profile-info-value">{{ $employee->address }}</div>
                </div>
                <!-- Gender -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-venus-mars"></i></span>Gender</div>
                    <div class="profile-info-value">{{ ucfirst($employee->gender) }}</div>
                </div>
                <!-- Salary -->
                <div class="col-md-6 col-12">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-dollar-sign"></i></span>Salary</div>
                    <div class="profile-info-value">${{ number_format($employee->salary, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection
