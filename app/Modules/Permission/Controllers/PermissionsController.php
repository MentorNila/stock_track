<?php

namespace App\Modules\Permission\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Client\Facade\ClientFacade;
use App\Modules\Permission\Models\Permission;
use App\Modules\Permission\Requests\MassDestroyPermissionRequest;
use App\Modules\Permission\Requests\StorePermissionRequest;
use App\Modules\Permission\Requests\UpdatePermissionRequest;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{


    public function index()
    {

        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all();

        return view('Permission::index', compact('permissions'));
    }

    public function create()
    {

        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Permission::create');
    }

    public function store(StorePermissionRequest $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:permissions,title,NULL,id,deleted_at,NULL'
        ]);

        if ($validator->passes()) {

            $permission = Permission::create($request->all());

            return  response()->json(['success' => '1']);

        }
        return response()->json(['errors' => $validator->errors()]);

    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Permission::edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $updatePermissionRequest)
    {

        $validator = Validator::make($updatePermissionRequest->all(), [
            'title' => 'required|unique:permissions,title,NULL,id,deleted_at,NULL'
        ]);

        if ($validator->passes()) {

            $id = $updatePermissionRequest->input('permission-id');

            $permission = Permission::find($id);

            $permission->update($updatePermissionRequest->all());

            return response()->json(['success' => '1']);

        }
        return response()->json(['errors' => $validator->errors()]);

    }

    public function show(Permission $permission)
    {

        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('Permission::show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {

        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        return back();
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {

        Permission::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
