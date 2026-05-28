<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
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
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],

            'contact_number' => ['required', 'string', 'max:20'],

            'address' => ['required', 'string', 'max:255'],

            'facebook_link' => ['nullable', 'url'],

            'messenger_link' => ['nullable', 'url'],

            'password' => ['required', 'confirmed', 'min:8'],

        ]);

        // Create seller account
        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'contact_number' => $request->contact_number,

            'address' => $request->address,

            'facebook_link' => $request->facebook_link,

            'messenger_link' => $request->messenger_link,

            'password' => Hash::make($request->password),

            'role' => 'seller',

            'is_verified' => false,

        ]);

        // Send email verification link
        event(new Registered($user));

        // Auto login user
        Auth::login($user);

        // Redirect to verification page
        return redirect()->route('verification.notice');
    }
}