<?php

namespace App\Services;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DeviceService
{
    public function saveOrUpdateDevice(Request $request)
    {
        $isUpdate = isset($request->deviceId) && !empty($request->deviceId);

        $device = $isUpdate ? Device::where('uuid',$request->deviceId)->first() : new Device();

        $device->name = $request->name;
        $device->model = $request->model;
        $device->brand = $request->brand;
        $device->device_id = $request->device_id;
        $device->status = $request->has('status') ? $request->status : 0;

        if ($isUpdate) {
            $device->updater_id = Auth::id();
        } else {
            $device->creator_id = Auth::id();
            $device->password = Str::random(12);
        }

        $result = $device->save()
            ? ['status' => true, 'message' => $isUpdate ? __('Device details updated successfully!') : __('Device created successfully!'), 'is_update' => $isUpdate ? 'Updated!' : 'Added!']
            : ['status' => false, 'message' => __('Device could not be saved!')];

        return $result;
    }

    public function deleteDevice(Request $request)
    {
        $result = [];
        if (!auth()->user()->can('device-delete')) {
            $result = ['status' => false, 'message' => 'You have not permission to delete devices.'];

            return $result;
        }
        $data = Device::where('uuid',$request->id)->first();

        if (!$data) {
            $result = ['status' => false, 'message' => 'Device not found.'];
            return $result;
        }
        $data->delete();
        $result = ['status' => true, 'message' => 'Device deleted successfully.'];
        return $result;
    }
}
