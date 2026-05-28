<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('ThriftHub OTP Verification')
            ->html("
                <h2>Welcome to ThriftHub</h2>

                <p>Your OTP Code:</p>

                <h1>{$this->otp}</h1>

                <p>Expires in 10 minutes.</p>
            ");
    }
}