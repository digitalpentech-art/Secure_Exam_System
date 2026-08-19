<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Examination;
use App\Models\Result;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminResultTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_delete_results()
    {
        // 1. Setup Admin and Data
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => Hash::make('password'), 'role' => 'admin']);
        $student = User::create(['name' => 'Student', 'email' => 'student@test.com', 'password' => Hash::make('password'), 'role' => 'student']);
        
        $course = Course::create(['course_code' => 'CS101', 'title' => 'Intro', 'unit' => 3, 'department' => 'CS']);
        $exam = Examination::create(['course_id' => $course->id, 'title' => 'Test Exam', 'date' => '2026-09-01', 'start_time' => '09:00:00', 'end_time' => '23:59:59', 'duration' => 60, 'max_score' => 10, 'status' => 'closed']);
        
        $result = Result::create([
            'student_id' => $student->id,
            'examination_id' => $exam->id,
            'score' => 8,
            'percentage' => 80,
            'grade' => 'A'
        ]);

        // 2. Act as Admin
        $this->withoutMiddleware();
        $this->actingAs($admin);

        // 3. View Results
        $response = $this->get('/admin/results');
        $response->assertStatus(200);
        $response->assertSee('Test Exam');

        // 4. Delete Result
        $response = $this->delete("/admin/results/{$result->id}");
        $response->assertRedirect('/admin/results');

        // 5. Verify deletion
        $this->assertDatabaseMissing('results', ['id' => $result->id]);
    }
}
