<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\MemberComp;
use App\Models\PlanTier;
use App\Models\State;
use Illuminate\Http\Request;

class CompanyinfoController extends Controller
{
    public function index()
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $memberComp = MemberComp::with('member')->where('did', session('compid'))->first();
        $states = State::orderBy('state_name', 'ASC')->get();
        $countries = Country::orderBy('country_id', 'ASC')->get();
        $paidups = PlanTier::orderBy('pt_id', 'ASC')->get();
        return view('frontend.companyinfo.index', compact('memberComp', 'states', 'countries', 'paidups'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            // 'state' => 'required',
            'postcode' => 'required',
            'country' => 'required',
            'official_website' => 'required',
            'office_no' => 'required',
            'date_of_company_formation' => 'required',
            // 'latest_paid_up_capital' => 'required',
        ]);

        $memberComp = MemberComp::where('did',session('compid'))->first();
        $memberComp->d_compadd = $request->address;
        $memberComp->d_compaddcity = $request->city;
        $memberComp->d_compaddstate = $request->state ?? 0;
        $memberComp->d_compaddpcode = $request->postcode;
        $memberComp->d_compaddcountry = $request->country;
        $memberComp->d_comp_weburl = $request->official_website;
        $memberComp->d_offno = $request->office_no;
        $memberComp->d_faxno = $request->faxno;
        $memberComp->d_datecompform = $request->date_of_company_formation;
        $memberComp->d_mod_at = date("Y-m-d H:i:s");
        $memberComp->d_mod_by = auth()->user()->ml_id;
        $memberComp->save();

        return redirect()->route('companyinfo.index')->with('success', 'Data updated successfully!');
    }
}