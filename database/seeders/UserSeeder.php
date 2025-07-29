<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create a specific test user
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create 19 more random users
        User::factory(19)->create();
    }
}