<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\MemberComp;
use Illuminate\Support\Facades\Auth;

class MemberProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('activememberprofile-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $mid = $this->route('id');
        $user = Auth::user();

        // Fetch data related to the member
        if ($user->hasRole('BranchAdmin')) {
            $data = MemberComp::select('member_comps.*', 'members.mid', 'members.m_type', 'members.m_approval_at', 'members.m_branch')
            ->join('members', 'members.mid', '=', 'member_comps.d_mid')
            ->where('members.m_branch', $user->regid)
                ->where('member_comps.did', $mid)
                ->where('member_comps.d_status', 1)
                ->first();
        } elseif (chkAdminAccess() == 1) {
            $data = MemberComp::select('member_comps.*', 'members.mid', 'members.m_type', 'members.m_approval_at', 'members.m_branch')
            ->join('members', 'members.mid', '=', 'member_comps.d_mid')
            ->where('member_comps.did', $mid)
                ->where('member_comps.d_status', 1)
                ->first();
        } else {
            return false;
        }

        $data = $data->first();

        // Base validation rules
        $rules = [
            'compname' => 'required|max:255',
            'compadd' => 'required|max:255',
            'compcity' => 'required|max:255',
            'compstate' => 'required',
            'comppc' => 'required|max:255',
            'compcountry' => 'required',
            'd_comp_weburl' => 'required|max:255',
            'd_offno' => 'required|max:255',
        ];

        if ($data && ($data->m_type = 2 || $data->m_type == 3 || $data->m_type == 4 || $data->m_type == 6)) {
            $rules['ordmm'] = 'required';
        }

        // Add additional rules based on the member type
        if ($data && $data->m_type != 5 && $data->m_type != 6) {
            $rules['d_compssmno'] = 'required|max:255';
            $rules['d_datecompform'] = 'required|max:255|date_format:Y-m-d';
            $rules['d_paidcapital'] = 'required';
        }

        $rules['f9'] = 'nullable|file|mimes:pdf,jpeg,png,gif,jpg';
        $rules['f24'] = 'nullable|file|mimes:pdf,jpeg,png,gif,jpg';
        $rules['f49'] = 'nullable|file|mimes:pdf,jpeg,png,gif,jpg';
        $rules['annreturn'] = 'nullable|file|mimes:pdf,jpeg,png,gif,jpg';

        if ($data && $data->m_type != 4 && $data->d_status != 4) {
            $rules['d_devlicense'] = 'required|max:255';
        }

        $rules['devlic'] = 'nullable|file|mimes:pdf,jpeg,png,gif,jpg';

        if($this->has('adminname'))
        {
            $rules['adminname'] = 'required|max:255';
            $rules['admintitle'] = 'required';
            $rules['adminpost'] = 'required|max:255';
            $rules['adminemail'] = 'required|max:255|email';
            $rules['adminmobile'] = 'required|max:255';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Get all files being validated
            $files = ['f9', 'f24', 'f49', 'annreturn'];

            foreach ($files as $fileField) {
                if ($this->hasFile($fileField)) {
                    $file = $this->file($fileField);
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();

                    // Conditional file size validation based on file type
                    if ($extension === 'pdf') {
                        if ($size > ((config('constant.MAX_PDF_FILESIZE_MB') + 1) * 1024 * 1024)) {
                            $validator->errors()->add($fileField, 'The file size should not exceed ' . config('constant.MAX_PDF_FILESIZE_MB') . ' MB for PDFs.');
                        }
                    } else {
                        if ($size > ((config('constant.MAX_IMG_FILESIZE_MB') + 1) * 1024 * 1024)) {
                            $validator->errors()->add($fileField, 'The file size should not exceed ' . config('constant.MAX_IMG_FILESIZE_MB') . ' MB for images.');
                        }
                    }
                }
            }
        });
    }

    public function messages()
    {
        return [
            'ordmm.required' => 'Ordinary Member-Membership No. is required',
            'compname.required' => 'Company Name is required',
            'compname.max' => 'Company Name must not be greater than :max characters.',
            'compadd.required' => 'Address is required',
            'compadd.max' => 'Address must not be greater than :max characters.',
            'compcity.required' => 'City is required',
            'compcity.max' => 'City must not be greater than :max characters.',
            'compstate.required' => 'State is required',
            'comppc.required' => 'Postcode is required',
            'comppc.max' => 'Postcode must not be greater than :max characters.',
            'compcountry.required' => 'Country is required',
            'd_comp_weburl.required' => 'Official Website URL is required',
            'd_comp_weburl.max' => 'Official Website URL must not be greater than :max characters.',
            'd_offno.required' => 'Office No. is required',
            'd_offno.max' => 'Office No. must not be greater than :max characters.',
            'd_compssmno.required' => 'SSM Registration No. is required',
            'd_compssmno.max' => 'SSM Registration No. must not be greater than :max characters.',
            'd_datecompform.required' => 'Date Formation is required',
            'd_datecompform.max' => 'Date Formation must not be greater than :max characters.',
            'd_datecompform.date_format' => 'Date Formation field must match the format YYYY-mm-dd.',
            'd_paidcapital.required' => 'Latest Paid-Up Capital field is required',

            'd_devlicense.required' => 'This field is required',
            'd_devlicense.max' => 'This field must not be greater than :max characters.',

            'f9.mimes' => 'This field must be a file of type: :values.',
            'f24.mimes' => 'This field must be a file of type: :values.',
            'f49.mimes' => 'This field must be a file of type: :values.',
            'annreturn.mimes' => 'This field must be a file of type: :values.',
            'devlic.mimes' => 'This field must be a file of type: :values.',

            'adminname.required' => 'Full Name is required',
            'adminname.max' => 'Full Name must not be greater than :max characters.',
            'admintitle.required' => 'Title is required',
            'adminpost.required' => 'Designation is required',
            'adminpost.max' => 'Designation must not be greater than :max characters.',
            'adminemail.required' => 'Email is required',
            'adminemail.max' => 'Email must not be greater than :max characters.',
            'adminemail.email' => 'The Email field must be a valid email address.',
            'adminmobile.required' => 'Contact No. is required',
            'adminmobile.max' => 'The Contact No.not be greater than :max characters.',
        ];
    }
}
