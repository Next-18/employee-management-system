{{-- filepath: c:\wamp64\www\project\resources\views\employee\add.blade.php --}}
@extends('layouts.main')

@section('content')
<div class="container py-7" style="background: linear-gradient(to bottom, #f7f8fa, #eef2f5); min-height: 100vh;">
    <!-- Heading -->
    <header class="text-center mb-8">
        <h2 class="display-5 fw-medium" style="color: #2c2c54; font-family: 'Lora', serif; letter-spacing: -0.5px;">Add New Employee</h2>
        <p class="text-muted" style="font-size: 1.15rem; font-family: 'Raleway', sans-serif; font-weight: 400;">Enter the details below to gracefully onboard an employee.</p>
    </header>

    <!-- Success Message -->
    @if (session('message'))
        <div class="alert alert-success fade show" style="background: #f0f7f0; border: 1px solid #e0ece0; color: #2e7d32; border-radius: 10px; font-family: 'Raleway', sans-serif; max-width: 950px; margin: 0 auto 2.5rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
            {{ session('message') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger fade show" style="background: #fdf4f4; border: 1px solid #f8e1e1; color: #b91c1c; border-radius: 10px; font-family: 'Raleway', sans-serif; max-width: 950px; margin: 0 auto 2.5rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card mx-auto" style="max-width: 900px; border-radius: 14px; background: #ffffff; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);">
        <div class="card-body p-6 p-md-7">
            <form method="POST" action="{{ route('employee.store') }}" class="needs-validation" novalidate>
                @csrf
                <div class="row g-4">
                    <!-- Personal Details -->
                    <div class="col-md-6">
                        <h5 class="fw-medium mb-4" style="color: #2c2c54; font-family: 'Lora', serif;">Personal Details</h5>
                        <div class="mb-3">
                            <label for="FirstName" class="form-label">First Name <span class="text-muted">(Required)</span></label>
                            <input type="text" name="FirstName" id="FirstName" class="form-control" placeholder="e.g., John" value="{{ old('FirstName') }}" required pattern="^[A-Za-z\s\-]+$" title="Only letters, spaces, and hyphens are allowed">
                            @error('FirstName') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="LastName" class="form-label">Last Name <span class="text-muted">(Required)</span></label>
                            <input type="text" name="LastName" id="LastName" class="form-control" placeholder="e.g., Doe" value="{{ old('LastName') }}" required pattern="^[A-Za-z\s\-]+$" title="Only letters, spaces, and hyphens are allowed">
                            @error('LastName') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="MiddleName" class="form-label">Middle Name</label>
                            <input type="text" name="MiddleName" id="MiddleName" class="form-control" placeholder="Optional" value="{{ old('MiddleName') }}" pattern="^[A-Za-z\s\-]*$" title="Only letters, spaces, and hyphens are allowed">
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="col-md-6">
                        <h5 class="fw-medium mb-4" style="color: #2c2c54; font-family: 'Lora', serif;">Contact Details</h5>
                        <div class="mb-3">
                            <label for="Birthday" class="form-label">Date of Birth <span class="text-muted">(Required)</span></label>
                            <input type="date" name="Birthday" id="Birthday" class="form-control" value="{{ old('Birthday') }}" required>
                            @error('Birthday') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="PhoneNumber" class="form-label">Phone Number <span class="text-muted">(Required)</span></label>
                            <input type="tel" name="PhoneNumber" id="PhoneNumber" class="form-control" placeholder="e.g., 09123456789" pattern="[0-9]{11}" value="{{ old('PhoneNumber') }}" required>
                            @error('PhoneNumber') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender <span class="text-muted">(Required)</span></label>
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Gender" id="GenderMale" value="Male" {{ old('Gender') == 'Male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="GenderMale">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Gender" id="GenderFemale" value="Female" {{ old('Gender') == 'Female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="GenderFemale">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Gender" id="GenderNonBinary" value="NonBinary" {{ old('Gender') == 'NonBinary' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="GenderNonBinary">Non-Binary</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Gender" id="GenderCustom" value="Custom" {{ old('Gender') == 'Custom' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="GenderCustom">Custom</label>
                                </div>
                            </div>
                            <div id="customGenderField" class="mt-3" style="display: {{ old('Gender') == 'Custom' ? 'block' : 'none' }};">
                                <label for="CustomGender" class="form-label">Please specify</label>
                                <input type="text" name="CustomGender" id="CustomGender" class="form-control" placeholder="Enter your gender" value="{{ old('CustomGender') }}">
                            </div>
                            @error('Gender') <small class="text-danger">{{ $message }}</small> @enderror
                            @error('CustomGender') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Address and Salary -->
                <div class="row g-4 mt-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Address" class="form-label">Address <span class="text-muted">(Required)</span></label>
                            <textarea name="Address" id="Address" class="form-control" rows="2" placeholder="Enter full address" required>{{ old('Address') }}</textarea>
                            @error('Address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Salary" class="form-label">Salary <span class="text-muted">(Required)</span></label>
                            <input type="number" name="Salary" id="Salary" class="form-control" placeholder="e.g., 50000" value="{{ old('Salary') }}" required min="0" step="0.01">
                            @error('Salary') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2" style="border-radius: 8px;">Submit Employee Details</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- External Dependencies -->
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500&family=Raleway:wght@400;500&display=swap" rel="stylesheet">

<style>
    .form-control:focus, .form-select:focus {
        border-color: #d4af37 !important;
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25) !important;
    }
    .btn:hover {
        background: #d4af37;
        color: #2c2c54;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(212, 175, 55, 0.4);
    }
    .form-control, .form-select, .btn {
        transition: all 0.3s ease;
    }
    .form-control:hover, .form-select:hover {
        border-color: #c7cbd4;
    }
    .form-label {
        margin-bottom: 0.75rem;
    }
    .text-muted {
        font-size: 0.85rem;
    }
    .form-control, .form-select, textarea.form-control {
        height: 46px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const genderRadios = document.querySelectorAll('input[name="Gender"]');
        const customGenderField = document.getElementById('customGenderField');

        genderRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                customGenderField.style.display = this.value === 'Custom' ? 'block' : 'none';
            });
        });

        // Prevent numbers in name fields
        ['FirstName', 'LastName', 'MiddleName'].forEach(id => {
            const input = document.getElementById(id);
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^A-Za-z\s\-]/g, '');
            });
        });
    });
</script>

@endsection
