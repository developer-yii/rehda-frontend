<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;

class BranchNewsletterController extends Controller
{
    public function index()
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        $newsletters = Newsletter::where('bu_status',2)->get();
        return view('frontend.branch-newsletter.index', compact('newsletters'));
    }
}