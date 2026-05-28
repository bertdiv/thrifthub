<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

use Carbon\Carbon;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
     * @throws ValidationException
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

    // Save registration data temporarily in session
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

    // Send Email
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = env('MAIL_USERNAME');

        $mail->Password = env('MAIL_PASSWORD');

        $mail->SMTPSecure = 'tls';

        $mail->Port = 587;

        $mail->SMTPDebug = 2;

        $mail->Timeout = 60;

        $mail->setFrom(
            env('MAIL_FROM_ADDRESS'),
            env('MAIL_FROM_NAME')
        );

        $mail->addAddress($request->email);

        $mail->isHTML(true);

        $mail->Subject = 'ThriftHub OTP Verification';

        $mail->Body = "
            <h2>Welcome to ThriftHub</h2>

            <p>Your OTP Code:</p>

            <h1>$otp</h1>

            <p>Expires in 10 minutes.</p>
        ";

        $mail->send();

    } catch (\Exception $e) {

    dd($e->getMessage());
}

    return redirect()->route('otp.verify.form');
}
}