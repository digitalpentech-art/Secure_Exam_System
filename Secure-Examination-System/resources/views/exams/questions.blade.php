<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto p-4 md:p-8" id="exam-container" data-session-id="{{ $sessionId }}">
        <!-- Header -->
        <div class="bg-white p-6 rounded-t-lg shadow-sm border-b flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Examination</h1>
            <div id="timer" class="text-lg font-mono font-bold text-red-600 bg-red-50 px-3 py-1 rounded">--:--</div>
        </div>
        
        <!-- Progress Bar -->
        <div class="bg-white px-6 py-2 shadow-sm border-b">
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div id="progress-bar" class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
            </div>
            <p id="progress-text" class="text-xs text-gray-500 mt-1">Question 0 of 0</p>
        </div>

        <!-- Question Area -->
        <div id="questions-list" class="bg-white p-6 shadow-md min-h-[300px]">
            <p class="text-gray-600 animate-pulse">Loading questions...</p>
        </div>

        <!-- Navigation -->
        <div class="bg-white p-6 rounded-b-lg shadow-sm border-t flex justify-between items-center">
            <button id="prev-btn" class="text-gray-600 font-semibold px-4 py-2 hover:bg-gray-100 rounded disabled:opacity-50" onclick="changeQuestion(-1)" disabled>Previous</button>
            <button id="next-btn" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded hover:bg-blue-700 shadow-sm" onclick="changeQuestion(1)">Next</button>
            <button id="submit-btn" class="bg-green-600 text-white font-semibold px-6 py-2 rounded hover:bg-green-700 shadow-sm hidden" onclick="submitExam()">Submit Exam</button>
        </div>
    </div>

    <script>
        const sessionId = document.getElementById('exam-container').dataset.sessionId;
        const questionsList = document.getElementById('questions-list');
        const timerElement = document.getElementById('timer');
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        let endTime;
        let questions = [];
        let currentIndex = 0;

        fetch(`/sessions/${sessionId}/questions`)
            .then(response => response.json())
            .then(data => {
                endTime = new Date(data.end_time);
                // Pre-shuffle options for each question once
                questions = data.questions.map(q => ({
                    ...q,
                    shuffledOptions: shuffleArray(['option_a', 'option_b', 'option_c', 'option_d'])
                }));
                renderQuestion();
                startTimer();
            });

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function renderQuestion() {
            const q = questions[currentIndex];
            const storedAnswer = getStoredAnswer(q.id);
            
            // Use pre-shuffled options
            const options = q.shuffledOptions;
            
            questionsList.innerHTML = `
                <p class="font-bold text-xl mb-6 text-gray-800">${currentIndex + 1}. ${q.text}</p>
                <div class="space-y-4">
                    ${options.map(opt => `
                        <label class="flex items-center gap-4 p-4 border-2 rounded-lg hover:border-blue-300 hover:bg-blue-50 cursor-pointer transition ${storedAnswer === q[opt] ? 'border-blue-500 bg-blue-50' : 'border-gray-200'}">
                            <input type="radio" name="answer_${q.id}" value="${q[opt]}" class="question-answer h-5 w-5 text-blue-600" data-id="${q.id}" ${storedAnswer === q[opt] ? 'checked' : ''} onchange="saveAnswer(${q.id}, '${q[opt].replace(/'/g, "\\'")}')">
                            <span class="text-gray-700 text-lg">${q[opt]}</span>
                        </label>
                    `).join('')}
                </div>
            `;
            
            // Update Buttons
            document.getElementById('prev-btn').disabled = (currentIndex === 0);
            const isLast = (currentIndex === questions.length - 1);
            document.getElementById('next-btn').classList.toggle('hidden', isLast);
            document.getElementById('submit-btn').classList.toggle('hidden', !isLast);
            
            // Update Progress
            const progress = ((currentIndex + 1) / questions.length) * 100;
            progressBar.style.width = `${progress}%`;
            progressText.textContent = `Question ${currentIndex + 1} of ${questions.length}`;
        }

        function saveAnswer(questionId, answer) {
            const answers = JSON.parse(localStorage.getItem('answers') || '{}');
            answers[questionId] = answer;
            localStorage.setItem('answers', JSON.stringify(answers));
            renderQuestion(); // Re-render to update selected styling
        }

        function getStoredAnswer(questionId) {
            const answers = JSON.parse(localStorage.getItem('answers') || '{}');
            return answers[questionId];
        }

        function changeQuestion(delta) {
            // If going forward (delta > 0), check if answer is selected
            if (delta > 0) {
                const currentQuestionId = questions[currentIndex].id;
                const storedAnswer = getStoredAnswer(currentQuestionId);
                if (!storedAnswer) {
                    alert('Please select an answer before proceeding.');
                    return;
                }
            }
            
            currentIndex += delta;
            renderQuestion();
        }

        function startTimer() {
            const interval = setInterval(() => {
                const now = new Date();
                const diff = endTime - now;
                if (diff <= 0) {
                    clearInterval(interval);
                    timerElement.textContent = "00:00";
                    submitExam();
                } else {
                    const minutes = Math.floor(diff / 1000 / 60);
                    const seconds = Math.floor((diff / 1000) % 60);
                    timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                }
            }, 1000);
        }

        function submitExam() {
            if (!confirm('Are you sure you want to submit your exam?')) return;
            
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            const answers = Object.entries(JSON.parse(localStorage.getItem('answers') || '{}')).map(([question_id, answer]) => ({
                question_id,
                answer
            }));

            fetch(`/sessions/${sessionId}/submit`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ answers })
            })
            .then(async response => {
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`Submission failed (Status ${response.status}): ${text}`);
                }
                return response.json();
            })
            .then(data => {
                localStorage.removeItem('answers');
                alert(data.message);
                window.location.href = data.redirect || '/dashboard';
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Exam';
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                console.error('Submission error:', error);
                alert('Submission failed: ' + error.message);
            });
        }
    </script>
</body>
</html>
