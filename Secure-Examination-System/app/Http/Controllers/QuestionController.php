<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

use App\Models\Examination;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $examinationId = $request->query('examination_id');
        $examination = Examination::findOrFail($examinationId);
        $questions = Question::where('examination_id', $examinationId)->get();
        return view('lecturer.questions', compact('questions', 'examination'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'examination_id' => 'required|exists:examinations,id',
            'question_text' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required',
        ]);

        Question::create([
            'examination_id' => $request->examination_id,
            'text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect('/lecturer/questions?examination_id=' . $request->examination_id)->with('success', 'Question created successfully');
    }

    public function edit(Question $question)
    {
        return view('lecturer.edit-question', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $question->update($request->all());
        return redirect('/lecturer/questions?examination_id=' . $question->examination_id)->with('success', 'Question updated successfully');
    }

    public function destroy(Question $question)
    {
        $examinationId = $question->examination_id;
        $question->delete();
        return redirect('/lecturer/questions?examination_id=' . $examinationId)->with('success', 'Question deleted successfully');
    }
}
