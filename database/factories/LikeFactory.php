<?php

namespace Database\Factories;

use App\Enum\Like\LikeTypeEnum;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'likeable_id' => $this->faker->randomElement([Post::factory()]),
            'likeable_type' => $this->faker->randomElement(LikeTypeEnum::class)
        ];
    }
}
