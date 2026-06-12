<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports — {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="mb-8">
        <a href="{{ route('exams.show', $exam) }}" class="text-sm text-gray-500 hover:underline">← Back to Exam</a>
        <h1 class="text-2xl font-semibold text-gray-800 mt-2">Grading Reports</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $exam->title }}</p>
    </div>

    @if($reports->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <p class="text-lg">No reports yet.</p>
            <p class="text-sm mt-1">Upload answer sheets to generate reports.</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Student</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Student ID</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Score</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Percentage</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Result</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4 font-medium text-gray-800">{{ $report->answerSheet->student_name }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $report->answerSheet->student_id }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $report->score }} / {{ $report->total_questions }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ number_format($report->percentage, 1) }}%</td>
                            <td class="px-5 py-4">
                                @if($report->passed)
                                    <span class="bg-green-50 text-green-700 text-xs font-medium px-3 py-1 rounded-full">Pass</span>
                                @else
                                    <span class="bg-red-50 text-red-700 text-xs font-medium px-3 py-1 rounded-full">Fail</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('reports.show', $report) }}"
                                       class="text-indigo-600 hover:underline">View</a>
                                    <a href="{{ route('reports.export', $report) }}"
                                       class="text-gray-600 hover:underline">Export PDF</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
</body>
</html>