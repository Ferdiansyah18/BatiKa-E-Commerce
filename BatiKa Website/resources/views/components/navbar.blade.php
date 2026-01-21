<nav class="navbar navbar-expand-lg fixed-top z-5 py-3 navbar-glass transition-all">
    <div class="container">
        
        <a class="navbar-brand fw-bold fs-3" href="#" style="color: var(--color-primary); letter-spacing: -0.5px;">
            BatiKa.
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 gap-lg-3 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }} fw-medium px-2" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('collections') ? 'active' : '' }} fw-medium px-2" href="{{ url('/collections') }}">Shop</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-4 mt-3 mt-lg-0">
                @auth
                    @if(!auth()->user()->hasAnyRole(['admin', 'owner']))
                        <a href="{{ route('cart.index') }}" class="nav-icon position-relative transition-all text-dark">
                            <i class="bi bi-cart2 fs-4"></i>
                                @php
                                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                                @endphp
                                @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.6rem;">
                                    {{ $cartCount }}
                                </span>
                                @endif
                        </a>
                    @endif
                @endauth
                
                @auth
                    <a href="{{ route('account.dashboard') }}" class="profile-link">
                        <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=C89D66&color=fff' }}" 
                             alt="{{ Auth::user()->name }}" 
                             height="40" width="40" 
                             class="rounded-circle object-fit-cover shadow-sm border border-2 border-white">
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>