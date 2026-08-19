<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@heroicons/vue@2.0.18/dist/heroicons.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Course Management</h1>
            <a href="/lecturer/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-600">
                <ion-icon name="arrow-back-outline"></ion-icon> Back
            </a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-semibold mb-4">Add New Course</h2>
            <form action="/lecturer/courses" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @csrf
                <input type="text" name="course_code" placeholder="Code" class="p-2 border rounded" required>
                <input type="text" name="title" placeholder="Title" class="p-2 border rounded" required>
                <input type="number" name="unit" placeholder="Units" class="p-2 border rounded" required>
                <input type="text" name="department" placeholder="Department" class="p-2 border rounded" required>
                <button type="submit" class="bg-blue-600 text-white p-2 rounded flex items-center justify-center gap-2">
                    <ion-icon name="add-circle-outline"></ion-icon> Create
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">All Courses</h2>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Code</th>
                        <th class="py-2">Title</th>
                        <th class="py-2">Units</th>
                        <th class="py-2">Department</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr class="border-b">
                            <td class="py-2">{{ $course->course_code }}</td>
                            <td class="py-2">{{ $course->title }}</td>
                            <td class="py-2">{{ $course->unit }}</td>
                            <td class="py-2">{{ $course->department }}</td>
                            <td class="py-2 flex gap-4">
                                <a href="/lecturer/courses/{{ $course->id }}/edit" class="text-yellow-600 hover:text-yellow-800 flex items-center gap-1">
                                    <ion-icon name="create-outline"></ion-icon> Edit
                                </a>
                                <form action="/lecturer/courses/{{ $course->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course? All associated examinations will also be deleted.');">
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
</body>
</html>
