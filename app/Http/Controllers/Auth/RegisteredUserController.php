<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show register page
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Firebase handles registration now
     * This method is no longer used
     */
    public function store(Request $request)
    {
        return redirect()
            ->route('register')
            ->with('error', 'Please use Firebase registration.');
    }

    /**
     * Create seller account AFTER Firebase email verification
     */
    public function firebaseRegister(Request $request): JsonResponse
    {
        $request->validate([

            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'email'],

            'contact_number' => ['required', 'string', 'max:20'],

            'address' => ['required', 'string', 'max:255'],

            'facebook_link' => ['nullable', 'url'],

            'password' => ['required', 'string', 'min:8'],

        ]);

        // Prevent duplicate users
        $existingUser = User::where(
            'email',
            $request->email
        )->first();

        if ($existingUser) {

            return response()->json([

                'success' => true,

                'message' => 'User already exists.'

            ]);
        }

        // Create verified seller
        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'contact_number' => $request->contact_number,

            'address' => $request->address,

            'facebook_link' => $request->facebook_link,

            'password' => Hash::make($request->password),

            'role' => 'seller',

            'is_verified' => true,

            'email_verified_at' => now(),

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Account created successfully.',

            'user' => $user

        ]);
    }
}