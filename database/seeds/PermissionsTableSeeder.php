<?php

use App\Modules\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [[
            'id'         => '1',
            'title'      => 'user_management_access',
            'created_at' => '2019-08-19 12:16:24',
            'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '2',
                'title'      => 'permission_create',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '3',
                'title'      => 'permission_edit',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '4',
                'title'      => 'permission_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '5',
                'title'      => 'permission_delete',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '6',
                'title'      => 'permission_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '7',
                'title'      => 'role_create',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '8',
                'title'      => 'role_edit',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '9',
                'title'      => 'role_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '10',
                'title'      => 'role_delete',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '11',
                'title'      => 'role_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '12',
                'title'      => 'user_create',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '13',
                'title'      => 'user_edit',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '14',
                'title'      => 'user_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '15',
                'title'      => 'user_delete',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '16',
                'title'      => 'user_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '17',
                'title'      => 'client_create',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '18',
                'title'      => 'client_edit',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '19',
                'title'      => 'client_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '20',
                'title'      => 'client_delete',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '21',
                'title'      => 'client_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '22',
                'title'      => 'filing_data_create',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '23',
                'title'      => 'filing_data_edit',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '24',
                'title'      => 'filing_data_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '25',
                'title'      => 'filing_data_delete',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '26',
                'title'      => 'filing_data_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '27',
                'title'      => 'audit_log_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '28',
                'title'      => 'audit_log_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '29',
                'title'      => 'dashboard_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '30',
                'title'      => 'plan_create',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '31',
                'title'      => 'plan_edit',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '32',
                'title'      => 'plan_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '33',
                'title'      => 'plan_delete',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '34',
                'title'      => 'plan_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '35',
                'title'      => 'company_create',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '36',
                'title'      => 'company_edit',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '37',
                'title'      => 'company_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '38',
                'title'      => 'company_delete',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '39',
                'title'      => 'company_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '40',
                'title'      => 'request_create',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '41',
                'title'      => 'request_edit',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '42',
                'title'      => 'request_show',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '43',
                'title'      => 'request_delete',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '44',
                'title'      => 'request_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
            [
                'id'         => '45',
                'title'      => 'taxonomy_access',
                'created_at' => '2019-08-19 12:16:24',
                'updated_at' => '2019-08-19 12:16:24',
            ],
        ];

        Permission::insert($permissions);
    }
}
