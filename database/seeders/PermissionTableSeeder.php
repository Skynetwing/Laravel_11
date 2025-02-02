<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $all_permissions = [
            'Menu' => [
                'dashboard',
                'users',
            ],
            'Role' => [
                'menu-manage-role',
                'role-list',
                'role-create',
                'role-edit',
                'role-delete',
            ],
            'User' => [
                'menu-manage-users',
                'user-list',
                'user-create',
                'user-edit',
                'user-delete',
            ]
        ];

        $position_group = 1;
        foreach ($all_permissions as $key => $permissions) {
            $position = 1;
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'position' =>  $position, 'group' => $key, 'position_group' => $position_group]);
                $position++;
            }
            $position_group++;
        }
    }
}
