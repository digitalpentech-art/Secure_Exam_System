<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\ExaminationSession;
use App\Models\Answer;
use App\Services\GradingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExaminationEngineController extends Controller
{
    protected $gradingService;

    public function __construct(GradingService $gradingService)
    {
        \Log::info('ExaminationEngineController loaded');
        $this->gradingService = $gradingService;
    }

    public function showStartPage($examinationId)
    {
        $examination = Examination::findOrFail($examinationId);
        return view('exams.start', compact('examination'));
    }

    public function startExam($examinationId)
    {
        $examination = Examination::findOrFail($examinationId);
        
        // Check if the student has already completed an attempt
        $completedAttempt = ExaminationSession::where('student_id', Auth::id())
            ->where('examination_id', $examinationId)
            ->where('status', 'completed')
            ->exists();

        if ($completedAttempt) {
            return redirect('/dashboard')->with('error', 'You have already completed this examination.');
        }

        // Find an active, non-expired session to resume
        $session = ExaminationSession::where('student_id', Auth::id())
            ->where('examination_id', $examinationId)
            ->where('status', 'active')
            ->get()
            ->filter(function($s) {
                return Carbon::now()->lessThan($s->end_time);
            })
            ->first();

        if ($session) {
            // Redirect to questions if an active, valid session exists
            return redirect('/sessions/' . $session->id . '/questions-view');
        }

        $session = ExaminationSession::create([
            'student_id' => Auth::id(),
            'examination_id' => $examinationId,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addMinutes($examination->duration),
        ]);

        return redirect('/sessions/' . $session->id . '/questions-view');
    }

    public function getQuestions($sessionId)
    {
        $session = ExaminationSession::findOrFail($sessionId);
        
        $questions = $session->examination->questions()->inRandomOrder()->get();
        
        return response()->json([
            'questions' => $questions,
            'end_time' => $session->end_time
        ]);
    }

    public function submitExam(Request $request, $sessionId)
    {
        try {
            return DB::transaction(function () use ($request, $sessionId) {
                $session = ExaminationSession::findOrFail($sessionId);
                
                if (Carbon::now()->greaterThan($session->end_time)) {
                    return response()->json(['message' => 'Time expired'], 403);
                }

                // Defensive check for answers payload
                $answers = $request->input('answers', []);
                
                \Log::info('Submitting answers for session ' . $sessionId . ': ' . json_encode($answers));
                
                if (!is_array($answers)) {
                    return response()->json(['message' => 'Invalid answer format'], 400);
                }

                foreach ($answers as $answer) {
                    // Ensure expected keys exist
                    if (isset($answer['question_id'], $answer['answer'])) {
                        Answer::create([
                            'session_id' => $sessionId,
                            'question_id' => $answer['question_id'],
                            'student_answer' => $answer['answer'],
                        ]);
                    }
                }

                $session->update(['status' => 'completed']);
                
                // Grade the exam
                $this->gradingService->gradeSession($sessionId);
                
                return response()->json(['message' => 'Exam submitted and graded', 'redirect' => '/dashboard']);
            });
        } catch (\Exception $e) {
            \Log::error('Exam submission failed: ' . $e->getMessage());
            return response()->json(['message' => 'Internal server error during submission'], 500);
        }
    }
}
