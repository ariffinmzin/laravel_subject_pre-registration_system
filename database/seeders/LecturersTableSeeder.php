<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lecturer;

class LecturersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch the users created by UsersTableSeeder
        $user1 = User::where('email', 'johndoe@example.com')->first();
        $user2 = User::where('email', 'janesmith@example.com')->first();

        // Use firstOrCreate to avoid duplicates in Lecturers table
        Lecturer::updateOrCreate(
            ['user_id' => $user1->id],
            [
                'department' => 'Software Engineering',
                'lecturer_level' => 'Senior Lecturer',
            ]
        );

        Lecturer::updateOrCreate(
            ['user_id' => $user2->id],
            [
                'department' => 'Information Technology',
                'lecturer_level' => 'Senior Lecturer',
            ]
        );
    }
}