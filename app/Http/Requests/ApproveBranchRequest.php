<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveBranchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('memberusers-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oid' => 'required|integer',
            'branchid' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'oid.required' => 'Invalid request!',
            'branchid.required' => 'Select branch!',
            'branchid.integer' => 'Invalid branch!',
            'oid.integer' => 'Invalid request!',
        ];
    }
}
