<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@coordina.local'],
            [
                'name' => 'admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),

            ]
        );
        $user->assignRole('super-admin');
    }
}
