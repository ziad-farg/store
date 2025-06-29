<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456789',
                'store_id' => null,
            ],
            [
                'name' => 'ziad farg',
                'email' => 'ziad@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456788',
                'store_id' => 1,
            ],
            [
                'name' => 'ali sharara',
                'email' => 'ali@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456787',
                'store_id' => 1,
            ],
            [
                'name' => 'mohamed medht',
                'email' => 'medht@gmail.com',
                'password' => Hash::make('123456789'),
                'phone_number' => '0123456786',
                'store_id' => 2,
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
