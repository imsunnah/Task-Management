<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="{{ route('dashboard') }}">

            <span class="text-white tracking-tight">Task <span class="text-gray">Manager</span></span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto bg-dark-mobile rounded-pill px-3">
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'active rounded-pill bg-primary bg-opacity-10 text-primary' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2-fill me-1 small"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 {{ request()->routeIs('tasks.*') ? 'active rounded-pill bg-primary bg-opacity-10 text-primary' : '' }}" href="{{ route('tasks.index') }}">
                        Tasks
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 {{ request()->routeIs('events.*') ? 'active rounded-pill bg-primary bg-opacity-10 text-primary' : '' }}" href="{{ route('events.index') }}">
                        Events
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 {{ request()->routeIs('calendar.*') ? 'active rounded-pill bg-primary bg-opacity-10 text-primary' : '' }}" href="{{ route('calendar.index') }}">
                        Calendar
                    </a>
                </li>

                @if (auth()->check() && auth()->user()->isAdmin())
                <li class="nav-item mx-1">
                    <a class="nav-link px-3 {{ request()->routeIs('users.*') ? 'active rounded-pill bg-primary bg-opacity-10 text-primary' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-people me-1"></i> Users
                    </a>
                </li>
                @endif
            </ul>

            <div class="navbar-nav">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center bg-light bg-opacity-10 rounded-pill px-3 py-1" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D6EFD&color=fff" class="rounded-circle me-2" width="28" height="28" alt="Avatar">
                        <span class="text-white small fw-medium">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 rounded-4" aria-labelledby="userDropdown">
                        <li>
                            <h6 class="dropdown-header">Manage Account</h6>
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
