<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' => User::factory(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'status_id' =>Status::factory(),
            'title' => ucwords($this->faker->words(4, true)),
            'description' => $this->faker->paragraph(5)
        ];
    }

    public function existing(){
        return $this->state(function(array $attributes){
            return [
                'user_id' => $this->faker->numberBetween(1, 20),
                'category_id' => $this->faker->numberBetween(1, 4),
                'status_id' => $this->faker->numberBetween(1, 5),
            ];
        });
    }
}
