{{-- filepath: c:\wamp64\www\project\resources\views\employee\master.blade.php --}}
@extends('layouts.main')

@section('content')
    <div class="container my-5 px-3 px-md-4">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-semibold text-dark mb-0">Master List</h2>
            <a href="{{ route('employee.add') }}" class="btn btn-outline-dark btn-sm px-3 py-2 rounded-1 shadow-sm">
                <i class="fas fa-plus me-2"></i>Add Employee
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('message'))
            <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show rounded-1 mb-4 border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <div>{{ session('message') }}</div>
                </div>
            </div>
        @endif

        {{-- Error Message for Existing Employee --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-1 mb-4 border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2 text-danger"></i>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
        @endif

        {{-- Employee Table --}}
        @if($employees->count())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            {{-- Table Header --}}
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="ps-4 py-3 text-start fw-medium small text-uppercase" style="width: 5%;">ID</th>
                                    <th class="py-3 text-center fw-medium small text-uppercase" style="width: 8%;">Photo</th>
                                    <th class="py-3 text-start fw-medium small text-uppercase" style="width: 18%;">Employee</th>
                                    <th class="py-3 text-center fw-medium small text-uppercase" style="width: 18%;">Email</th>
                                    <th class="py-3 text-center fw-medium small text-uppercase" style="width: 12%;">Birthday</th>
                                    <th class="py-3 text-center fw-medium small text-uppercase" style="width: 10%;">Phone</th>
                                    <th class="py-3 text-start fw-medium small text-uppercase" style="width: 15%;">Address</th>
                                    <th class="py-3 text-center fw-medium small text-uppercase" style="width: 8%;">Gender</th>
                                    <th class="pe-4 py-3 text-end fw-medium small text-uppercase" style="width: 8%;">Salary</th>
                                    <th class="py-3 text-center fw-medium small text-uppercase" style="width: 8%;">Actions</th>
                                </tr>
                            </thead>
                            {{-- Table Body --}}
                            <tbody>
                                @foreach($employees as $employee)
                                    <tr class="{{ $employee->trashed() ? 'bg-light text-muted' : '' }} hover-row">
                                        {{-- ID --}}
                                        <td class="ps-4 py-3 text-start small text-muted">
                                            {{ $employee->id }}
                                        </td>
                                        {{-- Photo --}}
                                        <td class="py-3 text-center">
                                            <img src="{{ $employee->profile_picture ? asset('storage/' . $employee->profile_picture) : asset('images/default-avatar.png') }}" alt="Profile Picture" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #eee;">
                                        </td>
                                        {{-- Full Name --}}
                                        <td class="py-3 text-start px-2">
                                            <a href="{{ route('employee.profile', $employee->id) }}" class="fw-medium small text-decoration-none text-dark hover-underline">
                                                {{ implode(' ', array_filter([$employee->first_name, $employee->middle_name, $employee->last_name, $employee->suffix])) }}
                                            </a>
                                        </td>
                                        

                                        {{-- Email --}}
                                        <td class="py-3 text-center small text-muted px-2">
                                            {{ $employee->user->email ?? 'N/A' }}
                                        </td>

                                        {{-- Birthday --}}
                                        <td class="py-3 text-center small text-muted px-2">
                                            {{ \Carbon\Carbon::parse($employee->birthday)->format('d M Y') }}
                                        </td>

                                        {{-- Phone --}}
                                        <td class="py-3 text-center small text-muted">
                                            {{ $employee->phone_number }}
                                        </td>

                                        {{-- Address --}}
                                        <td class="py-3 text-start small text-muted">
                                            {{ $employee->address }}
                                        </td>

                                        {{-- Gender --}}
                                        <td class="py-3 text-center">
                                            <span class="badge bg-{{ strtolower($employee->gender) === 'male' ? 'primary' : 'warning' }}-subtle text-{{ strtolower($employee->gender) === 'male' ? 'primary' : 'warning' }} rounded-pill px-3 py-1">
                                                {{ ucfirst($employee->gender) }}
                                            </span>
                                        </td>

                                        {{-- Salary --}}
                                        <td class="pe-4 py-3 text-end fw-medium small">
                                            ${{ number_format($employee->salary, 2) }}
                                        </td>

                                        {{-- Actions --}}
                                        <td class="py-3 text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2" style="min-height: 32px;">
                                                {{-- Edit --}}
                                                <a href="{{ route('employee.edit', $employee->id) }}"
                                                   class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center action-btn shadow-sm"
                                                   style="width: 32px; height: 32px;"
                                                   title="Edit Employee"
                                                   data-bs-toggle="tooltip"
                                                   aria-label="Edit Employee">
                                                    <i class="fas fa-pencil-alt fa-xs"></i>
                                                </a>

                                                {{-- Restore/Delete --}}
                                                @if($employee->trashed())
                                                    <form action="{{ route('employee.restore', $employee->id) }}" method="POST" class="d-inline m-0">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-warning rounded-circle d-flex align-items-center justify-content-center action-btn shadow-sm"
                                                                style="width: 32px; height: 32px;"
                                                                title="Restore Employee"
                                                                data-bs-toggle="tooltip"
                                                                aria-label="Restore Employee">
                                                            <i class="fas fa-undo fa-xs"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('employee.delete', $employee->id) }}" method="POST" class="d-inline m-0"
                                                          onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center action-btn shadow-sm"
                                                                style="width: 32px; height: 32px;"
                                                                title="Delete Employee"
                                                                data-bs-toggle="tooltip"
                                                                aria-label="Delete Employee">
                                                            <i class="fas fa-trash fa-xs"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            {{-- No Employees Found --}}
            <div class="card border-0 text-center p-5 shadow-sm">
                <i class="fas fa-user-slash text-muted fs-1 mb-3 opacity-25"></i>
                <h4 class="text-muted fw-light">No Employees Found</h4>
                <p class="text-muted small mb-4">Add your first employee to get started</p>
                <a href="{{ route('employee.add') }}" class="btn btn-outline-dark rounded-1 px-4 shadow-sm">
                    Add Employee
                </a>
            </div>
        @endif
    </div>
@endsection
