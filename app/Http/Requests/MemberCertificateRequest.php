<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MemberCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('memberusers-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fileimg' => 'required|file|mimes:pdf|max:'.((config('constant.MAX_PDF_FILESIZE_MB') + 1) * 1024)
        ];
    }

    public function messages()
    {
        return [
            'fileimg.required' => 'please upload certificate',
            'fileimg.mimes' => 'This field must be a file of type: :values.',
            'fileimg.max' => 'The file size should not exceed ' . config('constant.MAX_PDF_FILESIZE_MB') . ' MB for PDFs.'
        ];
    }
}
