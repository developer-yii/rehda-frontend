<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $perms = [
      ['name' => 'user-view', 'guard_name' => 'web', 'model' => 'User'],
      ['name' => 'user-update', 'guard_name' => 'web', 'model' => 'User'],
      ['name' => 'user-delete', 'guard_name' => 'web', 'model' => 'User'],
      ['name' => 'user-create', 'guard_name' => 'web', 'model' => 'User'],
      ['name' => 'role-view', 'guard_name' => 'web', 'model' => 'Role'],
      ['name' => 'role-update', 'guard_name' => 'web', 'model' => 'Role'],
      ['name' => 'role-create', 'guard_name' => 'web', 'model' => 'Role'],
      ['name' => 'role-delete', 'guard_name' => 'web', 'model' => 'Role'],
      ['name' => 'setting-view', 'guard_name' => 'web', 'model' => 'Setting'],
      ['name' => 'setting-update', 'guard_name' => 'web', 'model' => 'Setting'],
    ];
    foreach ($perms as $key => $val) {
      if (!Permission::where('name', $val['name'])->exists()) {
        Permission::create($val);
      }
    }

    $rows = [
      'SuperAdmin' => [
        'user-create',
        'user-update',
        'user-delete',
        'user-view',
        'role-view',
        'role-update',
        'role-create',
        'role-delete',
        'setting-view',
        'setting-update',
      ],

      'Developer' => [
        'user-create',
        'user-update',
        'user-delete',
        'user-view',
        'role-view',
        'role-update',
        'role-create',
        'role-delete',
        'setting-view',
        'setting-update',
      ],
    ];

    foreach ($rows as $role_name => $permissions) {
      $role = Role::findByName($role_name);
      foreach ($permissions as $id => $permission) {
        if (!$role->hasPermissionTo($permission)) {
          $role->givePermissionTo($permission);
        }
      }
    }
  }
}
