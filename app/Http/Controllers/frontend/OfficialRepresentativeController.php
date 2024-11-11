<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequestMember;
use App\Models\Country;
use App\Models\Gender;
use App\Models\MemberUserProfile;
use App\Models\Salutation;
use App\Models\State;
use Illuminate\Http\Request;

class OfficialRepresentativeController extends Controller
{
    public function index()
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $userProfiles = MemberUserProfile::where('up_mid', session('compid'))->where('up_usertype',1)->orderBy('up_id','ASC')->get();
        $titles = Salutation::orderBy('sname', 'ASC')->get();
        $genders = Gender::orderBy('gname','ASC')->get();
        $states = State::orderBy('state_name', 'ASC')->get();
        $countries = Country::orderBy('country_id', 'ASC')->get();
        return view('frontend.official-representative.index', compact('userProfiles','titles','genders','states','countries'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'official1title' => 'required',
            'official1designation' => 'required',
            'official1gender' => 'required',
            // 'official1email' => 'required|email',
            'official1contact_no' => 'required',
            'official1address' => 'required',
            'official1city' => 'required',
            'official1state' => 'required',
            'official1postcode' => 'required',
            // 'official1country' => 'required',

            'official2title' => 'required',
            'official2designation' => 'required',
            'official2gender' => 'required',
            // 'official2email' => 'required|email',
            'official2contact_no' => 'required',
            'official2address' => 'required',
            'official2city' => 'required',
            'official2state' => 'required',
            'official2postcode' => 'required',
            // 'official2country' => 'required',
        ],[
            'official1title.required' => 'The title field is required.',
            'official1designation.required' => 'The designation field is required.',
            'official1gender.required' => 'The gender field is required.',
            // 'official1email.required' => 'The email field is required.',
            // 'official1email.email' => 'Please enter valid email.',
            'official1contact_no.required' => 'The contact no field is required.',
            'official1address.required' => 'The correspondence address field is required.',
            'official1city.required' => 'The city field is required.',
            'official1state.required' => 'The state field is required.',
            'official1postcode.required' => 'The postcode field is required.',
            // 'official1country.required' => 'The country field is required.',

            'official2title.required' => 'The title field is required.',
            'official2designation.required' => 'The designation field is required.',
            'official2gender.required' => 'The gender field is required.',
            // 'official2email.required' => 'The email field is required.',
            // 'official2email.email' => 'Please enter valid email.',
            'official2contact_no.required' => 'The contact no field is required.',
            'official2address.required' => 'The correspondence address field is required.',
            'official2city.required' => 'The city field is required.',
            'official2state.required' => 'The state field is required.',
            'official2postcode.required' => 'The postcode field is required.',
            // 'official2country.required' => 'The country field is required.',
        ]);

        if(isset($request->official1) && $request->official1 != null) {
            $userProfile1 = MemberUserProfile::where('up_id', $request->official1)->where('up_mid', session('compid'))->first();
            $userProfile1->up_title = $request->official1title;
            $userProfile1->up_designation = $request->official1designation;
            $userProfile1->up_gender = $request->official1gender;
            $userProfile1->up_contactno = $request->official1contact_no;
            // $userProfile1->up_emailadd = $request->official1email;
            $userProfile1->up_profq = $request->official1pro_qualification;
            $userProfile1->up_address = $request->official1address;
            $userProfile1->up_city = $request->official1city;
            $userProfile1->up_address_3 = $request->official1address_3;
            $userProfile1->up_state = $request->official1state;
            $userProfile1->up_postcode = $request->official1postcode;
            $userProfile1->up_country = $request->official1country;
            $userProfile1->up_sec_name = $request->official1secretary_name;
            $userProfile1->up_sec_title = $request->official1secretary_title;
            $userProfile1->up_sec_email = $request->official1secretary_email;
            $userProfile1->up_sec_mobile = $request->official1secretary_contact_no;
            $userProfile1->up_mod_at = date("Y-m-d H:i:s");
            $userProfile1->save();
        }

        if(isset($request->official2) && $request->official2 != null) {
            $userProfile2 = MemberUserProfile::where('up_id', $request->official2)->where('up_mid', session('compid'))->first();
            $userProfile2->up_title = $request->official2title;
            $userProfile2->up_designation = $request->official2designation;
            $userProfile2->up_gender = $request->official2gender;
            $userProfile2->up_contactno = $request->official2contact_no;
            // $userProfile2->up_emailadd = $request->official2email;
            $userProfile2->up_profq = $request->official2pro_qualification;
            $userProfile2->up_address = $request->official2address;
            $userProfile2->up_city = $request->official2city;
            $userProfile2->up_address_3 = $request->official2address_3;
            $userProfile2->up_state = $request->official2state;
            $userProfile2->up_postcode = $request->official2postcode;
            $userProfile2->up_country = $request->official2country;
            $userProfile2->up_sec_name = $request->official2secretary_name;
            $userProfile2->up_sec_title = $request->official2secretary_title;
            $userProfile2->up_sec_email = $request->official2secretary_email;
            $userProfile2->up_sec_mobile = $request->official2secretary_contact_no;
            $userProfile2->up_mod_at = date("Y-m-d H:i:s");
            $userProfile2->save();
        }

        return redirect()->route('official-representative.index')->with('success', 'Data updated successfully!');
    }

    public function new1(Request $request)
    {
        $userProfile = MemberUserProfile::where('up_id', $request->resetNorId)->where('up_mid', session('compid'))->first();

        if($userProfile) {

            ChangeRequestMember::create([
                'rc_uid' => $request->resetNorId,
                'rc_name' => $request->resetNorName,
                'rc_mykad' => $request->resetNorMyKad ?? NULL,
                'rc_passportno' => $request->resetNorPassportno ?? NULL,
                'rc_contactno' => $request->resetNorContact,
                'rc_emailadd' => $request->resetNorEmail,
                'rc_created_at' => date('Y-m-d H:i:s'),
                'rc_oldname' => $userProfile->up_fullname,
                'rc_oldmykad' => $userProfile->up_mykad,
                'rc_oldcontactno' => $userProfile->up_contactno,
                'rc_oldemailadd' => $userProfile->up_emailadd,
            ]);

            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function alternateIndex()
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $userProfiles = MemberUserProfile::where('up_mid', session('compid'))->where('up_usertype',1)->orderBy('up_id','ASC')->get();
        $titles = Salutation::orderBy('sname', 'ASC')->get();
        $genders = Gender::orderBy('gname','ASC')->get();
        $states = State::orderBy('state_name', 'ASC')->get();
        $countries = Country::orderBy('country_id', 'ASC')->get();
        $alternate = 1;
        return view('frontend.official-representative.index', compact('userProfiles','titles','genders','states','countries','alternate'));
    }
}