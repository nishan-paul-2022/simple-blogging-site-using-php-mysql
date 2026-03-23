<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::where('status', 'published')->get();
        $users = User::all();

        if ($posts->isEmpty()) {
            $this->command->info('No published posts found. Skipping comment seeding.');
            return;
        }

        foreach ($posts as $post) {
            Comment::factory()
                ->count(rand(2, 5))
                ->create([
                    'post_id' => $post->id,
                    'user_id' => $users->isNotEmpty() ? $users->random()->id : null,
                    'is_approved' => true,
                ]);
        }
    }
}
