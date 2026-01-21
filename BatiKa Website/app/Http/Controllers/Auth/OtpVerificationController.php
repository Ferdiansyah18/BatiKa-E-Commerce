<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpVerificationController extends Controller
{
    public function show(Request $request)
    {
        // Must have registration data in session
        if (!$request->session()->has('registration_data')) {
            return redirect()->route('register');
        }

        $idxData = $request->session()->get('registration_data');
        
        // Calculate remaining seconds for cooldown
        $lastSent = $idxData['updated_at'];
        $cooldown = 30; 
        $secondsSinceLastSent = now()->diffInSeconds($lastSent);
        $remainingCooldown = max(0, $cooldown - $secondsSinceLastSent);

        // Calculate usage OTP expiration remaining seconds
        $otpRemainingSeconds = max(0, (int) now()->diffInSeconds($idxData['otp_expires_at'], false));

        return view('auth.verify-otp', [
            'email' => $idxData['email'],
            'otp_remaining_seconds' => $otpRemainingSeconds,
            'remaining_cooldown' => $remainingCooldown
        ]);
    }

    public function resend(Request $request)
    {
        if (!$request->session()->has('registration_data')) {
            return redirect()->route('register');
        }

        $data = $request->session()->get('registration_data');

        // Check throttle (30 seconds)
        $lastSent = $data['updated_at'];
        if ($lastSent->diffInSeconds(now()) < 30) {
            return back()->with('error', 'Please wait before requesting a new code.');
        }

        $otp = rand(100000, 999999);
        $data['otp_code'] = $otp;
        $data['otp_expires_at'] = now()->addMinute();
        $data['updated_at'] = now();

        $request->session()->put('registration_data', $data);

        Mail::to($data['email'])->send(new OtpMail($otp));

        return back()->with('status', 'A new verification code has been sent to your email.');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!$request->session()->has('registration_data')) {
            return redirect()->route('register');
        }

        $data = $request->session()->get('registration_data');

        if ($data['otp_code'] != $request->otp) {
            throw ValidationException::withMessages([
                'otp' => ['The provided code is invalid.'],
            ]);
        }

        if ($data['otp_expires_at'] < now()) {
             throw ValidationException::withMessages([
                'otp' => ['The code has expired. Please request a new one.'],
            ]);
        }

        // OTP Valid - Create User
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'email_verified_at' => now(),
        ]);

        // Login the user
        Auth::login($user);

        // Clear session
        $request->session()->forget('registration_data');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
