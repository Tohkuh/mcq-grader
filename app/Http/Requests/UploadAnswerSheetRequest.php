<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadAnswerSheetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'max:255'],
            'student_id'   => ['required', 'string', 'max:100'],
            'file'         => ['required', 'file', 'mimes:csv,xlsx', 'max:2048'],
        ];
    }
}