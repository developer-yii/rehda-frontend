<?php

namespace App\Services;

use App\Http\Requests\NewsletterRequest;
use App\Models\Branch;
use App\Models\ContentPermissionBranch;
use App\Models\ContentPermissionMember;
use App\Models\MemberType;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class NewsletterService
{
    public function getNewslettersDataTable()
    {
        $hq = 'HQ';
        $br = 'Branch';
        $user = Auth::user();
        $isAdmin = chkAdminAccess() == 1;

        if ($user->hasRole('BranchAdmin')) {
            $newsletters = Newsletter::with('branchName')->where(function ($query) use ($user, $br, $hq) {
                $query->where('bu_branchid', $user->branchid)
                    ->where('bu_level', $br)
                    ->orWhere('bu_level', $hq);
            })->orderBy('bu_id', 'desc')->get();
        } else if (chkAdminAccess() == 1) {
            $newsletters = Newsletter::with('branchName')->orderBy('bu_created_at', 'desc')->get();
        } else {
            return collect();
        }

        return datatables()->of($newsletters)
            ->addColumn('newsletter', function ($data) {
                // Replace '../' with empty string for the image and PDF paths
                $imgPath = str_replace('../', '', $data->bu_img_cover);
                $pdfPath = str_replace('../', '', $data->bu_file_path);

                // Generate full URLs for the image and PDF
                $imgUrl = asset('storage/' . $imgPath);
                $pdfUrl = asset('storage/' . $pdfPath);

                $newsletter = $data->bu_name . ' ' . $data->bu_yr;
                return $newsletter . '<br><a href="' . $pdfUrl . '" target="_blank"><img src="' . $imgUrl . '" width="100px"></a>';
            })
            ->addColumn('level', function ($data) {
                return $data->bu_level ?? '-';
            })
            ->addColumn('branch', function ($data) {
                return $data->branchName->bname ?? '-';
            })
            ->addColumn('status', function ($data) {
                return $data->bu_status == 2
                    ? '<span class="badge bg-success btn-xs">Publish</span>'
                    : '<span class="badge bg-primary btn-xs">Draft</span>';
            })
            ->addColumn('actions', function ($data) use ($user, $isAdmin) {
                $buttons = '';
                if (auth()->user()->can('newsletter-edit')) {
                    if (($user->branchid == $data->bu_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<a href="' . route('newsletters.edit', ['id' => $data->bu_id])  . '" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('translation.label_edit') . '" class="btn btn-primary btn-xs mb-1"><i class="fas fa-edit me-1"></i>Edit</a>';
                    }
                }

                if (auth()->user()->can('contentpermission-edit') && $data->bu_level == 'HQ') {
                    if (($user->branchid == $data->bu_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><a href="javascript:void(0)" class="btn btn-secondary btn-xs mb-1 newsletter-branch-permission" data-id="' . $data->bu_id . '" data-title="newsletter" style="width: 140px;"><i class="fa-regular fa-credit-card me-1"></i>Branch Permission</a>';
                    }
                }

                if (auth()->user()->can('contentpermissionmember-edit')) {
                    if (($user->branchid == $data->bu_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><a href="javascript:void(0)" class="btn btn-secondary btn-xs mb-1 membership-permission" data-id="' . $data->bu_id . '" data-title="newsletter" style="width: 167px;"><i class="fa-regular fa-credit-card me-1"></i>Membership Permission</a>';
                    }
                }
                if (auth()->user()->can('newsletter-delete')) {
                    if (($user->branchid == $data->bu_branchid && $user->hasRole('BranchAdmin')) || $isAdmin) {
                        $buttons .= '<br><button class="btn btn-danger btn-xs newsletterdelete" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('translation.label_delete') . '" id="' . $data->bu_id . '" name="delete"><i class="fa fa-trash me-1"></i>Delete</button>';
                    }
                }
                return $buttons;
            })
            ->rawColumns(['newsletter', 'level', 'branch', 'status', 'actions'])
            ->make(true);
    }

    public function storeNewsletter(NewsletterRequest $request)
    {
        $user = Auth::user();
        $input = $request->except('_token', 'bu_img_cover', 'bu_file_path');

        if (chkAdminAccess() == 1) {
            $input['bu_level'] = "HQ";
            $input['bu_branchid'] = null;
        } else if ($user->hasRole('BranchAdmin')) {
            $input['bu_level'] = "Branch";
            $input['bu_branchid'] = $user->branchid;
        }

        // Upload image file
        if ($request->hasFile('bu_img_cover')) {
            $file = $request->file('bu_img_cover');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($file->getClientOriginalExtension());
            $newFilename = $originalName . '-' . now()->format('YmdHis') . '.' . $extension;
            $path = $file->storeAs('uploads/newsletter', $newFilename, 'public');
            $input['bu_img_cover'] = $path;
        }

        // Upload PDF file
        if ($request->hasFile('bu_file_path')) {
            $filePdf = $request->file('bu_file_path');
            $originalPdfName = pathinfo($filePdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extensionPdf = strtolower($filePdf->getClientOriginalExtension());
            $newPdfFilename = $originalPdfName . '-' . now()->format('YmdHis') . '.' . $extensionPdf;
            $pdfPath = $filePdf->storeAs('uploads/newsletter', $newPdfFilename, 'public');
            $input['bu_file_path'] = $pdfPath;
        }

        Newsletter::create($input);

        return ['status' => true, 'message' => 'Newsletter created successfully!'];
    }

    public function updateNewsletter(NewsletterRequest $request)
    {
        $user = Auth::user();
        $input = $request->except('_token', 'bu_id', 'bu_img_cover', 'bu_file_path');

        if (chkAdminAccess() == 1) {
            $input['bu_level'] = "HQ";
            $input['bu_branchid'] = null;
        } else if ($user->hasRole('BranchAdmin')) {
            $input['bu_level'] = "Branch";
            $input['bu_branchid'] = $user->branchid;
        }

        $newsletter = Newsletter::find($request->bu_id);

        if (!$newsletter) {
            return ['status' => false, 'message' => 'Newsletter not found.'];
        }

        // Upload image file
        if ($request->hasFile('bu_img_cover')) {
            if ($newsletter->bu_img_cover && Storage::disk('public')->exists($newsletter->bu_img_cover)) {
                Storage::disk('public')->delete($newsletter->bu_img_cover);
            }
            $file = $request->file('bu_img_cover');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($file->getClientOriginalExtension());
            $newFilename = $originalName . '-' . now()->format('YmdHis') . '.' . $extension;
            $path = $file->storeAs('uploads/newsletter', $newFilename, 'public');
            $input['bu_img_cover'] = $path;
        }

        // Upload PDF file
        if ($request->hasFile('bu_file_path')) {
            if ($newsletter->bu_file_path && Storage::disk('public')->exists($newsletter->bu_file_path)) {
                Storage::disk('public')->delete($newsletter->bu_file_path);
            }
            $filePdf = $request->file('bu_file_path');
            $originalPdfName = pathinfo($filePdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extensionPdf = strtolower($filePdf->getClientOriginalExtension());
            $newPdfFilename = $originalPdfName . '-' . now()->format('YmdHis') . '.' . $extensionPdf;
            $pdfPath = $filePdf->storeAs('uploads/newsletter', $newPdfFilename, 'public');
            $input['bu_file_path'] = $pdfPath;
        }

        $newsletter->update($input);

        return ['status' => true, 'message' => 'Newsletter updated successfully!'];
    }

    public function destroyNewsletter($id)
    {
        $newsletter = Newsletter::find($id);

        if ($newsletter) {
            // Delete associated files if needed
            if ($newsletter->bu_img_cover && Storage::disk('public')->exists($newsletter->bu_img_cover)) {
                Storage::disk('public')->delete($newsletter->bu_img_cover);
            }
            if ($newsletter->bu_file_path && Storage::disk('public')->exists($newsletter->bu_file_path)) {
                Storage::disk('public')->delete($newsletter->bu_file_path);
            }

            $newsletter->delete();

            return ['status' => true, 'message' => 'Newsletter deleted successfully!'];
        } else {
            return ['status' => false, 'message' => 'Newsletter not found!'];
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

        $html = view('backend.newsletters.permission', compact('memberTypes', 'permissionMember', 'cm_item', 'cm_item_type'))->render();

        return ['status' => true, 'message' => 'Permission Fetch successfully!', 'data' => $html];
    }

    public function deleteMembershipPermission(int $id): array
    {
        $permissionMember = ContentPermissionMember::find($id);

        if (!$permissionMember) {
            return ['status' => false, 'message' => 'Newsletter Member Permission not found!'];
        }
        ContentPermissionMember::where('cm_item', $id)->where('cm_item_type', 'newsletter')->delete();

        $permissionMember->delete();

        return ['status' => true, 'message' => 'Newsletter Member Permission deleted successfully!'];
    }

    public function storeMembershipPermission(array $selectedValues, string $cmTitle, int $cmId): array
    {
        if (count($selectedValues) > 0) {
            foreach ($selectedValues as $memberType) {
                $permission = new ContentPermissionMember;
                $permission->cm_item = $cmId;
                $permission->cm_item_type = $cmTitle;
                $permission->cm_membertype = $memberType;
                $permission->save();
            }
        }

        return ['status' => true, 'message' => 'Newsletter Member Permission stored successfully!'];
    }

    public function updateSorting(array $sortedIDs)
    {
        foreach ($sortedIDs as $index => $id) {
            Newsletter::where('bu_id', $id)->update(['bu_sorting' => $index + 1]);
        }

        return ['message' => 'Sorting updated successfully'];
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

        $html = view('backend.newsletters.branchPermission', compact('branchs', 'permissionBranch', 'cp_item', 'cp_item_type'))->render();
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

        return ['status' => true, 'message' => 'Newsletter Branch Permission stored successfully!'];
    }
}
