<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CircularRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'ar_date' => 'required|date',
            'ar_yr' => 'required',
            'ar_name' => 'required|string|max:255',
            'ar_status' => 'nullable|in:1,2',
        ];

        $maxPdfSize = (config('constant.MAX_PDF_FILESIZE_MB') * 1024); // Max size in kilobytes

        // Conditional rules
        if ($this->ar_id) {
            $rules['ar_file_path'] = 'nullable|mimes:pdf|max:' . $maxPdfSize;
        } else {
            $rules['ar_file_path'] = 'required|mimes:pdf|max:' . $maxPdfSize;
        }

        return $rules;
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'ar_date.required' => 'The Circular date field is required.',
            'ar_yr.required' => 'The Circular description field is required.',
            'ar_name.required' => 'The Circular name field is required.',
            'ar_name.string' => 'The Circular name must be a string.',
            'ar_name.max' => 'The Circular name may not be greater than 255 characters.',
            'ar_status.in' => 'The selected Circular status is invalid.',
            'ar_file_path.required' => 'The Circular file path is required when no business unit is selected.',
            'ar_file_path.mimes' => 'The Circular file must be a PDF.',
            'ar_file_path.max' => 'The Circular file size must not exceed ' . config('constant.MAX_PDF_FILESIZE_MB') . ' MB.',
        ];
    }
}
