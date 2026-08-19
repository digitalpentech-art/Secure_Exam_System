<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6">Edit Course</h1>
        <form action="/lecturer/courses/{{ $course->id }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')
            <input type="text" name="course_code" value="{{ $course->course_code }}" class="p-2 border rounded" required>
            <input type="text" name="title" value="{{ $course->title }}" class="p-2 border rounded" required>
            <input type="number" name="unit" value="{{ $course->unit }}" class="p-2 border rounded" required>
            <input type="text" name="department" value="{{ $course->department }}" class="p-2 border rounded" required>
            <div class="md:col-span-2 flex justify-end gap-4">
                <a href="/lecturer/courses" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Course</button>
            </div>
        </form>
    </div>
</body>
</html>
