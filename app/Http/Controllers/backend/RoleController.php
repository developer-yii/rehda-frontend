<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('role-view')) {
            return redirect()->back()->with('error', 'You have not permission to access this page.');
        }
        $roles = Role::with('permissions');
        if ($request->ajax()) {

            return datatables()->of($roles)
                ->addColumn('permission', function ($data) {
                    $permission = $data->permissions->pluck('name')->toArray();
                    $backclr = [1 => 'bg-primary', 2 => 'bg-secondary', 3 => 'bg-success', 4 => 'bg-danger', 5 => 'bg-warning', 'bg-info', 6 => 'bg-dark'];
                    $button = '<div class="demo-inline-spacing">';
                    foreach ($permission as $value) {
                        $button .= '<span class="badge ' . $backclr[rand(1, 6)] . ' bg-glow">' . $value . '</span>';
                    }
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('actions', function ($data) {
                    $button = '';
                    if (auth()->user()->can('role-update')) {
                        $button = '<a href="' . url('roles/create?role_id=' . $data->id) . '" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('translation.label_edit').'" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
                    }
                    if (auth()->user()->can('role-delete')) {
                        $button .= '<button class="btn btn-danger mx-2 delete" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('translation.label_delete').'" id="' . $data->id . '" name="delete"><i class="fa fa-trash"></i></button>';
                    }
                    return $button;
                })
                ->rawColumns(['permission', 'actions'])
                ->make(true);
        }
        return view('backend.roles.index');
    }

    public function addeditrole(Request $request)
    {
        if (!auth()->user()->can('role-update')) {
            return redirect()->back()->with('error', 'You have not permission to access this page.');
        }

        $role = [];
        $getrolepermission = [];
        if (isset($request->role_id) && $request->role_id != '') {
            $role = Role::find($request->role_id);
            $getrolepermission = $role->permissions->pluck('name')->toArray();
        }
        $permission = Permission::all();
        $permissions = $permission->groupBy('model');

        return view('backend.roles.edit', compact('permissions', 'role', 'getrolepermission'));
    }

    public function saveOrUpdateRole(Request $request)
    {
        if ($request->ajax()) {
            if (!auth()->user()->can('role-create') && !auth()->user()->can('role-update')) {
                return response()->json(['message' => 'You dont have permission to create role.'], 422);
            }
            if (isset($request->role_id) && $request->role_id != '') {
                $rules = [
                    'role_name' => 'required|unique:roles,name,' . $request->role_id . ',id',
                ];
            } else {
                $rules = [
                    'role_name' => 'required|unique:roles,name'
                ];
            }

            $validation = Validator::make($request->all(), $rules);

            if ($validation->fails()) {
                return response()->json(['status' => false, 'errors' => $validation->errors(), 'data' => []]);
            }

            if (isset($request->role_id) && $request->role_id != '') {
                $createRole = Role::find($request->role_id);
                $createRole->updated_at = now();
                $message = 'Role updated successfully!';
                $is_updated = 'Updated';
                if (empty($createRole) && $createRole == null) {
                    return response()->json(['status' => false, 'message' => 'Role not found!', 'data' => []]);
                }
            } else {
                $createRole = new Role();
                $message = 'Role created successfully!';
                $is_updated = 'Added';
            }

            $createRole->name = $request->role_name;
            $createRole->guard_name = 'web';
            if ($createRole->save()) {
                $createRole->syncPermissions($request->permissions);
                return response()->json(['status' => true, 'message' => $message, 'data' => route('roles.index'), 'is_update' => $is_updated], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong!', 'data' => []]);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Request', 'data' => []], 400);
        }
    }
    public function delete(Request $request)
    {
        if ($request->ajax()) {
            if (!auth()->user()->can('role-delete')) {
                return response()->json(['message' =>  'You have not permission to delete this role.'], 422);
            }
            $result = [];

            $data = Role::withCount(['users'])->where('id', $request->id)->first();

            if (!$data) {
                $result = ['status' => false, 'message' => 'Role not found.'];
                return response()->json($result);
            } else if ($data->users_count > 0) {
                return response()->json(['status' => false, 'message' => 'The deletion of the role is currently not possible as it is associated with users.', 'data' => []]);
            }

            $data->delete();
            $result = ['status' => true, 'message' => 'Role deleted successfully.'];
            return response()->json($result);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Request', 'data' => []], 400);
        }
    }
}
