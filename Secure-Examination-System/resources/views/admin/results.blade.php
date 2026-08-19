<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Result Management</h1>
            <a href="/admin/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-600">
                Back
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">All Results</h2>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Student</th>
                        <th class="py-2">Examination</th>
                        <th class="py-2">Score</th>
                        <th class="py-2">Percentage</th>
                        <th class="py-2">Grade</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                        <tr class="border-b">
                            <td class="py-2">{{ $result->student->name }}</td>
                            <td class="py-2">{{ $result->examination->title }}</td>
                            <td class="py-2">{{ $result->score }}</td>
                            <td class="py-2">{{ number_format($result->percentage, 1) }}%</td>
                            <td class="py-2">{{ $result->grade }}</td>
                            <td class="py-2">
                                <form action="/admin/results/{{ $result->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this result?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
