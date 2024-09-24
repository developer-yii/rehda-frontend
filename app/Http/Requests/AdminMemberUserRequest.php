<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminMemberUserRequest extends FormRequest
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
            'adminname' => 'required|max:255',
            'admintitle' => 'required',
            'adminpost' => 'required|max:255',
            'adminmobile' => 'required|max:255',
            'adminemail' => 'required|max:255|email',
        ];
    }

    public function messages()
    {
        return [

            'adminname.required' => 'Full Name is required',
            'adminname.max' => 'Full Name must not be greater than :max characters.',

            'admintitle.required' => 'Title is required',

            'adminpost.required' => 'Designation is required',
            'adminpost.max' => 'Designation must not be greater than :max characters.',

            'adminemail.required' => 'Email is required',
            'adminemail.max' => 'Email must not be greater than :max characters.',
            'adminemail.email' => 'The Email field must be a valid email address.',

            'adminmobile.required' => 'Contact No. is required',
            'adminmobile.max' => 'The Contact No. must not be greater than :max characters.',

        ];
    }
}
