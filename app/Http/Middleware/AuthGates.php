<?php

namespace App\Http\Middleware;

use App\Modules\Client\Facade\ClientFacade;
use App\Modules\Client\Models\Client;
use App\Modules\Permission\Models\Permission;
use App\Modules\Role\Models\PermissionRole;
use App\Modules\User\Models\User;
use App\Modules\Role\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;
use function foo\func;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();
        if (!app()->runningInConsole() && $user) {
            $roles = Role::with('permissions')->get();
            $permissionsArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permission){
                    $permissionsArray[$permission->title][] = $role->id;

                }
            }

            foreach ($permissionsArray as $title => $roles) {
                Gate::define($title, function (User $user) use ($roles) {
                    return in_array($user->role->id, $roles);
                });
            }
        }

        return $next($request);
    }
}
