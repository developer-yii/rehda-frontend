<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberComp;
use App\Models\Notice;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BranchCircularController extends Controller
{
    public function index(Request $request)
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $memberComp = MemberComp::with('member')->where('did', session('compid'))->first();
        $ctype = "notice";
        $memberType = $memberComp->member->m_type;
        $branchId = $memberComp->member->m_branch;
        $notices = Notice::where('ar_status', 2)
        // ->where(function ($query) use ($ctype, $memberType, $branchId) {
        //     // HQ Level condition
        //     $query->where(function ($subquery) use ($ctype, $memberType, $branchId) {
        //         $subquery->where('ar_level', 'HQ')
        //             ->whereIn('ar_id', function ($q) use ($ctype, $memberType) {
        //                 $q->select('cm_item')
        //                     ->from('content_mperm')
        //                     ->where('cm_item_type', $ctype)
        //                     ->where('cm_membertype', $memberType);
        //             })
        //             ->whereIn('ar_id', function ($q) use ($branchId, $ctype) {
        //                 $q->select('cp_item')
        //                     ->from('content_perm')
        //                     ->where('cp_branch', $branchId)
        //                     ->where('cp_item_type', $ctype);
        //             });
        //     })
        //     // Branch level condition
        //     ->orWhere(function ($subquery) use ($ctype, $memberType, $branchId) {
        //         $subquery->where('ar_level', 'Branch')
        //             ->where('ar_branchid', $branchId)
        //             ->whereIn('ar_id', function ($q) use ($ctype, $memberType) {
        //                 $q->select('cm_item')
        //                     ->from('content_mperm')
        //                     ->where('cm_item_type', $ctype)
        //                     ->where('cm_membertype', $memberType);
        //             });
        //     });
        // })
        ->orderBy('ar_date', 'desc');
        // ->get();

        if ($request->ajax()) {

            return DataTables::eloquent($notices)
            ->addColumn('date', function ($row) {
                return '<h3>('. date('d F Y', strtotime($row->ar_date)) .') '. $row->ar_name .'</h3><p>'. $row->ar_yr .'</p>';
            })
            ->addColumn('actions', function ($row) {
                $buttons = '';

                $buttons .= '<a href="'. config('app.backendurl').'storage/'.str_replace('../','',$row->ar_file_path) .'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1">View</a>';
                $buttons .= '<a href="'. config('app.backendurl').'storage/'.str_replace('../','',$row->ar_file_path) .'" target="_blank" download class="btn btn-outline-primary waves-effect">Download</a>';

                return $buttons;
            })
            ->rawColumns(['date', 'actions'])
            ->toJson();

        }

        $notices = $notices->get();

        return view('frontend.branch-circular.index', compact('notices'));
    }
}