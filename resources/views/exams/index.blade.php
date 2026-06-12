<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams — MCQ Grader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="max-w-5xl mx-auto py-10 px-4">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Exams</h1>
            <p class="text-sm text-gray-500 mt-1">Manage all your MCQ exams</p>
        </div>
        <a href="{{ route('exams.create') }}"
           class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            + New Exam
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($exams->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <p class="text-lg">No exams yet.</p>
            <p class="text-sm mt-1">Create your first exam to get started.</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Title</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Questions</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Pass Mark</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Submissions</th>
                        <th class="text-left px-5 py-3 text-gray-500 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($exams as $exam)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4 font-medium text-gray-800">{{ $exam->title }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $exam->total_questions }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $exam->pass_mark }}%</td>
                            <td class="px-5 py-4 text-gray-600">{{ $exam->answer_sheets_count }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('exams.show', $exam) }}"
                                       class="text-indigo-600 hover:underline">View</a>
                                    <a href="{{ route('answer-sheets.create', $exam) }}"
                                       class="text-green-600 hover:underline">Upload Sheet</a>
                                    <a href="{{ route('reports.index', $exam) }}"
                                       class="text-blue-600 hover:underline">Reports</a>
                                    <form method="POST" action="{{ route('exams.destroy', $exam) }}"
                                          onsubmit="return confirm('Delete this exam?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:underline">Delete</button>
                                    </form>
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