<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::updateOrCreate(
            ['email' => 'johndoe@example.com'],
            [
                'name' => 'John Doe',
                'matric_id' => '123456',
                'password' => Hash::make('password'),
                'role' => 'lecturer',
                'last_login' => now(),
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'janesmith@example.com'],
            [
                'name' => 'Jane Smith',
                'matric_id' => '654321',
                'password' => Hash::make('password'),
                'role' => 'lecturer',
                'last_login' => now(),
            ]
        );

        // Store the created user IDs for use in the LecturersTableSeeder
        $this->command->info('User 1 ID: ' . $user1->id);
        $this->command->info('User 2 ID: ' . $user2->id);
    }
}