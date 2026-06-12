<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadAnswerSheetRequest;
use App\Imports\AnswerSheetImport;
use App\Models\AnswerSheet;
use App\Models\Exam;
use App\Services\GradingService;
use Maatwebsite\Excel\Facades\Excel;

class AnswerSheetController extends Controller
{
    public function create(Exam $exam)
    {
        return view('answer-sheets.upload', compact('exam'));
    }

    public function store(UploadAnswerSheetRequest $request, Exam $exam)
    {
        $path = $request->file('file')->store('answer-sheets');

        $sheet = AnswerSheet::create([
            'exam_id'      => $exam->id,
            'student_name' => $request->student_name,
            'student_id'   => $request->student_id,
            'file_path'    => $path,
            'status'       => 'pending',
        ]);

        $gradingService = new GradingService();

        Excel::import(new AnswerSheetImport($sheet, $gradingService), $request->file('file'));

        $sheet->refresh();
        $report = $sheet->gradingReport;

        return redirect()->route('reports.show', $report)
            ->with('success', 'Answer sheet uploaded and graded successfully.');
    }

    public function show(AnswerSheet $answerSheet)
    {
        $answerSheet->load(['exam', 'answers.question', 'gradingReport']);
        return view('answer-sheets.show', compact('answerSheet'));
    }
}