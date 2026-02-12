@props(['textColor' => 'text-dark'])

<nav class="navbar fixed-top py-3 navbar-glass transition-all" 
     x-data="{ 
        menuOpen: false,
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
            if (this.menuOpen) {
                document.body.style.overflow = 'hidden'; // Lock Scroll
                // Open Animation
                gsap.to('.fullscreen-menu', { duration: 0.5, opacity: 1, pointerEvents: 'all', ease: 'power2.out' });
                // Animasi Link Besar: Dari Kanan (x: 100) ke Posisi Awal (x: 0)
                gsap.fromTo('.menu-link-large', 
                    { x: 100, opacity: 0 },
                    { duration: 0.6, x: 0, opacity: 1, stagger: 0.1, ease: 'power2.out', delay: 0.2 }
                );
                // Animasi Link Kecil: Dari Kanan (x: 50) ke Posisi Awal (x: 0)
                gsap.fromTo('.menu-link-small', 
                    { x: 50, opacity: 0 },
                    { duration: 0.5, x: 0, opacity: 1, stagger: 0.05, ease: 'power2.out', delay: 0.4 }
                );
            } else {
                document.body.style.overflow = ''; // Unlock Scroll
                // Close Animation
                gsap.to('.fullscreen-menu', { duration: 0.4, opacity: 0, pointerEvents: 'none', ease: 'power2.in' });
            }
        }
     }">
     
    <div class="container d-flex align-items-center justify-content-between">
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3 transition-colors position-relative z-index-50" href="#" style="color: var(--color-primary); letter-spacing: -0.5px; z-index: 99999;">
            BatiKa.
        </a>

        <!-- Right Side: Menu Toggler -->
        <div class="d-flex align-items-center gap-4">
            
            <!-- Menu Button -->
            <button @click="toggleMenu()" class="btn btn-link text-decoration-none p-0 border-0 d-flex align-items-center gap-2 position-relative z-index-50" style="z-index: 99999;">
                <i class="bi fs-1 transition-all" 
                   :class="{'bi-list': !menuOpen, 'bi-x-lg': menuOpen, 'text-primary': !menuOpen, 'text-white': menuOpen}"></i>
            </button>
        </div>
    </div>

    <!-- Fullscreen Menu Overlay -->
    <template x-teleport="body">
        <div class="fullscreen-menu position-fixed top-0 start-0 w-100 h-100 bg-dark text-white d-flex flex-column" 
             style="opacity: 0; pointer-events: none; z-index: 9999;">
            
            <!-- Internal Header (Logo & Close Button) -->
            <div class="container py-4 flex-shrink-0">
                <div class="d-flex align-items-center justify-content-between">
                    <!-- Internal Logo -->
                    <a class="fw-bold fs-3 text-decoration-none" href="#" style="color: var(--color-primary); letter-spacing: -0.5px;">
                        BatiKa.
                    </a>

                    <!-- Internal Close Button -->
                    <button @click="toggleMenu()" class="btn btn-link text-decoration-none p-0 border-0 d-flex align-items-center gap-2">
                        <i class="bi bi-x-lg fs-1 text-primary"></i>
                    </button>
                </div>
            </div>

            <div class="container flex-grow-1 d-flex align-items-center">
                <div class="row w-100">
                    <div class="col-12">
                        <ul class="list-unstyled mb-0">
                            <li class="overflow-hidden mb-5">
                                <a href="{{ url('/') }}" class="menu-link-large d-inline-block text-white fw-bold text-decoration-none display-2 lh-1" @click="toggleMenu()">
                                    <span class="hover-split-text">HOME</span>
                                </a>
                            </li>
                            <li class="overflow-hidden mb-5">
                                <a href="{{ url('/collections') }}" class="menu-link-large d-inline-block text-white fw-bold text-decoration-none display-2 lh-1" @click="toggleMenu()">
                                    <span class="hover-split-text">COLLECTIONS</span>
                                </a>
                            </li>
                            
                            @auth
                            @if(!auth()->user()->hasAnyRole(['admin', 'owner']))
                            <li class="overflow-hidden mb-5">
                                <a href="{{ route('cart.index') }}" class="menu-link-large d-inline-block text-white fw-bold text-decoration-none display-2 lh-1" @click="toggleMenu()">
                                    <span class="hover-split-text">CART</span>
                                    @php
                                        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                                    @endphp
                                    @if($cartCount > 0)
                                    <span class="fs-4 align-middle text-warning">({{ $cartCount }})</span>
                                    @endif
                                </a>
                            </li>
                            @endif

                            <li class="overflow-hidden mb-5">
                                <a href="{{ route('account.dashboard') }}" class="menu-link-large d-inline-flex align-items-center gap-4 text-white fw-bold text-decoration-none display-2 lh-1" @click="toggleMenu()">
                                    <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=C89D66&color=fff' }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="rounded-circle object-fit-cover border border-3 border-white flex-shrink-0"
                                         style="width: 80px; height: 80px;">
                                    <span class="hover-split-text">{{ Str::limit(Auth::user()->name, 15) }}</span>
                                </a>
                            </li>
                            @else
                            <li class="overflow-hidden mb-5">
                                <a href="{{ route('login') }}" class="menu-link-large d-inline-block text-white fw-bold text-decoration-none display-2 lh-1" @click="toggleMenu()">
                                    <span class="hover-split-text">LOGIN</span>
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="container p-4">
                <div class="d-flex justify-content-between text-white-50 small">
                    <span>&copy; 2026 BatiKa, Inc. All rights reserved.</span>
                </div>
            </div>
        </div>
    </template>
</nav>