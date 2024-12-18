<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchContactDetailsController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('order','ASC')->get();
        return view('frontend.branch-contact-details.index', compact('branches'));
    }
}
