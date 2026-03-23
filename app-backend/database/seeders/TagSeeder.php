<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'Next.js', 'slug' => 'nextjs'],
            ['name' => 'React', 'slug' => 'react'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Database', 'slug' => 'database'],
            ['name' => 'API', 'slug' => 'api'],
            ['name' => 'Tutorial', 'slug' => 'tutorial'],
            ['name' => 'Tips', 'slug' => 'tips'],
            ['name' => 'Guide', 'slug' => 'guide'],
            ['name' => 'News', 'slug' => 'news'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => $tag['slug']],
                $tag
            );
        }
    }
}
