<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberCert;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MembershipCertificateController extends Controller
{
    public function index(Request $request)
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        if ($request->ajax()) {

            $certificates = MemberCert::where('mc_mid', session('compid'))->orderBy('mc_yr', 'DESC');

            return DataTables::eloquent($certificates)
            ->addColumn('date', function ($row) {
                return 'Membership Certificate '.$row->mc_yr;
            })
            ->addColumn('actions', function ($row) {
                $buttons = '';

                $buttons .= '<a href="'. config('app.backendurl').'storage/'.str_replace('../','',$row->mc_cert_path) .'" target="_blank" class="btn btn-outline-primary waves-effect me-2">View</a>';

                $buttons .= '<a href="'. config('app.backendurl').'storage/'.str_replace('../','',$row->mc_cert_path) .'" target="_blank" download class="btn btn-outline-primary waves-effect">Download</a>';

                return $buttons;
            })
            ->rawColumns(['date', 'actions'])
            ->toJson();
        }
        return view('frontend.membership-certificate.index');
    }
}