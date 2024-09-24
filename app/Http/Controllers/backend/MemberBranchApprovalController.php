<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\MemberComp;
use App\Models\Member;
use App\Models\MemberUserProfile;
use App\Models\MemberUser;
use App\Http\Requests\ApproveBranchRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\MembershipActivated;
use Carbon\Carbon;

class MemberBranchApprovalController extends Controller
{
    public function getSingle(Request $request)
    {
        if ($request->ajax() && $request->id) {
            $did = $request->id;
            $result = Member::whereHas('memberComps', function ($query) use ($did) {
                $query->where('did', $did);
            })->with('memberComps')->latest()->first();

            if ($result && $result->memberComps->isNotEmpty()) {
                $memberComp = $result->memberComps->first();
                if ($memberComp->d_refer_branch) {
                    $branch = Branch::find($memberComp->d_refer_branch);
                    return $branch ? $branch->bname : '';
                }
            }
            return '';
        }
    }

    public function approve(ApproveBranchRequest $request)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            if ($user->cannot('memberusers-create')) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to perform this action.'
                ], 403);
            }

            $now = now();
            $app_yr = now()->format('y');

            // Get branch details
            $branch = Branch::where('bid', $request->branchid)->firstOrFail();

            // Get member_comps details
            $memberComp = MemberComp::where('did', $request->oid)->firstOrFail();

            // Get member details
            $member = Member::where('mid', $memberComp->d_mid)->firstOrFail();

            $hda = config('constant.MNP1'); // Example constant for `m_no_p1`

            // Handle based on member type
            if ($member->m_type == 6) {
                // Update member details for type 6
                $member->update([
                    'm_branch' => $branch->bid,
                    'm_no_p1' => $hda,
                    'm_no_p5' => $app_yr,
                    'm_approval_at' => $now
                ]);
                logSystem(auth()->id(), 'Update', $member->getChanges(), 'Member');
            } else {
                if (empty($member->m_branch)) {
                    // Generate and update running number
                    $run_no = getLatestMainRunningNo($memberComp->did);
                    $bno = $branch->bruningno + 1;

                    // Update branch bruningno
                    $branch->update(['bruningno' => $bno]);

                    // Handle branch number formatting based on member type
                    $bno = str_pad($bno, 4, "0", STR_PAD_LEFT);
                    if ($member->m_type == 2) {
                        $bno .= 'S';
                    } elseif ($member->m_type == 3) {
                        $bno .= 'AB';
                    } elseif ($member->m_type == 4 || $member->m_type == 5) {
                        $bno .= 'A';
                    }

                    // Check for duplicate membership number
                    $countExisted = chkMembershipNoExisted($hda, $run_no, $branch->bcode, $bno, $app_yr);
                    if ($countExisted > 0) {
                        DB::rollback();
                        return response()->json(['status' => false, 'message' => 'Membership no. error. Please contact developer.'], 403);
                    }

                    // Update member details
                    $member->update([
                        'm_branch' => $branch->bid,
                        'm_no_p1' => $hda,
                        'm_no_p2' => $run_no,
                        'm_no_p3' => $branch->bcode,
                        'm_no_p4' => $bno,
                        'm_no_p5' => $app_yr,
                        'm_approval_at' => $now
                    ]);
                    logSystem(auth()->id(), 'Update', $member->getChanges(), 'Member');
                } else {
                    // Update member approval time
                    $member->update(['m_approval_at' => $now]);
                    logSystem(auth()->id(), 'Update', $member->getChanges(), 'Member');
                }
            }

            $status = 1;

            // Fetch member user profiles
            $memberProfiles = MemberUserProfile::where('up_mid', $request->input('oid'))->get();

            foreach ($memberProfiles as $profile) {

                $priv = getMemberUserTypePriv($profile->up_usertype);
                $random_salt = Hash::make(uniqid());
                $tempps = uniqid();

                $password = Hash::make($tempps . $random_salt);
                $username = $profile->up_usertype == 1 ? $profile->up_mykad : getMembershipNo($memberComp->d_mid);

                $memberUser = new MemberUser([
                    'ml_uid' => $profile->up_id,
                    'ml_username' => $username,
                    'ml_emailadd' => $profile->up_emailadd,
                    'ml_pwd' => $password,
                    'ml_salt' => $random_salt,
                    'ml_priv' => $priv,
                    'ml_status' => $status,
                    'ml_created_at' => $now,
                    'ml_temppwd' => $tempps
                ]);
                $memberUser->save();

                logSystem(auth()->id(), 'Create', $memberUser->toArray(), 'MemberUsers');

                // Email content preparation
                $comp = getMemberCompanyName($profile->up_mid);
                $usernameForEmail = $profile->up_usertype == 1 ? $profile->up_mykad : getMembershipNobyMID($profile->up_mid);

                // set from email and name
                $fromEmail = config('constant.ADMIN_EMAIL');
                $fromName = config('constant.COMP_NAME2');

                Mail::to($profile->up_emailadd)->send(new MembershipActivated($profile->up_fullname, $usernameForEmail, $tempps, $comp, $fromEmail, $fromName));
            }

            $memberComp->update([
                'd_status' => 1,
                'd_mod_at' => $now,
                'd_mod_by' => auth()->id(),
            ]);

            logSystem(auth()->id(), 'Update', $memberComp->getChanges(), 'MemberCompStatus');

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Membership approved successfully and email has been sent to member!'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            \Log::error('Error in approve member function: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while approving the membership. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
