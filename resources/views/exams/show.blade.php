<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }} — MCQ Grader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="mb-8">
        <a href="{{ route('exams.index') }}" class="text-sm text-gray-500 hover:underline">← Back to Exams</a>
        <div class="flex items-center justify-between mt-2">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">{{ $exam->title }}</h1>
                @if($exam->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $exam->description }}</p>
                @endif
            </div>
            <a href="{{ route('answer-sheets.create', $exam) }}"
               class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                + Upload Answer Sheet
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Questions</p>
            <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $exam->total_questions }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Pass Mark</p>
            <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $exam->pass_mark }}%</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Submissions</p>
            <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $exam->answerSheets->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-medium text-gray-700 mb-4">Answer Key</h2>
            <div class="space-y-2 max-h-80 overflow-y-auto">
                @foreach($exam->questions as $question)
                    <div class="flex items-center justify-between text-sm py-1 border-b border-gray-100 last:border-0">
                        <span class="text-gray-600">Question {{ $question->question_number }}</span>
                        <span class="bg-indigo-50 text-indigo-700 font-medium px-3 py-0.5 rounded-full">
                            {{ $question->correct_option->value }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-medium text-gray-700">Submissions</h2>
                <a href="{{ route('reports.index', $exam) }}" class="text-sm text-indigo-600 hover:underline">View all reports</a>
            </div>
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @forelse($exam->answerSheets as $sheet)
                    <div class="flex items-center justify-between text-sm py-2 border-b border-gray-100 last:border-0">
                        <div>
                            <p class="font-medium text-gray-800">{{ $sheet->student_name }}</p>
                            <p class="text-gray-400 text-xs">ID: {{ $sheet->student_id }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($sheet->status === 'graded')
                                <span class="bg-green-50 text-green-700 text-xs px-2 py-0.5 rounded-full">Graded</span>
                                @if($sheet->gradingReport)
                                    <a href="{{ route('reports.show', $sheet->gradingReport) }}"
                                       class="text-indigo-600 hover:underline text-xs">Report</a>
                                @endif
                            @else
                                <span class="bg-yellow-50 text-yellow-700 text-xs px-2 py-0.5 rounded-full">Pending</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">No submissions yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
</body>
</html>