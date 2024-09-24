<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\MemberService;
use App\Models\MemberComp;
use App\Models\Branch;
use App\Models\Salutation;
use App\Models\Gender;
use App\Models\Country;
use App\Models\State;
use App\Models\MemberCert;
use App\Models\MemberUserProfile;
use App\Models\MemberUser;
use App\Http\Requests\MemberUserPasswordChangeRequest;
use App\Http\Requests\UpdateMemberUserRequest;
use App\Http\Requests\OffRepMemberUserRequest;
use App\Http\Requests\AdminMemberUserRequest;

class MemberInfoController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->can('memberusers-view') && !$user->can('activemembers-view')) {
            return redirect()->back()->with('error', 'You don\'t have permission to access members info page');
        }

        // Validate the 'pid' parameter
        if (!$request->has('pid') || empty($request->pid)) {
            return redirect()->back()->with('error', 'Invalid data request!');
        }

        $pid = $request->pid;

        // Fetch data based on user roles
        $query = MemberComp::where('d_status', 1)->where('did', $pid);

        if ($user->hasRole('BranchAdmin')) {
            $query->whereHas('member', function ($q) use ($user) {
                $q->where('m_branch', $user->regid);
            });
        } elseif (chkAdminAccess() == 1) {
        } else {
            return redirect()->back()->with('error', 'You don\'t have permission to access members info page');
        }

        $memberComp = $query->with('member')->first();

        if (!$memberComp) {
            echo "No record / no permission. Close this window."; die;
            // return redirect()->back()->with('error', 'No record found');
        }

        $memberType = $memberComp->member->memberType->typename ?? null;

        $status = getMCStatus($memberComp->d_status);

        $users = MemberUserProfile::where('up_mid', $pid)
            ->join('member_users', 'member_userprofiles.up_id', '=', 'member_users.ml_uid')
            ->get();

        $memberCerts = MemberCert::where('mc_mid', $pid)->orderBy('mc_yr', 'asc')->get();

        return view('backend.members.member-info', compact('memberComp', 'memberType', 'status', 'users', 'memberCerts'));
    }

    public function resetPassword(MemberUserPasswordChangeRequest $request)
    {
        $user = MemberUser::where('ml_username', $request->username)->firstOrFail();

        if (!$user) {
            return response()->json(['message' => 'User not found or inactive'], 404);
        }

        // Generate new salt and hash new password
        $newSalt = Hash::make(uniqid(openssl_random_pseudo_bytes(16), TRUE));

        $newPasswordHash = hash('sha512', $request->new_password . $newSalt);

        $user->ml_pwd = $newPasswordHash;
        $user->ml_salt = $newSalt;

        if ($user->save()) {
            logSystem(auth()->id(), 'Edit', $user->getChanges(), 'MemberUPassword');

            return response()->json(['success' => true, 'message' => 'Password updated successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update password.'], 500);
        }
    }

    public function editUser(Request $request)
    {
        if (Auth::user()->cannot('memberusers-edit')) {
            return redirect()->back()->with('error', 'You don\'t have permission to edit member users');
        }

        $memberProfile = MemberUserProfile::join('member_users', 'member_userprofiles.up_id', '=', 'member_users.ml_uid')
            ->where('member_users.ml_id', $request->id)
            ->where('member_userprofiles.up_mid', $request->mid)
            ->first();

        $salutations = Salutation::orderBy('sname', 'asc')->pluck('sname', 'sid');

        $states = State::orderBy('state_name', 'asc')->pluck('state_name', 'state_id');

        $countries = Country::orderBy('country_name', 'asc')->pluck('country_name', 'country_id');

        $genders = Gender::pluck('gname', 'gid');

        return view('backend.members.edit-mmuser', compact('memberProfile', 'salutations', 'genders', 'states', 'countries'));
    }

    public function updateUser(UpdateMemberUserRequest $request)
    {
        if (empty($request->id) || empty($request->mid)) {
            return response()->json(['message' => 'Failed to update user'], 404);
        }

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $id = $request->id;
            $mid = $request->mid;

            $memberProfile = MemberUserProfile::join('member_users', 'member_userprofiles.up_id', '=', 'member_users.ml_uid')
                ->where('member_users.ml_id', $id)
                ->where('member_userprofiles.up_mid', $mid)
                ->first();

            $userProfile = MemberUserProfile::where('up_id', $memberProfile->up_id)->where('up_mid', $mid)->first();
            $memberUser = MemberUser::where('ml_uid', $userProfile->up_id)->first();

            if ($userProfile && $memberUser) {
                if ($userProfile->up_usertype == 1) {
                    $userProfile->update([
                        'up_fullname'   => $request->input('up_fullname'),
                        'up_title'      => $request->input('title'),
                        'up_mykad'      => $request->input('mykad'),
                        'up_designation' => $request->input('designation'),
                        'up_gender'     => $request->input('gender'),
                        'up_contactno'  => $request->input('mobileno'),
                        'up_emailadd'   => $request->input('emailadd'),
                        'up_profq'      => $request->input('up_profq'),
                        'up_address'    => $request->input('up_address'),
                        'up_city'       => $request->input('up_city'),
                        'up_state'      => $request->input('up_state'),
                        'up_postcode'   => $request->input('up_postcode'),
                        'up_country'    => $request->input('up_country'),
                        'up_sec_name'   => $request->input('up_sec_name'),
                        'up_sec_title'  => $request->input('up_sec_title'),
                        'up_sec_email'  => $request->input('up_sec_email'),
                        'up_sec_mobile' => $request->input('up_sec_mobile')
                    ]);

                    // Update user data
                    $memberUser->update([
                        'ml_username' => $request->input('mykad'),
                        'ml_emailadd' => $request->input('emailadd'),
                    ]);
                } else {
                    $userProfile->update([
                        'up_fullname'   => $request->input('adminname'),
                        'up_title'      => $request->input('admintitle'),
                        'up_designation' => $request->input('adminpost'),
                        'up_contactno'  => $request->input('adminmobile'),
                        'up_emailadd'   => $request->input('adminemail'),
                    ]);

                    // Update memberUser email
                    $memberUser->update([
                        'ml_emailadd' => $request->input('adminemail'),
                    ]);
                }

                DB::commit();

                if ($userProfile->up_usertype == 1) {
                    logSystem($user->id, 'Edit', $userProfile->toArray(), 'MemberProfile');
                    logSystem($user->id, 'Edit', $memberUser->toArray(), 'ChgRepProfileUsername');
                } else {
                    logSystem($user->id, 'Edit', $userProfile->toArray(), 'MemberProfileAdmin');
                    logSystem($user->id, 'Edit', $memberUser->toArray(), 'ChgRepProfileAUsername');
                }
                return response()->json(['status' => true, 'message' => 'User updated successfully!'], 200);
            }

            return response()->json(['message' => 'Failed to update user'], 404);
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            Log::error('Error in updating member user: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updateing the user. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteUser(Request $request)
    {
        if (Auth::user()->cannot('memberusers-delete')) {
            return response()->json(['status' => false, 'message' => 'You don\'t have permission to delete member users'], 403);
        }

        if (!isset($request->id) || empty($request->id)) {
            return response()->json(['message' => 'Failed to delete user'], 404);
        }

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $memberProfile = MemberUserProfile::find($request->id);
            if (!$memberProfile) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $memberUsers = MemberUser::where('ml_uid', $request->id)->get();

            if ($memberUsers->isEmpty()) {
                return response()->json(['message' => 'Member user not found'], 404);
            }

            foreach ($memberUsers as $memberUser) {
                $memberUser->delete();
                logSystem($user->id, 'Delete', $memberUser->toArray(), 'MMUser');
            }

            // Delete member profile
            $r = $memberProfile->delete();

            DB::commit();

            // Log the deletion
            logSystem($user->id, 'Delete', $memberProfile->toArray(), 'MMProfile');

            if ($r) {
                return response()->json(['status' => true, 'message' => 'User deleted successfully!'], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error
            Log::error('Error in deleting member user: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the user. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addmmOffUser(Request $request)
    {
        $mid = $request->mid;

        $salutations = Salutation::orderBy('sname', 'asc')->pluck('sname', 'sid');

        $states = State::orderBy('state_name', 'asc')->pluck('state_name', 'state_id');

        $countries = Country::orderBy('country_name', 'asc')->pluck('country_name', 'country_id');

        $genders = Gender::pluck('gname', 'gid');

        return view('backend.members.add-offrep-member', compact('salutations', 'genders', 'states', 'countries', 'mid'));
    }

    public function postAddmmOffUser(OffRepMemberUserRequest $request)
    {
        if ($request->ajax() && $request->mid) {
            $data = $request->all();
            $result = $this->memberService->addMmOffUser($data);
            return response()->json($result);
        }
        return response()->json(['status' => false, 'message' => __('Invalid Request'), 'data' => []], 400);
    }

    public function addmmAdmUser(Request $request)
    {
        $mid = $request->mid;
        $salutations = Salutation::orderBy('sname', 'asc')->pluck('sname', 'sid');

        return view('backend.members.add-admin-member', compact('salutations', 'mid'));
    }

    public function postAddmmAdmUser(AdminMemberUserRequest $request)
    {
        if ($request->ajax() && $request->mid) {
            $data = $request->all();
            $result = $this->memberService->addMmAdmUser($data);
            return response()->json($result);
        }
        return response()->json(['status' => false, 'message' => __('Invalid Request'), 'data' => []], 400);
    }
}
