<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report — {{ $report->answerSheet->student_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="max-w-4xl mx-auto py-10 px-4">

    <div class="mb-8">
        <a href="{{ route('reports.index', $report->answerSheet->exam) }}"
           class="text-sm text-gray-500 hover:underline">← Back to Reports</a>
        <div class="flex items-center justify-between mt-2">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">{{ $report->answerSheet->student_name }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    ID: {{ $report->answerSheet->student_id }} ·
                    Exam: {{ $report->answerSheet->exam->title }}
                </p>
            </div>
            <a href="{{ route('reports.export', $report) }}"
               class="bg-gray-800 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-900 transition">
                Export PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-5 text-center">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Score</p>
            <p class="text-3xl font-semibold text-gray-800 mt-1">
                {{ $report->score }} / {{ $report->total_questions }}
            </p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 text-center">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Percentage</p>
            <p class="text-3xl font-semibold text-gray-800 mt-1">
                {{ number_format($report->percentage, 1) }}%
            </p>
        </div>
        <div class="p-5 text-center rounded-xl border {{ $report->passed ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
            <p class="text-xs uppercase tracking-wide {{ $report->passed ? 'text-green-600' : 'text-red-600' }}">Result</p>
            <p class="text-3xl font-semibold mt-1 {{ $report->passed ? 'text-green-700' : 'text-red-700' }}">
                {{ $report->passed ? 'Pass' : 'Fail' }}
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-medium text-gray-700">Question Breakdown</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Question</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Your Answer</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Correct Answer</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Result</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($report->answerSheet->answers->sortBy('question.question_number') as $answer)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 text-gray-700">Q{{ $answer->question->question_number }}</td>
                        <td class="px-5 py-3">
                            @if($answer->selected_option)
                                <span class="font-medium {{ $answer->is_correct ? 'text-green-700' : 'text-red-600' }}">
                                    {{ $answer->selected_option->value }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">No answer</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <span class="bg-indigo-50 text-indigo-700 font-medium px-2 py-0.5 rounded">
                                {{ $answer->question->correct_option->value }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            @if($answer->is_correct)
                                <span class="bg-green-50 text-green-700 text-xs px-2 py-0.5 rounded-full">Correct</span>
                            @else
                                <span class="bg-red-50 text-red-700 text-xs px-2 py-0.5 rounded-full">Wrong</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</body>
</html>