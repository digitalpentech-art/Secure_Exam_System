@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Examination Sessions</h1>
            <a href="/lecturer/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-600">
                Back
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Examination</th>
                        <th class="py-2">Student</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                        <tr class="border-b">
                            <td class="py-2">{{ $session->examination->title }}</td>
                            <td class="py-2">{{ $session->student->name }}</td>
                            <td class="py-2">{{ ucfirst($session->status) }}</td>
                            <td class="py-2">
                                @if($session->status === 'completed')
                                    <form action="/lecturer/sessions/{{ $session->id }}/reset" method="POST" onsubmit="return confirm('Reset this student attempt?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                                            <ion-icon name="refresh-outline"></ion-icon> Reset Attempt
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
