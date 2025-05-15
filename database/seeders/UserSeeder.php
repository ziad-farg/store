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
        User::create([
            'name' => 'ziad farg',
            'email' => 'ziad@gmail.com',
            'password' => Hash::make('123456789'),
            'phone_number' => '0123456789',
        ]);
    }
}
