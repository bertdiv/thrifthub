<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function show()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
{
    $request->validate([
        'otp' => ['required']
    ]);

    $data = session('register_data');

    if (!$data) {

        return redirect()->route('register')
            ->withErrors([
                'otp' => 'Session expired.'
            ]);
    }

    // Check OTP
    if (
        $data['otp_code'] != $request->otp ||
        now()->greaterThan($data['otp_expires_at'])
    ) {

        return back()->withErrors([
            'otp' => 'Invalid or expired OTP.'
        ]);
    }

    // Create user ONLY AFTER OTP VERIFIED
    $user = User::create([

        'name' => $data['name'],

        'email' => $data['email'],

        'contact_number' => $data['contact_number'],

        'address' => $data['address'] ?? null,

        'facebook_link' => $data['facebook_link'] ?? null,

        'messenger_link' => $data['messenger_link'] ?? null,

        'password' => Hash::make($data['password']),

        'role' => 'seller',

        'is_verified' => true,

    ]);

    // Clear session
    session()->forget('register_data');

    // Auto login
    Auth::login($user);

    return redirect('/dashboard')
        ->with('success', 'Account created successfully.');
}
}