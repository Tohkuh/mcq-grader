<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\AnswerSheetController;
use App\Http\Controllers\ReportController;

// Landing page
Route::get('/', function () {
    return redirect()->route('exams.index');
});

// Exams
Route::resource('exams', ExamController::class);

// Answer sheet upload & grading
Route::get('exams/{exam}/upload', [AnswerSheetController::class, 'create'])->name('answer-sheets.create');
Route::post('exams/{exam}/upload', [AnswerSheetController::class, 'store'])->name('answer-sheets.store');
Route::get('answer-sheets/{answerSheet}', [AnswerSheetController::class, 'show'])->name('answer-sheets.show');

// Reports
Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show');
Route::get('exams/{exam}/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/{report}/export', [ReportController::class, 'export'])->name('reports.export');