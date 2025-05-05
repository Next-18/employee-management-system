<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}" aria-current="{{ request()->routeIs('home') ? 'page' : '' }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Employee Management Section -->
    @if(auth()->user()->role === 'admin')
    <div class="sidebar-heading">
        Employee Management
    </div>

    <li class="nav-item {{ request()->routeIs('employee.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employeeMenu" aria-expanded="false" aria-controls="employeeMenu">
            <i class="fas fa-fw fa-users"></i>
            <span>Employees</span>
        </a>
        <div id="employeeMenu" class="collapse {{ request()->routeIs('employee.*') ? 'show' : '' }}" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                <h6 class="collapse-header text-primary font-weight-bold">Employee Actions:</h6>
                <a class="collapse-item {{ request()->routeIs('employee.add') ? 'active' : '' }}" href="{{ route('employee.add') }}">
                    <i class="fas fa-user-plus text-primary mr-2"></i> Add Employees
                </a>
                <a class="collapse-item {{ request()->routeIs('employee.master') ? 'active' : '' }}" href="{{ route('employee.master') }}">
                    <i class="fas fa-list text-primary mr-2"></i> Master List
                </a>
            </div>
        </div>
    </li>
    @endif

    <!-- Attendance Section -->
    <li class="nav-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('attendance.index') }}" aria-current="{{ request()->routeIs('attendance.*') ? 'page' : '' }}">
            <i class="fas fa-calendar-check"></i>
            <span>Attendance</span>
        </a>
    </li>

    <!-- Leave Management Section -->
    <li class="nav-item {{ request()->routeIs('leave.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('leave.index') }}" aria-current="{{ request()->routeIs('leave.*') ? 'page' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Leave Management</span>
        </a>
    </li>

    <!-- Employee-only Quick Links -->
    @if(auth()->user()->role === 'employee')
    <li class="nav-item {{ request()->routeIs('attendance.create') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('attendance.create') }}" aria-current="{{ request()->routeIs('attendance.create') ? 'page' : '' }}">
            <i class="fas fa-user-check"></i>
            <span>Mark Attendance</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('leave.create') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('leave.create') }}" aria-current="{{ request()->routeIs('leave.create') ? 'page' : '' }}">
            <i class="fas fa-calendar-plus"></i>
            <span>Request Leave</span>
        </a>
    </li>
    @endif

 

   
   
 

</ul>
