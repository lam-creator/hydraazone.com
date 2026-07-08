<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['phone' => '01916062906'],
            [
                'name' => 'Guest User',
                'email' => 'guest_user@hydraazone.com',
                'password' => Hash::make('hydraazone.com'),
                'status' => 'active',
            ]
        );
    }
}
