<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Examination;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::create(['name' => 'Admin', 'email' => 'admin@kibu.edu.ng', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::create(['name' => 'Lecturer', 'email' => 'lecturer@kibu.edu.ng', 'password' => Hash::make('password'), 'role' => 'lecturer']);
        User::create(['name' => 'Student', 'email' => 'student@kibu.edu.ng', 'password' => Hash::make('password'), 'role' => 'student']);

        // Course
        $course = Course::create([
            'course_code' => 'CSC401',
            'title' => 'Software Engineering',
            'unit' => 3,
            'department' => 'Computer Science',
        ]);

        // Examination
        $exam = Examination::create([
            'course_id' => $course->id,
            'title' => 'Midterm Test',
            'date' => '2026-09-10',
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'duration' => 60,
            'max_score' => 10,
            'status' => 'active',
        ]);

        // Question
        Question::create([
            'examination_id' => $exam->id,
            'text' => 'What does MVC stand for?',
            'option_a' => 'Model View Controller',
            'option_b' => 'Most Valuable Code',
            'option_c' => 'Modern Virtual Computing',
            'option_d' => 'Model View Computing',
            'correct_answer' => 'A',
            'marks' => 10,
        ]);
    }
}
