<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
 
class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Remove this if creating explicitly
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
