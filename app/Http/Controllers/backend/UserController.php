<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user->can('user-view')) {
            return redirect()->back()->with('error', 'No Access to user page!');
        }

        $role =  Role::orderBy('updated_at', 'desc')->get();

        return view('backend.users.index', compact('role'));
    }

    public function getUser(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles','branchName')->where('id', '!=', Auth::id())->orderBy('updated_at', 'desc');
            $loginuser = Auth::user();

            return datatables()->of($users)
                ->addColumn('username', function ($data) {
                    $username = $data->username ?? '-';
                    return $username;
                })
                ->addColumn('branch', function($data){
                    $branchName = isset($data->branchName) ? $data->branchName->bname : '-';
                    return $branchName;
                })
                ->addColumn('role', function (User $users) {
                    return $users->roles->pluck('name')->implode(', ');
                })
                ->editColumn('is_active', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-success btn-xs">Active</span>';
                    } else {
                        return '<span class="badge bg-danger btn-xs">Inactive</span>';
                    }
                })
                ->addColumn('actions', function ($data) use ($loginuser) {
                    $button = '';
                    if ($loginuser->can('user-update')) {
                        $button = '<div class="d-flex"><button class="btn btn-primary edit" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('translation.label_edit') . '" id="' . $data->id . '"><i class="fas fa-edit"></i></button>';
                    }
                    if ($loginuser->can('user-delete')) {
                        $button .= '<button class="btn btn-danger mx-2 delete" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('translation.label_delete') . '" id="' . $data->id . '" name="delete"><i class="fa fa-trash"></i></button></div>';
                    }
                    return $button;
                })->rawColumns(['username','branch', 'actions', 'is_active'])
                ->make(true);
        }
    }

    public function saveOrUpdateUser(Request $request)
    {
        if ($request->ajax()) {
            if (!auth()->user()->can('user-update') && !auth()->user()->can('user-create')) {
                return redirect()->back()->with('error', 'You have not permission to access this page.');
            }
            if (isset($request->user_id) && $request->user_id != '') {
                $rules = [
                    'email' => 'required|email|unique:users,email,' . $request->user_id . ',id,deleted_at,NULL',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'user_image' => 'mimes:jpeg,jpg,png,gif',
                    'role' => 'required',
                    'phone_number' => 'nullable|regex:/^\+?\d{10,}$/|min:10',
                    'password' => 'nullable|min:8'
                ];
            } else {
                $rules = [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|unique:users,email,{{id}},id,deleted_at,NULL',
                    'user_image' => 'mimes:jpeg,jpg,png,gif',
                    'role' => 'required',
                    'phone_number' => 'nullable|regex:/^\+?\d{10,}$/|min:10',
                    'password' => 'required|min:8'
                ];
            }
            $messages['first_name.required'] = 'First name is required.';
            $messages['last_name.required'] = 'Last name is required.';
            $messages['email.unique'] = 'This email id has already been taken.';
            $messages['role.required'] = 'Please select a role.';
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $result = ['status' => false, 'errors' => $validator->errors(), 'data' => []];
                return response()->json($result);
            }
            $data = $this->userService->saveOrUpdateUser($request);

            return response()->json($data);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Request', 'data' => []], 400);
        }
    }
    public function getSingleUser(Request $request)
    {
        if ($request->ajax()) {
            $result = [];
            if (isset($request->id) && $request->id != '') {
                $user = User::with('roles')->where('id', $request->id)->first();
                if (!empty($user) && $user != null) {
                    $result = ['status' => true, 'message' => 'User Fetched Successfully', 'data' => $user];
                } else {
                    $result = ['status' => false, 'message' => 'User not found', 'data' => []];
                }
                return response()->json($result);
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid Request', 'data' => []]);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Request', 'data' => []], 400);
        }
    }

    public function deleteUser(Request $request)
    {
        if ($request->ajax()) {
            if (!auth()->user()->can('user-delete')) {
                return redirect()->back()->with('error', 'You have not permission to access this page.');
            }
            $data = $this->userService->deleteUser($request);

            return response()->json($data);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Request', 'data' => []], 400);
        }
    }
}
