<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MemberComp;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\MembershipNumberRequest;
use App\Models\MemberUser;
use App\Models\MemberUserProfile;

class MembershipNumberController extends Controller
{
    public function getMembershipNoDetail(Request $request)
    {
        $member = Member::select('members.*')
                ->join('member_comps', 'members.mid', '=', 'member_comps.d_mid')
                ->where('member_comps.did', $request->pid)
                ->first();

        if ($member) {
            $membershipNumber = getMembershipNobyMID($request->pid);
            return response()->json(['status' => true,'mno' => $membershipNumber, 'member' => $member]);
        }

        return response()->json(['status' => false, 'message' => 'Member not found'], 404);
    }

    public function updateMembershipNo(MembershipNumberRequest $request)
    {
        try {
            DB::beginTransaction();

            $member = Member::select('members.*')
            ->join('member_comps', 'members.mid', '=', 'member_comps.d_mid')
            ->where('member_comps.did', $request->member_id)
                ->first();

            if (!$member) {
                throw new \Exception('Member not found');
            }

            $countExisted = chkMembershipNoExisted($member->m_no_p1, $request->m_no_p2, $member->m_no_p3, $request->m_no_p4, $request->m_no_p5);

            if ($countExisted > 0) {
                $validator = Validator::make([], []);
                $validator->getMessageBag()->add('m_no_p3', 'Membership no. existed! Please try again.');
                return response()->json([
                    'message' => 'Membership no. existed! Please try again.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Perform the update
            $memberObj = Member::find($member->mid);
            $memberObj->m_no_p2 = $request->m_no_p2;
            $memberObj->m_no_p4 = $request->m_no_p4;
            $memberObj->m_no_p5 = $request->m_no_p5;
            $memberObj->save();

            logSystem(auth()->id(), 'Edit', $memberObj->getChanges(), 'MembershipNo');

            $memberProfile = MemberUserProfile::join('member_users as u', 'member_userprofiles.up_id', 'u.ml_uid')
            ->where('up_usertype', 2)
            ->where('up_mid', $request->member_id)
            ->first();

            $mmno = getMembershipNo($member->mid);

            $memberUser = MemberUser::find($memberProfile->ml_id);
            if ($memberUser) {
                $memberUser->ml_username = $mmno;
                $memberUser->save();
                logSystem(auth()->id(), 'Edit', $memberUser->getChanges(), 'CompAdminUsername');
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => "New membership no. updated successfully!"]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in updating member user: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to update membership number.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
