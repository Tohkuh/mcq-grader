<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnswerSheet extends Model
{
    protected $fillable = ['exam_id', 'student_name', 'student_id', 'file_path', 'status'];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function gradingReport(): HasOne
    {
        return $this->hasOne(GradingReport::class);
    }
}