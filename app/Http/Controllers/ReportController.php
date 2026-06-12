<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\GradingReport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Exam $exam)
    {
        $reports = GradingReport::whereHas('answerSheet', function ($q) use ($exam) {
            $q->where('exam_id', $exam->id);
        })->with('answerSheet')->latest()->get();

        return view('reports.index', compact('exam', 'reports'));
    }

    public function show(GradingReport $report)
    {
        $report->load([
            'answerSheet.exam',
            'answerSheet.answers.question',
        ]);

        return view('reports.show', compact('report'));
    }

    public function export(GradingReport $report)
    {
        $report->load([
            'answerSheet.exam',
            'answerSheet.answers.question',
        ]);

        $pdf = Pdf::loadView('pdf.report', compact('report'));

        return $pdf->download('report-' . $report->answerSheet->student_id . '.pdf');
    }
}