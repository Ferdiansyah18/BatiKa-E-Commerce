<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow p-5" style="width: 420px; border-radius: 16px;">
            
            <h3 class="text-center fw-bold mb-4">Create Account</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required autofocus autocomplete="name">

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autocomplete="username">

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required autocomplete="new-password">

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        required autocomplete="new-password">

                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}" class="text-decoration-none small text-muted">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="btn btn-dark px-4 py-2 fw-semibold">
                        {{ __('Register') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
