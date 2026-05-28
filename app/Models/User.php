<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable fields
     */
    protected $fillable = [

        'name',
        'email',
        'contact_number',
        'address',
        'facebook_link',
        'messenger_link',
        'password',
        'role',
        'is_verified',
        'email_verified_at',

    ];

    /**
     * Hidden fields
     */
    protected $hidden = [

        'password',
        'remember_token',

    ];

    /**
     * Cast attributes
     */
    protected $casts = [

        'email_verified_at' => 'datetime',

        'password' => 'hashed',

        'is_verified' => 'boolean',

    ];
}