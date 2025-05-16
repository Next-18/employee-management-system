@extends('layouts.main')
@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f7f8fa 0%, #e3e9f0 100%);
    }
    .dashboard-header {
        margin-bottom: 30px;
        border-bottom: 2px solid #e9ecef;
        background: linear-gradient(90deg, #2c2c54 60%, #4e54c8 100%);
        color: #fff;
        border-radius: 1.5rem 1.5rem 0 0;
        padding: 2rem 1.5rem 1.2rem 1.5rem;
        box-shadow: 0 4px 24px rgba(44,44,84,0.10);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .dashboard-header h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0;
    }
    .dashboard-header i {
        font-size: 2.5rem;
        color: #fff;
        margin-right: 1rem;
    }
    .dashboard-card {
        transition: box-shadow 0.3s, transform 0.3s ease;
        border-radius: 1.2rem;
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(6px);
        border: 1px solid #e3e9f0;
        box-shadow: 0 8px 32px rgba(44,44,84,0.10);
    }
    .dashboard-card:hover {
        box-shadow: 0 16px 48px rgba(44,44,84,0.18);
        transform: translateY(-8px) scale(1.04);
        background: rgba(255,255,255,0.85);
    }
    .dashboard-icon {
        font-size: 2.8rem;
        margin-bottom: 0.8rem;
        transition: color 0.3s ease;
    }
    .dashboard-card:hover .dashboard-icon {
        color: #007bff;
    }
    .dashboard-section-title {
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: 0.8px;
        margin-bottom: 0.6rem;
        color: #333;
    }
    .list-group-item {
        border: none;
        border-bottom: 1px solid #f0f0f0;
        padding: 12px 15px;
        background: rgba(255,255,255,0.6);
        transition: background 0.2s;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    .list-group-item:hover {
        background: #f1f1f1;
    }
    .badge {
        font-size: 1rem;
        padding: 8px 15px;
        border-radius: 1.5rem;
        text-transform: uppercase;
        font-weight: 700;
    }
    .badge.bg-gradient {
        background: linear-gradient(135deg, #6c757d, #495057);
    }
    .card-header {
        background-color: #007bff;
        color: white;
        font-weight: 600;
        padding: 16px 20px;
        border-radius: 1.2rem 1.2rem 0 0;
        font-size: 1.1rem;
    }
    .card-header i {
        font-size: 1.3rem;
        margin-right: 10px;
    }
    @media (max-width: 768px) {
        .dashboard-card {
            padding: 20px;
        }
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 1.2rem 0.7rem 1rem 0.7rem;
        }
        .dashboard-header h2 {
            font-size: 1.3rem;
        }
    }
</style>

<div class="container my-5 px-3 px-md-4">
    <div class="dashboard-header">
        <div class="d-flex align-items-center">
            <i class="bi bi-speedometer2"></i>
            <h2>Admin Dashboard</h2>
        </div>
        <span class="badge bg-gradient">Admin Panel</span>
    </div>

    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card dashboard-card text-center py-3">
                <div class="dashboard-icon text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="dashboard-section-title">Total Employees</div>
                <div class="display-5 fw-bold text-primary">{{ $employeeCount }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card text-center py-3">
                <div class="dashboard-icon text-success">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="dashboard-section-title">Total Attendance Records</div>
                <div class="display-5 fw-bold text-success">{{ $attendanceCount }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card text-center py-3">
                <div class="dashboard-icon text-warning">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="dashboard-section-title">Total Leave Requests</div>
                <div class="display-5 fw-bold text-warning">{{ $leaveCount }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
