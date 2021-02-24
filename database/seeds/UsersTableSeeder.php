<?php

use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [[
            'id'             => 1,
            'name'           => 'Admin',
            'email'          => 'admin@admin.com',
            'is_superadmin'  => 1,
            'password'       => '$2y$10$bbWk2eIxRUx6fFlAosl12O.EtSe47pf6jh85KTWDiURRh5aLzGHIm',
            'remember_token' => null,
            'role_id'        => 1,
            'created_at'     => '2019-08-19 11:47:42',
            'updated_at'     => '2019-08-19 11:47:42',
            'deleted_at'     => null,
        ]];

        User::insert($users);
    }
}
