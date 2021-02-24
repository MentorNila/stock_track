<?php

namespace App\Modules\Role\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Permission\Models\Permission;
use App\Modules\Role\Logic\Roles;
use App\Modules\Role\Models\Role;
use App\Modules\Role\Requests\MassDestroyRoleRequest;
use App\Modules\Role\Requests\StoreRoleRequest;
use App\Modules\Role\Requests\UpdateRoleRequest;
use Gate;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = (new Roles())->getRolesByLevel();
        $permissions = Permission::all()->pluck('title', 'id');
        return view('Role::index', compact('roles','permissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Role::create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {

        $roleData = $request->all();
        $roleData['agency_level'] = isset($roleData['agency_level']) ? 1 : 0;


        $existingRole_title = Role::where('title', $request['title'])->first();
        $existingRole_code = Role::where('code', $request['code'])->first();


        if ($existingRole_code) {
            return response()->json(['error_code_unique' => 'Role with this code exists already']);
        }

        if ($existingRole_title) {
            return response()->json(['error_title_unique' => 'Role with this title exists already']);
        }


        $role = Role::create($roleData);

        return response()->json(['success' => '1']);

    }

    public function edit(Role $role)
    {
        abort(404);
        abort_if(Gate::denies('role_edit') || !(new Roles())->checkAccess($role), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Role::edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request)
    {

        $roleData = $request->all();
        $roleData['agency_level'] = isset($roleData['agency_level']) ? 1 : 0;


        $id = $request->input('id');

        $role = Role::find($id);

        $existingRole_title = Role::where('title', $request['title'])->first();
        $existingRole_code = Role::where('code', $request['code'])->first();


        if ($existingRole_code) {
            if($role->id != $existingRole_code->id){
                return response()->json(['error_code_unique' => 'Role with this code exists already']);
            }
        }

        if ($existingRole_title) {
            if($role->id != $existingRole_title->id){
                return response()->json(['error_title_unique' => 'Role with this title exists already']);
            }
        }

        $role->update($roleData);

        return response()->json(['success' => '1']);
    }


    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show') || !(new Roles())->checkAccess($role), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->load('permissions');

        return view('Role::show', compact('role'));
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();

        return back();
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        Role::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function rolesPermissions(Request $request){
        $rolePermissions = $request->all()['permissions'];
        $roles = Role::all();
        foreach($roles as $role){
            if(!array_key_exists($role->id, $rolePermissions)){
                $role->permissions()->sync([]);
            }
        }
        foreach($rolePermissions as $key => $value){
            $role = Role::where('id', $key)->first();
            $role->permissions()->sync($value);
        }
        return redirect()->route('admin.roles.index');
    }

    public function getRole(){
        $roleId = \Request::all()['id'];
        $role = Role::find($roleId)->toArray();

        return \Response::json(array(
            'success'=> true,
            'role' => $role,
        ), 200);
    }
}
