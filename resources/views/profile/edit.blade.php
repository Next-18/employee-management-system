@extends('layouts.main')

@section('content')
<div class="container py-7" style="background: linear-gradient(to bottom, #f7f8fa, #eef2f5); min-height: 100vh;">

    <!-- Heading -->
    <header class="text-center mb-8">
        <h2 class="display-5 fw-medium" style="color: #2c2c54; font-family: 'Lora', serif;">Edit Profile</h2>
        <p class="text-muted" style="font-size: 1.15rem; font-family: 'Raleway', sans-serif;">Update your account information below.</p>
    </header>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success fade show mx-auto" style="max-width: 950px; margin-bottom: 2.5rem;">
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
    <div class="card mx-auto" style="max-width: 800px; border-radius: 14px;">
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
                             class="border rounded-circle shadow"
                             style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #2c2c54;">
                    </div>
                    <input type="file" name="profile_picture" id="profile_picture" class="d-none @error('profile_picture') is-invalid @enderror" onchange="previewProfilePic(event)">
                    <label for="profile_picture" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">Upload New Picture</label>
                    @error('profile_picture') 
                        <div class="text-danger mt-2">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- First Name -->
                <div class="mb-4">
                    <label for="first_name" class="form-label">First Name <span class="text-muted">(Required)</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                        value="{{ old('first_name', $user->first_name) }}" required pattern="[A-Za-z\s]+">
                    @error('first_name') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Middle Name -->
                <div class="mb-4">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror"
                        value="{{ old('middle_name', $user->middle_name) }}">
                    @error('middle_name') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="mb-4">
                    <label for="last_name" class="form-label">Last Name <span class="text-muted">(Required)</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                        value="{{ old('last_name', $user->last_name) }}" required pattern="[A-Za-z\s]+">
                    @error('last_name') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address <span class="text-muted">(Required)</span></label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Mobile Number -->
                <div class="mb-4">
                    <label for="contact_number" class="form-label">Mobile Number <span class="text-muted">(Required)</span></label>
                    <input type="text" id="contact_number" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror"
                        value="{{ old('contact_number', $user->contact_number) }}" required>
                    @error('contact_number') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <!-- Gender -->
                <div class="mb-4">
                    <label class="form-label">Gender <span class="text-muted">(Required)</span></label>
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
                    <label for="current_password" class="form-label">Current Password <span class="text-muted">(Required to change password)</span></label>
                    <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror"
                        placeholder="Enter current password">
                    @error('current_password') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="new_password" class="form-label">New Password <span class="text-muted">(Optional)</span></label>
                    <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror"
                        placeholder="Enter new password">
                    @error('new_password') 
                        <div class="text-danger mt-1">{{ $message }}</div> 
                    @enderror
                    <small class="text-muted">Leave blank if you don't want to change the password.</small>
                </div>

                <div class="mb-5">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
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
