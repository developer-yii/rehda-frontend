<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberComp;
use App\Models\MemberUser;
use App\Models\MemberUserProfile;
use App\Models\Newsletter;

class BranchNewsletterController extends Controller
{
    public function index()
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $newsletters = Newsletter::where('bu_status',2);

        $memberComp = MemberComp::with('member')->where('did', session('compid'))->first();

        if($memberComp && $memberComp->member && $memberComp->member->m_branch){
            $newsletters->where('bu_branchid', $memberComp->member->m_branch);
        }

        $newsletters = $newsletters->get();
        return view('frontend.branch-newsletter.index', compact('newsletters'));
    }
}