<?php
namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\MemberComp;
use App\Models\Member;
use App\Models\MemberUserProfile;
use App\Models\MemberUser;
use Illuminate\Support\Facades\Auth;


class MemberUserController extends Controller
{
    public function userlists(Request $request)
    {
        if (!Auth::user()->can('memberusers-view')) {
            return redirect()->back()->with('error', 'You have not permission to view member users.');
        }

        if(isset($request->pid) && !empty($request->pid))
        {
            $userProfiles = MemberUserProfile::where('up_mid', $request->pid)->get();
            $companyName = MemberComp::find($request->pid)->d_compname ?? null;
            return view('backend.members.users', compact('userProfiles','companyName'));
        }
        else {

            die("Invalid data. Close this window.");
            exit();
        }
    }

    public function changeStatus(Request $request)
    {
        if (Auth::user()->cannot('memberusers-edit')) {
            return response()->json(['message' => 'You do not have permission to edit member users.'], 403);
        }

        if ($request->has('chckv') && $request->has('cc')) {
            $id = $request->input('chckv');
            $status = $request->input('cc') == 'Yes' ? 1 : 2;

            $memberUser = MemberUser::find($id);

            if (!$memberUser) {
                return response()->json(['message' => 'Member user not found.'], 404);
            }

            $memberUser->ml_status = $status;

            if ($memberUser->save()) {
                // Log the action
                logSystem(auth()->id(), 'Edit', $memberUser->getChanges(), 'MMUserChgStatus');

                return response()->json(['success' => true, 'message' => 'User status updated successfully.']);
            } else {
                return response()->json(['success' => false,'message' => 'Failed to update user status.'], 500);
            }
        } else {
            return response()->json(['message' => 'Invalid data provided.'], 400);
        }
    }
}