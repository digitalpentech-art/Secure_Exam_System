<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Course;
use App\Models\Examination;
use App\Models\Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class ExamTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_student_can_take_exam(): void
    {
        // 1. Setup Data
        $student = User::create(['name' => 'Student', 'email' => 'student@test.com', 'password' => Hash::make('password'), 'role' => 'student']);
        $course = Course::create(['course_code' => 'CS101', 'title' => 'Intro', 'unit' => 3, 'department' => 'CS']);
        $exam = Examination::create(['course_id' => $course->id, 'title' => 'Test Exam', 'date' => '2026-09-01', 'start_time' => '09:00:00', 'end_time' => '23:59:59', 'duration' => 60, 'max_score' => 1, 'status' => 'active']);
        $q = Question::create(['examination_id' => $exam->id, 'text' => 'Q1', 'option_a' => 'A', 'option_b' => 'B', 'option_c' => 'C', 'option_d' => 'D', 'correct_answer' => 'A', 'marks' => 1]);

        $this->browse(function (Browser $browser) use ($student, $exam) {
            $browser->loginAs($student)
                    ->visit("/exams/{$exam->id}/start")
                    // The start method redirects to the questions view
                    ->waitFor('#questions-list')
                    ->radio('answer_'. $exam->questions->first()->id, 'A')
                    ->press('Submit Examination')
                    ->waitForLocation('/dashboard')
                    ->assertPathIs('/dashboard');
        });
    }
}
