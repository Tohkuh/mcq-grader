<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam — MCQ Grader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="max-w-3xl mx-auto py-10 px-4">

    <div class="mb-8">
        <a href="{{ route('exams.index') }}" class="text-sm text-gray-500 hover:underline">← Back to Exams</a>
        <h1 class="text-2xl font-semibold text-gray-800 mt-2">Create New Exam</h1>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('exams.store') }}" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
            <h2 class="text-base font-medium text-gray-700">Exam Details</h2>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                       placeholder="e.g. Biology Midterm 2024">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                          placeholder="Optional description...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Total Questions <span class="text-red-500">*</span></label>
                    <input type="number" name="total_questions" id="total_questions" value="{{ old('total_questions') }}"
                           min="1"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Pass Mark (%) <span class="text-red-500">*</span></label>
                    <input type="number" name="pass_mark" value="{{ old('pass_mark') }}"
                           min="1" max="100"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>
            </div>

            <div>
                <button type="button" onclick="generateRows()"
                        class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                    Generate Answer Key Rows
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-medium text-gray-700 mb-4">Answer Key</h2>
            <div id="answer-key-rows" class="space-y-3">
                <p class="text-sm text-gray-400">Set total questions above and click "Generate Answer Key Rows".</p>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 text-white text-sm px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                Create Exam
            </button>
        </div>

    </form>
</div>

<script>
function generateRows() {
    const total = parseInt(document.getElementById('total_questions').value);
    const container = document.getElementById('answer-key-rows');

    if (!total || total < 1) {
        alert('Please enter a valid number of questions first.');
        return;
    }

    container.innerHTML = '';

    const options = ['A', 'B', 'C', 'D'];

    for (let i = 1; i <= total; i++) {
        const row = document.createElement('div');
        row.className = 'flex items-center gap-4';
        row.innerHTML = `
            <span class="text-sm text-gray-600 w-28">Question ${i}</span>
            <div class="flex gap-2">
                ${options.map(opt => `
                    <label class="flex items-center gap-1 cursor-pointer">
                        <input type="radio" name="answers[${i}]" value="${opt}" required
                               class="accent-indigo-600">
                        <span class="text-sm text-gray-700">${opt}</span>
                    </label>
                `).join('')}
            </div>
        `;
        container.appendChild(row);
    }
}
</script>
</body>
</html>