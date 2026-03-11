<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    public function run(): void {
        $password = '123456';

        $users = [
            ['name' => 'user1', 'email' => 'user1@example.com'],
            ['name' => 'user2', 'email' => 'user2@example.com'],
            ['name' => 'user3', 'email' => 'user3@example.com'],
            ['name' => 'user4', 'email' => 'user4@example.com'],
            ['name' => 'user5', 'email' => 'user5@example.com'],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name'     => $user['name'],
                    'password' => Hash::make($password),
                ]
            );
        }
    }
}
