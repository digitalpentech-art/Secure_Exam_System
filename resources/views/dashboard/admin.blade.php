@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
            <h2 class="text-gray-600">Total Students</h2>
            <p class="text-3xl font-bold">{{ $data['stats']['total_students'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
            <h2 class="text-gray-600">Total Lecturers</h2>
            <p class="text-3xl font-bold">{{ $data['stats']['total_lecturers'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
            <h2 class="text-gray-600">Active Exams</h2>
            <p class="text-3xl font-bold">{{ $data['stats']['active_exams'] }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">System Overview</h2>
        <canvas id="adminChart" width="400" height="200"></canvas>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
        <a href="/admin/users" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Manage Users</a>
        <a href="/admin/results" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Manage Results</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('adminChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Students', 'Lecturers', 'Active Exams'],
                datasets: [{
                    label: 'Count',
                    data: [{{ $data['stats']['total_students'] }}, {{ $data['stats']['total_lecturers'] }}, {{ $data['stats']['active_exams'] }}],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b']
                }]
            },
            options: { responsive: true }
        });
    </script>
@endsection
