<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Circular;
use App\Models\MemberComp;

class Circularcontroller extends Controller
{
    public function index()
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $memberComp = MemberComp::with('member')->where('did', session('compid'))->first();
        $member = $memberComp->member;
        $regdate = date('Y-m-d',strtotime(getMMRegDate(session('compid'))));
        $ctype = "circular";

        $circulers = Circular::where('ar_status', 2)
        // ->where('ar_date', '>=', $regdate)
        // ->where(function ($query) use ($ctype, $member) {
        //     // HQ level condition
        //     $query->where(function ($subquery) use ($ctype, $member) {
        //         $subquery->where('ar_level', 'HQ')
        //             ->whereIn('ar_id', function ($q) use ($ctype, $member) {
        //                 // Subquery for content_mperm
        //                 $q->select('cm_item')
        //                     ->from('content_mperm')
        //                     ->where('cm_item_type', $ctype)
        //                     ->where('cm_membertype', $member['member_type']);
        //             })
        //             ->whereIn('ar_id', function ($q) use ($ctype, $member) {
        //                 // Subquery for content_perm
        //                 $q->select('cp_item')
        //                     ->from('content_perm')
        //                     ->where('cp_branch', $member['branchid'])
        //                     ->where('cp_item_type', $ctype);
        //             });
        //     })
        //     // Branch level condition
        //     ->orWhere(function ($subquery) use ($ctype, $member) {
        //         $subquery->where('ar_level', 'Branch')
        //             ->where('ar_branchid', $member['branchid'])
        //             ->whereIn('ar_id', function ($q) use ($ctype, $member) {
        //                 // Subquery for content_mperm
        //                 $q->select('cm_item')
        //                     ->from('content_mperm')
        //                     ->where('cm_item_type', $ctype)
        //                     ->where('cm_membertype', $member['member_type']);
        //             });
        //     });
        // })
        // ->orderBy('ar_date', 'desc')
        ->get();

        return view('frontend.circular.index', compact('circulers'));
    }
}