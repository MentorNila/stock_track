<?php

namespace App\Modules\User\Controllers;

use App\Modules\Company\Logic\CompanyLogic;
use App\Http\Controllers\Controller;
use App\Modules\Role\Logic\Roles;
use App\Modules\User\Logic\Notifications;
use App\Modules\User\Logic\Users;
use App\Modules\User\Models\User;
use App\Modules\Role\Models\Role;
use App\Modules\User\Requests\MassDestroyUserRequest;
use Gate;
use DB;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = (new Users())->getUsers();
        $users = $users->select('u.id as id', 'u.name as name', 'u.email as email', 'r.title as role_title')
            ->distinct()->get();

        return view('User::index', compact('users'))->with(['users' => $users]);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = (new Roles())->prepareRoleByLevel();
        $companies = (new CompanyLogic)->getCompanies();

        return view('User::create', compact('roles', 'companies'));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->save();
        $user->companies()->sync($request->input('companies', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit') || !(new Users())->checkAccess($user), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = (new Roles())->prepareRoleByLevel();
        $companies = (new CompanyLogic)->getCompanies();

        return view('User::edit', compact('roles', 'user', 'companies'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        $user->companies()->sync($request->input('companies', []));

        return redirect()->route('admin.users.index');
    }

    public function updatePassword(Request $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show') || !(new Users())->checkAccess($user), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('User::show', compact('user'));
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        if (isset($request['id'])) {
            $em = User::where('email', $email)->where('id', '!=', $request['id'])->first();
            if ($em) {
                return \Response::json(array(
                    'success' => 'true'
                ), 200);
            } else {
                return \Response::json(array(
                    'success' => 'false',
                ), 200);
            }
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            return \Response::json(array(
                'success' => 'true'
            ), 200);
        } else {
            return \Response::json(array(
                'success' => 'false',
            ), 200);
        }
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(\Request $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function markNotificationAsRead(){
        $data = \Request::all();
        $notificationID = null;
        if(!is_null($data['id'])){
            $notificationID = $data['id'];
        }
        (new Notifications)->markNotificationAsRead($notificationID);

        return \Response::json(array(
            'success'=> true
        ), 200);
    }


}
