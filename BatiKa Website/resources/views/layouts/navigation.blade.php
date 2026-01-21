<nav class="navbar navbar-expand-lg navbar-glass sticky-top mb-4">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}" style="color: var(--color-primary); font-size: 1.5rem;">
            BatiKa.
        </a>

        <!-- Hamburger for mobile -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Side: Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                @role('owner|admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        {{ __('Products') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        {{ __('Categories') }}
                    </a>
                </li>
                @endrole
            </ul>

            <!-- Right Side: Settings Dropdown -->
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="bg-primary bg-opacity-10 rounded-circle text-primary d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="fw-medium">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                        <li>
                            <a class="dropdown-item rounded-3 mb-1" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i> {{ __('Profile') }}
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button" class="dropdown-item rounded-3 text-danger" onclick="confirmLogout()">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of your session.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>
@endpush
