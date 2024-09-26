<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberCert;
use Illuminate\Http\Request;

class MembershipCertificateController extends Controller
{
    public function index()
    {
        $certificates = MemberCert::where('mc_mid', session('compid'))->orderBy('mc_yr', 'DESC')->get();
        return view('frontend.membership-certificate.index', compact('certificates'));
    }
}