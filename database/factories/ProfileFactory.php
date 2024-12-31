<?php

namespace Database\Factories;

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
            'profile_id' => fake()->uuid(),
            'bio' => fake()->text(),
            'name' => fake()->name(),
            'user_id' => fake()->uuid(),
            'avatar_url' => fake()->imageUrl(),
            'banner_url' => fake()->imageUrl(),
            'instagram_profile_url' => fake()->url(),
            'behance_profile_url' => fake()->url(),
            'category' => fake()->name(),
        ];
    }
}
