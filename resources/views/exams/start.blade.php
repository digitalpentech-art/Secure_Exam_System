@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $examination->title }}</h1>
        
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <p class="text-sm text-blue-600 font-semibold uppercase tracking-wider">Duration</p>
                <p class="text-xl font-bold text-gray-800">{{ $examination->duration }} minutes</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <p class="text-sm text-blue-600 font-semibold uppercase tracking-wider">Max Score</p>
                <p class="text-xl font-bold text-gray-800">{{ $examination->max_score }}</p>
            </div>
        </div>
        
        <p class="mb-8 text-gray-600 leading-relaxed">Are you ready to start this examination? Once started, the timer will begin counting down immediately. Ensure you have a stable internet connection.</p>
        
        <form action="/exams/{{ $examination->id }}/start" method="POST">
            @csrf
            <button type="submit" class="w-full bg-blue-600 text-white p-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition duration-200 shadow-sm">Start Examination</button>
        </form>
    </div>
@endsection
