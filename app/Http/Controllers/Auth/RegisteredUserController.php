<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

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
     * Handle registration request.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'email', 'unique:users'],

            'contact_number' => ['required', 'string', 'max:20'],

            'address' => ['nullable', 'string', 'max:255'],

            'facebook_link' => ['nullable', 'url'],

            'messenger_link' => ['nullable', 'url'],

            'password' => ['required', 'confirmed', 'min:8'],

        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store temporary registration data
        session([
            'register_data' => [

                'name' => $request->name,

                'email' => $request->email,

                'contact_number' => $request->contact_number,

                'address' => $request->address,

                'facebook_link' => $request->facebook_link,

                'messenger_link' => $request->messenger_link,

                'password' => $request->password,

                'role' => 'seller',

                'otp_code' => $otp,

                'otp_expires_at' => now()->addMinutes(10),

            ]
        ]);

        // Send OTP Email
        try {

            Mail::to($request->email)
                ->send(new SendOtpMail($otp));

        } catch (\Exception $e) {

            return back()->withErrors([
                'email' => $e->getMessage()
            ]);
        }

        return redirect()->route('otp.verify.form');
    }
}