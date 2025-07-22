<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $all_permissions = [
            'Menu' => [
                'dashboard',
                'users',
                'settings'
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
            ],
            'settings' => [
                'menu-manage-settings',
            ]
        ];

        $position_group = 1;

        foreach ($all_permissions as $group => $permissions) {
            $position = 1;

            foreach ($permissions as $permission) {
                Permission::updateOrCreate(
                    ['name' => $permission], // condition
                    [
                        'group' => $group,
                        'position' => $position,
                        'position_group' => $position_group
                    ]
                );

                $position++;
            }

            $position_group++;
        }
    }
}
