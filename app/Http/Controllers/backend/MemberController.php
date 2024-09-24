<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MemberRequest;
use App\Services\MemberService;
use App\Models\MemberComp;
use App\Models\Member;
use App\Models\MemberUserProfile;
use App\Models\Salutation;
use App\Models\State;
use App\Models\PlanTier;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Branch;

class MemberController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function newRegistration(Request $request)
    {
        if (!Auth::user()->can('memberusers-view')) {
            return redirect()->back()->with('error', 'You don\'t have permission to access new registration page');
        }

        $branches = Branch::orderBy('bname')->pluck('bname', 'bid');

        // Check if it's an AJAX request for DataTables
        if ($request->ajax()) {
            $user = Auth::user();

            $query = MemberComp::with('member')
                ->where('d_status', 2);

            return DataTables::of($query)
                ->editColumn('d_created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->d_created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('member_type', function ($row) {
                    // return getMembershipType($row->member->memberType);
                    return $row->member->memberType->typename ?? null;
                })
                ->addColumn('status', function ($row) {
                    return getMCStatus($row->d_status);
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
                ->addColumn('paid_up_capital', function ($row) {
                    return getCapital($row->d_paidcapital);
                })
                ->addColumn('supporting_docs', function ($row) {
                    $docs = [];
                    if (!empty($row->d_f9ssm) && $row->d_f9ssm != 1003) {
                        $docs[] = "<li><a href='" . asset('/storage') . "/" . $row->d_f9ssm . "' target='_blank'>SSM <i class='fa fa-link'></i></a></li>";
                    }
                    if (!empty($row->d_f24) && $row->d_f24 != 1003) {
                        $docs[] = "<li><a href='" . asset('/storage') . "/" . $row->d_f24 . "' target='_blank'>Form 24 <i class='fa fa-link'></i></a></li>";
                    }
                    if (!empty($row->d_f49) && $row->d_f49 != 1003) {
                        $docs[] = "<li><a href='" . asset('/storage') . "/" . $row->d_f49 . "' target='_blank'>Form 49 <i class='fa fa-link'></i></a></li>";
                    }
                    if (!empty($row->d_anualretuncopy) && $row->d_anualretuncopy != 1003) {
                        $docs[] = "<li><a href='" . asset('/storage') . "/" . $row->d_anualretuncopy . "' target='_blank'>Annual Return <i class='fa fa-link'></i></a></li>";
                    }
                    if (!empty($row->d_devlicense) && $row->d_devlicensecopy != 1003) {
                        $docs[] = "<li>Housing Developer's License No. <a href='" . asset('/storage') . "/" . $row->d_devlicensecopy . "' target='_blank'>{$row->d_devlicense} <i class='fa fa-link'></i></a></li>";
                    } else if (!empty($row->d_devlicense)) {
                        $docs[] = "<li>Housing Developer's License No. {$row->d_devlicense}</li>";
                    }
                    return "<ol>" . implode('', $docs) . "</ol>";
                })
                ->addColumn('actions', function ($row) use ($request, $user) {
                    $buttons = '';
                    if ($user->can('memberusers-edit')) {
                        $buttons .= "<a href='" . route('members.edit', $row->did) . "' class='btn btn-xs btn-info mb-1'><li class='fa fa-edit me-1'></li> Edit</a><br>
                            <button type='button' class='btn btn-success btn-xs approve-member mb-1' data-toggle='modal' data-id='{$row->did}'><i class='fa fa-check me-1'></i> Approve</button><br>
                            <a target='_blank' onclick=\"window.open('" . route('mm-userlists.userlists', ['pid' => $row->did]) . "', 'pagename', 'resizable=no,height=600,width=800'); return false;\" class='btn btn-primary btn-xs mb-1'><li class='fa fa-list me-1'></li> Users</a><br>
                            <a target='_blank' onclick=\"window.open('" . route('mm-userlists.billing', ['pid' => $row->did]) . "', 'pagename', 'resizable=no,height=600,width=800'); return false;\" class='btn btn-outline-secondary btn-xs mb-1'><li class='fa fa-list-alt me-1'></li> Invoices</a><br>";
                    }
                    if ($user->can('activemembers-delete')) {
                        $buttons .= "<a href='javascript:void(0);' class='btn btn-danger btn-xs reject-member' data-id='".$row->did."'><li class='fa fa-trash me-1'></li> Reject</a><br>";
                    }

                    return $buttons;
                })
                ->rawColumns(['details', 'supporting_docs', 'd_compname', 'actions'])
                ->make(true);
        }

        return view('backend.members.new-registrations', compact('branches'));
    }

    public function edit(Request $request, $mid)
    {
        // Check if the user is authorized to edit members
        if (!Auth::user()->can('memberusers-edit')) {
            return redirect()->back()->with('error', 'You have not permission to Edit members.');
        }

        if ($mid) {
            $data = MemberComp::select('member_comps.*', 'members.mid', 'members.m_type', 'members.m_approval_at', 'members.m_branch')
                ->join('members', 'members.mid', '=', 'member_comps.d_mid')
                ->where('member_comps.did', $mid)
                ->where('member_comps.d_status', 2)
                ->first();

            if (!$data) {
                return redirect()->back()->with('error', 'Data not found.');
            }
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

        return view('backend.members.edit-newRegistration', compact('mid','salutations', 'states', 'genders', 'countries', 'plantiers', 'ordinaryMembers', 'data','userProfiles'));
    }

    public function update(MemberRequest $request, $id)
    {
        if ($request->ajax() && $id) {
            $data = $this->memberService->updateMember($request, $id);
            return response()->json($data);
        }

        return response()->json(['status' => false, 'message' => __('Invalid Request'), 'data' => []], 400);
    }

    public function reject(Request $request)
    {
        if (!isset($request->oid) || empty($request->oid)) {
            return response()->json(['status' => false, 'message' => 'Request failed!'], 400);
        }

        // Check if the user is authorized to reject members
        if (!Auth::user()->can('activemembers-delete')) {
            return response()->json(['status' => false, 'message' => 'You have not permission to reject!'], 403);
        }

        $oid = $request->oid;

        // Find member_comp and related member
        $memberComp = MemberComp::where('did', $oid)
            ->where('d_status', 2)
            ->first();

        if ($memberComp) {
            // Update member_comp status to rejected (status = 3)
            $memberComp->d_status = 3;
            $memberComp->save();

            logSystem(auth()->id(), 'Reject', $memberComp->getChanges(), 'NewRegistration');

            return response()->json(['status' => true, 'message' => "Reject success"]);
        }
        return response()->json(['status' => false, 'message' => 'Request failed!'], 400);
    }
}
