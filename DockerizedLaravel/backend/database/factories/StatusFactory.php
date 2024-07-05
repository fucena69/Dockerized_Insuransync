<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Source;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source' => $this->faker->name,
            'is_deleted' => $this->faker->numberBetween(0, 1),
        ];
    }
}
