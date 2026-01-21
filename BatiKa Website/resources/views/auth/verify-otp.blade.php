<x-guest-layout>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow p-5" style="width: 420px; border-radius: 16px;">

            {{-- Title --}}
            <h3 class="text-center fw-bold mb-4">Account Verification</h3>

            <div class="mb-4 text-center small text-muted">
                {{ __('Please enter the 6-digit verification code sent to your email address.') }}
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert alert-success small">{{ session('status') }}</div>
            @endif
             @if (session('error'))
                <div class="alert alert-danger small">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('otp.verify') }}">
                @csrf



                {{-- OTP Code --}}
                <div class="mb-3">
                    <label for="otp" class="form-label text-center w-100">{{ __('Verification Code') }}</label>
                    <input id="otp" type="text" name="otp"
                        class="form-control text-center fs-4 tracking-widest @error('otp') is-invalid @enderror"
                        value="{{ old('otp') }}" required autofocus autocomplete="one-time-code" maxlength="6"
                        style="letter-spacing: 0.5em;">

                    @error('otp')
                        <div class="invalid-feedback text-center">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Timer --}}
                <div class="text-center mb-3">
                    <span id="timer" class="text-danger fw-bold"></span>
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" id="verifyBtn" class="btn btn-dark py-2 fw-semibold">
                        {{ __('Verify Account') }}
                    </button>
                </div>
            </form>

            {{-- Resend Option --}}
            <form method="POST" action="{{ route('otp.resend') }}" class="mt-3 text-center">
                @csrf

                <button type="submit" id="resendBtn" class="btn btn-link text-decoration-none text-muted small" disabled>
                    Resend Code (<span id="resendTimer">{{ sprintf('%02d:%02d', floor($remaining_cooldown / 60), $remaining_cooldown % 60) }}</span>)
                </button>
            </form>

        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function formatTime(seconds) {
                var m = Math.floor(seconds / 60);
                var s = Math.floor(seconds % 60);
                return (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s);
            }

            // OTP Expiration Timer
            var remainingOtpTime = {{ $otp_remaining_seconds }};
            var timerElement = document.getElementById('timer');
            var verifyBtn = document.getElementById('verifyBtn');
            
            // Initial call to set text immediately
            if (remainingOtpTime > 0) {
                 timerElement.innerHTML = formatTime(remainingOtpTime);
            } else {
                 timerElement.innerHTML = "Code Expired";
                 timerElement.classList.add('text-danger');
                 verifyBtn.disabled = true;
            }

            if (remainingOtpTime > 0) {
                var countdown = setInterval(function() {
                    remainingOtpTime--;
                    
                    if (remainingOtpTime < 0) {
                        clearInterval(countdown);
                        timerElement.innerHTML = "Code Expired";
                        timerElement.classList.add('text-danger');
                        verifyBtn.disabled = true;
                    } else {
                        timerElement.innerHTML = formatTime(remainingOtpTime);
                    }
                }, 1000);
            }

            // Resend Cooldown Timer
            var resendBtn = document.getElementById('resendBtn');
            var resendTimerSpan = document.getElementById('resendTimer');
            var remainingCooldown = {{ $remaining_cooldown }};
            
            // Initial text
            if(remainingCooldown > 0) {
                 resendTimerSpan.textContent = formatTime(remainingCooldown);
            }

            if (remainingCooldown > 0) {
                var resendInterval = setInterval(function() {
                    remainingCooldown--;
                    resendTimerSpan.textContent = formatTime(remainingCooldown);

                    if (remainingCooldown <= 0) {
                        clearInterval(resendInterval);
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = "Resend Code";
                        resendBtn.classList.remove('text-muted');
                        resendBtn.classList.add('text-primary');
                    }
                }, 1000);
            } else {
                resendBtn.disabled = false;
                resendBtn.innerHTML = "Resend Code";
                resendBtn.classList.remove('text-muted');
                resendBtn.classList.add('text-primary');
            }
        });
    </script>
</x-guest-layout>
