<x-guest-layout>
    <div class="container-fluid min-vh-100 p-0">
        <div class="row min-vh-100 g-0">
            
            {{-- Left Side: Image & Branding (Using Hero Image for Variety) --}}
            <div class="col-lg-6 d-none d-lg-block position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 w-100 h-100" 
                     style="background-image: url('{{ asset('images/register-new.jpg') }}'); background-size: cover; background-position: center;">
                </div>
                {{-- Dark Overlay --}}
                <div class="position-absolute top-0 start-0 w-100 h-100" 
                     style="background: linear-gradient(135deg, rgba(82, 60, 40, 0.85), rgba(46, 32, 28, 0.9));">
                </div>
                
                {{-- Content Over Image --}}
                <div class="position-relative z-1 h-100 d-flex flex-column justify-content-center px-5 text-white">
                    <h1 class="display-3 fw-bold mb-3">Join BatiKa.</h1>
                    <p class="fs-4 fw-light ls-1">Experience the elegance of Indonesian Heritage.</p>
                    <div class="mt-4" style="width: 80px; height: 3px; background-color: #C89D66;"></div>
                </div>
            </div>

            {{-- Right Side: Register Form --}}
            <div class="col-lg-6 d-flex justify-content-center align-items-center bg-white">
                <div class="w-100 p-5 p-lg-5" style="max-width: 500px;">
                    
                    {{-- Mobile Branding --}}
                    <div class="text-center mb-4 d-lg-none">
                        <h2 class="fw-bold" style="color: var(--color-primary);">BatiKa</h2>
                    </div>

                    <div class="text-start mb-5">
                        <h2 class="fw-bold text-dark">Create Account</h2>
                        <p class="text-muted">Start your journey with us today.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-4" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus autocomplete="name">
                            <label for="name">Full Name</label>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-4" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="username">
                            <label for="email">Email Address</label>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control rounded-4" id="phone" name="phone" placeholder="08123456789" value="{{ old('phone') }}" required>
                            <label for="phone">Phone Number</label>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control rounded-4" id="password" name="password" placeholder="Password" required autocomplete="new-password" style="padding-right: 40px;">
                            <label for="password">Password</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; z-index: 10;" onclick="togglePassword('password', this)">
                                <i class="bi bi-eye text-muted"></i>
                            </span>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-floating mb-4 position-relative">
                            <input type="password" class="form-control rounded-4" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" style="padding-right: 40px;">
                            <label for="password_confirmation">Confirm Password</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; z-index: 10;" onclick="togglePassword('password_confirmation', this)">
                                <i class="bi bi-eye text-muted"></i>
                            </span>
                            @error('password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Register Button --}}
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm mb-4">
                            Sign Up
                        </button>

                        {{-- Divider --}}
                        <div class="position-relative text-center mb-4">
                            <hr class="text-muted opacity-25">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">OR</span>
                        </div>

                        {{-- Login Link --}}
                        <div class="text-center">
                            <span class="text-muted small">Already have an account?</span>
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none ms-1" style="color: var(--color-primary);">
                                Sign In
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, element) {
            const input = document.getElementById(inputId);
            const icon = element.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</x-guest-layout>
