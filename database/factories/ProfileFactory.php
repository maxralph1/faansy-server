<?php

namespace Database\Factories;

// use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' => User::all()->uniqid()->id,
            // // 'image_url' => fake()->imageUrl(rand(50, 500), rand(50, 500), 'users', true, 'Faker'),
            // 'address' => fake()->address(),
            // 'bio' => fake()->text(100),
            // 'website_url' => fake()->url(),
            // 'witter_account' => fake()->url(),
            // 'google_account' => fake()->url(),
            // 'language' => fake()->randomElement($array = array('en-US', 'fr', 'de')),
            // 'dark_mode' => fake()->boolean(),
        ];
    }
}
