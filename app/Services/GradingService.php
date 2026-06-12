<?php

namespace App\Services;

use App\Models\AnswerSheet;
use App\Models\GradingReport;

class GradingService
{
    public function grade(AnswerSheet $sheet): GradingReport
    {
        $answers = $sheet->answers()->with('question')->get();

        $totalQuestions = $answers->count();
        $score = $answers->where('is_correct', true)->count();
        $percentage = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;
        $passed = $percentage >= $sheet->exam->pass_mark;

        $report = GradingReport::updateOrCreate(
            ['answer_sheet_id' => $sheet->id],
            [
                'score'           => $score,
                'total_questions' => $totalQuestions,
                'percentage'      => round($percentage, 2),
                'passed'          => $passed,
            ]
        );

        $sheet->update(['status' => 'graded']);

        return $report;
    }
}