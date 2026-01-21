<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow p-5" style="width: 420px; border-radius: 16px;">

            {{-- Title --}}
            <h3 class="text-center fw-bold mb-4">Welcome Back</h3>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert alert-success small">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus autocomplete="username">

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required autocomplete="current-password">

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="mb-3 form-check">
                    <input id="remember" type="checkbox" name="remember" class="form-check-input">
                    <label for="remember" class="form-check-label small">
                        {{ __('Remember me') }}
                    </label>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none small text-muted">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="btn btn-dark px-4 py-2 fw-semibold">
                        {{ __('Log in') }}
                    </button>
                </div>

            </form>

            {{-- Footer --}}
            <div class="text-center mt-4 small">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
                    Create Account
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
