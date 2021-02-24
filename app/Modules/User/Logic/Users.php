<?php namespace App\Modules\User\Logic;

use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserCompany;
use App\Modules\User\Models\UserFiling;
use Illuminate\Support\Facades\DB;

class Users
{
    protected $user;

    public function __construct(){
        $this->user = auth()->user();
    }

    /**
     * Check if auth user has permission to update specific user
     */
    public function checkAccess($user) {
        if ($this->user->role->level > $user->role->level){
            return false;
        }

        return true;
    }

    public function getUsers(){
        $users = DB::table(User::getTableName() . ' as u')
            ->join(Role::getTableName() . ' as r', 'r.id', '=', 'u.role_id');

        if($this->user->is_superadmin){
            return $users;
        }

        $users = $this->filterUsersByLevel($users);
        $users = $this->filterUsersByCompany($users);

        return $users;
    }

    function filterUsersByLevel($users){
        $users = $users->where('r.level', '>=', $this->user->role->level);

        return $users;
    }

    function filterUsersByCompany($users){
        $userCompanies = UserCompany::where('user_id', $this->user->id)->get()->pluck('company_id')->toArray();
        $users = $users->join(UserCompany::getTableName() . ' as uc', 'u.id', '=', 'uc.user_id')
            ->whereIn('uc.company_id', $userCompanies);

        return $users;
    }

    public function getAssignedUsersFiling($filingId){
        return DB::table(User::getTableName() . ' as u')
            ->join(UserFiling::getTableName() . ' as uf', 'uf.user_id', '=', 'u.id')
            ->where('filing_id', $filingId)
            ->distinct()
            ->get();
    }

    public function getAvailableUsersToAssign($assignedUsers){
        $users = $this->getUsers();
        $users = $users->select('u.id as id', 'u.name as name', 'u.email as email', 'r.title as role_title')
            ->whereNotIn('u.id', $assignedUsers->pluck('id')->toArray())
            ->distinct()->get();

        $agencyLevelUsers = $this->getAgencyLevelUsers()
            ->select('u.id as id', 'u.name as name', 'u.email as email', 'r.title as role_title')
            ->whereNotIn('u.id', $assignedUsers->pluck('id')->toArray())
            ->get();

        return $users->merge($agencyLevelUsers);
    }

    public function prepareUsersAsOptions($selectedUsers, $availableUsers){
        $content = '';
        if (!empty($selectedUsers)){
            foreach ($selectedUsers as $user){
                $content .= '<option value="' . $user->id . '" selected>' . $user->email . '</option>';
            }
        }
        if (!empty($availableUsers)){
            foreach ($availableUsers as $user){
                $content .= '<option value="' . $user->id . '">' . $user->email . '</option>';
            }
        }

        return $content;
    }

    public function assignUsersToFiling($userIds, $filingId){
        UserFiling::store($userIds, $filingId);
    }

    public function getAgencyLevelUsers(){
        return DB::table(User::getTableName() . ' as u')
            ->join(Role::getTableName() . ' as r', 'r.id', '=', 'u.role_id')
            ->where('r.agency_level',1);
    }
}
