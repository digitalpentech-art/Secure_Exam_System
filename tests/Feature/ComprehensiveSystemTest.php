<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Examination;
use App\Models\Question;
use App\Models\ExaminationSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ComprehensiveSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_examination_workflow()
    {
        $this->withoutMiddleware();
        // 1. Setup Data
        $student = User::create(['name' => 'Student', 'email' => 'student@test.com', 'password' => Hash::make('password'), 'role' => 'student']);
        
        $course = Course::create(['course_code' => 'CS101', 'title' => 'Intro', 'unit' => 3, 'department' => 'CS']);
        $exam = Examination::create(['course_id' => $course->id, 'title' => 'Test Exam', 'date' => '2026-09-01', 'start_time' => '09:00:00', 'end_time' => '23:59:59', 'duration' => 60, 'max_score' => 1, 'status' => 'active']);
        $q = Question::create(['examination_id' => $exam->id, 'text' => 'Q1', 'option_a' => 'A', 'option_b' => 'B', 'option_c' => 'C', 'option_d' => 'D', 'correct_answer' => 'A', 'marks' => 1]);

        // 2. Exam Flow
        $this->actingAs($student);
        
        // Start Exam - Web flow (redirects)
        $response = $this->post("/exams/{$exam->id}/start");
        $response->assertStatus(302);
        
        // Follow redirect to questions view
        $sessionId = ExaminationSession::where('student_id', $student->id)->where('examination_id', $exam->id)->first()->id;
        $response->assertRedirect("/sessions/{$sessionId}/questions-view");

        // Submit Exam
        $response = $this->postJson("/sessions/{$sessionId}/submit", [
            'answers' => [['question_id' => $q->id, 'answer' => 'A']]
        ]);
        
        $response->assertStatus(200);

        // 4. Verify Grading
        $this->assertDatabaseHas('results', [
            'student_id' => $student->id,
            'examination_id' => $exam->id,
            'score' => 1,
            'percentage' => 100,
            'grade' => 'A'
        ]);
    }
}
