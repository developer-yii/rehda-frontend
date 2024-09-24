<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\MemberComp;
use App\Models\MemberUser;
use App\Models\MemberUserProfile;
use Carbon\Carbon;

class MemberService
{
    public function updateMember(Request $request, $id)
    {
        $memberComp = MemberComp::findOrFail($id);
        $memberCompData = [];

        $memberProfiles = $memberComp->memberUserProfile()
            ->whereIn('up_usertype', [1, 2]) // Get both user types in one query
            ->get()
            ->groupBy('up_usertype');
        $userProfiles = $memberProfiles->get(1); // Profiles with `up_usertype` 1
        $adminProfiles  = $memberProfiles->get(2); // Profiles with `up_usertype` 2

        // Fetch the first admin profile safely
        $adminProfile = $adminProfiles ? $adminProfiles->first() : null;

        DB::beginTransaction();
        try {
            // Handle file uploads
            $fileFields = [
                'd_f9ssm' => 'f9',
                'd_f24' => 'f24',
                'd_f49' => 'f49',
                'd_anualretuncopy' => 'annreturn',
                'd_devlicensecopy' => 'devlic'
            ];

            foreach ($fileFields as $k => $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    // Get the original filename and extension
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $extension = strtolower($extension); // Make sure the extension is lowercase

                    // Create a new filename with timestamp and original filename
                    $newFilename = $originalName . '-' . now()->format('YmdHis') . '.' . $extension;

                    // Store the file in the 'uploads' folder within the 'public' disk with the new filename
                    $path = $file->storeAs('uploads', $newFilename, 'public');
                    $memberCompData[$k] = $path;

                    // Delete old file if exists
                    if ($memberComp->$k) {
                        // continue; // remove this continue to old delete file
                        Storage::disk('public')->delete($memberComp->$k);
                    }
                }
            }

            $memberComp->d_parentcomp = isset($request->ordmm) ? $request->ordmm : 0;
            $memberComp->d_compname = $request->compname;
            $memberComp->d_compadd = $request->compadd;
            $memberComp->d_compaddcity = $request->compcity;
            $memberComp->d_compaddstate = $request->compstate;
            $memberComp->d_compaddpcode = $request->comppc;
            $memberComp->d_compaddcountry = $request->compcountry;
            $memberComp->d_comp_weburl = $request->d_comp_weburl;
            $memberComp->d_offno = $request->d_offno;
            $memberComp->d_faxno = $request->d_faxno;
            $memberComp->d_compssmno = $request->d_compssmno;
            $memberComp->d_datecompform = $request->d_datecompform;
            $memberComp->d_paidcapital = $request->d_paidcapital;
            $memberComp->d_f9ssm = $memberCompData['d_f9ssm'] ?? $request->ef9;
            $memberComp->d_f24 = $memberCompData['d_f24'] ?? $request->ef24;
            $memberComp->d_f49 = $memberCompData['d_f49'] ?? $request->ef49;
            $memberComp->d_anualretuncopy = $memberCompData['d_anualretuncopy'] ?? $request->eannreturn;
            $memberComp->d_devlicense = $request->d_devlicense;
            $memberComp->d_devlicensecopy = $memberCompData['d_devlicensecopy'] ?? $request->edevlic;
            $memberComp->d_remarks = $request->rem;
            $memberComp->d_mod_by = Auth::id();
            $memberComp->save();

            logSystem(Auth::id(), 'Edit', $memberComp->getChanges(), 'NewReg');

            // Update UserProfiles
            foreach ($userProfiles as $profile) {
                for ($i = 1; $i <= count($userProfiles); $i++) {
                    $upid = $request->input('upid' . $i); // Get the `upid` from the request

                    if ($profile->up_id == $upid) {

                        // Use $i for form fields, as $i matches the form field index
                        $profileData = $request->only([
                            "up_fullname" . $i,
                            "title" . $i,
                            "mykad" . $i,
                            "designation" . $i,
                            "gender" . $i,
                            "mobileno" . $i,
                            "emailadd" . $i,
                            "up_profq" . $i,
                            "up_address" . $i,
                            "up_city" . $i,
                            "up_state" . $i,
                            "up_postcode" . $i,
                            "up_country" . $i,
                            "up_sec_name" . $i,
                            "up_sec_title" . $i,
                            "up_sec_email" . $i,
                            "up_sec_mobile" . $i
                        ]);

                        // Update the profile using the correct form field data
                        $profile->update([
                            'up_fullname' => $profileData["up_fullname" . $i],
                            'up_title' => $profileData["title" . $i],
                            'up_mykad' => $profileData["mykad" . $i],
                            'up_designation' => $profileData["designation" . $i],
                            'up_gender' => $profileData["gender" . $i],
                            'up_contactno' => $profileData["mobileno" . $i],
                            'up_emailadd' => $profileData["emailadd" . $i],
                            'up_profq' => $profileData["up_profq" . $i],
                            'up_address' => $profileData["up_address" . $i],
                            'up_city' => $profileData["up_city" . $i],
                            'up_state' => $profileData["up_state" . $i],
                            'up_postcode' => $profileData["up_postcode" . $i],
                            'up_country' => $profileData["up_country" . $i],
                            'up_sec_name' => $profileData["up_sec_name" . $i],
                            'up_sec_title' => $profileData["up_sec_title" . $i],
                            'up_sec_email' => $profileData["up_sec_email" . $i],
                            'up_sec_mobile' => $profileData["up_sec_mobile" . $i],
                        ]);
                        logSystem(Auth::id(), 'Edit', $profile->getChanges(), 'MemberProfile' . $i);
                        break; // Exit the inner loop once the profile is updated
                    }
                }
            }

            // Update admin profile if exists
            if ($request->has('adminname')) {
                if ($adminProfile) {

                    $adminProfile->update([
                        'up_fullname' => $request->input('adminname'),
                        'up_title' => $request->input('admintitle'),
                        'up_designation' => $request->input('adminpost'),
                        'up_contactno' => $request->input('adminmobile'),
                        'up_emailadd' => $request->input('adminemail'),
                    ]);

                    logSystem(Auth::id(), 'Edit', $adminProfile->getChanges(), 'MemberProfileAdmin' . $i);
                }
            }

            DB::commit();

            // Prepare URLs for the response
            $urls = [
                'd_f9ssm' => $memberComp->d_f9ssm ? asset('storage/' . $memberComp->d_f9ssm) : null,
                'd_f24' => $memberComp->d_f24 ? asset('storage/' . $memberComp->d_f24) : null,
                'd_f49' => $memberComp->d_f49 ? asset('storage/' . $memberComp->d_f49) : null,
                'd_anualretuncopy' => $memberComp->d_anualretuncopy ? asset('storage/' . $memberComp->d_anualretuncopy) : null,
                'd_devlicensecopy' => $memberComp->d_devlicensecopy ? asset('storage/' . $memberComp->d_devlicensecopy) : null,
                'ef9' => $memberComp->d_f9ssm ? $memberComp->d_f9ssm : null,
                'ef24' => $memberComp->d_f24 ? $memberComp->d_f24 : null,
                'ef49' => $memberComp->d_f49 ? $memberComp->d_f49 : null,
                'eannreturn' => $memberComp->d_anualretuncopy ? $memberComp->d_anualretuncopy : null,
                'edevlic' => $memberComp->d_devlicensecopy ? $memberComp->d_devlicensecopy : null,
            ];

            return response()->json(['status' => true, 'message' => 'Registration updated successfully!', 'urls' => $urls], 200);
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error details
            \Log::error('Error while updating registration: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => false, 'message' => 'An error occurred while updating the registration.'], 500);
        }
    }

