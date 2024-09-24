<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffRepMemberUserRequest extends FormRequest
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
            'up_fullname' => 'required|max:255',
            'title' => 'required',
            'mykad' => 'required|max:255',
            'designation' => 'required|max:255',
            'gender' => 'required',
            'up_profq' => 'nullable|max:255',
            'emailadd' => 'required|max:255|email',
            'mobileno' => 'required|max:255',
            'up_address' => 'required|max:255',
            'up_city' => 'required|max:255',
            'up_state' => 'required',
            'up_postcode' => 'required|max:255',
            'up_country' => 'required',
            'up_sec_name' => 'nullable|max:255',
            'up_sec_email' => 'nullable|email|max:255',
            'up_sec_mobile' => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [

            'up_fullname.required' => 'Full Name is required',
            'up_fullname.max' => 'Full Name must not be greater than :max characters.',

            'title.required' => 'Title is required',

            'mykad.required' => 'MyKad No. is required',
            'mykad.max' => 'MyKad No. must not be greater than :max characters.',
            'designation.required' => 'Designation is required',
            'designation.max' => 'Designation must not be greater than :max characters.',

            'gender.required' => 'Gender is required',

            'up_profq.max' => 'Professional Qualification must not be greater than :max characters.',

            'emailadd.required' => 'Email is required',
            'emailadd.max' => 'Email must not be greater than :max characters.',
            'emailadd.email' => 'The Email field must be a valid email address.',

            'mobileno.required' => 'Contact No. is required',
            'mobileno.max' => 'The Contact No. must not be greater than :max characters.',

            'up_address.required' => 'Correspondence Address is required',
            'up_address.max' => 'Correspondence Address must not be greater than :max characters.',

            'up_city.required' => 'City is required',
            'up_city.max' => 'City must not be greater than :max characters.',

            'up_state.required' => 'State is required',

            'up_postcode.required' => 'Postcode is required',
            'up_postcode.max' => 'Postcode must not be greater than :max characters.',

            'up_country.required' => 'Country is required',

            'up_sec_name.max' => 'Secretary name must not be greater than :max characters.',

            'up_sec_email.email' => 'The Email field must be a valid email address.',
            'up_sec_email.max' => 'Email must not be greater than :max characters.',

            'up_sec_mobile.max' => 'The Contact No. must not be greater than :max characters.',
        ];
    }
}
