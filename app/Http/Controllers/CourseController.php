<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('lecturer.courses', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses',
            'title' => 'required',
            'unit' => 'required|integer',
            'department' => 'required',
        ]);

        Course::create($request->all());
        return redirect('/lecturer/courses')->with('success', 'Course created successfully');
    }

    public function edit(Course $course)
    {
        return view('lecturer.edit-course', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $course->update($request->all());
        return redirect('/lecturer/courses')->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect('/lecturer/courses')->with('success', 'Course deleted successfully');
    }
}