    public function updateActiveMember(Request $request, $id)
    {
        $memberComp = MemberComp::findOrFail($id);
        $memberCompData = [];

        $memberProfiles = $memberComp->memberUserProfile()
            ->whereIn('up_usertype', [1, 2]) // Get both user types in one query
            ->get()
            ->groupBy('up_usertype');
        $userProfiles = $memberProfiles->get(1); // Profiles with `up_usertype` 1
        $adminProfiles  = $memberProfiles->get(2); // Profiles with `up_usertype` 2

        // Fetch the first admin profile safely
        $adminProfile = $adminProfiles ? $adminProfiles->first() : null;

        DB::beginTransaction();
        try {
            // Handle file uploads
            $fileFields = [
                'd_f9ssm' => 'f9',
                'd_f24' => 'f24',
                'd_f49' => 'f49',
                'd_anualretuncopy' => 'annreturn',
                'd_devlicensecopy' => 'devlic'
            ];

            foreach ($fileFields as $k => $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    // Get the original filename and extension
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $extension = strtolower($extension); // Make sure the extension is lowercase

                    // Create a new filename with timestamp and original filename
                    $newFilename = $originalName . '-' . now()->format('YmdHis') . '.' . $extension;

                    // Store the file in the 'uploads' folder within the 'public' disk with the new filename
                    $path = $file->storeAs('uploads', $newFilename, 'public');
                    $memberCompData[$k] = $path;

                    // Delete old file if exists
                    if ($memberComp->$k) {
                        // continue; // remove this continue to old delete file
                        Storage::disk('public')->delete($memberComp->$k);
                    }
                }
            }

            $memberComp->d_parentcomp = isset($request->ordmm) ? $request->ordmm : 0;
            $memberComp->d_compname = $request->compname;
            $memberComp->d_compadd = $request->compadd;
            $memberComp->d_compaddcity = $request->compcity;
            $memberComp->d_compaddstate = $request->compstate;
            $memberComp->d_compaddpcode = $request->comppc;
            $memberComp->d_compaddcountry = $request->compcountry;
            $memberComp->d_comp_weburl = $request->d_comp_weburl;
            $memberComp->d_offno = $request->d_offno;
            $memberComp->d_faxno = $request->d_faxno;
            $memberComp->d_compssmno = $memberComp->d_status == 4 ? '' : $request->d_compssmno; // edit request from in-active reg. then compssmno will be blank
            $memberComp->d_datecompform = $request->d_datecompform;
            $memberComp->d_paidcapital = $request->d_paidcapital;
            $memberComp->d_f9ssm = $memberCompData['d_f9ssm'] ?? $request->ef9;
            $memberComp->d_f24 = $memberCompData['d_f24'] ?? $request->ef24;
            $memberComp->d_f49 = $memberCompData['d_f49'] ?? $request->ef49;
            $memberComp->d_anualretuncopy = $memberCompData['d_anualretuncopy'] ?? $request->eannreturn;
            $memberComp->d_devlicense = $request->d_devlicense;
            $memberComp->d_devlicensecopy = $memberCompData['d_devlicensecopy'] ?? $request->edevlic;
            $memberComp->d_remarks = $request->rem;
            $memberComp->d_status = $request->status;
            $memberComp->d_mod_by = Auth::id();
            $memberComp->save();

            logSystem(Auth::id(), 'Edit', $memberComp->getChanges(), 'NewReg');

            // Update UserProfiles
            foreach ($userProfiles as $profile) {
                for ($i = 1; $i <= count($userProfiles); $i++) {
                    $upid = $request->input('upid' . $i); // Get the `upid` from the request

                    if ($profile->up_id == $upid) {

                        // Use $i for form fields, as $i matches the form field index
                        $profileData = $request->only([
                            "up_fullname" . $i,
                            "title" . $i,
                            "mykad" . $i,
                            "designation" . $i,
                            "gender" . $i,
                            "mobileno" . $i,
                            "emailadd" . $i,
                            "up_profq" . $i,
                            "up_address" . $i,
                            "up_city" . $i,
                            "up_state" . $i,
                            "up_postcode" . $i,
                            "up_country" . $i,
                            "up_sec_name" . $i,
                            "up_sec_title" . $i,
                            "up_sec_email" . $i,
                            "up_sec_mobile" . $i
                        ]);

                        // Update the profile using the correct form field data
                        $profile->update([
                            'up_fullname' => $profileData["up_fullname" . $i],
                            'up_title' => $profileData["title" . $i],
                            'up_mykad' => $profileData["mykad" . $i],
                            'up_designation' => $profileData["designation" . $i],
                            'up_gender' => $profileData["gender" . $i],
                            'up_contactno' => $profileData["mobileno" . $i],
                            'up_emailadd' => $profileData["emailadd" . $i],
                            'up_profq' => $profileData["up_profq" . $i],
                            'up_address' => $profileData["up_address" . $i],
                            'up_city' => $profileData["up_city" . $i],
                            'up_state' => $profileData["up_state" . $i],
                            'up_postcode' => $profileData["up_postcode" . $i],
                            'up_country' => $profileData["up_country" . $i],
                            'up_sec_name' => $profileData["up_sec_name" . $i],
                            'up_sec_title' => $profileData["up_sec_title" . $i],
                            'up_sec_email' => $profileData["up_sec_email" . $i],
                            'up_sec_mobile' => $profileData["up_sec_mobile" . $i],
                        ]);
                        logSystem(Auth::id(), 'Edit', $profile->getChanges(), 'MemberProfile' . $i);



                        // Update memberUser model
                        $memberUser = MemberUser::where('ml_uid', $upid)->first();
                        $memberUser->update([
                                    'ml_username' => $profileData["mykad" . $i],
                                    'ml_emailadd' => $profileData["emailadd" . $i],
                                ]);

                        logSystem(Auth::id(), "Edit", $memberUser->getChanges(), "CompEditUsername1");

                        break; // Exit the inner loop once the profile is updated
                    }
                }
            }

            // Update admin profile if exists
            if ($request->has('adminname')) {
                if ($adminProfile) {

                    $adminProfile->update([
                        'up_fullname' => $request->input('adminname'),
                        'up_title' => $request->input('admintitle'),
                        'up_designation' => $request->input('adminpost'),
                        'up_contactno' => $request->input('adminmobile'),
                        'up_emailadd' => $request->input('adminemail'),
                    ]);

                    logSystem(Auth::id(), 'Edit', $adminProfile->getChanges(), 'MemberProfileAdmin' . $i);

                    // Update memberUser model for admin
                    $adminUser = MemberUser::where('ml_uid', $request->upadminid)->first();
                    $adminUser->update([
                                    'ml_emailadd' => $request->input('adminemail'),
                                ]);

                    logSystem(Auth::id(), "Edit", $adminUser->getChanges(), "CompEditUsernameAdmin");
                }
            }

            DB::commit();

            // Prepare URLs for the response
            $urls = [
                'd_f9ssm' => $memberComp->d_f9ssm ? asset('storage/' . $memberComp->d_f9ssm) : null,
                'd_f24' => $memberComp->d_f24 ? asset('storage/' . $memberComp->d_f24) : null,
                'd_f49' => $memberComp->d_f49 ? asset('storage/' . $memberComp->d_f49) : null,
                'd_anualretuncopy' => $memberComp->d_anualretuncopy ? asset('storage/' . $memberComp->d_anualretuncopy) : null,
                'd_devlicensecopy' => $memberComp->d_devlicensecopy ? asset('storage/' . $memberComp->d_devlicensecopy) : null,
                'ef9' => $memberComp->d_f9ssm ? $memberComp->d_f9ssm : null,
                'ef24' => $memberComp->d_f24 ? $memberComp->d_f24 : null,
                'ef49' => $memberComp->d_f49 ? $memberComp->d_f49 : null,
                'eannreturn' => $memberComp->d_anualretuncopy ? $memberComp->d_anualretuncopy : null,
                'edevlic' => $memberComp->d_devlicensecopy ? $memberComp->d_devlicensecopy : null,
            ];

            return response()->json(['status' => true, 'message' => 'Registration updated successfully!', 'urls' => $urls], 200);
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error details
            \Log::error('Error while updating registration: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => false, 'message' => 'An error occurred while updating the registration.'], 500);
        }
    }

