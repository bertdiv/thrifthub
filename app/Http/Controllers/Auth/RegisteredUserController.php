<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show registration page
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Send verification email first
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'email', 'unique:users'],

            'contact_number' => ['required', 'string', 'max:20'],

            'address' => ['required', 'string', 'max:255'],

            'facebook_link' => ['nullable', 'url'],

            'password' => ['required', 'confirmed', 'min:8'],

        ]);

        // Save temporary data
        session([
            'register_data' => [

                'name' => $request->name,

                'email' => $request->email,

                'contact_number' => $request->contact_number,

                'address' => $request->address,

                'facebook_link' => $request->facebook_link,

                'password' => Hash::make($request->password),

                'role' => 'seller',

            ]
        ]);

        // Create signed verification URL
        $verificationUrl = URL::temporarySignedRoute(

            'custom.verify.email',

            now()->addMinutes(30),

            [
                'email' => $request->email
            ]
        );

        // Send email
        Mail::raw(

            "Click the link below to verify your email and complete registration:\n\n$verificationUrl",

            function ($message) use ($request) {

                $message->to($request->email)
                        ->subject('Verify Your Email - ThriftHub');

            }
        );

        return redirect()->route('login')->with(

            'status',

            'Verification email sent successfully.'

        );
    }
}