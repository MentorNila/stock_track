<?php

use App\Modules\Permission\Models\Permission;
use App\Modules\Role\Models\Role;
use App\Modules\Role\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $superadmin_permissions = Permission::all();
        foreach ($superadmin_permissions as $id => $permission){
            PermissionRole::firstOrCreate([
                'role_id' => 1,
                'permission_id' => $id,
            ]);
        }
    }
}
