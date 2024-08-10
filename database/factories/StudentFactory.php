<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\User;
use App\Models\Lecturer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Student::class;

    public function definition(): array
    {
        return [
            //
            'user_id' => User::factory(), // Generates a related User model
            'lecturer_id' => Lecturer::factory(),
            'year_of_study' => fake()->numberBetween(1, 4),
            'program' => fake()->randomElement(['BIT', 'BIP', 'BIS', 'BIW', 'BIM']),
            'status' => fake()->randomElement(['registered', 'unregistered']),
        ];
    }
}
