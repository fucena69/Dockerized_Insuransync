<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\MarketSurvey;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class MarketSurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'saving_often' => $this->faker->word(),
            'savings_location' => $this->faker->word(),
            'critical_illness_level' => $this->faker->word(),
            'disabled_level' => $this->faker->word(),
            'force_retirement_level' => $this->faker->word(),
            'child_college_level' => $this->faker->word(),
            'money_protect' => $this->faker->word(),
            'contact_date' => $this->faker->dateTime(),
            'questions' => $this->faker->paragraph(),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'age' => $this->faker->numberBetween(18, 65),
            'phone_number' => $this->faker->phoneNumber(),
            'civil_status' => $this->faker->randomElement(['single', 'married', 'divorced']),
            'occupation' => $this->faker->jobTitle(),
            'remarks' => $this->faker->paragraph(),
            'is_deleted' => false,
        ];
    }
}
