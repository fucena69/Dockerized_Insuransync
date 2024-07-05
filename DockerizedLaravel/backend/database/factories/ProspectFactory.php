<?php

namespace Database\Factories;

use App\Models\Prospect;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProspectFactory extends Factory
{
    protected $model = Prospect::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'age' => $this->faker->numberBetween(0, 100),
            'occupation' => $this->faker->jobTitle,
            'category' => $this->faker->word,
            'source' => $this->faker->word,
            'relationship' => $this->faker->word,
            'status' => $this->faker->numberBetween(0, 10),
            'remarks' => $this->faker->sentence,
            'is_deleted' => $this->faker->boolean(0),
            'user_id' => User::factory(),
            'approach_date' => $this->faker->optional()->date(),
            'meeting_date' => $this->faker->optional()->date(),
            'followup_date' => $this->faker->optional()->date(),
            'processing_date' => $this->faker->optional()->date(),
            'submitted_date' => $this->faker->optional()->date(),
            'approved_date' => $this->faker->optional()->date(),
            'denied_date' => $this->faker->optional()->date(), 
            'is_presenting' => $this->faker->boolean(0),
            'medical_condition' => $this->faker->word,
        ];
    }
}
