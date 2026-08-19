<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Questions - {{ $examination->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Manage Questions: {{ $examination->title }}</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-semibold mb-2">Add New Question</h2>
            <p class="text-sm text-gray-600 mb-4">Fill out the form below to add a question to this examination. Ensure you provide all four options and specify the correct answer exactly as it appears in one of the options.</p>
            <form action="/lecturer/questions" method="POST" class="grid grid-cols-1 gap-4">
                @csrf
                <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Question Text</label>
                    <textarea name="question_text" class="w-full p-2 border rounded mt-1" rows="3" required></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Option A</label>
                        <input type="text" name="option_a" id="option_a" class="w-full p-2 border rounded mt-1 option-input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Option B</label>
                        <input type="text" name="option_b" id="option_b" class="w-full p-2 border rounded mt-1 option-input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Option C</label>
                        <input type="text" name="option_c" id="option_c" class="w-full p-2 border rounded mt-1 option-input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Option D</label>
                        <input type="text" name="option_d" id="option_d" class="w-full p-2 border rounded mt-1 option-input" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Correct Answer</label>
                    <select name="correct_answer" id="correct_answer" class="w-full p-2 border rounded mt-1" required>
                        <option value="">Select the correct option...</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Create Question</button>
            </form>
        </div>

        <script>
            const optionInputs = document.querySelectorAll('.option-input');
            const correctSelect = document.getElementById('correct_answer');

            optionInputs.forEach(input => {
                input.addEventListener('input', updateCorrectAnswerSelect);
            });

            function updateCorrectAnswerSelect() {
                const selectedValue = correctSelect.value;
                correctSelect.innerHTML = '<option value="">Select the correct option...</option>';
                
                optionInputs.forEach(input => {
                    if (input.value) {
                        const option = document.createElement('option');
                        option.value = input.value;
                        option.textContent = input.value;
                        if (selectedValue === input.value) {
                            option.selected = true;
                        }
                        correctSelect.appendChild(option);
                    }
                });
            }
        </script>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">All Questions</h2>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Question Text</th>
                        <th class="py-2">Correct Answer</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                        <tr class="border-b">
                            <td class="py-2">{{ $question->text }}</td>
                            <td class="py-2">{{ $question->correct_answer }}</td>
                            <td class="py-2 flex gap-4">
                                <a href="/lecturer/questions/{{ $question->id }}/edit" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                <form action="/lecturer/questions/{{ $question->id }}" method="POST">
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
