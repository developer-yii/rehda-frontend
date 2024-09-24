<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\MemberComp;

class MemberRejectedRegistrationController extends Controller
{
    public function rejectedRegistration(Request $request)
    {
        if (!Auth::user()->can('memberusers-view')) {
            return redirect()->back()->with('error', 'You don\'t have permission to access rejected registration page');
        }

        // Check if it's an AJAX request for DataTables
        if ($request->ajax()) {
            $user = Auth::user();

            $query = MemberComp::with('member')
                ->where('d_status', 3);

            return DataTables::of($query)
                ->editColumn('d_created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->d_created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('member_type', function ($row) {
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
                    if ($user->can('activemembers-edit')) {
                        $buttons .= "
                            <a target='_blank' onclick=\"window.open('" . route('mm-userlists.userlists', ['pid' => $row->did]) . "', 'pagename', 'resizable=no,height=600,width=800'); return false;\" class='btn btn-primary btn-xs mb-1'><li class='fa fa-list me-1'></li> Users</a><br>";
                    }

                    return $buttons;
                })
                ->rawColumns(['details', 'supporting_docs', 'd_compname', 'actions'])
                ->make(true);
        }

        return view('backend.members.rejected-registrations');
    }

}
