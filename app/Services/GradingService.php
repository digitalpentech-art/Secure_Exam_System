<?php

namespace App\Services;

use App\Models\ExaminationSession;
use App\Models\Result;

class GradingService
{
    public function gradeSession($sessionId)
    {
        $session = ExaminationSession::with('examination.questions', 'answers')->findOrFail($sessionId);
        $score = 0;

        foreach ($session->answers as $answer) {
            $question = $session->examination->questions->where('id', $answer->question_id)->first();
            if ($question) {
                // Map A, B, C, D to the actual text content of the options
                $optionMap = [
                    'A' => $question->option_a,
                    'B' => $question->option_b,
                    'C' => $question->option_c,
                    'D' => $question->option_d,
                ];
                
                // Get the actual text of the correct answer
                $correctText = $optionMap[$question->correct_answer] ?? $question->correct_answer;
                
                // Compare student answer (text) with correct answer text
                if (trim($answer->student_answer) === trim($correctText)) {
                    $score += $question->marks;
                }
            }
        }

        $maxScore = $session->examination->max_score;
        $percentage = ($score / $maxScore) * 100;
        $grade = $this->calculateGrade($percentage);

        return Result::create([
            'student_id' => $session->student_id,
            'examination_id' => $session->examination_id,
            'score' => $score,
            'percentage' => $percentage,
            'grade' => $grade,
        ]);
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 70) return 'A';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C';
        if ($percentage >= 45) return 'D';
        return 'F';
    }
}
