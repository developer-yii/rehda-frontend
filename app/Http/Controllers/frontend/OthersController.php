<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberComp;
use App\Models\Paper;
use Illuminate\Http\Request;

class OthersController extends Controller
{
    public function index(Request $request)
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $memberComp = MemberComp::with('member')->where('did', session('compid'))->first();
        $memberType = $memberComp->member->m_type;
        $branchId = $memberComp->member->m_branch;
        $ctype = "paper";

        $papers = Paper::where('ar_status', 2)
        ->where(function ($query) use ($ctype, $memberType, $branchId) {
            $query->whereIn('ar_id', function ($subquery) use ($ctype, $memberType) {
                $subquery->select('cm_item')
                    ->from('content_mperm')
                    ->where('cm_item_type', $ctype)
                    ->where('cm_membertype', $memberType);
            })
            ->whereIn('ar_id', function ($subquery) use ($branchId, $ctype) {
                $subquery->select('cp_item')
                    ->from('content_perm')
                    ->where('cp_branch', $branchId)
                    ->where('cp_item_type', $ctype);
            });
        })
        ->orderBy('ar_sorting', 'asc')
        ->get();
        return view('frontend.others.index', compact('papers'));
    }
}