<?php

namespace App\Http\Controllers;

use App\Models\BranchAnnualReport;
use App\Models\MemberComp;
use App\Models\MemberUser;
use App\Models\MemberUserProfile;
use Illuminate\Http\Request;

class BranchAnnualreportController extends Controller
{
    public function index()
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $membercomp = MemberComp::with('member')->where('did', session('compid'))->first();

        $cm_item_type = 'annualreport';
        $cm_membertype = $membercomp->member->m_type;
        $cp_branch = $membercomp->member->m_branch;
        $cp_item_type = 'annualreport';


        $annualreports = BranchAnnualReport::where('status', 2)
        ->whereIn('id', function($query) use ($cm_item_type, $cm_membertype) {
            $query->select('cm_item')
                ->from('content_mperm')
                ->where('cm_item_type', $cm_item_type)
                ->where('cm_membertype', $cm_membertype);
        })
        ->whereIn('id', function($query) use ($cp_branch, $cp_item_type) {
            $query->select('cp_item')
                ->from('content_perm')
                ->where('cp_branch', $cp_branch)
                ->where('cp_item_type', $cp_item_type);
        });

        if(auth()->user()->ml_priv == "OfficeRep") {
            $user = MemberUser::whereHas('memberUserProfile', function ($query) {
                $query->where('up_mid', session('compid'));
            })
            ->where('ml_username', auth()->user()->ml_username)
            ->where('ml_priv', "OfficeRep")
            ->where('ml_status', 1)
            ->first();
            $memberComp = MemberComp::with('member')->where('did', session('compid'))->first();
        } else {
            $user = auth()->user();
            $memberComp = MemberComp::with('member')->where('did', session('compid'))->first();
        }
        if($user) {
            $profile = MemberUserProfile::where('up_id', $user->ml_uid)->first();
            if($profile){
                $branch = getMemberBranch(getMemberBid(getMemberDid($profile->up_mid)));
                if(strtolower($branch) != "johor" && $memberComp && $memberComp->member && $memberComp->member->m_branch){
                    $annualreports->where('branchid', $memberComp->member->m_branch);
                }
            }
        }

        $annualreports = $annualreports->orderBy('sorting', 'asc')->get();

        return view('frontend.branch-annualreport.index', compact('annualreports'));
    }
}
