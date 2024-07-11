<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'management_service_access',
            ],
            [
                'id'    => 18,
                'title' => 'service_create',
            ],
            [
                'id'    => 19,
                'title' => 'service_edit',
            ],
            [
                'id'    => 20,
                'title' => 'service_show',
            ],
            [
                'id'    => 21,
                'title' => 'service_delete',
            ],
            [
                'id'    => 22,
                'title' => 'service_access',
            ],
            [
                'id'    => 23,
                'title' => 'services_attribute_create',
            ],
            [
                'id'    => 24,
                'title' => 'services_attribute_edit',
            ],
            [
                'id'    => 25,
                'title' => 'services_attribute_show',
            ],
            [
                'id'    => 26,
                'title' => 'services_attribute_delete',
            ],
            [
                'id'    => 27,
                'title' => 'services_attribute_access',
            ],
            [
                'id'    => 28,
                'title' => 'view_service_create',
            ],
            [
                'id'    => 29,
                'title' => 'view_service_edit',
            ],
            [
                'id'    => 30,
                'title' => 'view_service_show',
            ],
            [
                'id'    => 31,
                'title' => 'view_service_access',
            ],
            [
                'id'    => 32,
                'title' => 'account_create',
            ],
            [
                'id'    => 33,
                'title' => 'account_edit',
            ],
            [
                'id'    => 34,
                'title' => 'account_show',
            ],
            [
                'id'    => 35,
                'title' => 'account_delete',
            ],
            [
                'id'    => 36,
                'title' => 'account_access',
            ],
            [
                'id'    => 37,
                'title' => 'management_account_access',
            ],
            [
                'id'    => 38,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
