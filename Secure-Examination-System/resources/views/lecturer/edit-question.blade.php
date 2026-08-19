<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Question</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6">Edit Question</h1>
        <form action="/lecturer/questions/{{ $question->id }}" method="POST" class="grid grid-cols-1 gap-4">
            @csrf
            @method('PUT')
            <textarea name="text" class="w-full p-2 border rounded" rows="3" required>{{ $question->text }}</textarea>
            <input type="text" name="option_a" value="{{ $question->option_a }}" class="p-2 border rounded" required>
            <input type="text" name="option_b" value="{{ $question->option_b }}" class="p-2 border rounded" required>
            <input type="text" name="option_c" value="{{ $question->option_c }}" class="p-2 border rounded" required>
            <input type="text" name="option_d" value="{{ $question->option_d }}" class="p-2 border rounded" required>
            <input type="text" name="correct_answer" value="{{ $question->correct_answer }}" class="p-2 border rounded" required>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded">Update Question</button>
        </form>
    </div>
</body>
</html>
