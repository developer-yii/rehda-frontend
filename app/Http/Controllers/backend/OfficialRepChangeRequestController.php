<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OffRepChangeService;

class OfficialRepChangeRequestController extends Controller
{
    protected $offRepChangeService;

    public function __construct(OffRepChangeService $offRepChangeService)
    {
        $this->offRepChangeService = $offRepChangeService;
    }

    public function index(Request $request)
    {
        if (auth()->user()->cannot('changeoffrep-view')) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        if ($request->get('export') === 'csv') {
            return $this->offRepChangeService->exportToCsv();
        }

        if ($request->ajax()) {
            return $this->offRepChangeService->getRequests();
        }

        return view('backend.official-rep.change-requests');
    }

    public function approve(Request $request)
    {
        if (auth()->user()->cannot('changeoffrep-edit')) {
            return response()->json(['status' => false, 'message' => 'You don\'t have permission to approve request'], 403);
        }

        if ($request->ajax() && $request->id) {
            return $this->offRepChangeService->approve($request->id);
        }
        return response()->json(['status' => false, 'message' => __('Invalid Request'), 'data' => []], 400);

    }

    public function reject(Request $request)
    {
        if (auth()->user()->cannot('changeoffrep-edit')) {
            return response()->json(['status' => false, 'message' => 'You don\'t have permission to reject request'], 403);
        }

        if ($request->ajax() && $request->id) {
            return $this->offRepChangeService->reject($request->id);
        }
        return response()->json(['status' => false, 'message' => __('Invalid Request'), 'data' => []], 400);

    }
}
