<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lecturer;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecturer>
 */
class LecturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Lecturer::class;
    
    public function definition(): array
    {
        return [
            //
            'user_id' => User::factory(), // Generates a related User model
            'department' => fake()->randomElement(['Software Engineering', 'Information Technology']),
            'lecturer_level' => fake()->randomElement(['Senior Lecturer', 'Head of Department', 'Dean', 'Deputy Dean']),
        ];
    }
}
