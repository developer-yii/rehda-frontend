<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Member;
use App\Models\MemberComp;
use App\Models\MemberUserProfile;
use App\Models\PlanTier;
use App\Models\Salutation;
use App\Models\State;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $branches = Branch::orderBy('bname','ASC')->get();
        $states = State::where('state_name','!=','Singapore')->orderBy('state_name', 'ASC')->get();
        $countries = Country::orderBy('country_id', 'ASC')->get();
        $paidups = PlanTier::orderBy('pt_id', 'ASC')->get();
        $titles = Salutation::orderBy('sname', 'ASC')->get();
        $genders = Gender::orderBy('gname','ASC')->get();
        return view('auth.register', compact('branches','states','countries','paidups','titles','genders'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function ordinaryRegister(Request $request)
    {

        Log::info('ordinary-request-data');
        Log::info($request->all());

        $request->validate([
            'ordinaryCompanyPreferBranch' => 'required',
            'ordinaryCompanyName' => 'required|unique:member_comps,d_compname,NULL,id,d_status,!3,d_deleted_at,NULL',
            'ordinaryCompanyAddress' => 'required',
            'ordinaryCompanyAddressCity' => 'required',
            'ordinaryCompanyAddressState' => 'required',
            'ordinaryCompanyAddressPc' => 'required',
            'ordinaryCompanyAddressCountry' => 'required',
            // 'ordinaryOfficialWebsite' => 'required',
            'ordinaryOfficialNumber' => 'required',
            'ordinarySSMRegNumber' => 'required',
            'ordinaryDateOfCompanyFormation' => 'required',
            'ordinaryLatestPaidUpCapital' => 'required',
            'ordinaryCopySSMCert' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'ordinaryCopyForm24' => 'nullable|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'ordinaryCopyForm49' => 'nullable|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'ordinaryCopyOfAnnualReturn' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'ordinaryHouseDevelopingLicense' => 'required',
            'ordinaryCopyOfHousingDeveloperLicense' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'ordinaryNominationForm' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',

            'ordinaryAdminTitle' => 'required',
            'ordinaryNameOfAdmin' => 'required',
            'ordinaryAdminDesignation' => 'required',
            'ordinaryAdminEmail' => 'required|email',
            'ordinaryAdminContactNumber' => 'required',

            'ordinaryOfficial1Title' => 'required',
            'ordinaryOfficial1Nop' => 'required',
            'ordinaryMyKad' => 'required_if:ordinaryMyKadSelect,==,1',
            'ordinaryPassportno' => 'required_if:ordinaryMyKadSelect,==,2',
            'ordinaryOfficial1Designation' => 'required',
            'ordinaryGender' => 'required',
            'ordinaryOfficial1Email' => 'required|email',
            'ordinaryOfficial1Contact' => 'required',
            'ordinaryOfficial1Address' => 'required',
            'ordinaryOfficial1AddressCity' => 'required',
            'ordinaryOfficial1AddressState' => 'required',
            'ordinaryOfficial1AddressPc' => 'required',
            'ordinaryOfficial1AddressCountry' => 'required',
            'ordinaryOfficial1SecretartEmail' => 'nullable|email',

            'ordinaryOfficial2Title' => 'required',
            'ordinaryOfficial2Nop' => 'required',
            'ordinaryMyKad2' => 'required_if:ordinaryMyKad2Select,==,1',
            'ordinary2Passportno' => 'required_if:ordinaryMyKad2Select,==,2',
            'ordinaryOfficial2Designation' => 'required',
            'ordinaryOfficial2Gender' => 'required',
            'ordinaryOfficial2Email' => 'required|email',
            'ordinaryOfficial2Contact' => 'required',
            'ordinaryOfficial2Address' => 'required',
            'ordinaryOfficial2AddressCity' => 'required',
            'ordinaryOfficial2AddressState' => 'required',
            'ordinaryOfficial2AddressPc' => 'required',
            'ordinaryOfficial2AddressCountry' => 'required',
            'ordinaryOfficial2SecretartEmail' => 'nullable|email',
        ],[
            'required' => 'This field is required.',
            'mimes' => 'Invalid file format. Please upload a file in PDF, JPEG, PNG, GIF, or JPG format.',
            'max' => 'File size exceeds the limit. Please upload a file smaller than 10 MB.',
            'email' => 'Please enter a valid email address.',
        ]);

        Log::info('ordinary-request-data-validated-successfuly');

        $dir = 'uploads/members/';

        if ($request->hasFile('ordinaryCopySSMCert')) {
            $file = $request->file('ordinaryCopySSMCert');

            $path1 = $this->uploadPDF($file, $dir, 300);

            if ($path1 === "1003") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopySSMCert' => "Copy of SSM Certification has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryCopyForm24')) {
            $file = $request->file('ordinaryCopyForm24');

            $path2 = $this->uploadPDF($file, $dir, 300);

            if ($path2 === "1003") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopyForm24' => "Copy of Form 24 has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryCopyForm49')) {
            $file = $request->file('ordinaryCopyForm49');

            $path3 = $this->uploadPDF($file, $dir, 300);

            if ($path3 === "1003") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopyForm49' => "Copy of Form 49 has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryCopyOfAnnualReturn')) {
            $file = $request->file('ordinaryCopyOfAnnualReturn');

            $path4 = $this->uploadPDF($file, $dir, 300);

            if ($path4 === "1003") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopyOfAnnualReturn' => "Copy of Annual Return has an error while uploading."
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryCopyOfHousingDeveloperLicense')) {
            $file = $request->file('ordinaryCopyOfHousingDeveloperLicense');

            $path5 = $this->uploadPDF($file, $dir, 100);

            if ($path5 === "1003") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopyOfHousingDeveloperLicense' => "Copy of Housing Developer's Licence No has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryNominationForm')) {
            $file = $request->file('ordinaryNominationForm');

            $nomination_form = $this->uploadPDF($file, $dir, 100);

            if ($nomination_form === "1003") {
                return response()->json([
                    'errors' => [
                        'ordinaryNominationForm' => "Copy of Nomination Form has an error while uploading.",
                    ],
                ], 422);
            }
        }

        $ord = 1;
        $now = date("Y-m-d H:i:s");

        try {

            $userprofile1 = '';
            $userprofile2 = '';
            $userprofileAdmin = '';

            $member = Member::create([
                'm_type' => $ord,
                'm_created_at' => $now
            ]);
            logSystem(auth()->id(), 'Create', $member->toArray(), 'Member');

            $mid = $member->mid;

            $memberComp = MemberComp::create([
                'd_mid' => $mid,
                'd_compname' => $request->ordinaryCompanyName,
                'd_compadd' => $request->ordinaryCompanyAddress,
                'd_compadd_3' => $request->ordinaryCompanyAddress3,
                'd_compaddcity' => $request->ordinaryCompanyAddressCity,
                'd_compaddstate' => $request->ordinaryCompanyAddressState ?? 0,
                'd_compaddpcode' => $request->ordinaryCompanyAddressPc,
                'd_compaddcountry' => $request->ordinaryCompanyAddressCountry,
                'd_comp_weburl' => $request->ordinaryOfficialWebsite ?? NULL,
                'd_offno' => $request->ordinaryOfficialNumber,
                'd_faxno' => $request->ordinaryFaxNumber,
                'd_compssmno' => $request->ordinarySSMRegNumber,
                'd_datecompform' => $request->ordinaryDateOfCompanyFormation,
                'd_paidcapital' => $request->ordinaryLatestPaidUpCapital,
                'd_f9ssm' => $path1,
                'd_f24' => $path2 ?? NULL,
                'd_f49' => $path3 ?? NULL,
                'd_anualretuncopy' => $path4,
                'd_devlicense' => $request->ordinaryHouseDevelopingLicense,
                'd_devlicensecopy' => $path5,
                'd_created_at' => $now,
                'd_refer_branch' => $request->ordinaryCompanyPreferBranch,
                'nomination_form' => $nomination_form,
            ]);
            logSystem(auth()->id(), 'Create', $memberComp->toArray(), 'MemberComp');

            $up_usertype = 1;
            if(!empty($request->ordinaryOfficial1Nop)){

                $userprofile1 = MemberUserProfile::create([
                    'up_usertype' => $up_usertype,
                    'up_fullname' => $request->ordinaryOfficial1Nop,
                    'up_title' => $request->ordinaryOfficial1Title,
                    'up_mykad' => $request->ordinaryMyKad ?? NULL,
                    'passportno' => $request->ordinaryPassportno ?? NULL,
                    'up_designation' => $request->ordinaryOfficial1Designation,
                    'up_gender' => $request->ordinaryGender,
                    'up_contactno' => $request->ordinaryOfficial1Contact,
                    'up_emailadd' => $request->ordinaryOfficial1Email,
                    'up_profq' => $request->ordinaryOfficial1ProQualification,
                    'up_address' => $request->ordinaryOfficial1Address,
                    'up_city' => $request->ordinaryOfficial1AddressCity,
                    'up_state' => $request->ordinaryOfficial1AddressState,
                    'up_postcode' => $request->ordinaryOfficial1AddressPc,
                    'up_country' => $request->ordinaryOfficial1AddressCountry,
                    'up_sec_name' => $request->ordinaryOfficial1SecretartName,
                    'up_sec_title' => $request->ordinaryOfficial1SecretartTitle,
                    'up_sec_email' => $request->ordinaryOfficial1SecretartEmail,
                    'up_sec_mobile' => $request->ordinaryOfficial1SecretartContact,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofile1->toArray(), 'MemberProfile1');

            }

            if(!empty($request->ordinaryOfficial2Nop)){

                $userprofile2 = MemberUserProfile::create([
                    'up_usertype' => $up_usertype,
                    'up_fullname' => $request->ordinaryOfficial2Nop,
                    'up_title' => $request->ordinaryOfficial2Title,
                    'up_mykad' => $request->ordinaryMyKad2 ?? NULL,
                    'passportno' => $request->ordinary2Passportno ?? NULL,
                    'up_designation' => $request->ordinaryOfficial2Designation,
                    'up_gender' => $request->ordinaryOfficial2Gender,
                    'up_contactno' => $request->ordinaryOfficial2Contact,
                    'up_emailadd' => $request->ordinaryOfficial2Email,
                    'up_profq' => $request->ordinaryOfficial2ProQualification,
                    'up_address' => $request->ordinaryOfficial2Address,
                    'up_city' => $request->ordinaryOfficial2AddressCity,
                    'up_state' => $request->ordinaryOfficial2AddressState,
                    'up_postcode' => $request->ordinaryOfficial2AddressPc,
                    'up_country' => $request->ordinaryOfficial2AddressCountry,
                    'up_sec_name' => $request->ordinaryOfficial2SecretartName,
                    'up_sec_title' => $request->ordinaryOfficial2SecretartTitle,
                    'up_sec_email' => $request->ordinaryOfficial2SecretartEmail,
                    'up_sec_mobile' => $request->ordinaryOfficial2SecretartContact,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofile2->toArray(), 'MemberProfile2');

            }

            if(!empty($request->ordinaryNameOfAdmin)){

                $admin = 2;
                $userprofileAdmin = MemberUserProfile::create([
                    'up_usertype' => $admin,
                    'up_fullname' => $request->ordinaryNameOfAdmin,
                    'up_title' => $request->ordinaryAdminTitle,
                    'up_designation' => $request->ordinaryAdminDesignation,
                    'up_contactno' => $request->ordinaryAdminContactNumber,
                    'up_emailadd' => $request->ordinaryAdminEmail,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofileAdmin->toArray(), 'MemberProfileAdmin');

            }

            if($userprofile1 || $userprofile2 || $userprofileAdmin) {
                return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Thank you.']);
            } else {
                return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);
            }
        } catch (\Exception $e) {

            // Cleanup Member record
            if (!$memberComp) {
                $member->delete();
            }

            // Cleanup MemberComp and Member
            if ($member && $memberComp && !$userprofile1) {
                $memberComp->delete();
                $member->delete();
            }

            // Cleanup MemberUser-Profile-1 and MemberComp and Member
            if ($member && $memberComp && $userprofile1 && !$userprofile2) {
                $userprofile1->delete();
                $memberComp->delete();
                $member->delete();
            }

            // Cleanup MemberUser-Profile-2 and MemberUser-Profile-1 and MemberComp and Member
            if($member && $memberComp && $userprofile1 && $userprofile2 && !$userprofileAdmin) {
                $userprofile2->delete();
                $userprofile1->delete();
                $memberComp->delete();
                $member->delete();
            }

            // Log the error details
            \Log::error('Error while ordinary registration: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);

        }
    }

    public function subsidiaryRegister(Request $request)
    {
        Log::info('subsidiary-request-data');
        Log::info($request->all());

        $request->validate([
            'subsidiaryCompanyPreferBranch' => 'required',
            'subsidiaryOrdinaryMembershipNumber' => 'required',
            'subsidiaryCompanyName' => 'required|unique:member_comps,d_compname,NULL,id,d_status,!3,d_deleted_at,NULL',
            'subsidiaryCompanyAddress' => 'required',
            'subsidiaryCompanyAddressCity' => 'required',
            'subsidiaryCompanyAddressState' => 'required',
            'subsidiaryCompanyAddressPc' => 'required',
            'subsidiaryCompanyAddressCountry' => 'required',
            // 'subsidiaryOfficialWebsite' => 'required',
            'subsidiaryOfficialNumber' => 'required',
            'subsidiarySSMRegNumber' => 'required',
            'subsidiaryDateOfCompanyFormation' => 'required',
            'subsidiaryLatestPaidUpCapital' => 'required',
            'subsidiaryCopySSMCert' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'subsidiaryCopyForm24' => 'nullable|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'subsidiaryCopyForm49' => 'nullable|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'subsidiaryCopyOfAnnualReturn' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'subsidiaryHouseDevelopingLicense' => 'required',
            'subsidiaryCopyOfHousingDeveloperLicense' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',

            'subsidiaryAdminTitle' => 'required',
            'subsidiaryNameOfAdmin' => 'required',
            'subsidiaryAdminDesignation' => 'required',
            'subsidiaryAdminEmail' => 'required|email',
            'subsidiaryAdminContactNumber' => 'required',

            'subsidiaryOfficial1Title' => 'required',
            'subsidiaryOfficial1Nop' => 'required',
            'subsidiaryMyKad' => 'required_if:subsidiaryMyKadSelect,==,1',
            'subsidiaryPassportno' => 'required_if:subsidiaryMyKadSelect,==,2',
            'subsidiaryOfficial1Designation' => 'required',
            'subsidiaryOfficial1Gender' => 'required',
            'subsidiaryOfficial1Email' => 'required|email',
            'subsidiaryOfficial1Contact' => 'required',
            'subsidiaryOfficial1Address' => 'required',
            'subsidiaryOfficial1AddressCity' => 'required',
            'subsidiaryOfficial1AddressState' => 'required',
            'subsidiaryOfficial1AddressPc' => 'required',
            'subsidiaryOfficial1AddressCountry' => 'required',
            'subsidiaryOfficial1SecretartEmail' => 'nullable|email',
        ],[
            'required' => 'This field is required.',
            'mimes' => 'Invalid file format. Please upload a file in PDF, JPEG, PNG, GIF, or JPG format.',
            'max' => 'File size exceeds the limit. Please upload a file smaller than 10 MB.',
            'email' => 'Please enter a valid email address.',
        ]);

        Log::info('subsidiary-request-data-validated-successfuly');

        $parentid = chkMembershipNo($request->subsidiaryOrdinaryMembershipNumber);
        if($parentid == null){
            return response()->json([
                'errors' => [
                    'subsidiaryOrdinaryMembershipNumber' => "Invalid Ordinary Membership No.", // Return error message if upload fails
                ],
            ], 422);
        }

        $dir = 'uploads/members/';

        if ($request->hasFile('subsidiaryCopySSMCert')) {
            $file = $request->file('subsidiaryCopySSMCert');

            $path1 = $this->uploadPDF($file, $dir, 300);

            if ($path1 === "1003") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopySSMCert' => "Copy of SSM Certification has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('subsidiaryCopyForm24')) {
            $file = $request->file('subsidiaryCopyForm24');

            $path2 = $this->uploadPDF($file, $dir, 300);

            if ($path2 === "1003") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopyForm24' => "Copy of Form 24 has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('subsidiaryCopyForm49')) {
            $file = $request->file('subsidiaryCopyForm49');

            $path3 = $this->uploadPDF($file, $dir, 300);

            if ($path3 === "1003") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopyForm49' => "Copy of Form 49 has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('subsidiaryCopyOfAnnualReturn')) {
            $file = $request->file('subsidiaryCopyOfAnnualReturn');

            $path4 = $this->uploadPDF($file, $dir, 300);

            if ($path4 === "1003") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopyOfAnnualReturn' => "Copy of Annual Return has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('subsidiaryCopyOfHousingDeveloperLicense')) {
            $file = $request->file('subsidiaryCopyOfHousingDeveloperLicense');

            $path5 = $this->uploadPDF($file, $dir, 100);

            if ($path5 === "1003") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopyOfHousingDeveloperLicense' => "Copy of Housing Developer's Licence No has an error while uploading.",
                    ],
                ], 422);
            }
        }

        $ord = 2;
        $now = date("Y-m-d H:i:s");

        try {

            $userprofile1 = '';
            $userprofileAdmin = '';

            $member = Member::create([
                'm_type' => $ord,
                'm_created_at' => $now
            ]);
            logSystem(auth()->id(), 'Create', $member->toArray(), 'Member');

            $mid = $member->mid;

            $memberComp = MemberComp::create([
                'd_parentcomp' => $parentid,
                'd_mid' => $mid,
                'd_compname' => $request->subsidiaryCompanyName,
                'd_compadd' => $request->subsidiaryCompanyAddress,
                'd_compadd_3' => $request->subsidiaryCompanyAddress3,
                'd_compaddcity' => $request->subsidiaryCompanyAddressCity,
                'd_compaddstate' => $request->subsidiaryCompanyAddressState ?? 0,
                'd_compaddpcode' => $request->subsidiaryCompanyAddressPc,
                'd_compaddcountry' => $request->subsidiaryCompanyAddressCountry,
                'd_comp_weburl' => $request->subsidiaryOfficialWebsite ?? NULL,
                'd_offno' => $request->subsidiaryOfficialNumber,
                'd_faxno' => $request->subsidiaryFaxNumber,
                'd_compssmno' => $request->subsidiarySSMRegNumber,
                'd_datecompform' => $request->subsidiaryDateOfCompanyFormation,
                'd_paidcapital' => $request->subsidiaryLatestPaidUpCapital,
                'd_f9ssm' => $path1,
                'd_f24' => $path2 ?? NULL,
                'd_f49' => $path3 ?? NULL,
                'd_anualretuncopy' => $path4,
                'd_devlicense' => $request->subsidiaryHouseDevelopingLicense,
                'd_devlicensecopy' => $path5,
                'd_created_at' => $now,
                'd_refer_branch' => $request->subsidiaryCompanyPreferBranch
            ]);
            logSystem(auth()->id(), 'Create', $memberComp->toArray(), 'MemberComp');

            $up_usertype = 1;
            if(!empty($request->subsidiaryOfficial1Nop)){

                $userprofile1 = MemberUserProfile::create([
                    'up_usertype' => $up_usertype,
                    'up_fullname' => $request->subsidiaryOfficial1Nop,
                    'up_title' => $request->subsidiaryOfficial1Title,
                    'up_mykad' => $request->subsidiaryMyKad ?? NULL,
                    'passportno' => $request->subsidiaryPassportno ?? NULL,
                    'up_designation' => $request->subsidiaryOfficial1Designation,
                    'up_gender' => $request->subsidiaryOfficial1Gender,
                    'up_contactno' => $request->subsidiaryOfficial1Contact,
                    'up_emailadd' => $request->subsidiaryOfficial1Email,
                    'up_profq' => $request->subsidiaryOfficial1ProQualification,
                    'up_address' => $request->subsidiaryOfficial1Address,
                    'up_city' => $request->subsidiaryOfficial1AddressCity,
                    'up_state' => $request->subsidiaryOfficial1AddressState,
                    'up_postcode' => $request->subsidiaryOfficial1AddressPc,
                    'up_country' => $request->subsidiaryOfficial1AddressCountry,
                    'up_sec_name' => $request->subsidiaryOfficial1SecretartName,
                    'up_sec_title' => $request->subsidiaryOfficial1SecretartTitle,
                    'up_sec_email' => $request->subsidiaryOfficial1SecretartEmail,
                    'up_sec_mobile' => $request->subsidiaryOfficial1SecretartContact,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofile1->toArray(), 'MemberProfile1');

            }

            if(!empty($request->subsidiaryNameOfAdmin)){

                $admin = 2;
                $userprofileAdmin = MemberUserProfile::create([
                    'up_usertype' => $admin,
                    'up_fullname' => $request->subsidiaryNameOfAdmin,
                    'up_title' => $request->subsidiaryAdminTitle,
                    'up_designation' => $request->subsidiaryAdminDesignation,
                    'up_contactno' => $request->subsidiaryAdminContactNumber,
                    'up_emailadd' => $request->subsidiaryAdminEmail,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofileAdmin->toArray(), 'MemberProfileAdmin');

            }

            if($userprofile1 || $userprofileAdmin){
                return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Thank you.']);
            } else {
                return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);
            }

        } catch (\Exception $e) {

            // Cleanup Member record
            if (!$memberComp) {
                $member->delete();
            }

            // Cleanup MemberComp and Member
            if ($member && $memberComp && !$userprofile1) {
                $memberComp->delete();
                $member->delete();
            }

            // Cleanup MemberUser-Profile-2 and MemberUser-Profile-1 and MemberComp and Member
            if($member && $memberComp && $userprofile1 && !$userprofileAdmin) {
                $userprofile1->delete();
                $memberComp->delete();
                $member->delete();
            }

            // Log the error details
            \Log::error('Error while subsidiary registration: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);

        }
    }

    public function affiliateRegister(Request $request)
    {
        Log::info('affiliate-request-data');
        Log::info($request->all());

        $request->validate([
            'affiliateCompanyPreferBranch' => 'required',
            'affiliateOrdinaryMembershipNumber' => 'required',
            'affiliateCompanyName' => 'required|unique:member_comps,d_compname,NULL,id,d_status,!3,d_deleted_at,NULL',
            'affiliateCompanyAddress' => 'required',
            'affiliateCompanyAddressCity' => 'required',
            'affiliateCompanyAddressState' => 'required',
            'affiliateCompanyAddressPc' => 'required',
            'affiliateCompanyAddressCountry' => 'required',
            // 'affiliateOfficialWebsite' => 'required',
            'affiliateOfficialNumber' => 'required',
            'affiliateSSMRegNumber' => 'required',
            'affiliateDateOfCompanyFormation' => 'required',
            'affiliateLatestPaidUpCapital' => 'required',
            'affiliateCopySSMCert' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'affiliateCopyForm24' => 'nullable|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'affiliateCopyForm49' => 'nullable|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'affiliateCopyOfAnnualReturn' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'affiliateHouseDevelopingLicense' => 'required',
            'affiliateCopyOfHousingDeveloperLicense' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',

            'affiliateAdminTitle' => 'required',
            'affiliateNameOfAdmin' => 'required',
            'affiliateAdminDesignation' => 'required',
            'affiliateAdminEmail' => 'required|email',
            'affiliateAdminContactNumber' => 'required',

            'affiliateOfficial1Title' => 'required',
            'affiliateOfficial1Nop' => 'required',
            'affiliateMyKad' => 'required_if:affiliateMyKadSelect,==,1',
            'affiliatePassportno' => 'required_if:affiliateMyKadSelect,==,2',
            'affiliateOfficial1Designation' => 'required',
            'affiliateOfficial1Gender' => 'required',
            'affiliateOfficial1Email' => 'required|email',
            'affiliateOfficial1Contact' => 'required',
            'affiliateOfficial1Address' => 'required',
            'affiliateOfficial1AddressCity' => 'required',
            'affiliateOfficial1AddressState' => 'required',
            'affiliateOfficial1AddressPc' => 'required',
            'affiliateOfficial1AddressCountry' => 'required',
            'affiliateOfficial1SecretartEmail' => 'nullable|email',

            'affiliateOfficial2Title' => 'required',
            'affiliateOfficial2Nop' => 'required',
            'affiliateMyKad2' => 'required_if:affiliateMyKad2Select,==,1',
            'affiliate2Passportno' => 'required_if:affiliateMyKad2Select,==,2',
            'affiliateOfficial2Designation' => 'required',
            'affiliateOfficial2Gender' => 'required',
            'affiliateOfficial2Email' => 'required|email',
            'affiliateOfficial2Contact' => 'required',
            'affiliateOfficial2Address' => 'required',
            'affiliateOfficial2AddressCity' => 'required',
            'affiliateOfficial2AddressState' => 'required',
            'affiliateOfficial2AddressPc' => 'required',
            'affiliateOfficial2AddressCountry' => 'required',
            'affiliateOfficial2SecretartEmail' => 'nullable|email',
        ],[
            'required' => 'This field is required.',
            'mimes' => 'Invalid file format. Please upload a file in PDF, JPEG, PNG, GIF, or JPG format.',
            'max' => 'File size exceeds the limit. Please upload a file smaller than 10 MB.',
            'email' => 'Please enter a valid email address.',
        ]);

        Log::info('affiliate-request-data-validated-successfuly');

        $parentid = chkMembershipNo($request->affiliateOrdinaryMembershipNumber);
        if($parentid == null){
            return response()->json([
                'errors' => [
                    'affiliateOrdinaryMembershipNumber' => "Invalid Ordinary Membership No.", // Return error message if upload fails
                ],
            ], 422);
        }

        $dir = 'uploads/members/';

        if ($request->hasFile('affiliateCopySSMCert')) {
            $file = $request->file('affiliateCopySSMCert');

            $path1 = $this->uploadPDF($file, $dir, 300);

            if ($path1 === "1003") {
                return response()->json([
                    'errors' => [
                        'affiliateCopySSMCert' =>  "Copy of SSM Certification has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('affiliateCopyForm24')) {
            $file = $request->file('affiliateCopyForm24');

            $path2 = $this->uploadPDF($file, $dir, 300);

            if ($path2 === "1003") {
                return response()->json([
                    'errors' => [
                        'affiliateCopyForm24' => "Copy of Form 24 has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('affiliateCopyForm49')) {
            $file = $request->file('affiliateCopyForm49');

            $path3 = $this->uploadPDF($file, $dir, 300);

            if ($path3 === "1003") {
                return response()->json([
                    'errors' => [
                        'affiliateCopyForm49' => "Copy of Form 49 has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('affiliateCopyOfAnnualReturn')) {
            $file = $request->file('affiliateCopyOfAnnualReturn');

            $path4 = $this->uploadPDF($file, $dir, 300);

            if ($path4 === "1003") {
                return response()->json([
                    'errors' => [
                        'affiliateCopyOfAnnualReturn' => "Copy of Annual Return has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('affiliateCopyOfHousingDeveloperLicense')) {
            $file = $request->file('affiliateCopyOfHousingDeveloperLicense');

            $path5 = $this->uploadPDF($file, $dir, 100);

            if ($path5 === "1003") {
                return response()->json([
                    'errors' => [
                        'affiliateCopyOfHousingDeveloperLicense' => "Copy of Housing Developer's Licence No has an error while uploading.", // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        $ord = 3;
        $now = date("Y-m-d H:i:s");

        try {

            $userprofile1 = '';
            $userprofile2 = '';
            $userprofileAdmin = '';

            $member = Member::create([
                'm_type' => $ord,
                'm_created_at' => $now
            ]);
            logSystem(auth()->id(), 'Create', $member->toArray(), 'Member');

            $mid = $member->mid;

            $memberComp = MemberComp::create([
                'd_parentcomp' => $parentid,
                'd_mid' => $mid,
                'd_compname' => $request->affiliateCompanyName,
                'd_compadd' => $request->affiliateCompanyAddress,
                'd_compadd_3' => $request->affiliateCompanyAddress3,
                'd_compaddcity' => $request->affiliateCompanyAddressCity,
                'd_compaddstate' => $request->affiliateCompanyAddressState ?? 0,
                'd_compaddpcode' => $request->affiliateCompanyAddressPc,
                'd_compaddcountry' => $request->affiliateCompanyAddressCountry,
                'd_comp_weburl' => $request->affiliateOfficialWebsite ?? NULL,
                'd_offno' => $request->affiliateOfficialNumber,
                'd_faxno' => $request->affiliateFaxNumber,
                'd_compssmno' => $request->affiliateSSMRegNumber,
                'd_datecompform' => $request->affiliateDateOfCompanyFormation,
                'd_paidcapital' => $request->affiliateLatestPaidUpCapital,
                'd_f9ssm' => $path1,
                'd_f24' => $path2 ?? NULL,
                'd_f49' => $path3 ?? NULL,
                'd_anualretuncopy' => $path4,
                'd_devlicense' => $request->affiliateHouseDevelopingLicense,
                'd_devlicensecopy' => $path5,
                'd_created_at' => $now,
                'd_refer_branch' => $request->affiliateCompanyPreferBranch
            ]);
            logSystem(auth()->id(), 'Create', $memberComp->toArray(), 'MemberComp');

            $up_usertype = 1;
            if(!empty($request->affiliateOfficial1Nop)){

                $userprofile1 = MemberUserProfile::create([
                    'up_usertype' => $up_usertype,
                    'up_fullname' => $request->affiliateOfficial1Nop,
                    'up_title' => $request->affiliateOfficial1Title,
                    'up_mykad' => $request->affiliateMyKad ?? NULL,
                    'passportno' => $request->affiliatePassportno ?? NULL,
                    'up_designation' => $request->affiliateOfficial1Designation,
                    'up_gender' => $request->affiliateOfficial1Gender,
                    'up_contactno' => $request->affiliateOfficial1Contact,
                    'up_emailadd' => $request->affiliateOfficial1Email,
                    'up_profq' => $request->affiliateOfficial1ProQualification,
                    'up_address' => $request->affiliateOfficial1Address,
                    'up_city' => $request->affiliateOfficial1AddressCity,
                    'up_state' => $request->affiliateOfficial1AddressState,
                    'up_postcode' => $request->affiliateOfficial1AddressPc,
                    'up_country' => $request->affiliateOfficial1AddressCountry,
                    'up_sec_name' => $request->affiliateOfficial1SecretartName,
                    'up_sec_title' => $request->affiliateOfficial1SecretartTitle,
                    'up_sec_email' => $request->affiliateOfficial1SecretartEmail,
                    'up_sec_mobile' => $request->affiliateOfficial1SecretartContact,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofile1->toArray(), 'MemberProfile1');

            }

            if(!empty($request->affiliateOfficial2Nop)){

                $userprofile2 = MemberUserProfile::create([
                    'up_usertype' => $up_usertype,
                    'up_fullname' => $request->affiliateOfficial2Nop,
                    'up_title' => $request->affiliateOfficial2Title,
                    'up_mykad' => $request->affiliateMyKad2 ?? NULL,
                    'passportno' => $request->affiliate2Passportno ?? NULL,
                    'up_designation' => $request->affiliateOfficial2Designation,
                    'up_gender' => $request->affiliateOfficial2Gender,
                    'up_contactno' => $request->affiliateOfficial2Contact,
                    'up_emailadd' => $request->affiliateOfficial2Email,
                    'up_profq' => $request->affiliateOfficial2ProQualification,
                    'up_address' => $request->affiliateOfficial2Address,
                    'up_city' => $request->affiliateOfficial2AddressCity,
                    'up_state' => $request->affiliateOfficial2AddressState,
                    'up_postcode' => $request->affiliateOfficial2AddressPc,
                    'up_country' => $request->affiliateOfficial2AddressCountry,
                    'up_sec_name' => $request->affiliateOfficial2SecretartName,
                    'up_sec_title' => $request->affiliateOfficial2SecretartTitle,
                    'up_sec_email' => $request->affiliateOfficial2SecretartEmail,
                    'up_sec_mobile' => $request->affiliateOfficial2SecretartContact,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofile2->toArray(), 'MemberProfile2');

            }

            if(!empty($request->affiliateNameOfAdmin)){

                $admin = 2;
                $userprofileAdmin = MemberUserProfile::create([
                    'up_usertype' => $admin,
                    'up_fullname' => $request->affiliateNameOfAdmin,
                    'up_title' => $request->affiliateAdminTitle,
                    'up_designation' => $request->affiliateAdminDesignation,
                    'up_contactno' => $request->affiliateAdminContactNumber,
                    'up_emailadd' => $request->affiliateAdminEmail,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofileAdmin->toArray(), 'MemberProfileAdmin');

            }

            if($userprofile1 || $userprofile2 ||  $userprofileAdmin){
                return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Thank you.']);
            } else {
                return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);
            }

        } catch (\Exception $e) {

            // Cleanup Member record
            if (!$memberComp) {
                $member->delete();
            }

            // Cleanup MemberComp and Member
            if ($member && $memberComp && !$userprofile1) {
                $memberComp->delete();
                $member->delete();
            }

            // Cleanup MemberUser-Profile-1 and MemberComp and Member
            if ($member && $memberComp && $userprofile1 && !$userprofile2) {
                $userprofile1->delete();
                $memberComp->delete();
                $member->delete();
            }

            // Cleanup MemberUser-Profile-2 and MemberUser-Profile-1 and MemberComp and Member
            if($member && $memberComp && $userprofile1 && $userprofile2 && !$userprofileAdmin) {
                $userprofile2->delete();
                $userprofile1->delete();
                $memberComp->delete();
                $member->delete();
            }

            // Log the error details
            \Log::error('Error while affiliate registration: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);

        }
    }

    public function associateRegister(Request $request)
    {
        Log::info('associate-request-data');
        Log::info($request->all());

        $request->validate([
            'associateCompanyPreferBranch' => 'required',
            'associateAccType' => 'required',
            'associateCompanyName' => 'required|unique:member_comps,d_compname,NULL,id,d_status,!3,d_deleted_at,NULL',
            'associateCompanyAddress' => 'required',
            'associateCompanyAddressCity' => 'required',
            'associateCompanyAddressState' => 'required',
            'associateCompanyAddressPc' => 'required',
            'associateCompanyAddressCountry' => 'required',
            // 'associateOfficialWebsite' => 'required',
            'associateOfficialNumber' => 'required',

            'associateSSMRegNumber' => 'required_if:associateAccType,==,1',
            'associateDateOfCompanyFormation' => 'required_if:associateAccType,==,1',
            'associateLatestPaidUpCapital' => 'required_if:associateAccType,==,1',
            'associateCopySSMCert' => 'required_if:associateAccType,==,1|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'associateCopyForm24' => 'required_if:associateAccType,==,1|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'associateCopyForm49' => 'required_if:associateAccType,==,1|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'associateCopyOfAnnualReturn' => 'required_if:associateAccType,==,1|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',

            'associateAdminTitle' => 'required_if:associateAccType,==,1',
            'associateNameOfAdmin' => 'required_if:associateAccType,==,1',
            'associateAdminDesignation' => 'required_if:associateAccType,==,1',
            'associateAdminEmail' => 'required_if:associateAccType,==,1|email',
            'associateAdminContactNumber' => 'required_if:associateAccType,==,1',

            'associateOfficial1Title' => 'required',
            'associateOfficial1Nop' => 'required',
            'associateOfficial1MyKad' => 'required_if:associateOfficial1MyKadSelect,==,1',
            'associateOfficial1Passportno' => 'required_if:associateOfficial1MyKadSelect,==,2',
            'associateOfficial1Designation' => 'required',
            'associateOfficial1Gender' => 'required',
            'associateOfficial1Email' => 'required|email',
            'associateOfficial1Contact' => 'required',
            'associateOfficial1Address' => 'required',
            'associateOfficial1AddressCity' => 'required',
            'associateOfficial1AddressState' => 'required',
            'associateOfficial1AddressPc' => 'required',
            'associateOfficial1Country' => 'required',
            'associateOfficial1SecretartEmail' => 'nullable|email',

            'associateOfficial2Title' => 'required_if:associateAccType,==,1',
            'associateOfficial2Nop' => 'required_if:associateAccType,==,1',
            'associateOfficial2MyKad' => [
                'nullable', // Optional by default
                function ($attribute, $value, $fail) {
                    if (request('associateAccType') == 1 && request('associateOfficial2MyKad2Select') == 1 && empty($value)) {
                        $fail('The mykad no. field is required.');
                    }
                }
            ],
            'associateOfficial2Passportno' => [
                'nullable', // Optional by default
                function ($attribute, $value, $fail) {
                    if (request('associateAccType') == 1 && request('associateOfficial2MyKad2Select') == 2 && empty($value)) {
                        $fail('The passport no. field is required.');
                    }
                }
            ],
            'associateOfficial2Designation' => 'required_if:associateAccType,==,1',
            'associateOfficial2Gender' => 'required_if:associateAccType,==,1',
            'associateOfficial2Email' => 'required_if:associateAccType,==,1|email',
            'associateOfficial2Contact' => 'required_if:associateAccType,==,1',
            'associateOfficial2Address' => 'required_if:associateAccType,==,1',
            'associateOfficial2AddressCity' => 'required_if:associateAccType,==,1',
            'associateOfficial2AddressState' => 'required_if:associateAccType,==,1',
            'associateOfficial2AddressPc' => 'required_if:associateAccType,==,1',
            'associateOfficial2AddressCountry' => 'required_if:associateAccType,==,1',
            'associateOfficial2SecretartEmail' => 'nullable|email',
        ],[
            'required' => 'This field is required.',
            'required_if' => 'This field is required.',
            'mimes' => 'Invalid file format. Please upload a file in PDF, JPEG, PNG, GIF, or JPG format.',
            'max' => 'File size exceeds the limit. Please upload a file smaller than 10 MB.',
            'email' => 'Please enter a valid email address.',
        ]);

        Log::info('associate-request-data-validated-successfuly');

        $dir = 'uploads/members/';

        if ($request->hasFile('associateCopySSMCert')) {
            $file = $request->file('associateCopySSMCert');

            $path1 = $this->uploadPDF($file, $dir, 300);

            if ($path1 === "1003") {
                return response()->json([
                    'errors' => [
                        'associateCopySSMCert' => "Copy of SSM Certification has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('associateCopyForm24')) {
            $file = $request->file('associateCopyForm24');

            $path2 = $this->uploadPDF($file, $dir, 300);

            if ($path2 === "1003") {
                return response()->json([
                    'errors' => [
                        'associateCopyForm24' => "Copy of Form 24 has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('associateCopyForm49')) {
            $file = $request->file('associateCopyForm49');

            $path3 = $this->uploadPDF($file, $dir, 300);

            if ($path3 === "1003") {
                return response()->json([
                    'errors' => [
                        'associateCopyForm49' => "Copy of Form 49 has an error while uploading.", // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('associateCopyOfAnnualReturn')) {
            $file = $request->file('associateCopyOfAnnualReturn');

            $path4 = $this->uploadPDF($file, $dir, 300);

            if ($path4 === "1003") {
                return response()->json([
                    'errors' => [
                        'associateCopyOfAnnualReturn' => "Copy of Annual Return has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if($request->associateAccType == 1) {
            $ord = 4;
        } else {
            $ord = 5;
        }
        $now = date("Y-m-d H:i:s");

        try {

            $userprofile1 = '';
            $userprofile2 = '';
            $userprofileAdmin = '';

            $member = Member::create([
                'm_type' => $ord,
                'm_created_at' => $now
            ]);
            logSystem(auth()->id(), 'Create', $member->toArray(), 'Member');

            $mid = $member->mid;

            if($request->associateAccType == 1) {
                $memberComp = MemberComp::create([
                    'd_mid' => $mid,
                    'd_compname' => $request->associateCompanyName,
                    'd_compadd' => $request->associateCompanyAddress,
                    'd_compadd_3' => $request->associateCompanyAddress3,
                    'd_compaddcity' => $request->associateCompanyAddressCity,
                    'd_compaddstate' => $request->associateCompanyAddressState ?? 0,
                    'd_compaddpcode' => $request->associateCompanyAddressPc,
                    'd_compaddcountry' => $request->associateCompanyAddressCountry,
                    'd_comp_weburl' => $request->associateOfficialWebsite ?? NULL,
                    'd_offno' => $request->associateOfficialNumber,
                    'd_faxno' => $request->associateFaxNumber,
                    'd_compssmno' => $request->associateSSMRegNumber,
                    'd_datecompform' => $request->associateDateOfCompanyFormation,
                    'd_paidcapital' => $request->associateLatestPaidUpCapital,
                    'd_f9ssm' => $path1,
                    'd_f24' => $path2 ?? NULL,
                    'd_f49' => $path3 ?? NULL,
                    'd_anualretuncopy' => $path4,
                    'd_created_at' => $now,
                    'd_refer_branch' => $request->associateCompanyPreferBranch
                ]);
            } else {
                $memberComp = MemberComp::create([
                    'd_mid' => $mid,
                    'd_compname' => $request->associateCompanyName,
                    'd_compadd' => $request->associateCompanyAddress,
                    'd_compaddcity' => $request->associateCompanyAddressCity,
                    'd_compaddstate' => $request->associateCompanyAddressState ?? 0,
                    'd_compaddpcode' => $request->associateCompanyAddressPc,
                    'd_compaddcountry' => $request->associateCompanyAddressCountry,
                    'd_comp_weburl' => $request->associateOfficialWebsite ?? NULL,
                    'd_offno' => $request->associateOfficialNumber,
                    'd_faxno' => $request->associateFaxNumber,
                    'd_compssmno' => ' ',
                    // 'd_compssmno' => $request->associateSSMRegNumber,
                    // 'd_datecompform' => $request->associateDateOfCompanyFormation,
                    // 'd_paidcapital' => $request->associateLatestPaidUpCapital,
                    'd_f9ssm' => $path1 ?? NULL,
                    // 'd_f24' => $path2 ?? NULL,
                    // 'd_f49' => $path3 ?? NULL,
                    // 'd_anualretuncopy' => $path4,
                    'd_created_at' => $now,
                    'd_refer_branch' => $request->associateCompanyPreferBranch
                ]);
            }
            logSystem(auth()->id(), 'Create', $memberComp->toArray(), 'MemberComp');

            $up_usertype = 1;
            if(!empty($request->associateOfficial1Nop)){

                $userprofile1 = MemberUserProfile::create([
                    'up_usertype' => $up_usertype,
                    'up_fullname' => $request->associateOfficial1Nop,
                    'up_title' => $request->associateOfficial1Title,
                    'up_mykad' => $request->associateOfficial1MyKad ?? NULL,
                    'passportno' => $request->associateOfficial1Passportno ?? NULL,
                    'up_designation' => $request->associateOfficial1Designation,
                    'up_gender' => $request->associateOfficial1Gender,
                    'up_contactno' => $request->associateOfficial1Contact,
                    'up_emailadd' => $request->associateOfficial1Email,
                    'up_profq' => $request->associateOfficial1ProQualification,
                    'up_address' => $request->associateOfficial1Address,
                    'up_city' => $request->associateOfficial1AddressCity,
                    'up_state' => $request->associateOfficial1AddressState,
                    'up_postcode' => $request->associateOfficial1AddressPc,
                    'up_country' => $request->associateOfficial1AddressCountry,
                    'up_sec_name' => $request->associateOfficial1SecretartName,
                    'up_sec_title' => $request->associateOfficial1SecretartTitle,
                    'up_sec_email' => $request->associateOfficial1SecretartEmail,
                    'up_sec_mobile' => $request->associateOfficial1SecretartContact,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofile1->toArray(), 'MemberProfile1');

            }

            if($request->associateAccType == 1) {
                if(!empty($request->associateOfficial2Nop)){

                    $userprofile2 = MemberUserProfile::create([
                        'up_usertype' => $up_usertype,
                        'up_fullname' => $request->associateOfficial2Nop,
                        'up_title' => $request->associateOfficial2Title,
                        'up_mykad' => $request->associateOfficial2MyKad ?? NULL,
                        'passportno' => $request->associateOfficial2Passportno ?? NULL,
                        'up_designation' => $request->associateOfficial2Designation,
                        'up_gender' => $request->associateOfficial2Gender,
                        'up_contactno' => $request->associateOfficial2Contact,
                        'up_emailadd' => $request->associateOfficial2Email,
                        'up_profq' => $request->associateOfficial2ProQualification,
                        'up_address' => $request->associateOfficial2Address,
                        'up_city' => $request->associateOfficial2AddressCity,
                        'up_state' => $request->associateOfficial2AddressState,
                        'up_postcode' => $request->associateOfficial2AddressPc,
                        'up_country' => $request->associateOfficial2AddressCountry,
                        'up_sec_name' => $request->associateOfficial2SecretartName,
                        'up_sec_title' => $request->associateOfficial2SecretartTitle,
                        'up_sec_email' => $request->associateOfficial2SecretartEmail,
                        'up_sec_mobile' => $request->associateOfficial2SecretartContact,
                        'up_created_at' => $now,
                        'up_mid' => $memberComp->did
                    ]);
                    logSystem(auth()->id(), 'Create', $userprofile2->toArray(), 'MemberProfile2');

                }

                if(!empty($request->associateNameOfAdmin)){

                    $admin = 2;
                    $userprofileAdmin = MemberUserProfile::create([
                        'up_usertype' => $admin,
                        'up_fullname' => $request->associateNameOfAdmin,
                        'up_title' => $request->associateAdminTitle,
                        'up_designation' => $request->associateAdminDesignation,
                        'up_contactno' => $request->associateAdminContactNumber,
                        'up_emailadd' => $request->associateAdminEmail,
                        'up_created_at' => $now,
                        'up_mid' => $memberComp->did
                    ]);
                    logSystem(auth()->id(), 'Create', $userprofileAdmin->toArray(), 'MemberProfileAdmin');

                }
            }


            if($userprofile1 || $userprofile2 ||  $userprofileAdmin){
                return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Thank you.']);
            } else {
                return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);
            }

        } catch (\Exception $e) {

            // Cleanup Member record
            if (!$memberComp) {
                $member->delete();
            }

            // Cleanup MemberComp and Member
            if ($member && $memberComp && !$userprofile1) {
                $memberComp->delete();
                $member->delete();
            }

            // Cleanup MemberUser-Profile-1 and MemberComp and Member
            if ($request->associateAccType == 1 && $member && $memberComp && $userprofile1 && !$userprofile2) {
                $userprofile1->delete();
                $memberComp->delete();
                $member->delete();
            }

            // Cleanup MemberUser-Profile-2 and MemberUser-Profile-1 and MemberComp and Member
            if($request->associateAccType == 1 && $member && $memberComp && $userprofile1 && $userprofile2 && !$userprofileAdmin) {
                $userprofile2->delete();
                $userprofile1->delete();
                $memberComp->delete();
                $member->delete();
            }

            // Log the error details
            \Log::error('Error while associate registration: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);

        }
    }

    public function rehdayouthRegister(Request $request)
    {
        Log::info('rehdaYouth-request-data');
        Log::info($request->all());

        $parentid = chkMembershipNo($request->rehdaYouthOrdinaryMembershipNumber);
        if($parentid == null){
            return response()->json([
                'errors' => [
                    'rehdaYouthOrdinaryMembershipNumber' => "Invalid Ordinary Membership No.", // Return error message if upload fails
                ],
            ], 422);
        }

        $request->validate([
            'rehdaYouthOrdinaryMembershipNumber' => 'required',
            'rehdaYouthCompanyName' => ['required',
                                        Rule::unique('member_comps', 'd_compname')
                                        ->where(function ($query) use ($parentid) {
                                            return $query->where('d_parentcomp', $parentid)
                                                        ->where('d_status', '!=', 3)
                                                        ->whereNull('d_deleted_at');
                                        })],
            'rehdaYouthCompanyAddress' => 'required',
            'rehdaYouthCompanyAddressCity' => 'required',
            'rehdaYouthCompanyAddressState' => 'required',
            'rehdaYouthCompanyAddressPc' => 'required',
            'rehdaYouthCompanyAddressCountry' => 'required',
            // 'rehdaYouthOfficialWebsite' => 'required',
            'rehdaYouthOfficialNumber' => 'required',

            'rehdaYouthOfficial1Title' => 'required',
            'rehdaYouthOfficial1Nop' => 'required',
            'rehdaYouthOfficial1MyKad' => 'required_if:rehdaYouthOfficial1MyKadSelect,==,1',
            'rehdaYouthOfficial1Passportno' => 'required_if:rehdaYouthOfficial1MyKadSelect,==,2',
            'rehdaYouthOfficial1Designation' => 'required',
            'rehdaYouthOfficial1Gender' => 'required',
            'rehdaYouthOfficial1Email' => 'required|email',
            'rehdaYouthOfficial1Contact' => 'required',
            'rehdaYouthOfficial1Address' => 'required',
            'rehdaYouthOfficial1AddressCity' => 'required',
            'rehdaYouthOfficial1AddressState' => 'required',
            'rehdaYouthOfficial1AddressPc' => 'required',
            'rehdaYouthOfficial1AddressCountry' => 'required',
            'rehdaYouthOfficial1SecretartEmail' => 'nullable|email',
            'rehdaYouthOfficial1MembersNominationsForm' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
            'rehdaYouthOfficial1MyKadCopy' => 'required|file|mimes:pdf,jpeg,png,gif,jpg|max:10240',
        ],[
            'required' => 'This field is required.',
            'email' => 'Please enter a valid email address.',
            'mimes' => 'Invalid file format. Please upload a file in PDF, JPEG, PNG, GIF, or JPG format.',
            'max' => 'File size exceeds the limit. Please upload a file smaller than 10 MB.',
        ]);

        Log::info('rehdaYouth-request-data-validated-successfuly');

        $dir = 'uploads/members/';

        if ($request->hasFile('rehdaYouthOfficial1MembersNominationsForm')) {
            $file = $request->file('rehdaYouthOfficial1MembersNominationsForm');

            $member_nominations_form = $this->uploadPDF($file, $dir, 300);

            if ($member_nominations_form === "1003") {
                return response()->json([
                    'errors' => [
                        'rehdaYouthOfficial1MembersNominationsForm' => "Members Nominations Form has an error while uploading.",
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('rehdaYouthOfficial1MyKadCopy')) {
            $file = $request->file('rehdaYouthOfficial1MyKadCopy');

            $mykad_copy = $this->uploadPDF($file, $dir, 300);

            if ($mykad_copy === "1003") {
                return response()->json([
                    'errors' => [
                        'rehdaYouthOfficial1MyKadCopy' => "MyKad Copy has an error while uploading.",
                    ],
                ], 422);
            }
        }

        $ord = 6;
        $now = date("Y-m-d H:i:s");

        try {

            $userprofile1 = '';

            $member = Member::create([
                'm_type' => $ord,
                'm_created_at' => $now
            ]);
            logSystem(auth()->id(), 'Create', $member->toArray(), 'Member');

            $mid = $member->mid;

            $memberComp = MemberComp::create([
                'd_parentcomp' => $parentid,
                'd_mid' => $mid,
                'd_compname' => $request->rehdaYouthCompanyName,
                'd_compadd' => $request->rehdaYouthCompanyAddress,
                'd_compadd_3' => $request->rehdaYouthCompanyAddressCity3,
                'd_compaddcity' => $request->rehdaYouthCompanyAddressCity,
                'd_compaddstate' => $request->rehdaYouthCompanyAddressState ?? 0,
                'd_compaddpcode' => $request->rehdaYouthCompanyAddressPc,
                'd_compaddcountry' => $request->rehdaYouthCompanyAddressCountry,
                'd_comp_weburl' => $request->rehdaYouthOfficialWebsite ?? NULL,
                'd_offno' => $request->rehdaYouthOfficialNumber,
                'd_faxno' => $request->rehdaYouthFaxNumber,
                'd_compssmno' => ' ',
                'd_created_at' => $now
            ]);
            logSystem(auth()->id(), 'Create', $memberComp->toArray(), 'MemberComp');

            $up_usertype = 1;
            if(!empty($request->rehdaYouthOfficial1Nop)){

                $userprofile1 = MemberUserProfile::create([
                    'up_usertype' => $up_usertype,
                    'up_fullname' => $request->rehdaYouthOfficial1Nop,
                    'up_title' => $request->rehdaYouthOfficial1Title,
                    'up_mykad' => $request->rehdaYouthOfficial1MyKad ?? NULL,
                    'passportno' => $request->rehdaYouthOfficial1Passportno ?? NULL,
                    'up_designation' => $request->rehdaYouthOfficial1Designation,
                    'up_gender' => $request->rehdaYouthOfficial1Gender,
                    'up_contactno' => $request->rehdaYouthOfficial1Contact,
                    'up_emailadd' => $request->rehdaYouthOfficial1Email,
                    'up_profq' => $request->rehdaYouthOfficial1ProQualification,
                    'up_address' => $request->rehdaYouthOfficial1Address,
                    'up_city' => $request->rehdaYouthOfficial1AddressCity,
                    'up_state' => $request->rehdaYouthOfficial1AddressState,
                    'up_postcode' => $request->rehdaYouthOfficial1AddressPc,
                    'up_country' => $request->rehdaYouthOfficial1AddressCountry,
                    'up_sec_name' => $request->rehdaYouthOfficial1SecretartName,
                    'up_sec_title' => $request->rehdaYouthOfficial1SecretartTitle,
                    'up_sec_email' => $request->rehdaYouthOfficial1SecretartEmail,
                    'up_sec_mobile' => $request->rehdaYouthOfficial1SecretartContact,
                    'member_nominations_form' => $member_nominations_form,
                    'mykad_copy' => $mykad_copy,
                    'up_created_at' => $now,
                    'up_mid' => $memberComp->did
                ]);
                logSystem(auth()->id(), 'Create', $userprofile1->toArray(), 'MemberProfile1');

            }

            if($memberComp || $userprofile1){
                return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Thank you.']);
            } else {
                return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);
            }

        } catch (\Exception $e) {

            // Cleanup Member record
            if (!$memberComp) {
                $member->delete();
            }

            // Cleanup MemberComp and Member
            if ($member && $memberComp && !$userprofile1) {
                $memberComp->delete();
                $member->delete();
            }

            // Log the error details
            \Log::error('Error while rehdaYouth registration: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []]);

        }
    }

    public function uploadPDF($file, $path, $filenameLimit)
    {
        $MAX_PDF_FILESIZE_MB = 10;
        $MAX_IMG_FILESIZE_MB = 5;

        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, ['pdf', 'jpeg', 'png', 'gif', 'jpg'])) {
                return "1002"; // Unknown extension
            }

            $size = $file->getSize();

            if ($extension === "pdf") {
                if ($size > $MAX_PDF_FILESIZE_MB * 1024 * 1024) {
                    return "1001"; // File is too large
                }
            } else {
                if ($size > $MAX_IMG_FILESIZE_MB * 1024 * 1024) {
                    return "1001"; // File is too large
                }
            }

            $indfile = pathinfo($filename);
            // $newFileName = $indfile['filename'] . '-' . date('YmdHis') . '.' . $extension;
            // $newFileName = Str::limit($indfile['filename'], $filenameLimit - ( strlen(date('YmdHis')) + strlen($extension) ) - 1) . '.' . $extension;
            $newFileName = Str::limit($indfile['filename'], ($filenameLimit - 39)) . '-' . date('YmdHis') . '.' . $extension;
            $newPath = $path . $newFileName;

            $admin_url = config('app.backendurl')."api/doc-upload";
            $response = Http::attach(
                'document', file_get_contents($file), $newFileName
            )->withOptions(['verify' => false])->post($admin_url, ['image_secret' => config('app.image_secret')]);

            if ($response->successful()) {
                return $newPath;
            } else {
                return "1003";
            }

            try {
                $file->storeAs($path, $newFileName, 'public'); // Store in the public disk
                return $newPath; // Return the new path
            } catch (\Exception $e) {
                return "1003"; // Error while uploading
            }
        }

        return null;
    }

    public function registerSuccess()
    {
        return view("auth.register-success");
    }

    public function validateCompanyName(Request $request)
    {
        if(isset($request->membership_number)){
            $parentid = chkMembershipNo($request->membership_number);
            if($parentid == null){
                return response()->json(['isUnique' => true]);
            } else {
                $isUnique = MemberComp::where('d_compname', $request->company_name)->where('d_parentcomp', $parentid)->where('d_status','!=',3)->where('d_deleted_at', null)->exists();
                return response()->json(['isUnique' => $isUnique]);
            }
        } else {
            $isUnique = MemberComp::where('d_compname', $request->company_name)->where('d_status','!=',3)->where('d_deleted_at', null)->exists();
            return response()->json(['isUnique' => $isUnique]);
        }
    }

    public function validateCompanyRegNo(Request $request)
    {
        $parentid = chkMembershipNo($request->membership_number);
        if($parentid == null){
            return response()->json(['found' => true]);
        } else {
            $memberComp = MemberComp::where('did', $parentid)->where('d_status','!=',3)->where('d_deleted_at', null)->first();
            if($memberComp) {
                return response()->json(['found' => false, 'company_name' => $memberComp->d_compname]);
            } else {
                return response()->json(['found' => true]);
            }
        }
    }
}
