<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-3">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 p-0">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 rounded-pill px-4 py-2" placeholder="Search..."
                aria-label="Search" aria-describedby="search-button">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary rounded-pill ml-2 px-3" type="button" id="search-button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Notification Icon -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle position-relative" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-lg" style="transition: transform 0.3s ease; transform: scale(1.1);"></i>
        
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--fade-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header text-muted">Notifications</h6>
                <a class="dropdown-item" href="#">
                    A new report is ready to download!
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center small text-primary" href="#">View all notifications</a>
            </div>
        </li>

        <!-- Messages Icon -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle position-relative" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-lg" style="transition: transform 0.3s ease; transform: scale(1.1);"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--fade-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header text-muted">Messages</h6>
                <a class="dropdown-item" href="#">
                    Hey! How are you doing?
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center small text-primary" href="#">View all messages</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle mr-2 shadow-sm" 
                     src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('img/undraw_profile.svg') }}" 
                     alt="Profile Picture" style="width: 36px; height: 36px;">
                <span class="mr-2 d-none d-lg-inline text-gray-700 small font-weight-bold">
                    {{ Auth::user()->full_name ?? 'Guest' }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--fade-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
