<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipNumberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('membershipno-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'm_no_p2' => 'required|max:4',
            'm_no_p4' => 'required|max:6',
            'm_no_p5' => 'required|max:4'
        ];
    }

    public function messages()
    {
        return [
            'm_no_p2.required' => 'Please enter all the required details',
            'm_no_p4.required' => 'Please enter all the required details',
            'm_no_p5.required' => 'Please enter all the required details',
            'm_no_p2.max' => 'First field must not be greater than :max characters.',
            'm_no_p4.max' => 'Second field must not be greater than :max characters.',
            'm_no_p5.max' => 'Third field must not be greater than :max characters.'
        ];
    }
}
