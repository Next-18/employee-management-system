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
            <img id="profilePicPreviewHeader"
                 src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                 alt="Profile Picture" class="profile-avatar mb-2">
            <h3 class="fw-bold mb-1" style="font-family: 'Lora', serif;">{{ $user->first_name ?? 'First Name Not Set' }} {{ $user->middle_name ?? '' }} {{ $user->last_name ?? 'Last Name Not Set' }}</h3>
            <div class="text-light small mb-2">{{ $user->email }}</div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success fade show mx-auto" style="max-width: 950px; margin-bottom: 2.5rem; margin-top: 1.5rem;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger fade show mx-auto" style="max-width: 950px; margin-bottom: 2.5rem;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card mx-auto" style="max-width: 800px; border-radius: 0 0 18px 18px;">
        <div class="card-body p-6 p-md-7">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <!-- Profile Picture Upload -->
                <div class="text-center mb-5">
                    <label for="profile_picture" class="form-label" style="font-family: 'Raleway', sans-serif;">Profile Picture</label>
                    <div class="mb-2">
                        <img id="profilePicPreview"
                             src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                             alt="Profile Picture"
                             class="border rounded-circle shadow profile-avatar"
                             style="object-fit: cover;">
                    </div>
                    <input type="file" name="profile_picture" id="profile_picture" class="d-none @error('profile_picture') is-invalid @enderror" onchange="previewProfilePic(event)">
                    <label for="profile_picture" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">Upload New Picture</label>
                    @error('profile_picture') 
                        <div class="text-danger mt-2">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- First Name -->
                <div class="mb-4">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-user"></i></span>First Name <span class="text-muted">(Required)</span></div>
                    <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                        value="{{ old('first_name', $user->first_name) }}" required pattern="[A-Za-z\s]+">
                    @error('first_name') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Middle Name -->
                <div class="mb-4">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-user"></i></span>Middle Name</div>
                    <input type="text" id="middle_name" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror"
                        value="{{ old('middle_name', $user->middle_name) }}">
                    @error('middle_name') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="mb-4">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-user"></i></span>Last Name <span class="text-muted">(Required)</span></div>
                    <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                        value="{{ old('last_name', $user->last_name) }}" required pattern="[A-Za-z\s]+">
                    @error('last_name') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-envelope"></i></span>Email Address <span class="text-muted">(Required)</span></div>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Mobile Number -->
                <div class="mb-4">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-mobile-alt"></i></span>Mobile Number <span class="text-muted">(Required)</span></div>
                    <input type="text" id="contact_number" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror"
                        value="{{ old('contact_number', $user->contact_number) }}" required>
                    @error('contact_number') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Gender -->
                <div class="mb-4">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-venus-mars"></i></span>Gender <span class="text-muted">(Required)</span></div>
                    <div class="d-flex flex-column gap-2">
                        @foreach(['Male', 'Female', 'NonBinary', 'Custom'] as $genderOption)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="Gender{{ $genderOption }}" value="{{ $genderOption }}"
                                    {{ old('gender', $user->gender) == $genderOption ? 'checked' : '' }} required>
                                <label class="form-check-label" for="Gender{{ $genderOption }}">{{ ucfirst($genderOption) }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div id="customGenderField" class="mt-3" style="display: {{ old('gender', $user->gender) == 'Custom' ? 'block' : 'none' }};">
                        <label for="customGender" class="form-label">Please specify</label>
                        <input type="text" name="customGender" id="customGender" class="form-control" 
                            placeholder="Enter your gender" value="{{ old('customGender', $user->customGender) }}">
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="mb-4">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-lock"></i></span>Current Password <span class="text-muted">(Required to change password)</span></div>
                    <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror"
                        placeholder="Enter current password">
                    @error('current_password') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-lock"></i></span>New Password <span class="text-muted">(Optional)</span></div>
                    <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror"
                        placeholder="Enter new password">
                    @error('new_password') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                    <small class="text-muted">Leave blank if you don't want to change the password.</small>
                </div>

                <div class="mb-5">
                    <div class="profile-info-label"><span class="profile-info-icon"><i class="fas fa-lock"></i></span>Confirm New Password</div>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control"
                        placeholder="Confirm new password">
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="text-center d-flex justify-content-center gap-4 mt-5">
                    <button type="submit" class="btn-save">
                        Save Changes
                    </button>

                    <a href="{{ route('profile') }}" class="btn-cancel">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Styles for Save/Cancel Buttons -->
<style>
    .btn-save, .btn-cancel {
        display: inline-block;
        padding: 0.8rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-save {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(106, 17, 203, 0.4);
    }

    .btn-cancel {
        background: linear-gradient(135deg, #dfe9f3 0%, #ffffff 100%);
        color: #2c2c54;
        border: 1px solid #d0d7de;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(106, 17, 203, 0.5);
    }

    .btn-cancel:hover {
        transform: translateY(-3px);
        background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-save:active, .btn-cancel:active {
        transform: scale(0.97);
    }
</style>

<!-- Scripts -->
<script>
    function previewProfilePic(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePicPreview').src = e.target.result;
            document.getElementById('profilePicPreviewHeader').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.querySelectorAll('input[name="gender"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('customGenderField').style.display = this.value === 'Custom' ? 'block' : 'none';
        });
    });
</script>

@endsection