    public function updateActiveMemberProfile(Request $request, $id)
    {
        $memberComp = MemberComp::findOrFail($id);
        $memberCompData = [];

        DB::beginTransaction();
        try {
            // Handle file uploads
            $fileFields = [
                'd_f9ssm' => 'f9',
                'd_f24' => 'f24',
                'd_f49' => 'f49',
                'd_anualretuncopy' => 'annreturn',
                'd_devlicensecopy' => 'devlic'
            ];

            foreach ($fileFields as $k => $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    // Get the original filename and extension
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $extension = strtolower($extension); // Make sure the extension is lowercase

                    // Create a new filename with timestamp and original filename
                    $newFilename = $originalName . '-' . now()->format('YmdHis') . '.' . $extension;

                    // Store the file in the 'uploads' folder within the 'public' disk with the new filename
                    $path = $file->storeAs('uploads', $newFilename, 'public');
                    $memberCompData[$k] = $path;

                    // Delete old file if exists
                    if ($memberComp->$k) {
                        // continue; // remove this continue to old delete file
                        Storage::disk('public')->delete($memberComp->$k);
                    }
                }
            }

            $memberComp->d_parentcomp = isset($request->ordmm) ? $request->ordmm : 0;
            $memberComp->d_compname = $request->compname;
            $memberComp->d_compadd = $request->compadd;
            $memberComp->d_compaddcity = $request->compcity;
            $memberComp->d_compaddstate = $request->compstate;
            $memberComp->d_compaddpcode = $request->comppc;
            $memberComp->d_compaddcountry = $request->compcountry;
            $memberComp->d_comp_weburl = $request->d_comp_weburl;
            $memberComp->d_offno = $request->d_offno;
            $memberComp->d_faxno = $request->d_faxno;
            $memberComp->d_compssmno = $request->d_compssmno ?? '';
            $memberComp->d_datecompform = $request->d_datecompform;
            $memberComp->d_paidcapital = $request->d_paidcapital;
            $memberComp->d_f9ssm = $memberCompData['d_f9ssm'] ?? $request->ef9;
            $memberComp->d_f24 = $memberCompData['d_f24'] ?? $request->ef24;
            $memberComp->d_f49 = $memberCompData['d_f49'] ?? $request->ef49;
            $memberComp->d_anualretuncopy = $memberCompData['d_anualretuncopy'] ?? $request->eannreturn;
            $memberComp->d_devlicense = $request->d_devlicense;
            $memberComp->d_devlicensecopy = $memberCompData['d_devlicensecopy'] ?? $request->edevlic;
            $memberComp->d_remarks = $request->rem;
            $memberComp->d_mod_by = Auth::id();
            $memberComp->save();

            logSystem(Auth::id(), 'Edit', $memberComp->getChanges(), 'NewReg');



            // Update admin profile if exists
            if ($request->has('adminname')) {
                $adminProfile = MemberUserProfile::where('up_id',$request->upadminid)->where('up_mid', $id)->first();

                if ($adminProfile) {
                    $adminProfile->update([
                        'up_fullname' => $request->input('adminname'),
                        'up_title' => $request->input('admintitle'),
                        'up_designation' => $request->input('adminpost'),
                        'up_contactno' => $request->input('adminmobile'),
                        'up_emailadd' => $request->input('adminemail'),
                    ]);

                    logSystem(Auth::id(), 'Edit', $adminProfile->getChanges(), 'MemberProfileAdmin');

                    // Update memberUser model for admin
                    $adminUser = MemberUser::where('ml_uid', $request->upadminid)->first();
                    $adminUser->update([
                                    'ml_emailadd' => $request->input('adminemail'),
                                ]);

                    logSystem(Auth::id(), "Edit", $adminUser->getChanges(), "ChgRepProfileAUsername");
                }
            }

            DB::commit();

            // Prepare URLs for the response
            $urls = [
                'd_f9ssm' => $memberComp->d_f9ssm ? asset('storage/' . $memberComp->d_f9ssm) : null,
                'd_f24' => $memberComp->d_f24 ? asset('storage/' . $memberComp->d_f24) : null,
                'd_f49' => $memberComp->d_f49 ? asset('storage/' . $memberComp->d_f49) : null,
                'd_anualretuncopy' => $memberComp->d_anualretuncopy ? asset('storage/' . $memberComp->d_anualretuncopy) : null,
                'd_devlicensecopy' => $memberComp->d_devlicensecopy ? asset('storage/' . $memberComp->d_devlicensecopy) : null,
                'ef9' => $memberComp->d_f9ssm ? $memberComp->d_f9ssm : null,
                'ef24' => $memberComp->d_f24 ? $memberComp->d_f24 : null,
                'ef49' => $memberComp->d_f49 ? $memberComp->d_f49 : null,
                'eannreturn' => $memberComp->d_anualretuncopy ? $memberComp->d_anualretuncopy : null,
                'edevlic' => $memberComp->d_devlicensecopy ? $memberComp->d_devlicensecopy : null,
            ];

            return response()->json(['status' => true, 'message' => 'Info updated successfully!', 'urls' => $urls], 200);
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error details
            Log::error('Error while updating member profile: ' . $e->getMessage(), [
                'exception' => $e,
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json(['status' => false, 'message' => 'An error occurred while updating the profile.'], 500);
        }
    }

    public function addMmOffUser(array $data)
    {
        // Check if the authenticated user has permission to create a member user
        if (Auth::user()->cannot('memberusers-create')) {
            return response()->json(['status' => false, 'message' => 'You don\'t have permission to create member users'], 403);
        }

        DB::beginTransaction();

        try {
            $utype = 1; // Assuming user type is officer
            $status = 1; // Active status

            // Create member user profile
            $memberProfile = MemberUserProfile::create([
                'up_fullname' => $data['up_fullname'],
                'up_title' => $data['title'],
                'up_mykad' => $data['mykad'],
                'up_designation' => $data['designation'],
                'up_gender' => $data['gender'],
                'up_contactno' => $data['mobileno'],
                'up_emailadd' => $data['emailadd'],
                'up_profq' => $data['up_profq'],
                'up_address' => $data['up_address'],
                'up_city' => $data['up_city'],
                'up_state' => $data['up_state'],
                'up_postcode' => $data['up_postcode'],
                'up_country' => $data['up_country'],
                'up_sec_name' => $data['up_sec_name'],
                'up_sec_title' => $data['up_sec_title'],
                'up_sec_email' => $data['up_sec_email'],
                'up_sec_mobile' => $data['up_sec_mobile'],
                'up_mid' => $data['mid'],
                'up_usertype' => $utype
            ]);

            if (!$memberProfile) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => 'Failed to create member profile'], 500);
            }

