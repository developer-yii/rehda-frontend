<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\ContentPermissionMember;
use App\Models\MemberType;
use Illuminate\Http\Request;
use App\Models\Circular;
use App\Models\ContentPermissionBranch;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CircularService
{
    public function getCircular()
    {
        $hq = 'HQ';
        $br = 'Branch';
        $user = Auth::user();
        $isBranchAdmin = $user->hasRole('BranchAdmin');
        $isAdmin = chkAdminAccess() == 1;

        if ($user->hasRole('BranchAdmin')) {
            $circulars = Circular::with('branchName')->where(function ($query) use ($br, $user) {
                $query->where('ar_branchid', $user->branchid)
                    ->where('ar_level', $br);
            })->orWhere('ar_level', $hq) // Make sure $hq is available in this scope
                ->orderBy('ar_id', 'desc')
                ->get();
        } elseif (chkAdminAccess() == 1) {
            $circulars = Circular::with('branchName')
                ->orderBy('ar_id', 'desc')
                ->get();
        } else {
            return collect(); // Return an empty collection if no conditions are met
        }

        return datatables()->of($circulars)
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->ar_date)->format('d F Y');
            })
            ->addColumn('title', function ($data) {
                $pdfPath = str_replace('../', '', $data->ar_file_path);
                $pdfUrl = asset('storage/' . $pdfPath);
                $name = $data->ar_name ?? '-';
                return $name . ' <a href="' . $pdfUrl . '" target="_blank"><i class="fa fa-external-link-square"></i></a>';
            })
            ->addColumn('desc', function ($data) {
                return $data->ar_yr ?? '-';
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
            ->addColumn('actions', function ($data) use ($user, $isAdmin) {
                $buttons = '';

                if (auth()->user()->can('circulars-edit')) {
                    if (($user->branchid == $data->ar_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<a href="' . route('circulars.edit', ['id' => $data->ar_id]) . '" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('translation.label_edit') . '" class="btn btn-primary btn-xs mb-1"><i class="fas fa-edit me-1"></i>Edit</a>';
                    }
                }

                if (auth()->user()->can('contentpermission-edit') && $data->ar_level == 'HQ') {
                    if (($user->branchid == $data->ar_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><a href="javascript:void(0)" class="btn btn-secondary btn-xs mb-1 circular-branch-permission" data-id="' . $data->ar_id . '" data-title="circular" style="width: 140px;"><i class="fa-regular fa-credit-card me-1"></i>Branch Permission</a>';
                    }
                }

                if (auth()->user()->can('contentpermissionmember-edit')) {
                    if (($user->branchid == $data->ar_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><a href="javascript:void(0)" class="btn btn-secondary btn-xs mb-1 circular-membership-permission" data-id="' . $data->ar_id . '" data-title="circular" style="width: 167px;"><i class="fa-regular fa-credit-card me-1"></i>Membership Permission</a>';
                    }
                }

                if (auth()->user()->can('circulars-delete')) {
                    if(($user->branchid == $data->ar_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><button class="btn btn-danger btn-xs circulardelete" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('translation.label_delete') . '" id="' . $data->ar_id . '" name="delete"><i class="fa fa-trash me-1"></i>Delete</button>';
                    }
                }

                return $buttons;
            })
            ->rawColumns(['date', 'title', 'desc', 'level', 'branch', 'status', 'actions'])
            ->make(true);
    }

    public function createCircular($data)
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
            $pdfPath = $filePdf->storeAs('uploads/circulars', $newPdfFilename, 'public');
            $input['ar_file_path'] = $pdfPath;
        }

        return Circular::create($input);
    }


    public function updateCircular($data)
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

        $circular = Circular::find($data->ar_id);
        if (!$circular) {
            return ['status' => false, 'message' => 'Circular not found.'];
        }

        // Upload PDF file
        if ($data->hasFile('ar_file_path')) {
            if ($circular->ar_file_path && Storage::disk('public')->exists($circular->ar_file_path)) {
                Storage::disk('public')->delete($circular->ar_file_path);
            }
            $filePdf = $data->file('ar_file_path');
            $originalPdfName = pathinfo($filePdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extensionPdf = strtolower($filePdf->getClientOriginalExtension());
            $newPdfFilename = $originalPdfName . '-' . now()->format('YmdHis') . '.' . $extensionPdf;
            $pdfPath = $filePdf->storeAs('uploads/circulars', $newPdfFilename, 'public');
            $input['ar_file_path'] = $pdfPath;
        }

        $circular->update($input);

        return ['status' => true, 'message' => 'Circulars updated successfully!'];
    }

    public function deleteCircular($id)
    {
        $circular = Circular::find($id);

        if ($circular) {
            // Delete the associated PDF file if it exists
            if ($circular->ar_file_path && Storage::disk('public')->exists($circular->ar_file_path)) {
                Storage::disk('public')->delete($circular->ar_file_path);
            }

            ContentPermissionMember::where('cm_item', $id)->where('cm_item_type', 'circular')->delete();
            ContentPermissionBranch::where('cp_item', $id)->where('cp_item_type', 'circular')->delete();
            $circular->delete();

            return ['status' => true, 'message' => 'Circular deleted successfully!'];
        } else {
            return ['status' => false, 'message' => 'Circular not found!'];
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

        $html = view('backend.circulars.permission', compact('memberTypes', 'permissionMember', 'cm_item', 'cm_item_type'))->render();

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

        return ['status' => true, 'message' => 'Circular Member Permission stored successfully!'];
    }

    public function getBranchData(Request $request)
    {
        $cp_item = $request->id;
        $cp_item_type = $request->title;

        $permissionBranch = ContentPermissionBranch::with('BranchName')
            ->where('cp_item_type', $cp_item_type)
            ->where('cp_item', $cp_item)
            ->get();

        // Use pluck() to extract the 'cm_membertype' values into an array
        $BranchIds = $permissionBranch->pluck('cp_branch')->toArray();

        // Now use the extracted array in the whereNotIn query
        $branchs = Branch::whereNotIn('bid', $BranchIds)->get();

        $html = view('backend.circulars.branchPermission', compact('branchs', 'permissionBranch', 'cp_item', 'cp_item_type'))->render();
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

        return ['status' => true, 'message' => 'Circular Branch Permission stored successfully!'];
    }
}
