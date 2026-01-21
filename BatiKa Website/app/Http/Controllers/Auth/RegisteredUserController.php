<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Carbon;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinute();

        // Store registration data in session
        $request->session()->put('registration_data', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt,
            'updated_at' => now(), // For throttling
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('otp.notice');
    }
}
