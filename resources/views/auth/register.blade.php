@extends('layouts.login')
@section('content')

<style>
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .card-header {
        background: none;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }

    .form-control, .form-select {
        border-radius: 6px;
    }

    .btn-signup {
        background-color: #1877f2;
        color: white;
        font-weight: bold;
        width: 100%;
        border-radius: 6px;
    }

    .btn-signup:hover {
        background-color: #155dc1;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <div class="card-header">
                    {{ __('Create a new account') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- First Name and Last Name -->
                        <div class="row mb-3">
                            <div class="col">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required pattern="[A-Za-z\s]+" title="First name can only contain letters and spaces.">
                                @error('first_name')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required pattern="[A-Za-z\s]+" title="Last name can only contain letters and spaces.">
                                @error('last_name')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email address" required>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <input id="contact_number" type="tel" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" placeholder="Mobile number" required pattern="^09\d{9}$" title="Mobile number must start with '09' and be 11 digits long.">
                            @error('contact_number')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label class="form-label">Gender <span class="text-muted">(Required)</span></label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="GenderMale" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="GenderMale">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="GenderFemale" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="GenderFemale">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="GenderNonBinary" value="NonBinary" {{ old('gender') == 'NonBinary' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="GenderNonBinary">Non-Binary</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="GenderCustom" value="Custom" {{ old('gender') == 'Custom' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="GenderCustom">Custom</label>
                                </div>
                            </div>
                            <div id="customGenderField" class="mt-3" style="display: {{ old('gender') == 'Custom' ? 'block' : 'none' }};">
                                <label for="custom_gender" class="form-label">Please specify</label> <!-- Changed to match field name -->
                                <input type="text" name="custom_gender" id="custom_gender" class="form-control" placeholder="Enter your gender" value="{{ old('custom_gender') }}"> <!-- Changed to match field name -->
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New password" required>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
                        </div>

                        <!-- Profile Picture -->
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Profile Picture (Optional)</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-signup">{{ __('Sign Up') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="gender"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            const customField = document.getElementById('customGenderField');
            if (this.value === 'Custom') {
                customField.style.display = 'block';
            } else {
                customField.style.display = 'none';
            }
        });
    });
</script>

@endsection
