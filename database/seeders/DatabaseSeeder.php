<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lecturer;
use App\Models\Student;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::factory()
        // ->count(10)
        // ->has(Lecturer::factory())
        // ->create();

       // Create Lecturers
       $lecturers = User::factory()
       ->count(5)
       ->create()
       ->each(function ($user) {
           if ($user->role === 'lecturer') {
               Lecturer::factory()->create(['user_id' => $user->id]);
           }
       });

   // Create Students and assign them to the created Lecturers
   User::factory()
       ->count(10)
       ->create()
       ->each(function ($user) use ($lecturers) {
           if ($user->role === 'student') {
               Student::factory()->create([
                   'user_id' => $user->id,
                   'lecturer_id' => $lecturers->random()->id,
               ]);
           }
       });









        // $this->call([
        //     UsersTableSeeder::class,
        //     LecturersTableSeeder::class,
        // ]);
    }
}
