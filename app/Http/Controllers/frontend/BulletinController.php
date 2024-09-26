<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    public function index()
    {
        $bulletins = Bulletin::where('bu_status',2)->get();

        return view('frontend.bulletin.index', compact('bulletins'));
    }
}

?>