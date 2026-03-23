<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Skipping post seeding.');

            return;
        }

        // Create sample posts
        $posts = Post::factory()
            ->count(15)
            ->make()
            ->each(function ($post) use ($users, $categories) {
                $post->user_id = $users->random()->id;
                $post->category_id = $categories->random()->id;
                $post->status = 'published';
                $post->published_at = now()->subDays(rand(1, 30));
            });

        foreach ($posts as $post) {
            $post->save();

            // Attach random tags
            if ($tags->isNotEmpty()) {
                $post->tags()->attach(
                    $tags->random(rand(2, 4))->pluck('id')->toArray()
                );
            }
        }
    }
}
