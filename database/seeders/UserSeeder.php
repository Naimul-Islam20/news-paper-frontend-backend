<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Core admin/editor accounts
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+8801700000001',
                'image' => null,
                'status' => true,
            ],
            [
                'name' => 'Senior Editor',
                'email' => 'senior.editor@example.com',
                'password' => Hash::make('password'),
                'role' => 'senior editor',
                'phone' => '+8801700000002',
                'image' => null,
                'status' => true,
            ],
            [
                'name' => 'Sub Editor',
                'email' => 'sub.editor@example.com',
                'password' => Hash::make('password'),
                'role' => 'sub editor',
                'phone' => '+8801700000003',
                'image' => null,
                'status' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData,
            );
        }

        // Additional reporter accounts
        if (User::where('role', 'reporter')->count() === 0) {
            for ($i = 1; $i <= 10; $i++) {
                User::create([
                    'name' => "Reporter {$i}",
                    'email' => "reporter{$i}@example.com",
                    'password' => Hash::make('password'),
                    'role' => 'reporter',
                    'phone' => '+8801710000' . str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                    'image' => null,
                    'status' => true,
                ]);
            }
        }
    }
}

