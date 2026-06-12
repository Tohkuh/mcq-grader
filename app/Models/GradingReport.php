<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradingReport extends Model
{
    protected $fillable = ['answer_sheet_id', 'score', 'total_questions', 'percentage', 'passed'];

    protected $casts = [
        'passed' => 'boolean',
        'percentage' => 'decimal:2',
    ];

    public function answerSheet(): BelongsTo
    {
        return $this->belongsTo(AnswerSheet::class);
    }
}