            // Generate salt and hash password
            $random_salt = Hash::make(uniqid(openssl_random_pseudo_bytes(16), TRUE));
            $password = hash('sha512', $data['mobileno'] . $random_salt);

            // Create member user
            $memberUser = MemberUser::create([
                'ml_uid' => $memberProfile->up_id, // Associate with profile ID
                'ml_username' => $data['mykad'],
                'ml_emailadd' => $data['emailadd'],
                'ml_pwd' => $password,
                'ml_salt' => $random_salt,
                'ml_priv' => getMemberUserTypePriv($utype),
                'ml_status' => $status,
            ]);

            if (!$memberUser) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => 'Failed to create member user'], 500);
            }

            DB::commit();

            // Log system actions for user creation
            logSystem(Auth::id(), 'Add', $memberProfile->toArray(), 'MemberOffRepProfile');
            logSystem(Auth::id(), 'Create', $memberUser->toArray(), 'MemberUsers');

            return response()->json(['status' => true, 'message' => 'User created successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            Log::error('Error in creating member user: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the user. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addMmAdmUser(array $data)
    {
        // Check if the authenticated user has permission to create a member user
        if (Auth::user()->cannot('memberusers-create')) {
            return response()->json(['status' => false, 'message' => 'You don\'t have permission to create member users'], 403);
        }

        DB::beginTransaction();

        try {
            $now = Carbon::now();
            $utype = 2; // Assuming user type is officer
            $status = 1; // Active status

            $mno = getMembershipNobyMID($data['mid']);

            $memberUser = MemberUser::where('ml_username', $mno)->where('ml_priv','CompanyAdmin')->first();

            if($memberUser){
                return response()->json(['status' => false, 'message' => 'The same username for the Admin already existed. Creation failed.'], 403);
            }

            // Create member user profile
            $memberProfile = MemberUserProfile::create([
                'up_fullname' => $data['adminname'],
                'up_title' => $data['admintitle'],
                'up_designation' => $data['adminpost'],
                'up_contactno' => $data['adminmobile'],
                'up_emailadd' => $data['adminemail'],
                'up_mid' => $data['mid'],
                'up_usertype' => $utype
            ]);

            if (!$memberProfile) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => 'Failed to create member profile'], 500);
            }

            // Generate salt and hash password
            $random_salt = Hash::make(uniqid(openssl_random_pseudo_bytes(16), TRUE));
            $password = hash('sha512', $data['adminmobile'] . $random_salt);

            // Create member user
            $memberUser = MemberUser::create([
                'ml_uid' => $memberProfile->up_id, // Associate with profile ID
                'ml_username' => $mno,
                'ml_emailadd' => $data['adminemail'],
                'ml_pwd' => $password,
                'ml_salt' => $random_salt,
                'ml_priv' => getMemberUserTypePriv($utype),
                'ml_status' => $status,
            ]);

            if (!$memberUser) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => 'Failed to create member user'], 500);
            }

            DB::commit();

            // Log system actions for user creation
            logSystem(Auth::id(), 'Add', $memberProfile->toArray(), 'MemberProfileAdmin');
            logSystem(Auth::id(), 'Create', $memberUser->toArray(), 'MemberUsers');

            return response()->json(['status' => true, 'message' => 'User created successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            Log::error('Error in creating member user: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the user. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
