<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SettingService
{
    public function updateSetting(Request $request)
    {
        $settings = $request->except(['_token', 'logo','favicon']);
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['name' => $key], ['value' => $value]);
        }

        if ($request->hasFile('logo') && $request->logo) {
            $dir = "public/backend/assets/img/logo/";
            $extension = $request->file("logo")->getClientOriginalExtension();
            $filename = "logo-" . uniqid() . "_" . time() . "." . $extension;
            Storage::disk("local")->put($dir . $filename, File::get($request->file("logo")));
            Setting::updateOrCreate(['name' => 'logo'], ['value' => $filename]);
        }
        if ($request->hasFile('favicon') && $request->favicon) {
            $dir = "public/backend/assets/img/favicon/";
            $extension = $request->file("favicon")->getClientOriginalExtension();
            $name = "favicon-" . uniqid() . "_" . time() . "." . $extension;
            Storage::disk("local")->put($dir . $name, File::get($request->file("favicon")));
            Setting::updateOrCreate(['name' => 'favicon'], ['value' => $name]);
        }
        if ($request->hasFile('login_cover_image') && $request->login_cover_image) {
                    $dir = "public/backend/assets/img/login-cover-image/";
                    $extension = $request->file("login_cover_image")->getClientOriginalExtension();
                    $name = "login_cover_image-" . uniqid() . "_" . time() . "." . $extension;
                    Storage::disk("local")->put($dir . $name, File::get($request->file("login_cover_image")));
                    Setting::updateOrCreate(['name' => 'login_cover_image'], ['value' => $name]);
        }

        if(isset($request->background_type) && $request->background_type != null) {
            $background_type = $request->background_type;
            if($background_type == 1) {
                if ($request->hasFile('login_background_image') && $request->login_background_image) {
                    $dir = "public/backend/assets/img/login-background-image/";
                    $extension = $request->file("login_background_image")->getClientOriginalExtension();
                    $name = "login_background_image-" . uniqid() . "_" . time() . "." . $extension;
                    Storage::disk("local")->put($dir . $name, File::get($request->file("login_background_image")));
                    Setting::updateOrCreate(['name' => 'login_background_image'], ['value' => $name]);
                }

            }
        }
        Artisan::call('config:clear');
        $result = ['status' => true, 'message' => 'Setting Updated Successfully!'];

        return $result;
    }
}
