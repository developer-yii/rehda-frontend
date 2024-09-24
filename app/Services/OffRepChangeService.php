<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\MemberType;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MemberUserProfile;
use App\Models\ChangeRequestMember;
use App\Models\MemberUser;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class OffRepChangeService
{
    public function getRequests()
    {
        $user = Auth::user();

        $requests = ChangeRequestMember::orderBy('rc_created_at', 'desc');

        return DataTables::eloquent($requests)
            ->editColumn('rc_created_at', function ($data) {
                return Carbon::parse($data->rc_created_at)->format('d F Y H:i:s');
            })
            ->addColumn('company_name', function ($data) {
                return $data->memberUserProfile->memberComp->d_compname ?? '-';
            })
            ->addColumn('membership_no', function ($data) {
                return getMembershipNobyMID($data->memberUserProfile->up_mid ?? 0) ?? '-';
            })
            ->addColumn('membership_type', function ($data) {
                return $data->memberUserProfile->memberComp->member->memberType->typename ?? '-';
            })
            ->editColumn('rc_status', function ($data) {
                if ($data->rc_status == 1) {
                    return '<span class="badge bg-info btn-xs">New</span>';
                } else if ($data->rc_status == 2) {
                    return '<span class="badge bg-success btn-xs">Completed</span>';
                } else {
                    return '<span class="badge bg-danger btn-xs">Rejected</span>';
                }
            })
            ->addColumn('actions', function ($data) {
                $buttons = '';
                if (auth()->user()->can('changeoffrep-edit') && $data->rc_status == 1) {
                    $buttons .= '<a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve" class="btn btn-primary btn-xs mb-1 me-1 approve-req" data-id="'.$data->rc_id.'"><i class="fas fa-edit me-1"></i>Approve</a>';
                    $buttons .= '<a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject" class="btn btn-danger btn-xs mb-1 reject-req" data-id="'.$data->rc_id.'"><i class="fas fa-trash me-1"></i>Reject</a>';
                }
                return $buttons;
            })
            ->rawColumns([ 'rc_status', 'actions'])
            ->toJson();
    }

    public function exportToCsv()
    {
        $query = ChangeRequestMember::orderBy('rc_created_at', 'desc');

        $filename = 'ListingReqs' . now()->format('YmdHis') . 'Export.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = [
            'Requested Date',
            'Company Name',
            'Membership No.',
            'Membership Type',
            'New Name',
            'New MyKad No.',
            'Current Name',
            'Current MyKad No.',
            'Status',
        ];

        $callback = function () use ($query, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($query->cursor() as $data) {
                $data = [
                    Carbon::parse($data->rc_created_at)->format('d F Y H:i:s'),
                    $data->memberUserProfile->memberComp->d_compname ?? '-',
                    getMembershipNobyMID($data->memberUserProfile->up_mid ?? 0) ?? '-',
                    $data->memberUserProfile->memberComp->member->memberType->typename ?? '-',
                    $data->rc_name,
                    $data->rc_mykad,
                    $data->rc_oldname,
                    $data->rc_oldmykad,
                    getChangeRequestStatusCSV($data->rc_status)
                ];
                fputcsv($file, $data);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function approve($id)
    {
        $changeReq = ChangeRequestMember::find($id);
        if($changeReq)
        {
            $memberProfile = MemberUserProfile::where('up_id',$changeReq->rc_uid)->where('up_usertype', 1)->first();
            if($memberProfile){
                $changeReq->rc_status = ChangeRequestMember::STATUS_COMPLETED;
                $changeReq->rc_approved_by = Auth::id();
                $changeReq->save();
                logSystem(auth()->id(), 'Approve', $changeReq->getChanges(), 'ReqChgRep');

                $memberProfile->up_fullname = $changeReq->rc_name;
                $memberProfile->up_mykad = $changeReq->rc_mykad;
                $memberProfile->save();
                logSystem(auth()->id(), 'Edit', $memberProfile->getChanges(), 'ReqChgRepProfile');

                $memberUpdate = MemberUser::where('ml_uid', $memberProfile->up_id)->first();
                $memberUpdate->ml_username = $changeReq->rc_mykad;
                $memberUpdate->save();

                logSystem(auth()->id(), 'Edit', $memberUpdate->getChanges(), 'ReqChgRepProfileUsername');

                $memberUpdate = MemberUser::where('ml_uid', $memberProfile->up_id)
                          ->update(['ml_username' => $changeReq->rc_mykad]);

                return response()->json(['status' => true, 'message' => "Approval success"]);
            }
        }
    }

    public function reject($id)
    {
        $changeReq = ChangeRequestMember::find($id);
        if($changeReq)
        {
            $changeReq->rc_status = ChangeRequestMember::STATUS_REJECTED;
            $r = $changeReq->save();
            logSystem(auth()->id(), 'Reject', $changeReq->getChanges(), 'ReqChgRep');

            if($r)
            {
                return response()->json(['status' => true, 'message' => "Reject success!"]);
            }
            else{
                return response()->json(['status' => false, 'message' => 'Request failed', 'data' => []], 400);
            }
        }
    }
}
