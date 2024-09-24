<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Models\ContentPermissionBranch;
use App\Models\ContentPermissionMember;
use App\Models\MemberType;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\NoticeService;


class NoticeController extends Controller
{

    protected $noticeService;

    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }



    public function index(Request $request)
    {
        if (!auth()->user()->can('notices-view')) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        if ($request->ajax()) {
            if ($request->ajax()) {
                return $this->noticeService->getNotices();
            }
        }
        return view('backend.notices.index');
    }

    public function create()
    {
        return view('backend.notices.create');
    }

    public function store(NoticeRequest $request)
    {
        $notice = $this->noticeService->createNotice($request);

        return response()->json(['status' => true, 'message' => 'Notice created successfully!']);
    }

    public function edit(Request $request, $id)
    {
        $data = Notice::find($id);
        return view('backend.notices.edit', compact('data'));
    }

    public function update(NoticeRequest $request)
    {
        $result = $this->noticeService->updateNotice($request);

        return response()->json($result);
    }


    public function delete(Request $request)
    {
        $result = $this->noticeService->deleteNotice($request->id);

        return response()->json($result);
    }

    public function membership(Request $request)
    {
        return $this->noticeService->getMembershipData($request);
    }

    public function membershipPermisionDelete(Request $request)
    {

        $permissionMember = ContentPermissionMember::find($request->id);

        if (!$permissionMember) {
            return ['status' => false, 'message' => 'Notice Member Permission not found!'];
        }

        $permissionMember->delete();

        return ['status' => true, 'message' => 'Notice Member Permission deleted successfully!'];
    }

    public function membershipPermissionStore(Request $request)
    {
        $selectedValues = $request->selectedValues;
        $cmTitle = $request->cm_title;
        $cmId = $request->cm_id;

        // Call the service method to store membership permissions
        $result = $this->noticeService->storeMembershipPermissions($cmId, $cmTitle, $selectedValues);

        return response()->json($result);
    }

    public function branch(Request $request)
    {
        return $this->noticeService->getBranchData($request);
    }

    public function branchPermisionDelete(Request $request)
    {

        $permissionBranch = ContentPermissionBranch::find($request->id);

        if (!$permissionBranch) {
            return ['status' => false, 'message' => 'Notice Branch Permission not found!'];
        }

        $permissionBranch->delete();

        return ['status' => true, 'message' => 'Notice Branch Permission deleted successfully!'];
    }

    public function branchPermissionStore(Request $request)
    {
        $selectedValues = $request->selectedValues;
        $cpTitle = $request->cp_title;
        $cpId = $request->cp_id;

        // Call the service method to store branch permissions
        $result = $this->noticeService->storeBranchPermissions($cpId, $cpTitle, $selectedValues);

        return response()->json($result);
    }
}
