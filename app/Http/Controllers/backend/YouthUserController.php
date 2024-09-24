<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MemberComp;
use App\Models\MemberUserProfile;
use App\Models\MemberUser;

class YouthUserController extends Controller
{
    public function youthUsers(Request $request)
    {
        $user = Auth::user();


        if (!$user->can('memberusers-view')) {
            return redirect()->back()->with('error', 'You don\'t have permission to access ordinary users page');
        }

        $companies = MemberComp::orderBy('d_compname')->groupBy('d_compname')->pluck('d_compname', 'd_compname');

        $query = MemberUserProfile::select(
            'member_userprofiles.*',
            'member_users.ml_username',
            'member_users.ml_id',
            'member_users.ml_status',
            'member_comps.d_status',
            'member_comps.d_compname',
            'member_comps.d_mid',
            'members.m_type',
            'members.m_branch',
            'member_types.typename'
        )
            ->join('member_users', 'member_userprofiles.up_id', '=', 'member_users.ml_uid')
            ->join('member_comps', 'member_comps.did', '=', 'member_userprofiles.up_mid')
            ->join('members', 'member_comps.d_mid', '=', 'members.mid')
            ->join('member_types', 'members.m_type', '=', 'member_types.mt_id')
            ->where('members.m_type', 6);


        if ($user->hasRole('BranchAdmin')) {
            $query->where('members.m_branch', $user->branchid);
        } elseif (chkAdminAccess() != 1) {
            return redirect()->back()->with('error', 'You don\'t have permission to access edit members profile page');
        }

        if ($request->get('export') === 'csv') {
            return $this->exportToCsv($query);
        }
        // Check if it's an AJAX request for DataTables
        if ($request->ajax()) {


            return DataTables::eloquent($query)
                ->addColumn('member_type', function ($row) {
                    return $row->memberComp->member->memberType->typename ?? null;
                })
                ->addColumn('user_type', function ($row) {
                    return getMemberUserType($row->up_usertype);
                })
                ->addColumn('full_name', function ($row) {
                    return getTitle($row->up_title) . ' ' . $row->up_fullname;
                })
                ->addColumn('gender', function ($row) {
                    return getGender($row->up_gender);
                })
                ->addColumn('secretary_detail', function ($row) {
                    return getTitle($row->up_sec_title) . ' ' . $row->up_sec_name . '<br>' . $row->up_sec_email . '<br>' . $row->up_sec_mobile;
                })
                ->addColumn('company_status', function ($row) {
                    return getMCStatus($row->d_status);
                })
                ->addColumn('user_status', function ($row) {
                    return getMMStatus($row->ml_status);
                })
                ->addColumn('actions', function ($row) use ($request, $user) {
                    $buttons = '';
                    if ($user->can('memberusers-edit')) {
                        $buttons .= "<a href='javascript:void(0);' data-username='" . $row->ml_username . "' data-pid='" . $row->up_mid . "' data-mid='" . $row->up_id . "' class='btn btn-outline-secondary btn-xs mb-1 w-max change-password'><li class='fa fa-edit me-1'></li> Reset Password</a><br>";

                        $buttons .= "<a href='" . route('active-members.editUser', ['id' => $row->ml_id, 'mid' => $row->up_mid]) . "' class='btn btn-xs btn-info mb-1'><li class='fa fa-edit me-1'></li> Edit</a><br>";
                    }
                    if ($user->can('memberusers-delete')) {
                        $buttons .= '<a href="javascript:void(0);" class="btn btn-danger btn-xs del-usr" data-id="' . $row->up_id . '"><i class="fa fa-trash me-1"></i> Del</a><br>';
                    }
                    return $buttons;
                })
                ->rawColumns(['user_status', 'secretary_detail', 'company_status', 'actions'])
                ->toJson();
        }

        return view('backend.members.users.youth', compact('companies'));
    }

    private function exportToCsv($query)
    {
        $filename = 'ListingYouthUsers' . now()->format('YmdHis') . 'Export.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = [
            'Company Name',
            'Company Status',
            'Member Type',
            'User Type',
            'Full Name',
            'MyKad',
            'Designation',
            'Gender',
            'Professional Qualification',
            'Email',
            'Contact No',
            'Address',
            'Secretary Details',
            'User Status'
        ];

        $callback = function () use ($query, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($query->cursor() as $row) {
                $data = [
                    $row->d_compname,
                    getMCStatusCSV($row->d_status),
                    $row->typename,
                    getMemberUserType($row->up_usertype),
                    getTitle($row->up_title) . ' ' . $row->up_fullname,
                    $row->up_mykad,
                    $row->up_designation,
                    getGender($row->up_gender),
                    $row->up_profq,
                    $row->up_emailadd,
                    $row->up_contactno,
                    $row->up_address,
                    getTitle($row->up_sec_title) . ' ' . $row->up_sec_name . ' ' . $row->up_sec_email . ' ' . $row->up_sec_mobile,
                    getMMStatusCSV($row->ml_status)
                ];
                fputcsv($file, $data);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
