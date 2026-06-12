<?php

namespace App\Imports;

use App\Enums\AnswerOption;
use App\Models\Answer;
use App\Models\AnswerSheet;
use App\Models\Question;
use App\Services\GradingService;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class AnswerSheetImport implements ToCollection, WithHeadingRow
{
    protected AnswerSheet $sheet;
    protected GradingService $gradingService;

    public function __construct(AnswerSheet $sheet, GradingService $gradingService)
    {
        $this->sheet          = $sheet;
        $this->gradingService = $gradingService;
    }

    public function collection(Collection $rows): void
    {
        $questions = Question::where('exam_id', $this->sheet->exam_id)
            ->get()
            ->keyBy('question_number');

        foreach ($rows as $row) {
            $questionNumber = $row['question_number'] ?? null;
            $selectedRaw    = strtoupper(trim($row['selected_option'] ?? ''));

            $question = $questions->get($questionNumber);

            if (!$question) {
                continue;
            }

            $selectedOption = AnswerOption::tryFrom($selectedRaw);
            $isCorrect      = $selectedOption !== null && $selectedOption === $question->correct_option;

            Answer::create([
                'answer_sheet_id' => $this->sheet->id,
                'question_id'     => $question->id,
                'selected_option' => $selectedOption?->value,
                'is_correct'      => $isCorrect,
            ]);
        }

        $this->gradingService->grade($this->sheet);
    }
}