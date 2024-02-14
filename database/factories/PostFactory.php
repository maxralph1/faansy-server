<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
        return [
            'user_id' => User::all()->random()->id,
            // 'user_id' => User::where('role_id', Role::where('title', 'super-admin')->first()->id)->first(),
            'body' => fake()->text(100),
            // 'image_url' => fake()->imageUrl(rand(50, 500), rand(50, 500), 'posts', true, 'Faker'),
            // 'video_url' => fake()->imageUrl(rand(50, 500), rand(50, 500), 'posts', true, 'Faker'),
            // 'pay_per_view' => fake()->boolean(),
            // 'pay_per_view_amount' => fake()->randomFloat(2, 10, 999) || null,
            'scheduled_live_time' => now(),
            'pinned' => false,
            'pinned_at' => null,
            'featured' => false,
            'repost' => false,
            // 'repost_original_id' => fake()->text(100),
            // 'repost_body' => fake()->text(20),
            // 'repost_original_post_timestamp' => now(),
        ];
    }
}
