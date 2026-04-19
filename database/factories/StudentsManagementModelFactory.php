<?php

namespace Database\Factories;

use App\Models\StudentsManagementModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentsManagementModel>
 */
class StudentsManagementModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numerify('2025####'),
            'fullname' => $this->faker->fullName(),
            'course' => $this->faker->randomElement([
                'BSIT','BSCS','BSE','BSBA'
            ]),
            'year_level' => $this->faker->numberBetween(1,4)
        ];
    }


}
