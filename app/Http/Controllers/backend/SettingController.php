<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use App\Rules\FaviconValidation;
use App\Services\SettingService;
use App\Models\Setting;
use App\Rules\BackgroundImageValidation;
use App\Rules\CoverImageValidation;
use App\Rules\LogoValidation;
use Illuminate\Http\Request;
class SettingController extends Controller
{

    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }
    public function index(Request $request)
    {
        $settings = Setting::pluck('value', 'name')->toArray();

        return view('backend.settings.index', compact('settings'));
    }

    public function uppdateSetting(Request $request)
    {
        if ($request->ajax()) {
            if (!auth()->user()->can('setting-update')) {
                return redirect()->back()->with('error', 'You have not permission to access this page.');
            }
            $validator = Validator::make($request->all(), [
                'app_name' => 'required|string|max:255',
                'app_description' => 'required|string',
                'smtp_host'  => 'required|string',
                'smtp_port'  => 'required|numeric',
                'smtp_user'  => 'required|string',
                'smtp_password'  => 'required|string',
                'logo' => [new LogoValidation],
                'login_background_image' => [new BackgroundImageValidation],
                'login_cover_image' => [new CoverImageValidation],
                'favicon' => [new FaviconValidation],
            ]);
            if ($validator->fails()) {
                $result = ['status' => false, 'errors' => $validator->errors(), 'data' => []];
                return response()->json($result);
            }
            $data = $this->settingService->updateSetting($request);

            return response()->json($data);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Request', 'data' => []], 400);
        }
    }
}
