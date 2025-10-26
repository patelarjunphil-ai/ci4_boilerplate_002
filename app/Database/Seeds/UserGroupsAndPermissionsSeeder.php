<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserGroupsAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Get the Group and Permission models
        $groupModel = model('CodeIgniter\Shield\Models\GroupModel');
        $permissionModel = model('CodeIgniter\Shield\Models\PermissionModel');

        //
        // Groups
        //
        $groups = [
            'admin' => 'Admin users',
            'user'  => 'Regular users',
        ];

        foreach ($groups as $group => $description) {
            if (! $groupModel->where('name', $group)->first()) {
                $groupModel->create([
                    'name'        => $group,
                    'description' => $description,
                ]);
            }
        }

        //
        // Permissions
        //
        $permissions = [
            'admin.access' => 'Can access the admin area',
            'users.manage' => 'Can manage users',
            'pos.use'      => 'Can use the POS system',
        ];

        foreach ($permissions as $permission => $description) {
            if (! $permissionModel->where('name', $permission)->first()) {
                $permissionModel->create([
                    'name'        => $permission,
                    'description' => $description,
                ]);
            }
        }

        //
        // Assign Permissions to Groups
        //
        $groupModel->addPermissionToGroup('admin.access', 'admin');
    }
}
