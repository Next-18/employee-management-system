<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">EMS</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    @if(auth()->user()->role === 'admin')
    <!-- Admin: Employee Management -->
    <div class="sidebar-heading">Employee Management</div>

    <li class="nav-item {{ request()->routeIs('employee.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employeeMenu" aria-expanded="false" aria-controls="employeeMenu">
            <i class="fas fa-users"></i>
            <span>Employees</span>
        </a>
        <div id="employeeMenu" class="collapse {{ request()->routeIs('employee.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage Employees</h6>
                <a class="collapse-item {{ request()->routeIs('employee.add') ? 'active' : '' }}" href="{{ route('employee.add') }}">
                    <i class="fas fa-user-plus mr-2 text-primary"></i> Add Employee
                </a>
                <a class="collapse-item {{ request()->routeIs('employee.master') ? 'active' : '' }}" href="{{ route('employee.master') }}">
                    <i class="fas fa-list mr-2 text-primary"></i> Master List
                </a>
            </div>
        </div>
    </li>

    <!-- Admin: Attendance Management -->
    <div class="sidebar-heading">Attendance Management</div>

    <li class="nav-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#attendanceMenu" aria-expanded="false" aria-controls="attendanceMenu">
            <i class="fas fa-calendar-check"></i>
            <span>Attendance</span>
        </a>
        <div id="attendanceMenu" class="collapse {{ request()->routeIs('attendance.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Attendance Actions</h6>
                <a class="collapse-item {{ request()->routeIs('attendance.pending') ? 'active' : '' }}" href="{{ route('attendance.pending') }}">
                    <i class="fas fa-clock mr-2 text-primary"></i> Pending Approvals
                </a>
                <a class="collapse-item {{ request()->routeIs('attendance.summary') ? 'active' : '' }}" href="{{ route('attendance.summary') }}">
                    <i class="fas fa-chart-pie mr-2 text-primary"></i> Summary
                </a>
                <a class="collapse-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                    <i class="fas fa-history mr-2 text-primary"></i> History
                </a>
            </div>
        </div>
    </li>

    <!-- Admin: Leave Management -->
    <div class="sidebar-heading">Leave Management</div>

    <li class="nav-item {{ request()->routeIs('leave.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('leave.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Manage Leaves</span>
        </a>
    </li>
    @endif

    @if(auth()->user()->role === 'employee')
    <!-- Employee: Quick Actions -->
    <div class="sidebar-heading">My Tools</div>

    <li class="nav-item {{ request()->routeIs('attendance.create') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('attendance.create') }}">
            <i class="fas fa-user-check"></i>
            <span>Mark Attendance</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('leave.create') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('leave.create') }}">
            <i class="fas fa-calendar-plus"></i>
            <span>Request Leave</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">
</ul>
