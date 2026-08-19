@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Lecturer Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
            <h2 class="text-gray-600">Total Courses</h2>
            <p class="text-3xl font-bold">{{ $data['stats']['total_courses'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
            <h2 class="text-gray-600">Total Examinations</h2>
            <p class="text-3xl font-bold">{{ $data['stats']['total_examinations'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
            <h2 class="text-gray-600">Total Questions</h2>
            <p class="text-3xl font-bold">{{ $data['stats']['total_questions'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Manage Courses</h2>
            <a href="/lecturer/courses" class="text-blue-600 underline">View Courses</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Manage Examinations</h2>
            <a href="/lecturer/examinations" class="text-blue-600 underline">View Examinations</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Manage Sessions</h2>
            <a href="/lecturer/sessions" class="text-blue-600 underline">View Sessions</a>
        </div>
    </div>
@endsection
