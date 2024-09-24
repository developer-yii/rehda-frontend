<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin' , 'guard_name' => 'web'],
            ['name' => 'Manager' , 'guard_name' => 'web'],
            ['name' => 'User' , 'guard_name' => 'web'],
        ];

        foreach ($roles as $key => $value){
            if(!Role::where('name', $value['name'])->exists()){
                Role::create($value);
            }
        }
    }
}
