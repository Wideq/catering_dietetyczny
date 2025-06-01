<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Define specific users we want to ensure exist
        $specificUsers = [
            [
                'name' => 'Jan Kowalski',
                'email' => 'jan.kowalski@example.com',
                'role' => 'user'
            ],
            [
                'name' => 'Anna Nowak',
                'email' => 'anna.nowak@example.com',
                'role' => 'user'
            ],
            [
                'name' => 'Piotr Wiśniewski',
                'email' => 'piotr.wisniewski@example.com',
                'role' => 'user'
            ],
            [
                'name' => 'Katarzyna Dąbrowska',
                'email' => 'kat.dabrowska@example.com',
                'role' => 'user'
            ],
            [
                'name' => 'Administrator',
                'email' => 'admin@puremeal.pl',
                'role' => 'admin'
            ]
        ];
        
        // Create each specific user if they don't already exist
        foreach ($specificUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'remember_token' => \Illuminate\Support\Str::random(10),
                    'role' => $userData['role'],
                ]
            );
        }
        
        // Create additional random users with the factory
        // This will use the faker generator for random names and emails
        User::factory()->count(20)->create();
    }
}