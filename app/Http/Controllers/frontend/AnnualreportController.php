<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Annualreport;
use App\Models\MemberComp;
use Illuminate\Http\Request;

class AnnualreportController extends Controller
{
    public function index()
    {
        // if(auth()->user()->ml_priv == "CompanyAdmin"){
        //     return redirect(route('bulletin.index'));
        // }
        // $annualreports = Annualreport::where('ar_status',2)->get();

        if(session('compid') == null){
            return redirect(route('login'));
        }

        $membercomp = MemberComp::with('member')->where('did', session('compid'))->first();

        $cm_item_type = 'annualreport';
        $cm_membertype = $membercomp->member->m_type;
        $cp_branch = $membercomp->member->m_branch;
        $cp_item_type = 'annualreport';


        $annualreports = AnnualReport::where('ar_status', 2)
        ->whereIn('ar_id', function($query) use ($cm_item_type, $cm_membertype) {
            $query->select('cm_item')
                ->from('content_mperm')
                ->where('cm_item_type', $cm_item_type)
                ->where('cm_membertype', $cm_membertype);
        })
        ->whereIn('ar_id', function($query) use ($cp_branch, $cp_item_type) {
            $query->select('cp_item')
                ->from('content_perm')
                ->where('cp_branch', $cp_branch)
                ->where('cp_item_type', $cp_item_type);
        })
        ->orderBy('ar_sorting', 'asc')
        ->get();

        return view('frontend.annualreport.index', compact('annualreports'));
    }
}

?>