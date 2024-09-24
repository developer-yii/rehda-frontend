<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApplicationService
{
    public function saveOrUpdateApplication(Request $request)
    {
        $isUpdate = isset($request->applicationId) && !empty($request->applicationId);

        $application = $isUpdate ? Application::where('app_uuid', $request->applicationId)->first() : new Application();

        $application->name = $request->name;
        $application->os = $request->os;
        $application->server = $request->input('server');
        $application->status = $request->has('status') ? $request->status : 0;

        if ($isUpdate) {
            $application->updater_id = Auth::id();
        } else {
            $application->creator_id = Auth::id();
        }

        $result = $application->save()
            ? ['status' => true, 'message' => $isUpdate ? __('Application details updated successfully!') : __('Application created successfully!'), 'is_update' => $isUpdate ? 'Updated!' : 'Added!']
            : ['status' => false, 'message' => __('Application could not be saved!')];

        return $result;
    }

    public function deleteApplication(Request $request)
    {
        $result = [];
        if (!auth()->user()->can('application-delete')) {
            $result = ['status' => false, 'message' => 'You have not permission to delete applications.'];

            return $result;
        }
        $data = Application::where('app_uuid', $request->id)->first();

        if (!$data) {
            $result = ['status' => false, 'message' => 'Application not found.'];
            return $result;
        }
        $data->delete();
        $result = ['status' => true, 'message' => 'Application deleted successfully.'];
        return $result;
    }
}
