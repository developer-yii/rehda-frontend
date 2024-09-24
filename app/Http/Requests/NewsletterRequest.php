<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterRequest extends FormRequest
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
            'bu_name' => 'required|string|max:255',
            'bu_yr' => [
                'required',
                'string',
                'regex:/^\d{4}(\/\d{4})?$/',
            ],
            'bu_status' => 'nullable|in:1,2',
        ];

        // Define max file sizes
        $maxImageSize = (config('constant.MAX_IMG_FILESIZE_MB') + 1) * 1024 * 1024; // Max 1MB
        $maxPdfSize = (config('constant.MAX_PDF_FILESIZE_MB') + 1) * 1024; // Max 10MB

        // Conditional rules
        if ($this->bu_id) {
            $rules['bu_img_cover'] = 'nullable|image|mimes:jpeg,jpg,png|max:' . $maxImageSize;
            $rules['bu_file_path'] = 'nullable|mimes:pdf|max:' . $maxPdfSize;
        } else {
            $rules['bu_img_cover'] = 'required|image|mimes:jpeg,jpg,png|max:' . $maxImageSize;
            $rules['bu_file_path'] = 'required|mimes:pdf|max:' . $maxPdfSize;
        }

        return $rules;
    }

    /**
     * Get the custom error messages for the validator.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'bu_name.required' => 'The newsletter title is required.',
            'bu_name.string' => 'The newsletter title must be a string.',
            'bu_name.max' => 'The newsletter title cannot exceed 255 characters.',
            'bu_yr.required' => 'The newsletter year is required.',
            'bu_yr.regex' => 'The newsletter year must be a valid year format (e.g., 2021/2022 or 2023).',
            'bu_img_cover.required' => 'The newsletter image is required.',
            'bu_img_cover.image' => 'The file must be an image.',
            'bu_img_cover.mimes' => 'The newsletter image must be a file of type: jpeg, jpg, png.',
            'bu_img_cover.max' => 'The newsletter image may not be greater than 1MB.',
            'bu_file_path.required' => 'The newsletter PDF is required.',
            'bu_file_path.mimes' => 'The newsletter PDF must be a file of type: pdf.',
            'bu_file_path.max' => 'The newsletter PDF may not be greater than 10MB.',
            'bu_status.in' => 'The status must be either Publish or Draft.',
        ];
    }
}
