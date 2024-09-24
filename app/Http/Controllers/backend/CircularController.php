<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CircularRequest;
use App\Models\Circular;
use App\Models\ContentPermissionBranch;
use App\Models\ContentPermissionMember;
use App\Services\CircularService;
use Illuminate\Http\Request;

class CircularController extends Controller
{
    protected $circularService;

    public function __construct(CircularService $circularService)
    {
        $this->circularService = $circularService;
    }

    public function index(Request $request)
    {
        if (!auth()->user()->can('circulars-view')) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        if ($request->ajax()) {
            if ($request->ajax()) {
                return $this->circularService->getCircular();
            }
        }
        return view('backend.circulars.index');
    }

    public function create()
    {
        return view('backend.circulars.create');
    }

    public function store(CircularRequest $request)
    {
        $circular = $this->circularService->createCircular($request);

        return response()->json(['status' => true, 'message' => 'Circular created successfully!']);
    }

    public function edit(Request $request, $id)
    {
        $data = Circular::find($id);
        return view('backend.circulars.edit', compact('data'));
    }

    public function update(CircularRequest $request)
    {
        $result = $this->circularService->updateCircular($request);

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $result = $this->circularService->deleteCircular($request->id);
        return response()->json($result);
    }

    public function membership(Request $request)
    {
        return $this->circularService->getMembershipData($request);
    }

    public function membershipPermisionDelete(Request $request)
    {

        $permissionMember = ContentPermissionMember::find($request->id);

        if (!$permissionMember) {
            return ['status' => false, 'message' => 'Circular Member Permission not found!'];
        }

        $permissionMember->delete();

        return ['status' => true, 'message' => 'Circular Member Permission deleted successfully!'];
    }

    public function membershipPermissionStore(Request $request)
    {
        $selectedValues = $request->selectedValues;
        $cmTitle = $request->cm_title;
        $cmId = $request->cm_id;

        // Call the service method to store membership permissions
        $result = $this->circularService->storeMembershipPermissions($cmId, $cmTitle, $selectedValues);

        return response()->json($result);
    }

    public function branch(Request $request)
    {
        return $this->circularService->getBranchData($request);
    }

    public function branchPermisionDelete(Request $request)
    {

        $permissionBranch = ContentPermissionBranch::find($request->id);

        if (!$permissionBranch) {
            return ['status' => false, 'message' => 'Circular Branch Permission not found!'];
        }

        $permissionBranch->delete();

        return ['status' => true, 'message' => 'Circular Branch Permission deleted successfully!'];
    }

    public function branchPermissionStore(Request $request)
    {
        $selectedValues = $request->selectedValues;
        $cpTitle = $request->cp_title;
        $cpId = $request->cp_id;

        // Call the service method to store branch permissions
        $result = $this->circularService->storeBranchPermissions($cpId, $cpTitle, $selectedValues);

        return response()->json($result);
    }
}
