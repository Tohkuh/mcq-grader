<?php

namespace App\Models;

use App\Enums\AnswerOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = ['answer_sheet_id', 'question_id', 'selected_option', 'is_correct'];

    protected $casts = [
        'selected_option' => AnswerOption::class,
        'is_correct' => 'boolean',
    ];

    public function answerSheet(): BelongsTo
    {
        return $this->belongsTo(AnswerSheet::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}