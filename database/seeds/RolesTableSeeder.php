<?php

use App\Modules\Role\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
              'id'         => 1,
              'title'      => 'Super Admin',
              'created_at' => '2019-08-16 15:11:15',
              'updated_at' => '2019-08-16 15:11:15',
              'deleted_at' => null,
            ],
            [
              'id'         => 2,
              'title'      => 'Admin',
              'created_at' => '2019-08-16 15:11:15',
              'updated_at' => '2019-08-16 15:11:15',
              'deleted_at' => null,
            ],
            [
                  'id'         => 3,
                  'title'      => 'User',
                  'created_at' => '2019-08-16 15:11:15',
                  'updated_at' => '2019-08-16 15:11:15',
                  'deleted_at' => null,
            ],
            [
                  'id'         => 4,
                  'title'      => 'Reviewer',
                  'created_at' => '2019-08-16 15:11:15',
                  'updated_at' => '2019-08-16 15:11:15',
                  'deleted_at' => null,
            ],
        ];

        Role::insert($roles);
    }
}
