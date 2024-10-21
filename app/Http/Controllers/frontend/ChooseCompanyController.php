<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberUser;
use Illuminate\Http\Request;

class ChooseCompanyController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        $upMidList = MemberUser::join('member_userprofiles', 'member_users.ml_uid', '=', 'member_userprofiles.up_id')
        ->where('member_users.ml_username', auth()->user()->ml_username)
        ->groupBy('member_userprofiles.up_mid')
        ->orderBy('member_userprofiles.up_mid', 'asc')
        ->pluck('member_userprofiles.up_mid')->toArray();

        // dd($upMidList);
        if(count($upMidList) > 1) {
            return view('frontend.choosecompany.index', compact('upMidList'));
        } else if(count($upMidList)==1){
            session([ 'compid' => $upMidList[0] ]);

            if(session('compid') && session('compid') != null) {

                return redirect(route('bulletin.index'));
            } else {
                return redirect(route('logout'));
            }
        } else {
            return redirect(route('login'));
        }

    }

    public function saveAccount(Request $request)
    {
        $request->validate([
            'chooseCompany' => 'required'
        ],[
            'chooseCompany' => 'Please Select Your Company.',
        ]);

        session(['compid' => $request->chooseCompany]);

        return redirect(route('bulletin.index'));
    }
}

?>