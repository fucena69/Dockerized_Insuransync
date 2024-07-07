<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Calendar;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class CalendarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->optional()->date(),
            'title' => $this->faker->sentence,
            'type' => $this->faker->numberBetween(1, 5),
            'is_deleted' => $this->faker->boolean(0),
        ];
    }
}
