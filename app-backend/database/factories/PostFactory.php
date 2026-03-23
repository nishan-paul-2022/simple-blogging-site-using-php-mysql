<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(5, true),
            'excerpt' => fake()->paragraph(),
            'featured_image' => 'https://picsum.photos/800/400?random='.fake()->uuid(),
            'views' => fake()->numberBetween(0, 1000),
            'status' => 'draft',
            'published_at' => null,
        ];
    }

    /**
     * Mark the post as published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ]);
    }

    /**
     * Mark the post as featured.
     */
    public function featured(): static
    {
        return $this->published()->state(fn (array $attributes) => [
            'featured_until' => now()->addDays(fake()->numberBetween(1, 7)),
        ]);
    }
}
