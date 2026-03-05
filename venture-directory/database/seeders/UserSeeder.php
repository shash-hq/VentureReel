<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Shashank Ranjan',
            'username' => 'shashank',
            'email' => 'admin@venturereel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Founder of VentureReel. Passionate about entrepreneurship and tech.',
        ]);

        // Demo users
        $users = [
            [
                'name' => 'Priya Sharma',
                'username' => 'priya-sharma',
                'email' => 'priya@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Startup enthusiast. Curating the best founder stories.',
            ],
            [
                'name' => 'Arjun Mehta',
                'username' => 'arjun-mehta',
                'email' => 'arjun@example.com',
                'password' => Hash::make('password'),
                'bio' => 'VC analyst turned creator. Building in public.',
            ],
            [
                'name' => 'Neha Gupta',
                'username' => 'neha-gupta',
                'email' => 'neha@example.com',
                'password' => Hash::make('password'),
                'bio' => 'EdTech founder. Sharing stories that inspire.',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
