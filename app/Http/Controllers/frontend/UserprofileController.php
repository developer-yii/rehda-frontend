<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Gender;
use App\Models\MemberUser;
use App\Models\MemberUserProfile;
use App\Models\Salutation;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserprofileController extends Controller
{
    public function index()
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        if(auth()->user()->ml_priv == 'CompanyAdmin'){

            $profile = MemberUserProfile::where('up_id', auth()->user()->ml_uid)->first();
            $titles = Salutation::orderBy('sname', 'ASC')->get();
            return view('frontend.userprofile.adminprofile', compact('profile','titles'));
        } else {

            $profile = MemberUserProfile::where('up_id', auth()->user()->ml_uid)->first();
            $titles = Salutation::orderBy('sname', 'ASC')->get();
            $genders = Gender::orderBy('gname','ASC')->get();
            $states = State::orderBy('state_name', 'ASC')->get();
            $countries = Country::orderBy('country_id', 'ASC')->get();
            return view('frontend.userprofile.memberprofile', compact('profile','titles','genders','states','countries'));
        }
    }

    public function updateMember(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'designation' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'correspondence_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'country' => 'required',
            'contact_no' => 'required',
            'new_password' => [
                'nullable', // Password can be null
                'string',   // Must be a string
                'min:6',    // At least 6 characters long
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', // Custom regex rule
            ],
            'retype_password' => 'required_with:new_password|same:new_password',
        ]);

        if(isset($request->changePass)) {

            $user = MemberUser::where('ml_id', auth()->user()->ml_id)->first();

            // Generate new salt and hash new password
            $newSalt = Hash::make(uniqid(openssl_random_pseudo_bytes(16), TRUE));

            $newPasswordHash = hash('sha512', $request->new_password . $newSalt);

            $user->ml_pwd = $newPasswordHash;
            $user->ml_salt = $newSalt;
            $user->save();
        }

        $profile = MemberUserProfile::where('up_id', auth()->user()->ml_uid)->where('up_mid', session('compid'))->first();
        $profile->up_title = $request->title;
        $profile->up_designation = $request->designation;
        $profile->up_gender = $request->gender;
        $profile->up_contactno = $request->contact_no;
        $profile->up_emailadd = $request->email;
        $profile->up_profq = $request->professional_qualification;
        $profile->up_address = $request->correspondence_address;
        $profile->up_city = $request->city;
        $profile->up_state = $request->state;
        $profile->up_postcode = $request->postcode;
        $profile->up_country = $request->country;
        $profile->up_sec_name = $request->secretary_name;
        $profile->up_sec_title = $request->secretary_title;
        $profile->up_sec_email = $request->secretary_email;
        $profile->up_sec_mobile = $request->up_sec_mobile;
        $profile->up_mod_at = auth()->user()->ml_uid;
        $profile->save();

        return redirect()->route('userprofile.index')->with('success', 'Data updated successfully!');
    }

    public function updateadmin(Request $request)
    {
        $request->validate([
            'name_of_admin' => 'required',
            'title' => 'required',
            'designation' => 'required',
            'email' => 'required|email',
            'contact_no' => 'required',
            'new_password' => [
                'nullable', // Password can be null
                'string',   // Must be a string
                'min:6',    // At least 6 characters long
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', // Custom regex rule
            ],
            'retype_password' => 'required_with:new_password|same:new_password',
        ],[
            'new_password.regex' => 'The new password must contain at least one lowercase letter, one uppercase letter, and one number.',
        ]);

        if(isset($request->changePass)) {

            $user = MemberUser::where('ml_id', auth()->user()->ml_id)->first();

            // Generate new salt and hash new password
            $newSalt = Hash::make(uniqid(openssl_random_pseudo_bytes(16), TRUE));

            $newPasswordHash = hash('sha512', $request->new_password . $newSalt);

            $user->ml_pwd = $newPasswordHash;
            $user->ml_salt = $newSalt;
            $user->save();
        }

        $profile = MemberUserProfile::where('up_id', auth()->user()->ml_uid)->where('up_mid', session('compid'))->first();
        $profile->up_fullname = $request->name_of_admin;
        $profile->up_title = $request->title;
        $profile->up_designation = $request->designation;
        $profile->up_contactno = $request->contact_no;
        $profile->up_emailadd = $request->email;
        $profile->up_mod_at = date("Y-m-d H:i:s");
        $profile->save();

        return redirect()->route('userprofile.index')->with('success', 'Data updated successfully!');
    }
}