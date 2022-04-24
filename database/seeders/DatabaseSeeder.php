<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Student;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Course;
use Database\Seeders\GPASeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Course::updateOrCreate(['name' => 'BSInfoTech']);

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Doe',
            'email' => 'admin@user.com',
            'password' => 'secret',
            'admin' => true,
        ]);

        $this->call(GPASeeder::class);

        // User::factory(5);

        // Student::factory(100)->create(['course_id' => $course->id]);
    }
}
