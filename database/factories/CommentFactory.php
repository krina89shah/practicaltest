<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = \App\Models\Comment::class;

    public function definition()
    {
        return [
            'post_id' => \App\Models\Post::factory(),
            'user_id' => \App\Models\User::all()->random()->id, // Use existing users
            'content' => $this->faker->sentence(),
        ];
    }
}

