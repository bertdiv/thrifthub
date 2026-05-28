<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CustomVerifyEmailController extends Controller
{
    /**
     * Verify email and create account
     */
    public function verify(Request $request)
    {
        // Check signed URL
        if (! $request->hasValidSignature()) {

            abort(403, 'Invalid or expired verification link.');

        }

        // Get temporary data
        $data = session('register_data');

        if (! $data) {

            return redirect()->route('register')->withErrors([

                'email' => 'Registration session expired.'

            ]);
        }

        // Create seller account
        $user = User::create([

            'name' => $data['name'],

            'email' => $data['email'],

            'contact_number' => $data['contact_number'],

            'address' => $data['address'],

            'facebook_link' => $data['facebook_link'],

            'password' => $data['password'],

            'role' => 'seller',

            'is_verified' => true,

            'email_verified_at' => now(),

        ]);

        // Clear session
        session()->forget('register_data');

        // Auto login
        Auth::login($user);

        // Redirect dashboard
        return redirect('/dashboard')->with(

            'success',

            'Seller account created successfully.'

        );
    }
}