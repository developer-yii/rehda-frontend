<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberComp;
use App\Models\MemberUserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChooseCompanyController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        // $userProfiles = MemberUserProfile::where('up_mid', $currentUser->ml_id)->groupBy('up_mid')->orderBy('up_mid')->get();

        $userProfiles = MemberUserProfile::select(
            'up_mid',
            DB::raw('MIN(up_id) as up_id'),          // Get the minimum up_id for each up_mid
            DB::raw('MIN(up_fullname) as up_fullname') // Get the minimum up_fullname for each up_mid
        )
        ->where('up_mid', $currentUser->ml_id)
        ->groupBy('up_mid') // Group by up_mid
        ->orderBy('up_mid')
        ->get();

        // dd($userProfiles);
        // $userProfiles = $userProfiles->groupBy('up_mid');
        // dd($userProfiles);

        return view('frontend.choosecompany.index', compact('userProfiles'));
    }

    public function saveAccount(Request $request)
    {
        session(['compid' => $request->chooseCompany]);

        return redirect(route('bulletin.index'));
    }
}

?>