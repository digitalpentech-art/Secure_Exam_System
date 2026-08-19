<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lecturer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Lecturer Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="/lecturer/courses" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold">Manage Courses</h2>
            </a>
            <a href="/lecturer/examinations" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-50">
                <h2 class="text-xl font-semibold">Manage Examinations</h2>
            </a>
        </div>
    </div>
</body>
</html>
