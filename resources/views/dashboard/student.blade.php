@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Student Dashboard</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8">
        <h2 class="text-xl font-semibold text-gray-700">Welcome, {{ auth()->user()->name }}</h2>
    </div>

    <h2 class="text-2xl font-bold mb-6 text-gray-800">Your Results</h2>
    @if(empty($data['results']) || $data['results']->isEmpty())
        <p class="text-gray-600 mb-12">You have not completed any examinations yet.</p>
    @else
        @foreach($data['results'] as $examinationId => $results)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
                <div class="bg-gray-50 border-b border-gray-200 py-3 px-6 font-semibold text-gray-700 rounded-t-xl">
                    {{ $results->first()->examination->title }}
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="border-b border-gray-100">
                            <tr>
                                <th class="py-3 px-6 text-gray-500 font-medium whitespace-nowrap">Attempt</th>
                                <th class="py-3 px-6 text-gray-500 font-medium whitespace-nowrap">Score</th>
                                <th class="py-3 px-6 text-gray-500 font-medium whitespace-nowrap">Percentage</th>
                                <th class="py-3 px-6 text-gray-500 font-medium whitespace-nowrap">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($results as $index => $result)
                                <tr>
                                    <td class="py-4 px-6 text-gray-600 whitespace-nowrap">Attempt {{ $index + 1 }}</td>
                                    <td class="py-4 px-6 text-gray-600 whitespace-nowrap">{{ $result->score }} / {{ $result->examination->max_score }}</td>
                                    <td class="py-4 px-6 text-gray-600 whitespace-nowrap">{{ number_format($result->percentage, 1) }}%</td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-sm font-bold {{ $result->grade === 'F' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $result->grade }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif

    <h2 class="text-2xl font-bold mb-6 text-gray-800">Active Examinations</h2>
    @if(empty($data['active_exams']) || $data['active_exams']->isEmpty())
        <p class="text-gray-600 mb-8">No active examinations currently.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach($data['active_exams'] as $exam)
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col gap-4">
                        <h3 class="text-lg font-bold text-gray-800">{{ $exam->title }}</h3>
                        <p class="text-sm text-gray-600">Course: {{ $exam->course->title ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">Duration: {{ $exam->duration }} mins</p>
                        <a href="/exams/{{ $exam->id }}/start" class="mt-auto block text-center bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Start Exam</a>
                    </div>
                @endforeach
        </div>
    @endif

    <h2 class="text-2xl font-bold mb-6 text-gray-800">Past Examinations (Closed)</h2>
    @if(empty($data['closed_exams']) || $data['closed_exams']->isEmpty())
        <p class="text-gray-600">No past examinations found.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($data['closed_exams'] as $exam)
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 flex flex-col gap-4 opacity-75">
                        <h3 class="text-lg font-bold text-gray-600">{{ $exam->title }}</h3>
                        <p class="text-sm text-gray-500">Course: {{ $exam->course->title ?? 'N/A' }}</p>
                        <span class="mt-auto text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold cursor-not-allowed">Closed</span>
                    </div>
                @endforeach
        </div>
    @endif
@endsection
