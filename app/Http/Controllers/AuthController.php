<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OtpRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student', // Default role
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        $user = Auth::user();

        // Role-based redirection
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard')->with('success', 'Logged in successfully!');
        } elseif ($user->role === 'lecturer') {
            return redirect('/lecturer/dashboard')->with('success', 'Logged in successfully!');
        }

        // Generate OTP for students
        $otp = rand(100000, 999999);
        OtpRecord::create([
            'user_id' => Auth::id(),
            'code' => Hash::make($otp),
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        session(['otp_debug' => $otp]);

        return redirect('/verify-otp-view');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $otpRecord = OtpRecord::where('user_id', Auth::id())
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if (!$otpRecord || !Hash::check($request->otp, $otpRecord->code)) {
            return response()->json(['message' => 'Invalid or expired OTP'], 401);
        }

        $otpRecord->update(['is_used' => true]);

        return redirect('/dashboard')->with('success', 'OTP verified. Logged in successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
