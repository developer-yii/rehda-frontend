<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\backend\MemberBillingController;
use App\Http\Controllers\Controller;
use App\Mail\PaymentEmail;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Member;
use App\Models\MemberComp;
use App\Models\MemberUserProfile;
use App\Models\Order;
use App\Models\Plan;
use App\Models\PlanTier;
use App\Models\Salutation;
use App\Models\State;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        $states = State::orderBy('state_name', 'ASC')->get();
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

        $request->validate([
            'ordinaryCompanyPreferBranch' => 'required',
            'ordinaryCompanyName' => 'required',
            'ordinaryCompanyAddress' => 'required',
            'ordinaryCompanyAddressCity' => 'required',
            'ordinaryCompanyAddressState' => 'required',
            'ordinaryCompanyAddressPc' => 'required',
            'ordinaryCompanyAddressCountry' => 'required',
            'ordinaryOfficialWebsite' => 'required',
            'ordinaryOfficialNumber' => 'required',
            'ordinarySSMRegNumber' => 'required',
            'ordinaryDateOfCompanyFormation' => 'required',
            'ordinaryLatestPaidUpCapital' => 'required',
            'ordinaryCopySSMCert' => 'required',
            'ordinaryCopyOfAnnualReturn' => 'required',
            'ordinaryHouseDevelopingLicense' => 'required',
            'ordinaryCopyOfHousingDeveloperLicense' => 'required',

            'ordinaryAdminTitle' => 'required',
            'ordinaryNameOfAdmin' => 'required',
            'ordinaryOfficial2Title' => 'required',
        ],[
            'required' => 'This field is required.',
        ]);

        $dir = 'uploads/members/';

        if ($request->hasFile('ordinaryCopySSMCert')) {
            $file = $request->file('ordinaryCopySSMCert');

            $path1 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path1 === "1001") {
                $result = "Copy of SSM Certification is too large.";
            } elseif ($path1 === "1002") {
                $result = "Copy of SSM Certification is not a valid format.";
            } elseif ($path1 === "1003") {
                $result = "Copy of SSM Certification has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopySSMCert' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryCopyForm24')) {
            $file = $request->file('ordinaryCopyForm24');

            $path2 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path2 === "1001") {
                $result = "Copy of Form 24 is too large.";
            } elseif ($path2 === "1002") {
                $result = "Copy of Form 24 is not a valid format.";
            } elseif ($path2 === "1003") {
                $result = "Copy of Form 24 has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopyForm24' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryCopyForm49')) {
            $file = $request->file('ordinaryCopyForm49');

            $path3 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path3 === "1001") {
                $result = "Copy of Form 49 is too large.";
            } elseif ($path3 === "1002") {
                $result = "Copy of Form 49 is not a valid format.";
            } elseif ($path3 === "1003") {
                $result = "Copy of Form 49 has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopyForm49' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryCopyOfAnnualReturn')) {
            $file = $request->file('ordinaryCopyOfAnnualReturn');

            $path4 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path4 === "1001") {
                $result = "Copy of Annual Return is too large.";
            } elseif ($path4 === "1002") {
                $result = "Copy of Annual Return is not a valid format.";
            } elseif ($path4 === "1003") {
                $result = "Copy of Annual Return has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopyOfAnnualReturn' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('ordinaryCopyOfHousingDeveloperLicense')) {
            $file = $request->file('ordinaryCopyOfHousingDeveloperLicense');

            $path5 = $this->uploadPDF($file, $dir, 100);

            $result = "";

            if ($path5 === "1001") {
                $result = "Copy of Housing Developer's Licence No is too large.";
            } elseif ($path5 === "1002") {
                $result = "Copy of Housing Developer's Licence No is not a valid format.";
            } elseif ($path5 === "1003") {
                $result = "Copy of Housing Developer's Licence No has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'ordinaryCopyOfHousingDeveloperLicense' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        // $orderno = date('ym').getRunningNo();
        // dd("1111",$path1, $path5, $orderno);

        $ord = 1;
        $now = date("Y-m-d H:i:s");

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
            'd_compaddcity' => $request->ordinaryCompanyAddressCity,
            'd_compaddstate' => $request->ordinaryCompanyAddressState,
            'd_compaddpcode' => $request->ordinaryCompanyAddressPc,
            'd_compaddcountry' => $request->ordinaryCompanyAddressCountry,
            'd_comp_weburl' => $request->ordinaryOfficialWebsite,
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
            'd_refer_branch' => $request->ordinaryCompanyPreferBranch
        ]);
        logSystem(auth()->id(), 'Create', $memberComp->toArray(), 'MemberComp');

        $up_usertype = 1;
        if(!empty($request->ordinaryOfficial1Nop)){

            $userprofile1 = MemberUserProfile::create([
                'up_usertype' => $up_usertype,
                'up_fullname' => $request->ordinaryOfficial1Nop,
                'up_title' => $request->ordinaryOfficial1Title,
                'up_mykad' => $request->ordinaryMyKad,
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
                'up_mykad' => $request->ordinaryMyKad2,
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

        $plan = Plan::where('pid', $ord)->first();
        $plantier = PlanTier::where('pt_id', $request->ordinaryLatestPaidUpCapital)->first();
        $curr_mth = date('n');

        if($curr_mth==1 || $curr_mth==2 || $curr_mth==3){
            $fee = $plantier->pt_fee;
        } else if($curr_mth==4 || $curr_mth==5 || $curr_mth==6){
            $fee = round(0.75*$plantier->pt_fee);
        } else if($curr_mth==7 || $curr_mth==8 || $curr_mth==9){
            $fee = round(0.5*$plantier->pt_fee);
        } else if($curr_mth==10 || $curr_mth==11){
            $fee = round(0.25*$plantier->pt_fee);
        } else {
            $fee = 0;
        }

        $total = $fee + $plan->plan_entrance_fee;
        $fpxfee = round(config('constant.FPX_FEE')*$total/100);
        $ccfee = round(config('constant.CC_FEE')*$total/100);
        $year = date('Y');
        $orderno = date('ym').getRunningNo();

        $order = Order::create([
            'order_no' => $orderno,
            'order_mid' => $memberComp->did,
            'order_planid' => $plan->pid,
            'order_planname' => $plan->plan_name,
            'order_sub_fee' => $fee,
            'order_entrance_fee' => $plan->plan_entrance_fee,
            'order_grandtotal' => $total,
            'order_payfpx' => $fpxfee,
            'order_paycc' => $ccfee,
            'order_created_at' => $now,
            'order_sub_fee_year' => $year
        ]);
        logSystem(auth()->id(), 'Create', $order->toArray(), 'Order');

        $ordercheck = Order::where('order_mid', $memberComp->did)->where('order_status',1)->first();

        $invno = config('constant.ORDERID_SET').$ordercheck->order_no;
        $subject = "[".config('constant.COMP_NAME2')."] Invoice ".$invno;
        $membercid = getMemberToSendInv($ordercheck->order_mid);
        $fullname = $membercid['fullname'];
        $email = $membercid['email'];
        Log::info($email);

        $memberBillingController = new MemberBillingController();
        $html = $memberBillingController->generateInvoiceHtml($ordercheck->oid);
        $filename = "Rehda Invoice-".config('constant.ORDERID_SET').$ordercheck->order_no.".pdf";

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $directoryPath = storage_path('app/public/invoices');
        $filePath = $directoryPath . '/' . $filename;

        // set from email and name
        $fromEmail = config('constant.ADMIN_EMAIL');
        $fromName = config('constant.COMP_NAME2');

        // Check if the directory exists, if not create it
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // 0755 permissions and true for recursive directory creation
        }

        // Save the file, overwriting it if it already exists, with exclusive lock
        file_put_contents($filePath, $dompdf->output(), LOCK_EX);

        try {
            Mail::to($email)->send(new PaymentEmail($invno, $fullname, $filename, $filePath, $subject,  $fromEmail, $fromName));
            return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Please check your email now for the invoice and payment link. Thank you.']);
        } catch (\Exception $e) {
            Log::error("Email failed to send. Error: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []], 400);
        }

    }

    public function subsidiaryRegister(Request $request)
    {
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

            $result = "";

            if ($path1 === "1001") {
                $result = "Copy of SSM Certification is too large.";
            } elseif ($path1 === "1002") {
                $result = "Copy of SSM Certification is not a valid format.";
            } elseif ($path1 === "1003") {
                $result = "Copy of SSM Certification has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopySSMCert' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('subsidiaryCopyForm24')) {
            $file = $request->file('subsidiaryCopyForm24');

            $path2 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path2 === "1001") {
                $result = "Copy of Form 24 is too large.";
            } elseif ($path2 === "1002") {
                $result = "Copy of Form 24 is not a valid format.";
            } elseif ($path2 === "1003") {
                $result = "Copy of Form 24 has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopyForm24' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('subsidiaryCopyForm49')) {
            $file = $request->file('subsidiaryCopyForm49');

            $path3 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path3 === "1001") {
                $result = "Copy of Form 49 is too large.";
            } elseif ($path3 === "1002") {
                $result = "Copy of Form 49 is not a valid format.";
            } elseif ($path3 === "1003") {
                $result = "Copy of Form 49 has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopyForm49' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('subsidiaryCopyOfAnnualReturn')) {
            $file = $request->file('subsidiaryCopyOfAnnualReturn');

            $path4 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path4 === "1001") {
                $result = "Copy of Annual Return is too large.";
            } elseif ($path4 === "1002") {
                $result = "Copy of Annual Return is not a valid format.";
            } elseif ($path4 === "1003") {
                $result = "Copy of Annual Return has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopyOfAnnualReturn' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('subsidiaryCopyOfHousingDeveloperLicense')) {
            $file = $request->file('subsidiaryCopyOfHousingDeveloperLicense');

            $path5 = $this->uploadPDF($file, $dir, 100);

            $result = "";

            if ($path5 === "1001") {
                $result = "Copy of Housing Developer's Licence No is too large.";
            } elseif ($path5 === "1002") {
                $result = "Copy of Housing Developer's Licence No is not a valid format.";
            } elseif ($path5 === "1003") {
                $result = "Copy of Housing Developer's Licence No has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'subsidiaryCopyOfHousingDeveloperLicense' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        $ord = 2;
        $now = date("Y-m-d H:i:s");

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
            'd_compaddcity' => $request->subsidiaryCompanyAddressCity,
            'd_compaddstate' => $request->subsidiaryCompanyAddressState,
            'd_compaddpcode' => $request->subsidiaryCompanyAddressPc,
            'd_compaddcountry' => $request->subsidiaryCompanyAddressCountry,
            'd_comp_weburl' => $request->subsidiaryOfficialWebsite,
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
                'up_mykad' => $request->subsidiaryMyKad,
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

        $plan = Plan::where('pid', $ord)->first();
        $plantier = PlanTier::where('pt_id', $request->ordinaryLatestPaidUpCapital)->first();
        $curr_mth = date('n');

        // if($curr_mth==1 || $curr_mth==2 || $curr_mth==3){
        //     $fee = $plantier->pt_fee;
        // } else if($curr_mth==4 || $curr_mth==5 || $curr_mth==6){
        //     $fee = round(0.75*$plantier->pt_fee);
        // } else if($curr_mth==7 || $curr_mth==8 || $curr_mth==9){
        //     $fee = round(0.5*$plantier->pt_fee);
        // } else if($curr_mth==10 || $curr_mth==11){
        //     $fee = round(0.25*$plantier->pt_fee);
        // } else {
        //     $fee = 0;
        // }

        $fee = $plan->plan_yearly_fee;

        $total = $fee + $plan->plan_entrance_fee;
        $fpxfee = round(config('constant.FPX_FEE')*$total/100);
        $ccfee = round(config('constant.CC_FEE')*$total/100);
        $year = date('Y');
        $orderno = date('ym').getRunningNo();

        $order = Order::create([
            'order_no' => $orderno,
            'order_mid' => $memberComp->did,
            'order_planid' => $plan->pid,
            'order_planname' => $plan->plan_name,
            'order_sub_fee' => $fee,
            'order_entrance_fee' => $plan->plan_entrance_fee,
            'order_grandtotal' => $total,
            'order_payfpx' => $fpxfee,
            'order_paycc' => $ccfee,
            'order_created_at' => $now,
            'order_sub_fee_year' => $year
        ]);
        logSystem(auth()->id(), 'Create', $order->toArray(), 'Order');

        $ordercheck = Order::where('order_mid', $memberComp->did)->where('order_status',1)->first();

        $invno = config('constant.ORDERID_SET').$ordercheck->order_no;
        $subject = "[".config('constant.COMP_NAME2')."] Invoice ".$invno;
        $membercid = getMemberToSendInv($ordercheck->order_mid);
        $fullname = $membercid['fullname'];
        $email = $membercid['email'];
        Log::info($email);

        $memberBillingController = new MemberBillingController();
        $html = $memberBillingController->generateInvoiceHtml($ordercheck->oid);
        $filename = "Rehda Invoice-".config('constant.ORDERID_SET').$ordercheck->order_no.".pdf";

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $directoryPath = storage_path('app/public/invoices');
        $filePath = $directoryPath . '/' . $filename;

        // set from email and name
        $fromEmail = config('constant.ADMIN_EMAIL');
        $fromName = config('constant.COMP_NAME2');

        // Check if the directory exists, if not create it
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // 0755 permissions and true for recursive directory creation
        }

        // Save the file, overwriting it if it already exists, with exclusive lock
        file_put_contents($filePath, $dompdf->output(), LOCK_EX);

        try {
            Mail::to($email)->send(new PaymentEmail($invno, $fullname, $filename, $filePath, $subject,  $fromEmail, $fromName));
            return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Please check your email now for the invoice and payment link. Thank you.']);
        } catch (\Exception $e) {
            Log::error("Email failed to send. Error: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []], 400);
        }

    }

    public function affiliateRegister(Request $request)
    {

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

            $result = "";

            if ($path1 === "1001") {
                $result = "Copy of SSM Certification is too large.";
            } elseif ($path1 === "1002") {
                $result = "Copy of SSM Certification is not a valid format.";
            } elseif ($path1 === "1003") {
                $result = "Copy of SSM Certification has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'affiliateCopySSMCert' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('affiliateCopyForm24')) {
            $file = $request->file('affiliateCopyForm24');

            $path2 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path2 === "1001") {
                $result = "Copy of Form 24 is too large.";
            } elseif ($path2 === "1002") {
                $result = "Copy of Form 24 is not a valid format.";
            } elseif ($path2 === "1003") {
                $result = "Copy of Form 24 has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'affiliateCopyForm24' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('affiliateCopyForm49')) {
            $file = $request->file('affiliateCopyForm49');

            $path3 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path3 === "1001") {
                $result = "Copy of Form 49 is too large.";
            } elseif ($path3 === "1002") {
                $result = "Copy of Form 49 is not a valid format.";
            } elseif ($path3 === "1003") {
                $result = "Copy of Form 49 has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'affiliateCopyForm49' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('affiliateCopyOfAnnualReturn')) {
            $file = $request->file('affiliateCopyOfAnnualReturn');

            $path4 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path4 === "1001") {
                $result = "Copy of Annual Return is too large.";
            } elseif ($path4 === "1002") {
                $result = "Copy of Annual Return is not a valid format.";
            } elseif ($path4 === "1003") {
                $result = "Copy of Annual Return has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'affiliateCopyOfAnnualReturn' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('affiliateCopyOfHousingDeveloperLicense')) {
            $file = $request->file('affiliateCopyOfHousingDeveloperLicense');

            $path5 = $this->uploadPDF($file, $dir, 100);

            $result = "";

            if ($path5 === "1001") {
                $result = "Copy of Housing Developer's Licence No is too large.";
            } elseif ($path5 === "1002") {
                $result = "Copy of Housing Developer's Licence No is not a valid format.";
            } elseif ($path5 === "1003") {
                $result = "Copy of Housing Developer's Licence No has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'affiliateCopyOfHousingDeveloperLicense' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        $ord = 3;
        $now = date("Y-m-d H:i:s");

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
            'd_compaddcity' => $request->affiliateCompanyAddressCity,
            'd_compaddstate' => $request->affiliateCompanyAddressState,
            'd_compaddpcode' => $request->affiliateCompanyAddressPc,
            'd_compaddcountry' => $request->affiliateCompanyAddressCountry,
            'd_comp_weburl' => $request->affiliateOfficialWebsite,
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
                'up_mykad' => $request->affiliateMyKad,
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
                'up_mykad' => $request->affiliateMyKad2,
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

        $plan = Plan::where('pid', $ord)->first();
        $plantier = PlanTier::where('pt_id', $request->ordinaryLatestPaidUpCapital)->first();
        $curr_mth = date('n');

        // if($curr_mth==1 || $curr_mth==2 || $curr_mth==3){
        //     $fee = $plantier->pt_fee;
        // } else if($curr_mth==4 || $curr_mth==5 || $curr_mth==6){
        //     $fee = round(0.75*$plantier->pt_fee);
        // } else if($curr_mth==7 || $curr_mth==8 || $curr_mth==9){
        //     $fee = round(0.5*$plantier->pt_fee);
        // } else if($curr_mth==10 || $curr_mth==11){
        //     $fee = round(0.25*$plantier->pt_fee);
        // } else {
        //     $fee = 0;
        // }

        $fee = $plan->plan_yearly_fee;

        $total = $fee + $plan->plan_entrance_fee;
        $fpxfee = round(config('constant.FPX_FEE')*$total/100);
        $ccfee = round(config('constant.CC_FEE')*$total/100);
        $year = date('Y');
        $orderno = date('ym').getRunningNo();

        $order = Order::create([
            'order_no' => $orderno,
            'order_mid' => $memberComp->did,
            'order_planid' => $plan->pid,
            'order_planname' => $plan->plan_name,
            'order_sub_fee' => $fee,
            'order_entrance_fee' => $plan->plan_entrance_fee,
            'order_grandtotal' => $total,
            'order_payfpx' => $fpxfee,
            'order_paycc' => $ccfee,
            'order_created_at' => $now,
            'order_sub_fee_year' => $year
        ]);
        logSystem(auth()->id(), 'Create', $order->toArray(), 'Order');

        $ordercheck = Order::where('order_mid', $memberComp->did)->where('order_status',1)->first();

        $invno = config('constant.ORDERID_SET').$ordercheck->order_no;
        $subject = "[".config('constant.COMP_NAME2')."] Invoice ".$invno;
        $membercid = getMemberToSendInv($ordercheck->order_mid);
        $fullname = $membercid['fullname'];
        $email = $membercid['email'];
        Log::info($email);

        $memberBillingController = new MemberBillingController();
        $html = $memberBillingController->generateInvoiceHtml($ordercheck->oid);
        $filename = "Rehda Invoice-".config('constant.ORDERID_SET').$ordercheck->order_no.".pdf";

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $directoryPath = storage_path('app/public/invoices');
        $filePath = $directoryPath . '/' . $filename;

        // set from email and name
        $fromEmail = config('constant.ADMIN_EMAIL');
        $fromName = config('constant.COMP_NAME2');

        // Check if the directory exists, if not create it
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // 0755 permissions and true for recursive directory creation
        }

        // Save the file, overwriting it if it already exists, with exclusive lock
        file_put_contents($filePath, $dompdf->output(), LOCK_EX);

        try {
            Mail::to($email)->send(new PaymentEmail($invno, $fullname, $filename, $filePath, $subject,  $fromEmail, $fromName));
            return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Please check your email now for the invoice and payment link. Thank you.']);
        } catch (\Exception $e) {
            Log::error("Email failed to send. Error: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []], 400);
        }
    }

    public function associateRegister(Request $request)
    {
        $dir = 'uploads/members/';

        if ($request->hasFile('associateCopySSMCert')) {
            $file = $request->file('associateCopySSMCert');

            $path1 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path1 === "1001") {
                $result = "Copy of SSM Certification is too large.";
            } elseif ($path1 === "1002") {
                $result = "Copy of SSM Certification is not a valid format.";
            } elseif ($path1 === "1003") {
                $result = "Copy of SSM Certification has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'associateCopySSMCert' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('associateCopyForm24')) {
            $file = $request->file('associateCopyForm24');

            $path2 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path2 === "1001") {
                $result = "Copy of Form 24 is too large.";
            } elseif ($path2 === "1002") {
                $result = "Copy of Form 24 is not a valid format.";
            } elseif ($path2 === "1003") {
                $result = "Copy of Form 24 has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'associateCopyForm24' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('associateCopyForm49')) {
            $file = $request->file('associateCopyForm49');

            $path3 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path3 === "1001") {
                $result = "Copy of Form 49 is too large.";
            } elseif ($path3 === "1002") {
                $result = "Copy of Form 49 is not a valid format.";
            } elseif ($path3 === "1003") {
                $result = "Copy of Form 49 has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'associateCopyForm49' => $result, // Return error message if upload fails
                    ],
                ], 422);
            }
        }

        if ($request->hasFile('associateCopyOfAnnualReturn')) {
            $file = $request->file('associateCopyOfAnnualReturn');

            $path4 = $this->uploadPDF($file, $dir, 300);

            $result = "";

            if ($path4 === "1001") {
                $result = "Copy of Annual Return is too large.";
            } elseif ($path4 === "1002") {
                $result = "Copy of Annual Return is not a valid format.";
            } elseif ($path4 === "1003") {
                $result = "Copy of Annual Return has an error while uploading.";
            }

            if ($result != "") {
                return response()->json([
                    'errors' => [
                        'associateCopyOfAnnualReturn' => $result, // Return error message if upload fails
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
                'd_compaddcity' => $request->associateCompanyAddressCity,
                'd_compaddstate' => $request->associateCompanyAddressState,
                'd_compaddpcode' => $request->associateCompanyAddressPc,
                'd_compaddcountry' => $request->associateCompanyAddressCountry,
                'd_comp_weburl' => $request->associateOfficialWebsite,
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
                'd_compaddstate' => $request->associateCompanyAddressState,
                'd_compaddpcode' => $request->associateCompanyAddressPc,
                'd_compaddcountry' => $request->associateCompanyAddressCountry,
                'd_comp_weburl' => $request->associateOfficialWebsite,
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
                'up_mykad' => $request->associateOfficial1MyKad,
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
                    'up_mykad' => $request->associateOfficial2MyKad,
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


        $plan = Plan::where('pid', $ord)->first();
        $plantier = PlanTier::where('pt_id', $request->ordinaryLatestPaidUpCapital)->first();
        $curr_mth = date('n');

        // if($curr_mth==1 || $curr_mth==2 || $curr_mth==3){
        //     $fee = $plantier->pt_fee;
        // } else if($curr_mth==4 || $curr_mth==5 || $curr_mth==6){
        //     $fee = round(0.75*$plantier->pt_fee);
        // } else if($curr_mth==7 || $curr_mth==8 || $curr_mth==9){
        //     $fee = round(0.5*$plantier->pt_fee);
        // } else if($curr_mth==10 || $curr_mth==11){
        //     $fee = round(0.25*$plantier->pt_fee);
        // } else {
        //     $fee = 0;
        // }

        $fee = $plan->plan_yearly_fee;

        $total = $fee + $plan->plan_entrance_fee;
        $fpxfee = round(config('constant.FPX_FEE')*$total/100);
        $ccfee = round(config('constant.CC_FEE')*$total/100);
        $year = date('Y');
        $orderno = date('ym').getRunningNo();

        $order = Order::create([
            'order_no' => $orderno,
            'order_mid' => $memberComp->did,
            'order_planid' => $plan->pid,
            'order_planname' => $plan->plan_name,
            'order_sub_fee' => $fee,
            'order_entrance_fee' => $plan->plan_entrance_fee,
            'order_grandtotal' => $total,
            'order_payfpx' => $fpxfee,
            'order_paycc' => $ccfee,
            'order_created_at' => $now,
            'order_sub_fee_year' => $year
        ]);
        logSystem(auth()->id(), 'Create', $order->toArray(), 'Order');

        $ordercheck = Order::where('order_mid', $memberComp->did)->where('order_status',1)->first();

        $invno = config('constant.ORDERID_SET').$ordercheck->order_no;
        $subject = "[".config('constant.COMP_NAME2')."] Invoice ".$invno;
        $membercid = getMemberToSendInv($ordercheck->order_mid);
        $fullname = $membercid['fullname'];
        $email = $membercid['email'];
        Log::info($email);

        $memberBillingController = new MemberBillingController();
        $html = $memberBillingController->generateInvoiceHtml($ordercheck->oid);
        $filename = "Rehda Invoice-".config('constant.ORDERID_SET').$ordercheck->order_no.".pdf";

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $directoryPath = storage_path('app/public/invoices');
        $filePath = $directoryPath . '/' . $filename;

        // set from email and name
        $fromEmail = config('constant.ADMIN_EMAIL');
        $fromName = config('constant.COMP_NAME2');

        // Check if the directory exists, if not create it
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // 0755 permissions and true for recursive directory creation
        }

        // Save the file, overwriting it if it already exists, with exclusive lock
        file_put_contents($filePath, $dompdf->output(), LOCK_EX);

        try {
            Mail::to($email)->send(new PaymentEmail($invno, $fullname, $filename, $filePath, $subject,  $fromEmail, $fromName));
            return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Please check your email now for the invoice and payment link. Thank you.']);
        } catch (\Exception $e) {
            Log::error("Email failed to send. Error: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []], 400);
        }
    }

    public function rehdayouthRegister(Request $request)
    {
        $parentid = chkMembershipNo($request->rehdaYouthOrdinaryMembershipNumber);
        if($parentid == null){
            return response()->json([
                'errors' => [
                    'rehdaYouthOrdinaryMembershipNumber' => "Invalid Ordinary Membership No.", // Return error message if upload fails
                ],
            ], 422);
        }

        $ord = 6;
        $now = date("Y-m-d H:i:s");

        $member = Member::create([
            'm_type' => $ord,
            'm_created_at' => $now
        ]);
        logSystem(auth()->id(), 'Create', $member->toArray(), 'Member');

        $mid = $member->mid;

        $memberComp = MemberComp::create([
            'd_mid' => $mid,
            'd_compname' => $request->rehdaYouthCompanyName,
            'd_compadd' => $request->rehdaYouthCompanyAddress,
            'd_compaddcity' => $request->rehdaYouthCompanyAddressCity,
            'd_compaddstate' => $request->rehdaYouthCompanyAddressState,
            'd_compaddpcode' => $request->rehdaYouthCompanyAddressPc,
            'd_compaddcountry' => $request->rehdaYouthCompanyAddressCountry,
            'd_comp_weburl' => $request->rehdaYouthOfficialWebsite,
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
                'up_mykad' => $request->rehdaYouthOfficial1MyKad,
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
                'up_created_at' => $now,
                'up_mid' => $memberComp->did
            ]);
            logSystem(auth()->id(), 'Create', $userprofile1->toArray(), 'MemberProfile1');

        }

        $plan = Plan::where('pid', $ord)->first();
        $plantier = PlanTier::where('pt_id', $request->ordinaryLatestPaidUpCapital)->first();
        $curr_mth = date('n');

        // if($curr_mth==1 || $curr_mth==2 || $curr_mth==3){
        //     $fee = $plantier->pt_fee;
        // } else if($curr_mth==4 || $curr_mth==5 || $curr_mth==6){
        //     $fee = round(0.75*$plantier->pt_fee);
        // } else if($curr_mth==7 || $curr_mth==8 || $curr_mth==9){
        //     $fee = round(0.5*$plantier->pt_fee);
        // } else if($curr_mth==10 || $curr_mth==11){
        //     $fee = round(0.25*$plantier->pt_fee);
        // } else {
        //     $fee = 0;
        // }

        $fee = $plan->plan_yearly_fee;

        $total = $fee + $plan->plan_entrance_fee;
        $fpxfee = round(config('constant.FPX_FEE')*$total/100);
        $ccfee = round(config('constant.CC_FEE')*$total/100);
        $year = date('Y');
        $orderno = date('ym').getRunningNo();

        $order = Order::create([
            'order_no' => $orderno,
            'order_mid' => $memberComp->did,
            'order_planid' => $plan->pid,
            'order_planname' => $plan->plan_name,
            'order_sub_fee' => $fee,
            'order_entrance_fee' => $plan->plan_entrance_fee,
            'order_grandtotal' => $total,
            'order_payfpx' => $fpxfee,
            'order_paycc' => $ccfee,
            'order_created_at' => $now,
            'order_sub_fee_year' => $year
        ]);
        logSystem(auth()->id(), 'Create', $order->toArray(), 'Order');

        $ordercheck = Order::where('order_mid', $memberComp->did)->where('order_status',1)->first();

        $invno = config('constant.ORDERID_SET').$ordercheck->order_no;
        $subject = "[".config('constant.COMP_NAME2')."] Invoice ".$invno;
        $membercid = getMemberToSendInv($ordercheck->order_mid);
        $fullname = $membercid['fullname'];
        $email = $membercid['email'];
        Log::info($email);

        $memberBillingController = new MemberBillingController();
        $html = $memberBillingController->generateInvoiceHtml($ordercheck->oid);
        $filename = "Rehda Invoice-".config('constant.ORDERID_SET').$ordercheck->order_no.".pdf";

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $directoryPath = storage_path('app/public/invoices');
        $filePath = $directoryPath . '/' . $filename;

        // set from email and name
        $fromEmail = config('constant.ADMIN_EMAIL');
        $fromName = config('constant.COMP_NAME2');

        // Check if the directory exists, if not create it
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // 0755 permissions and true for recursive directory creation
        }

        // Save the file, overwriting it if it already exists, with exclusive lock
        file_put_contents($filePath, $dompdf->output(), LOCK_EX);

        try {
            Mail::to($email)->send(new PaymentEmail($invno, $fullname, $filename, $filePath, $subject,  $fromEmail, $fromName));
            return response()->json(['status' => true, 'message' => 'Your registration has been submitted! Please check your email now for the invoice and payment link. Thank you.']);
        } catch (\Exception $e) {
            Log::error("Email failed to send. Error: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => "Your registration can't be submitted! Try again later.", 'data' => []], 400);
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

            try {
                $file->storeAs($path, $newFileName, 'public'); // Store in the public disk
                return $newPath; // Return the new path
            } catch (\Exception $e) {
                return "1003"; // Error while uploading
            }
        }

        return null;
    }
}
