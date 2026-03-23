<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest in tech and programming',
                'color' => '#6366f1',
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'description' => 'Tips and tricks for daily life',
                'color' => '#ec4899',
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
                'description' => 'Travel stories and guides',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Food',
                'slug' => 'food',
                'description' => 'Recipes and food reviews',
                'color' => '#10b981',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Business insights and strategies',
                'color' => '#0ea5e9',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
