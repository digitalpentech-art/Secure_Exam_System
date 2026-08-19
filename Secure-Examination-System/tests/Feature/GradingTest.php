<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Examination;
use App\Models\Question;
use App\Models\ExaminationSession;
use App\Services\GradingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GradingTest extends TestCase
{
    use RefreshDatabase;

    public function test_grading_logic()
    {
        $user = User::factory()->create();
        $course = Course::create(['course_code' => 'CS101', 'title' => 'Intro', 'unit' => 3, 'department' => 'CS']);
        $exam = Examination::create(['course_id' => $course->id, 'title' => 'Midterm', 'date' => '2026-09-01', 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'duration' => 60, 'max_score' => 2]);
        $q1 = Question::create(['examination_id' => $exam->id, 'text' => 'Q1', 'option_a' => 'A', 'option_b' => 'B', 'option_c' => 'C', 'option_d' => 'D', 'correct_answer' => 'A', 'marks' => 1]);
        $q2 = Question::create(['examination_id' => $exam->id, 'text' => 'Q2', 'option_a' => 'A', 'option_b' => 'B', 'option_c' => 'C', 'option_d' => 'D', 'correct_answer' => 'B', 'marks' => 1]);
        
        $session = ExaminationSession::create(['student_id' => $user->id, 'examination_id' => $exam->id, 'start_time' => now()]);
        
        // Save answers
        \App\Models\Answer::create(['session_id' => $session->id, 'question_id' => $q1->id, 'student_answer' => 'A']); // Correct
        \App\Models\Answer::create(['session_id' => $session->id, 'question_id' => $q2->id, 'student_answer' => 'A']); // Incorrect

        $gradingService = new GradingService();
        $result = $gradingService->gradeSession($session->id);

        $this->assertEquals(1, $result->score);
        $this->assertEquals(50, $result->percentage);
        $this->assertEquals('C', $result->grade);
    }
}
