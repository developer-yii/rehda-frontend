<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function editprofile ($id)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $get_user = User::where('id',Auth::user()->id)->first();

        return view('backend.profile.edit',compact('get_user'));
    }

    public function updateprofile (Request $request)
    {
        if($request->ajax()){
            $userId = Auth::id();
            $rules= [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $userId . ',id,deleted_at,NULL',
                'user_image' => 'nullable|max:10000|mimes:jpg,png,jpeg',
                'phone_number' => 'nullable|regex:/^\+?\d{10,}$/|min:10',
                'password' => 'nullable|min:8'
                ];
            $messages['first_name.required'] = 'First name is required.';
            $messages['email.unique'] = 'This email id has already been taken.';

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()){
                $result = ['status' => false, 'errors' => $validator->errors()];
            }else{

             $data = $this->userService->updateprofile($request);

             return response()->json($data);
            }
        }else{
            $result = ['status' => false, 'message' => __('post')['help_request']['invalid_request']];
        }
        return response()->json($result);
    }

}
