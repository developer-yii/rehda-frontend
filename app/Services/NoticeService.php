<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\ContentPermissionBranch;
use App\Models\ContentPermissionMember;
use App\Models\MemberType;
use Illuminate\Http\Request;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class NoticeService
{
    public function getNotices()
    {
        $hq = 'HQ';
        $user = Auth::user();
        $isAdmin = chkAdminAccess() == 1;

        if ($user->hasRole('BranchAdmin')) {
            $notices = Notice::with('branchName')
                ->where('ar_branchid', $user->branchid)
                ->orWhere('ar_level', $hq)
                ->orderBy('ar_id', 'desc')
                ->get();
        } elseif (chkAdminAccess() == 1) {
            $notices = Notice::with('branchName')
                ->orderBy('ar_id', 'desc')
                ->get();
        } else {
            return collect(); // Return an empty collection if no conditions are met
        }

        return datatables()->of($notices)
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->ar_date)->format('d F Y');
            })
            ->addColumn('title', function ($data) {
                $pdfPath = str_replace('../', '', $data->ar_file_path);
                $pdfUrl = asset('storage/' . $pdfPath);
                $name = $data->ar_name ?? '-';
                return $name . ' <a href="' . $pdfUrl . '" target="_blank"><i class="fa fa-external-link-square"></i></a>';
            })
            ->addColumn('level', function ($data) {
                return $data->ar_level ?? '-';
            })
            ->addColumn('branch', function ($data) {
                return $data->branchName->bname ?? '-';
            })
            ->addColumn('status', function ($data) {
                return $data->ar_status == 2
                    ? '<span class="badge bg-success btn-xs">Publish</span>'
                    : '<span class="badge bg-primary btn-xs">Draft</span>';
            })
            ->addColumn('actions', function ($data) use ($user,$isAdmin) {
                $buttons = '';
                if (auth()->user()->can('notices-edit')) {
                    if(($user->branchid == $data->ar_branchid && $user->hasRole('BranchAdmin')) || $isAdmin){
                        $buttons .= '<a href="' . route('notices.edit', ['id' => $data->ar_id]) . '" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('translation.label_edit') . '" class="btn btn-primary btn-xs mb-1"><i class="fas fa-edit me-1"></i>Edit</a>';

                    }
                }

                if (auth()->user()->can('contentpermission-edit') && $data->ar_level == 'HQ') {
                    if(($user->branchid == $data->ar_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><a href="javascript:void(0)" class="btn btn-secondary btn-xs mb-1 notice-branch-permission" data-id="' . $data->ar_id . '" data-title="notice" style="width: 140px;"><i class="fa-regular fa-credit-card me-1"></i>Branch Permission</a>';
                    }
                }

                if(auth()->user()->can('contentpermissionmember-edit')) {
                    if(($user->branchid == $data->ar_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><a href="javascript:void(0)" class="btn btn-secondary btn-xs mb-1 notice-membership-permission" data-id="' . $data->ar_id . '" data-title="notice" style="width: 167px;"><i class="fa-regular fa-credit-card me-1"></i>Membership Permission</a>';
                    }
                }
                if (auth()->user()->can('notices-delete')) {
                    if(($user->branchid == $data->ar_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><button class="btn btn-danger btn-xs noticedelete" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('translation.label_delete') . '" id="' . $data->ar_id . '" name="delete"><i class="fa fa-trash me-1"></i>Delete</button>';
                    }
                }
                return $buttons;
            })
            ->rawColumns(['date', 'title', 'level', 'branch', 'status', 'actions'])
            ->make(true);
    }

    public function createNotice($data)
    {
        $user = Auth::user();
        $input = $data->except('_token', 'ar_file_path');

        if (chkAdminAccess() == 1) {
            $input['ar_level'] = "HQ";
            $input['ar_branchid'] = null;
        } else if ($user->hasRole('BranchAdmin')) {
            $input['ar_level'] = "Branch";
            $input['ar_branchid'] = $user->branchid;
        }

        // Upload PDF file
        if ($data->hasFile('ar_file_path')) {
            $filePdf = $data->file('ar_file_path');
            $originalPdfName = pathinfo($filePdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extensionPdf = strtolower($filePdf->getClientOriginalExtension());
            $newPdfFilename = $originalPdfName . '-' . now()->format('YmdHis') . '.' . $extensionPdf;
            $pdfPath = $filePdf->storeAs('uploads/notices', $newPdfFilename, 'public');
            $input['ar_file_path'] = $pdfPath;
        }

        return Notice::create($input);
    }


    public function updateNotice($data)
    {
        $user = Auth::user();
        $input = $data->except('_token', 'ar_id');

        if (chkAdminAccess() == 1) {
            $input['ar_level'] = "HQ";
            $input['ar_branchid'] = null;
        } else if ($user->hasRole('BranchAdmin')) {
            $input['ar_level'] = "Branch";
            $input['ar_branchid'] = $user->branchid;
        }

        $notice = Notice::find($data->ar_id);
        if (!$notice) {
            return ['status' => false, 'message' => 'Notice not found.'];
        }

        // Upload PDF file
        if ($data->hasFile('ar_file_path')) {
            if ($notice->ar_file_path && Storage::disk('public')->exists($notice->ar_file_path)) {
                Storage::disk('public')->delete($notice->ar_file_path);
            }
            $filePdf = $data->file('ar_file_path');
            $originalPdfName = pathinfo($filePdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extensionPdf = strtolower($filePdf->getClientOriginalExtension());
            $newPdfFilename = $originalPdfName . '-' . now()->format('YmdHis') . '.' . $extensionPdf;
            $pdfPath = $filePdf->storeAs('uploads/notices', $newPdfFilename, 'public');
            $input['ar_file_path'] = $pdfPath;
        }

        $notice->update($input);

        return ['status' => true, 'message' => 'Notice updated successfully!'];
    }

    public function deleteNotice($id)
    {
        $notice = Notice::find($id);

        if ($notice) {
            // Delete the associated PDF file if it exists
            if ($notice->ar_file_path && Storage::disk('public')->exists($notice->ar_file_path)) {
                Storage::disk('public')->delete($notice->ar_file_path);
            }

            ContentPermissionMember::where('cm_item',$id)->where('cm_item_type','notice')->delete();

            $notice->delete();

            return ['status' => true, 'message' => 'Notice deleted successfully!'];
        } else {
            return ['status' => false, 'message' => 'Notice not found!'];
        }
    }

    public function getMembershipData(Request $request)
    {
        $cm_item = $request->id;
        $cm_item_type = $request->title;

        $permissionMember = ContentPermissionMember::with('memberTypeName')
            ->where('cm_item_type', $cm_item_type)
            ->where('cm_item', $cm_item)
            ->get();

        // Use pluck() to extract the 'cm_membertype' values into an array
        $memberTypeIds = $permissionMember->pluck('cm_membertype')->toArray();

        // Now use the extracted array in the whereNotIn query
        $memberTypes = MemberType::whereNotIn('mt_id', $memberTypeIds)->get();

        $html = view('backend.notices.permission', compact('memberTypes', 'permissionMember', 'cm_item', 'cm_item_type'))->render();

        return ['status' => true, 'message' => 'Permission Fetch successfully!', 'data' => $html];
    }

    public function storeMembershipPermissions($cmId, $cmTitle, $selectedValues)
    {
        if (count($selectedValues) > 0) {
            foreach ($selectedValues as $memberType) {
                $permission = new ContentPermissionMember();
                $permission->cm_item = $cmId;
                $permission->cm_item_type = $cmTitle;
                $permission->cm_membertype = $memberType;
                $permission->save();
            }
        }

        return ['status' => true, 'message' => 'Notice Member Permission stored successfully!'];
    }

    public function getBranchData(Request $request)
    {
        $cp_item = $request->id;
        $cp_item_type = $request->title;

        $permissionBranch = ContentPermissionBranch::with('BranchName')
            ->where('cp_item_type', $cp_item_type)
            ->where('cp_item', $cp_item)
            ->get();

        // Use pluck() to extract the 'cp_branch' values into an array
        $BranchIds = $permissionBranch->pluck('cp_branch')->toArray();

        // Now use the extracted array in the whereNotIn query
        $branchs = Branch::whereNotIn('bid', $BranchIds)->get();

        $html = view('backend.notices.branchPermission', compact('branchs', 'permissionBranch', 'cp_item', 'cp_item_type'))->render();
        return ['status' => true, 'message' => 'Permission Fetch successfully!', 'data' => $html];
    }

    public function storeBranchPermissions($cpId, $cpTitle, $selectedValues)
    {
        if (count($selectedValues) > 0) {
            foreach ($selectedValues as $branch) {
                $permission = new ContentPermissionBranch();
                $permission->cp_item = $cpId;
                $permission->cp_item_type = $cpTitle;
                $permission->cp_branch = $branch;
                $permission->save();
            }
        }

        return ['status' => true, 'message' => 'Notice Branch Permission stored successfully!'];
    }

}
