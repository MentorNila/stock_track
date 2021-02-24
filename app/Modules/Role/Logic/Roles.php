<?php namespace App\Modules\Role\Logic;

use App\Modules\Role\Models\Role;

class Roles
{
    protected $user;

    public function __construct(){
        $this->user = auth()->user();
    }

    public function getRolesByLevel(){
        if($this->user->is_superadmin){
            return Role::all();//->pluck('title', 'id');
        }
        $roles = $this->filterRolesByLevel();

        return $roles->get();
    }
    /**
     * Check if auth user has permission to update specific user
     */
    public function checkAccess($role) {
        if ($this->user->role->level > $role->level){
            return false;
        }

        return true;
    }
    function filterRolesByLevel(){
        return Role::where('level', '>=', $this->user->role->level);
    }

    function prepareRoleByLevel(){
        $roles = $this->getRolesByLevel();
        return $roles->pluck('title', 'id');
    }
}
