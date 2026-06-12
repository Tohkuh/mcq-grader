<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grading_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_sheet_id')->unique()->constrained()->cascadeOnDelete();
            $table->integer('score');
            $table->integer('total_questions');
            $table->decimal('percentage', 5, 2);
            $table->boolean('passed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grading_reports');
    }
};