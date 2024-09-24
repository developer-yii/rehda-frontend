<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class MigratePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all roles from the roles table
        $roles = DB::table('role')->get();

        // Fetch all modules from the module table
        $modules = DB::table('module')->get()->keyBy('module_id');  // assuming 'id' is the primary key

        // Fetch all role rights
        $roleRights = DB::table('role_rights')->get();

        foreach ($roleRights as $right) {
            $role = $roles->where('id', $right->rr_rolecode)->first();
            $module = $modules->get($right->rr_modulecode);

            if (!$role || !$module) {
                continue;
            }

            // Determine permissions
            $permissions = [
                'create'  => $right->rr_create === 'Yes' ? 'create' : null,
                'edit'    => $right->rr_edit === 'Yes' ? 'edit' : null,
                'delete'  => $right->rr_delete === 'Yes' ? 'delete' : null,
                'view'    => $right->rr_view === 'Yes' ? 'view' : null,
                'email'   => $right->rr_email === 'Yes' ? 'email' : null,
                'upload'  => $right->rr_upload === 'Yes' ? 'upload' : null,
                'status'  => $right->rr_status === 'Yes' ? 'status' : null,
                'approve' => $right->rr_approve === 'Yes' ? 'approve' : null,
            ];

            foreach ($permissions as $action => $perm) {
                // Permission name format: module_name-action (e.g., user-create)
                $permissionName = strtolower($module->mod_name) . '-' . $action;

                // Check if permission exists or create it
                $permission = Permission::firstOrCreate(['name' => $permissionName, 'model' => $module->mod_name]);

                // Find or create the role in Spatie's Role model
                $spatieRole = Role::firstOrCreate(['name' => $role->role_name]);

                if ($perm) {
                    // Assign the permission to the role
                    $spatieRole->givePermissionTo($permission);
                }
            }
        }

        // code for assigning role to users.
        // Step 1: Fetch all roles from the 'role' table
        $newRoles = DB::table('roles')->get()->keyBy('name');  // Assuming 'role_name' is the field in the 'role' table

        // Step 2: Loop through users and assign roles
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // Find the corresponding role based on the 'priv' field in the 'users' table
            $newRole = $newRoles->get($user->priv);

            if ($newRole) {
                // Assign role to the user in 'model_has_roles' table
                DB::table('model_has_roles')->insert([
                    'role_id' => $newRole->id,    // Assuming 'id' is the primary key in the 'roles' table
                    'model_type' => 'App\Models\User',  // Adjust this according to your User model's namespace
                    'model_id' => $user->id,
                ]);
            }
        }

    }
}
