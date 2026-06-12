<?php

namespace App\Models;

use App\Enums\AnswerOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = ['exam_id', 'question_number', 'correct_option'];

    protected $casts = [
        'correct_option' => AnswerOption::class,
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}