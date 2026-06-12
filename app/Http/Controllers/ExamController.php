<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExamRequest;
use App\Models\Exam;
use App\Models\Question;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::withCount('answerSheets')->latest()->get();
        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        return view('exams.create');
    }

    public function store(StoreExamRequest $request)
    {
        $exam = Exam::create([
            'title'           => $request->title,
            'description'     => $request->description,
            'total_questions' => $request->total_questions,
            'pass_mark'       => $request->pass_mark,
        ]);

        $questions = [];
        foreach ($request->answers as $questionNumber => $correctOption) {
            $questions[] = [
                'exam_id'         => $exam->id,
                'question_number' => $questionNumber,
                'correct_option'  => $correctOption,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        Question::insert($questions);

        return redirect()->route('exams.show', $exam)
            ->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load(['questions', 'answerSheets.gradingReport']);
        return view('exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $exam->load('questions');
        return view('exams.edit', compact('exam'));
    }

    public function update(StoreExamRequest $request, Exam $exam)
    {
        $exam->update([
            'title'           => $request->title,
            'description'     => $request->description,
            'total_questions' => $request->total_questions,
            'pass_mark'       => $request->pass_mark,
        ]);

        $exam->questions()->delete();

        $questions = [];
        foreach ($request->answers as $questionNumber => $correctOption) {
            $questions[] = [
                'exam_id'         => $exam->id,
                'question_number' => $questionNumber,
                'correct_option'  => $correctOption,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        Question::insert($questions);

        return redirect()->route('exams.show', $exam)
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')
            ->with('success', 'Exam deleted successfully.');
    }
}