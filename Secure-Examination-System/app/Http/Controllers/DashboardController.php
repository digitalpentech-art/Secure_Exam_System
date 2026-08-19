<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Examination;
use App\Models\Result;
use App\Models\User;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        $user = Auth::user();
        $data = ['role' => $user->role];

        if ($user->role === 'student') {
            // Group results by examination
            $data['results'] = Result::where('student_id', $user->id)
                ->with('examination')
                ->get()
                ->groupBy('examination_id');
            
            $data['active_exams'] = Examination::where('status', 'active')->get();
            $data['closed_exams'] = Examination::where('status', 'closed')->get();
            return view('dashboard.student', ['data' => $data]);
        } elseif ($user->role === 'lecturer') {
            $data['courses'] = Course::all();
            $data['examinations'] = Examination::all();
            $data['stats'] = [
                'total_courses' => Course::count(),
                'total_examinations' => Examination::count(),
                'total_questions' => \App\Models\Question::count(),
            ];
            return view('dashboard.lecturer', ['data' => $data]);
        } elseif ($user->role === 'admin') {
            $data['stats'] = [
                'total_students' => User::where('role', 'student')->count(),
                'total_lecturers' => User::where('role', 'lecturer')->count(),
                'active_exams' => Examination::where('status', 'active')->count(),
            ];
            $data['recent_logs'] = ActivityLog::latest()->take(10)->get();
            return view('dashboard.admin', ['data' => $data]);
        }
    }
}

