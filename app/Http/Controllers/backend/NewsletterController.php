<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterRequest;
use App\Models\ContentPermissionBranch;
use App\Models\ContentPermissionMember;
use App\Models\MemberComp;
use App\Models\MemberType;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\NewsletterService;

class NewsletterController extends Controller
{

    protected $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }


    public function index(Request $request)
    {
        if (!auth()->user()->can('newsletter-view')) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        if ($request->ajax()) {
            return $this->newsletterService->getNewslettersDataTable();
        }
        return view('backend.newsletters.index');
    }

    public function create()
    {
        return view('backend.newsletters.create');
    }

    public function store(NewsletterRequest $request)
    {
        $result = $this->newsletterService->storeNewsletter($request);

        return response()->json($result);
    }

    public function edit(Request $request, $id)
    {
        $data = Newsletter::find($id);
        return view('backend.newsletters.edit', compact('data'));
    }

    public function update(NewsletterRequest $request)
    {
        $result = $this->newsletterService->updateNewsletter($request);

        return response()->json($result);
    }

    public function destroy(Request $request)
    {
        $result = $this->newsletterService->destroyNewsletter($request->id);

        return response()->json($result);
    }

    public function membership(Request $request)
    {
        return $this->newsletterService->getMembershipData($request);
    }

    public function membershipPermisionDelete(Request $request)
    {

        $cm_id = $request->id;

        $result = $this->newsletterService->deleteMembershipPermission($cm_id);

        return $result;
    }

    public function membershipPermissionStore(Request $request)
    {
        $selectedValues = $request->selectedValues;
        $cmTitle = $request->cm_title;
        $cmId = $request->cm_id;

        // Call the service method
        $result = $this->newsletterService->storeMembershipPermission($selectedValues, $cmTitle, $cmId);

        return $result;
    }

    public function sortTable(Request $request)
    {
        $newsletters = Newsletter::orderBy('bu_sorting', 'asc')->get();

        return view('backend.newsletters.sort', compact('newsletters'));
    }

    public function sortUpdate(Request $request)
    {
        $sortedIDs = $request->input('sortedIDs');
        $response = $this->newsletterService->updateSorting($sortedIDs);

        return response()->json($response);
    }

    public function branch(Request $request)
    {
        return $this->newsletterService->getBranchData($request);
    }

    public function branchPermisionDelete(Request $request)
    {

        $permissionBranch = ContentPermissionBranch::find($request->id);

        if (!$permissionBranch) {
            return ['status' => false, 'message' => 'Newsletter Branch Permission not found!'];
        }

        $permissionBranch->delete();

        return ['status' => true, 'message' => 'Newsletter Branch Permission deleted successfully!'];
    }

    public function branchPermissionStore(Request $request)
    {
        $selectedValues = $request->selectedValues;
        $cpTitle = $request->cp_title;
        $cpId = $request->cp_id;

        // Call the service method to store branch permissions
        $result = $this->newsletterService->storeBranchPermissions($cpId, $cpTitle, $selectedValues);

        return response()->json($result);
    }
}
