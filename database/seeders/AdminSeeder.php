<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(

            [
                'email' => env('ADMIN_EMAIL')
            ],

            [
                'name' => env('ADMIN_NAME'),

                'contact_number' => '09123456789',

                'address' => 'ThriftHub Main Office',

                'password' => Hash::make(env('ADMIN_PASSWORD')),

                'role' => 'admin',

                'is_verified' => true,
            ]
        );
    }
}