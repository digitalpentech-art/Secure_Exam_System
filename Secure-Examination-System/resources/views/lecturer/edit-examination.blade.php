@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Edit Examination</h1>
            <a href="/lecturer/examinations" class="bg-gray-500 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-600">
                Back
            </a>
        </div>
        
        <form action="/lecturer/examinations/{{ $examination->id }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')
            <select name="course_id" class="p-2 border rounded" required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $examination->course_id == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
            <input type="text" name="title" value="{{ $examination->title }}" class="p-2 border rounded" required>
            <input type="date" name="date" value="{{ $examination->date }}" class="p-2 border rounded" required>
            <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($examination->start_time)->format('H:i') }}" class="p-2 border rounded" required>
            <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($examination->end_time)->format('H:i') }}" class="p-2 border rounded" required>
            <input type="number" name="duration" value="{{ $examination->duration }}" class="p-2 border rounded" required>
            <input type="number" name="max_score" value="{{ $examination->max_score }}" class="p-2 border rounded" required>
            <select name="status" class="p-2 border rounded" required>
                <option value="draft" {{ $examination->status === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ $examination->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="closed" {{ $examination->status === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded md:col-span-2">Update Examination</button>
        </form>
    </div>
@endsection
