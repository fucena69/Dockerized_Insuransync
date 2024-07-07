<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'userId' => User::factory(),
            'clientName' => $this->faker->name,
            'age' => $this->faker->numberBetween(0, 100),
            'occupation' => $this->faker->optional()->jobTitle,
            'medicalCondition' => $this->faker->optional()->sentence,
            'status' => $this->faker->numberBetween(0, 6),
            'remarks' => $this->faker->optional()->sentence,
            'active' => $this->faker->numberBetween(0, 1),
            'followupDate' => $this->faker->optional()->dateTime,
            'is_deleted' => $this->faker->numberBetween(0, 1),
        ];
    }
}
