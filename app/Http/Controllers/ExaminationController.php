<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\ExaminationSession;
use Illuminate\Http\Request;

use App\Models\Course;

class ExaminationController extends Controller
{
    public function index()
    {
        $examinations = Examination::with('course')->get();
        $courses = Course::all();
        return view('lecturer.examinations', compact('examinations', 'courses'));
    }

    public function resetSession(ExaminationSession $session)
    {
        // Delete associated result if it exists
        \App\Models\Result::where('student_id', $session->student_id)
            ->where('examination_id', $session->examination_id)
            ->delete();

        $session->delete();
        return back()->with('success', 'Student attempt and associated result have been reset successfully.');
    }

    public function listSessions()
    {
        $sessions = ExaminationSession::with(['examination', 'student'])->get();
        return view('lecturer.sessions', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'duration' => 'required|integer',
            'max_score' => 'required|integer',
            'status' => 'required|in:draft,active,closed',
        ]);

        Examination::create($validated);
        return redirect('/lecturer/examinations')->with('success', 'Examination created successfully');
    }

    public function edit(Examination $examination)
    {
        $courses = Course::all();
        return view('lecturer.edit-examination', compact('examination', 'courses'));
    }

    public function update(Request $request, Examination $examination)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'duration' => 'required|integer',
            'max_score' => 'required|integer',
            'status' => 'required|in:draft,active,closed',
        ]);
        
        $examination->update($validated);
        return redirect('/lecturer/examinations')->with('success', 'Examination updated successfully');
    }

    public function destroy(Examination $examination)
    {
        $examination->delete();
        return redirect('/lecturer/examinations')->with('success', 'Examination deleted successfully');
    }
}
