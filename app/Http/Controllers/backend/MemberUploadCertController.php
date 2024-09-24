<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\MemberComp;
use App\Models\MemberCert;
use App\Http\Requests\MemberCertificateRequest;

class MemberUploadCertController extends Controller
{
    public function showCert(Request $request)
    {
        if(Auth::user()->cannot('memberusers-edit')){
            return response()->json(['status' => false, 'message' => 'You dont have the permission to access member certificate', 'data' => []], 403);
        }

        if(empty($request->pid)){
            return response()->json(['status' => false, 'message' => 'Invalid request!', 'data' => []], 400);
        }

        $memberCerts = MemberCert::where('mc_mid', $request->pid)->orderBy('mc_yr', 'asc')->get();

        $html = view('backend.members.partials.cert-view',compact('memberCerts'))->render();

        return response()->json(['status' => true, 'html' => $html]);
    }

    public function deleteCert(Request $request) {
        if(Auth::user()->cannot('memberusers-edit')){
            return response()->json(['status' => false, 'message' => 'You dont have the permission to delete member certificate', 'data' => []], 403);
        }

        if(empty($request->eid)){
            return response()->json(['status' => false, 'message' => 'Invalid request!', 'data' => []], 400);
        }

        $memberCert = MemberCert::find($request->eid);

        // Construct the full path to the file
        $filePath = 'public/' . $memberCert->certificate_path;

        // Store the changes before deletion
        $changes = $memberCert->getAttributes();

        // === Delete the file if it exists // uncomment below code if want to remove files during delete process === //
        // if (Storage::exists($filePath)) {
        //     Storage::delete($filePath);
        // }

        $memberCert->delete();

        logSystem(auth()->id(), 'Delete', $changes, 'MembershipCert');

        return response()->json(['status' => true, 'message' => 'Certificate deleted successfully!']);
    }

    public function updateCert(MemberCertificateRequest $request)
    {
        $memberCert = MemberCert::where('mc_mid', $request->pid)->where('mc_yr', $request->certyr)->first();

        if($memberCert){
            // Construct the full path to the file
            $filePath = 'public/' . $memberCert->certificate_path;
            // === Delete the file if it exists // uncomment below code if want to remove files during delete process === //
            // if (Storage::exists($filePath)) {
            //     Storage::delete($filePath);
            // }

            $memberCert->delete();
        }

        // upload file
        if ($request->hasFile('fileimg')) {
            $file = $request->file('fileimg');

            // Get the original filename and extension
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $extension = strtolower($extension); // Make sure the extension is lowercase

            // Create a new filename with timestamp and original filename
            $newFilename = $originalName . '-' . now()->format('YmdHis') . '.' . $extension;

            // Store the file in the 'uploads/certificate' folder within the 'public' disk with the new filename
            $path = $file->storeAs('uploads/certificates', $newFilename, 'public');

            $memberCert = new MemberCert;
            $memberCert->mc_mid = $request->pid;
            $memberCert->mc_cert_path = $path;
            $memberCert->mc_yr = $request->certyr;
            $memberCert->save();

            logSystem(auth()->id(), 'Edit', $memberCert->getAttributes(), 'Product');

            $memberCerts = MemberCert::where('mc_mid', $request->pid)->orderBy('mc_yr', 'asc')->get();

            $html = view('backend.members.partials.cert-view',compact('memberCerts'))->render();

            return response()->json(['status' => true,'message' => 'Certificate uploaded successfully!' , 'html' => $html]);

        }
    }
}
