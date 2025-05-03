<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group shadow-sm">
            <input type="text" class="form-control bg-light border-0 small rounded-pill px-4" placeholder="Search for..."
                aria-label="Search" aria-describedby="search-button">
            <div class="input-group-append">
                <button class="btn btn-primary rounded-pill ml-2 px-3" type="button" id="search-button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Notification Icon -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle position-relative" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter animate__animated animate__bounceIn">3+</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--fade-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Notifications</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="icon-circle bg-primary text-white mr-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2023</div>
                        <span class="font-weight-bold">A new report is ready to download!</span>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center small text-primary" href="#">View all notifications</a>
            </div>
        </li>

        <!-- Messages Icon -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle position-relative" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-success badge-counter animate__animated animate__bounceIn">7</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--fade-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">Messages</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="User" style="width:40px; height:40px;">
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">Hey! How are you doing?</div>
                        <div class="small text-gray-500">Emily · 1h ago</div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center small text-primary" href="#">View all messages</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
