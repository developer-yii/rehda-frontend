<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\MemberService;
use App\Http\Requests\MemberRequest;
use App\Models\MemberComp;
use App\Models\MemberUserProfile;
use App\Models\Branch;
use App\Models\Salutation;
use App\Models\State;
use App\Models\PlanTier;
use App\Models\Country;
use App\Models\Gender;

class MemberInActiveRegistrationController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function inActiveMembers(Request $request)
    {
        $user = Auth::user();

        if (!$user->can('memberusers-view') && !$user->can('activemembers-view')) {
            return redirect()->back()->with('error', 'You don\'t have permission to access active members page');
        }

        $branches = Branch::orderBy('bname')->pluck('bname', 'bid');

        // Query based on user's privilege
        $query = MemberComp::with('member')
            ->where('d_status', 4);

        if ($user->hasRole('BranchAdmin')) {
            $query->whereHas('member', function($q) use ($user){
                $q->where('m_branch', $user->regid);
            });
        } elseif (chkAdminAccess() == 1) {
            // Admins can see all records
        } else {
            die;
        }

        // Check if it's an AJAX request for DataTables
        if ($request->ajax()) {

            if ($request->has('branch') && !empty($request->branch)) {
                $query->whereHas('member', function($q) use ($request) {
                    $q->where('m_branch', $request->branch);
                });
            }

            return DataTables::of($query)
                ->editColumn('m_approval_at', function ($row) {
                    return \Carbon\Carbon::parse($row->m_approval_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('member_type', function ($row) {
                    return $row->member->memberType->typename ?? null;
                })
                ->addColumn('branch_name', function ($row) {
                    return $row->member->branch->bname ?? null;
                })
                ->addColumn('membership_no', function ($row) {
                    return getMembershipNo($row->d_mid);
                })
                ->editColumn('d_compname', function ($row) {
                    return $row->d_compname . ($row->d_compssmno != '' ? "<br> " . $row->d_compssmno . "<br>" . getMCStatus($row->d_status) : "");
                })
                ->addColumn('parent_company', function ($row) {
                    return $row->d_parentcomp != 0 ? getMembershipNobyMID($row->d_parentcomp) : '-';
                })
                ->addColumn('details', function ($row) {
                    // Ensure that the URL includes the scheme (http or https)
                    $url = $row->d_comp_weburl;
                    if ($url && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
                        $url = "http://" . $url;
                    }
                    return "
                        <ul>
                            <li>Address: {$row->d_compadd} {$row->d_compaddcity} " .
                        getStatex($row->d_compaddstate) . " {$row->d_compaddpcode} " .
                        getCountryx($row->d_compaddcountry) . "</li>
                            <li>URL: " .
                        ($url ? "<a href='{$url}' target='_blank'>{$row->d_comp_weburl}</a>" : '') . "</li>
                            <li>Office No.: {$row->d_offno}</li>
                            <li>Fax No.: {$row->d_faxno}</li>
                        </ul>";
                })
                ->addColumn('actions', function ($row) use ($request, $user) {
                    $buttons = '';
                    if ($user->can('activemembers-edit')) {
                        $buttons .= "<a href='" . route('active-members.edit', $row->did) . "' class='btn btn-xs btn-info mb-1'><li class='fa fa-edit me-1'></li> Edit</a><br>";
                    }
                    if ($user->can('activememberprofile-edit')) {
                        $buttons .= "<a href='" . route('active-members.profile.edit', $row->did) . "' class='btn btn-xs btn-info mb-1'><li class='fa fa-edit me-1'></li> Edit</a><br>";
                    }
                    if ($user->can('certificates-edit')) {
                        $buttons .= "<a href='javascript:void(0)' target='_blank' data-id=".$row->did." class='btn btn-warning btn-xs mb-1 upload-cert'><li class='fa fa-list me-1'></li> Upload Cert</a><br>";
                    }

                    $buttons .= "<a href='javascript:void(0)' target='_blank' onClick=\"window.open('". route('active-members.member-info', ['pid' => $row->did]) ."','pagename','resizable=no,height=600,width=800'); return false;\" class='btn btn-success btn-xs mb-1'><i class='fa fa-eye me-1'></i> View More</a><br>";

                    if ($user->can('invoices-view')) {
                        $buttons .= "<a href='javascript:void(0)' target='_blank' onclick=\"window.open('" . route('mm-userlists.billing', ['pid' => $row->did]) . "', 'pagename', 'resizable=no,height=600,width=800'); return false;\" class='btn btn-outline-secondary btn-xs mb-1'><li class='fa fa-list-alt me-1'></li> Invoices</a><br>";
                    }

                    if ($user->can('statementaccount-view')) {
                        $buttons .= "<a href='javascript:void(0)' target='_blank' data-id='".$row->did."' class='btn btn-danger btn-xs mb-1 acc-statement'><li class='fa fa-list me-1'></li> Statement of Account</a><br>";
                    }

                    if ($user->can('membershipno-edit')) {
                        $buttons .= "<a href='javascript:void(0)' data-id='".$row->did."' class='btn btn-primary btn-xs change-mno'><i class='fa fa-edit me-1'></i> Change Membership No.</a>";
                    }



                    return $buttons;
                })
                ->rawColumns(['d_compname', 'actions','details'])
                ->make(true);
        }

        return view('backend.members.in-active', compact('branches'));
    }

    public function edit(Request $request, $mid)
    {
        // Check if the user is authorized to edit members
        if (!Auth::user()->can('activemembers-edit')) {
            return redirect()->back()->with('error', 'You have not permission to Edit members.');
        }

        if ($mid) {
            $data = MemberComp::select('member_comps.*', 'members.mid', 'members.m_type', 'members.m_approval_at', 'members.m_branch')
                ->join('members', 'members.mid', '=', 'member_comps.d_mid')
                ->where('member_comps.did', $mid)
                ->first();

            if (!$data) {
                return redirect()->back()->with('error', 'Data not found.');
            }

            $ordinaryMembers = MemberComp::select(
                'members.mid',
                'member_comps.d_compname',
                DB::raw("CONCAT(m_no_p1, m_no_p2, m_no_p3, m_no_p4, '/', m_no_p5) AS member_no")
            )
                ->join('members', 'members.mid', '=', 'member_comps.d_mid')
                ->where('m_no_p1', '!=', '')
                ->get();

            // Query to get user profiles
            $userProfiles = MemberUserProfile::where('up_mid', $mid)
                        ->orderBy('up_usertype', 'asc')
                        ->orderBy('up_id', 'asc')
                        ->get();

            $salutations = Salutation::pluck('sname', 'sid');

            $states = State::orderBy('state_name', 'asc')->pluck('state_name', 'state_id');

            $countries = Country::orderBy('country_name', 'asc')->pluck('country_name', 'country_id');

            $plantiers = PlanTier::pluck('pt_desc', 'pt_id');

            $genders = Gender::pluck('gname', 'gid');

            return view('backend.members.edit-active-member', compact('mid','salutations', 'states', 'genders', 'countries', 'plantiers', 'ordinaryMembers', 'data','userProfiles'));

        }
    }

    public function update(MemberRequest $request, $id)
    {
        if ($request->ajax() && $id) {
            $data = $this->memberService->updateActiveMember($request, $id);
            return response()->json($data);
        }

        return response()->json(['status' => false, 'message' => __('Invalid Request'), 'data' => []], 400);
    }

    public function profileEdit(Request $request)
    {
        pr($request->all());
    }
}
