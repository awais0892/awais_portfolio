<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (!$email || !$password) {
            \Illuminate\Support\Facades\Log::warning('AdminUserSeeder: ADMIN_EMAIL or ADMIN_PASSWORD not set in configuration.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrator',
                'password' => Hash::make($password),
            ]
        );

        \Illuminate\Support\Facades\Log::info("Admin user updated/created: {$email}");
    }
}
