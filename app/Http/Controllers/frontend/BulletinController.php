<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    public function index()
    {
        $bulletins = Bulletin::where('bu_status',2);

        if(auth()->user()->ml_priv == "CompanyAdmin"){
            $lastdigit = substr(auth()->user()->ml_username,-2);
            $year = '20'.$lastdigit;
            $bulletins->where('bu_yr','>=',$year);
        }

        $bulletins = $bulletins->get();

        return view('frontend.bulletin.index', compact('bulletins'));
    }
}

?>