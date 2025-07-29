<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create(); // Initialize Faker
        $blogs = [];

        // Get user IDs to assign blogs
        $userIds = User::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $blogs[] = [
                'title' => $faker->sentence(6),  // 6-word random title
                'content' => $faker->paragraph(5), // Random 5-sentence paragraph
                'created_by' => $userIds[array_rand($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Blog::insert($blogs); // Bulk insert all blogs
    }

}