<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'super admin',
                'email' => 'super@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456781',
                'store_id' => null,
                'last_active_at' => now(),
                'role' => 'super-admin',
            ],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456789',
                'store_id' => 5,
                'last_active_at' => now(),
                'role' => 'admin',
            ],
            [
                'name' => 'ziad farg',
                'email' => 'ziad@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456788',
                'store_id' => 1,
                'last_active_at' => now(),
                'role' => 'admin',
            ],
            [
                'name' => 'ali sharara',
                'email' => 'ali@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456787',
                'store_id' => 1,
                'last_active_at' => now(),
                'role' => 'admin',
            ],
            [
                'name' => 'mohamed medht',
                'email' => 'medht@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456786',
                'store_id' => 2,
                'last_active_at' => now(),
                'role' => 'admin',
            ],
            [
                'name' => 'abdolla magdy',
                'email' => 'magdy@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456785',
                'store_id' => 3,
                'last_active_at' => now(),
                'role' => 'user',
            ],
            [
                'name' => 'nasser shata',
                'email' => 'nasser@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456784',
                'store_id' => 4,
                'last_active_at' => now(),
                'role' => 'user',
            ]
        ];
        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);

            $user = User::create($userData);
            $user->assignRole($role); // Assign the role using Spatie
        }
    }
}
