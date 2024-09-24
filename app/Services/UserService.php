<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\User;

class UserService
{
    public function saveOrUpdateUser(Request $request)
    {
        $message = "";
        if(isset($request->user_id) && $request->user_id != ''){
            $addUser = User::find($request->user_id);
            $addUser->updated_at = now();
            $message = "User Updated Successfully!";
            $is_update = "Updated!";
            $addUser->updater_id = Auth::id();
        }else{
            $addUser =  new User();
            $message = "User Created Successfully!";
            $is_update = "Added!";
            $addUser->creator_id = Auth::id();
        }
        $addUser->first_name = $request->first_name;
        $addUser->last_name = $request->last_name;
        $addUser->email = $request->email;
        $addUser->phone_number = $request->phone_number;
        $addUser->is_active = (isset($request->is_active)) ? $request->is_active : 0;
        $addUser->email_verified_at = Now();

        $addUser->syncRoles($request->role);
        if ($request->password) {
            $addUser->password = Hash::make($request->password);
        }
        if ($request->hasFile('user_image') && $request->user_image) {
            if($request->hidden_image){
                Storage::disk("public")->delete('user_image/'.$request->hidden_image);
            }
            $dir = "public/user_image/";
            $extension = $request->file("user_image")->getClientOriginalExtension();
            $filename = "user_image".uniqid() . "_" . time() . "." . $extension;
            Storage::disk("local")->put($dir . $filename, File::get($request->file("user_image")));
            $addUser->profile_image = $filename;
        }
        if($addUser->save()){
            $result = ['status' => true, 'message' => $message, 'is_update' => $is_update];
        } else {
            $result = ['status' => false, 'message' => 'User can not saved!'];
        }

        return $result;
    }
    public function deleteUser(Request $request)
    {
        $result = [];
        if (!auth()->user()->can('user-delete')) {
            $result = ['status' => false, 'message' => 'You have not permission to delete users.'];

            return $result;
        }
        $data = User::find($request->id);
        if (Auth::user()->id == $request->id) {
            $result = ['status' => false, 'message' => 'You can not delete your account.'];
            return $result;
        }
        if (!$data) {
            $result = ['status' => false, 'message' => 'User not found.'];
            return $result;
        }
        $data->delete();
        $result = ['status' => true, 'message' => 'User deleted successfully.'];
        return $result;
    }

    public function updateprofile (Request $request)
    {
        $user_data = User::where('id',Auth::id())->first();
        $user_data->first_name = $request->first_name;
        $user_data->last_name = $request->last_name;
        $user_data->phone_number = $request->phone_number;
        $user_data->email = $request->email;
        $user_data->is_active = isset($request->is_active) ? 1 : 0;
        if ($request->password) {
            $user_data->password = Hash::make($request->password);
        }
        if($request->remove_image) {
            Storage::disk("public")->delete('user_image/'.$request->hidden_image);
        }
        if ($request->hasFile('user_image') && $request->user_image) {
            if($request->hidden_image){
                Storage::disk("public")->delete('user_image/'.$request->hidden_image);
            }

            $dir = "public/user_image/";
            $extension = $request->file("user_image")->getClientOriginalExtension();
            $filename = "user_image".uniqid() . "_" . time() . "." . $extension;
            Storage::disk("local")->put($dir . $filename, File::get($request->file("user_image")));
            $user_data->profile_image = $filename;
        }
        if($user_data->save()){

            $result = ['status' => true, 'message' => 'Profile Updated Successfully', 'data' => []];

        }else{
            $result = ['status' => false, 'message' => 'Something Went Wrong!'];
        }
        return $result;
    }
}