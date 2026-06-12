<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Answer Sheet — MCQ Grader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="max-w-xl mx-auto py-10 px-4">

    <div class="mb-8">
        <a href="{{ route('exams.show', $exam) }}" class="text-sm text-gray-500 hover:underline">← Back to Exam</a>
        <h1 class="text-2xl font-semibold text-gray-800 mt-2">Upload Answer Sheet</h1>
        <p class="text-sm text-gray-500 mt-1">Exam: <span class="font-medium text-gray-700">{{ $exam->title }}</span></p>
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

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <h2 class="text-sm font-medium text-gray-700 mb-3">Expected CSV Format</h2>
        <pre class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-xs text-gray-600 overflow-x-auto">question_number,selected_option
1,A
2,C
3,B
4,D
5,A</pre>
        <p class="text-xs text-gray-400 mt-2">Save as <code class="bg-gray-100 px-1 rounded">.csv</code> or <code class="bg-gray-100 px-1 rounded">.xlsx</code>. Column headers must match exactly.</p>
    </div>

    <form method="POST" action="{{ route('answer-sheets.store', $exam) }}" enctype="multipart/form-data"
          class="bg-white rounded-xl border border-gray-200 p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm text-gray-600 mb-1">Student Name <span class="text-red-500">*</span></label>
            <input type="text" name="student_name" value="{{ old('student_name') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                   placeholder="e.g. John Doe">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Student ID <span class="text-red-500">*</span></label>
            <input type="text" name="student_id" value="{{ old('student_id') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                   placeholder="e.g. STU-2024-001">
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Answer Sheet File <span class="text-red-500">*</span></label>
            <input type="file" name="file" accept=".csv,.xlsx"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-indigo-50 file:text-indigo-700">
            <p class="text-xs text-gray-400 mt-1">Accepted: .csv, .xlsx — Max 2MB</p>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit"
                    class="bg-indigo-600 text-white text-sm px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                Upload & Grade
            </button>
        </div>

    </form>
</div>
</body>
</html>