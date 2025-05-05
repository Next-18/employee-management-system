@php
    $user = auth()->user();
    $employee = $user?->employee;

    $fullName = collect([
        $employee?->first_name ?? $user?->first_name,
        $employee?->middle_name ?? $user?->middle_name,
        $employee?->last_name ?? $user?->last_name,
        $employee?->suffix ?? ''
    ])->filter()->implode(' ');

    $profilePic = $employee && $employee->profile_picture
        ? asset('storage/' . $employee->profile_picture)
        : ($user?->profile_picture
            ? asset('storage/' . $user->profile_picture)
            : asset('images/default-avatar.png'));
@endphp

<style>
    .icon-hover:hover {
        transform: scale(1.2);
        transition: 0.3s ease;
        color: #4e54c8 !important;
    }
    .profile-img-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        background-color: #28a745;
        border: 2px solid white;
        border-radius: 50%;
    }
    .navbar-search input {
        border-radius: 20px !important;
    }
    .navbar-search .btn {
        border-radius: 20px !important;
        background: linear-gradient(90deg, #2c2c54, #4e54c8);
        border: none;
    }
</style>

<nav class="navbar navbar-expand navbar-light bg-white topbar shadow-sm px-3 mb-4">

    <!-- Sidebar Toggle (for small devices) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-2 p-0">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Design-Only Search Bar -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group shadow-sm">
            <input type="text" class="form-control bg-light border-0 small px-4 py-2" placeholder="Search..." disabled>
            <div class="input-group-append">
                <button class="btn btn-secondary px-3" type="button" disabled>
                    <i class="fas fa-search fa-sm text-white"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Right -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Notification Icon -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle icon-hover" href="#" id="alertsDropdown" role="button" data-toggle="dropdown">
                <i class="fas fa-bell fa-lg"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--fade-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header text-muted">Notifications</h6>
                <a class="dropdown-item text-muted small" href="#">No new notifications</a>
            </div>
        </li>

        <!-- Message Icon -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle icon-hover" href="#" id="messagesDropdown" role="button" data-toggle="dropdown">
                <i class="fas fa-envelope fa-lg"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--fade-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header text-muted">Messages</h6>
                <a class="dropdown-item text-muted small" href="#">No new messages</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <div class="position-relative">
                    <img class="img-profile rounded-circle shadow-sm" src="{{ $profilePic }}"
                         alt="User Avatar" style="width: 40px; height: 40px; object-fit: cover;">
                    <div class="profile-img-indicator"></div>
                </div>
                <span class="ml-2 d-none d-lg-inline text-gray-700 small font-weight-bold">
                    {{ $fullName ?: 'Guest' }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--fade-in" aria-labelledby="userDropdown">
                <div class="dropdown-header text-center">
                    <img class="img-profile rounded-circle mb-2 shadow-sm" src="{{ $profilePic }}"
                         style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="text-gray-900 font-weight-bold">{{ $fullName }}</div>
                    <div class="small text-muted">{{ $user?->email ?? 'guest@example.com' }}</div>
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                </a>
                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
