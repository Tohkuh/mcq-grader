<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Exam extends Model
{
    protected $fillable = ['title', 'description', 'total_questions', 'pass_mark'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('question_number');
    }

    public function answerSheets(): HasMany
    {
        return $this->hasMany(AnswerSheet::class);
    }

    public function gradingReports(): HasManyThrough
    {
        return $this->hasManyThrough(GradingReport::class, AnswerSheet::class);
    }
}