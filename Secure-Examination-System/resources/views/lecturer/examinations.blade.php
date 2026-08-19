@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Examination Management</h1>
            <a href="/lecturer/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-600">
                <ion-icon name="arrow-back-outline"></ion-icon> Back
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-semibold mb-4">Add New Examination</h2>
            <form action="/lecturer/examinations" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <select name="course_id" class="p-2 border rounded" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
                <input type="text" name="title" placeholder="Title" class="p-2 border rounded" required>
                <input type="date" name="date" class="p-2 border rounded" required>
                <input type="time" name="start_time" class="p-2 border rounded" required>
                <input type="time" name="end_time" class="p-2 border rounded" required>
                <input type="number" name="duration" placeholder="Duration (mins)" class="p-2 border rounded" required>
                <input type="number" name="max_score" placeholder="Max Score" class="p-2 border rounded" required>
                <select name="status" class="p-2 border rounded" required>
                    <option value="draft">Draft</option>
                    <option value="active">Active</option>
                    <option value="closed">Closed</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white p-2 rounded flex items-center justify-center gap-2 md:col-span-2 lg:col-span-4">
                    <ion-icon name="add-circle-outline"></ion-icon> Create Examination
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">All Examinations</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Course</th>
                            <th class="py-2">Title</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examinations as $exam)
                            <tr class="border-b">
                                <td class="py-2">{{ $exam->course->title }}</td>
                                <td class="py-2">{{ $exam->title }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded text-sm {{ $exam->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($exam->status) }}
                                    </span>
                                </td>
                                <td class="py-2 flex gap-4">
                                    <a href="/lecturer/questions?examination_id={{ $exam->id }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        <ion-icon name="list-outline"></ion-icon> Questions
                                    </a>
                                    <a href="/lecturer/examinations/{{ $exam->id }}/edit" class="text-yellow-600 hover:text-yellow-800 flex items-center gap-1">
                                        <ion-icon name="create-outline"></ion-icon> Edit
                                    </a>
                                    <form action="/lecturer/examinations/{{ $exam->id }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                                            <ion-icon name="trash-outline"></ion-icon> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
