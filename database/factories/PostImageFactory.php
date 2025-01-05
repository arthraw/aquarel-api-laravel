<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostImage>
 */
class PostImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_image_id' => $this->faker->uuid(),
            'post_image_url' => $this->faker->imageUrl(),
            'profile_id' => Profile::factory(),
            'post_id' => Post::factory(),
        ];
    }
}
