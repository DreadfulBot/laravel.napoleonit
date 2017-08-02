<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserParamsRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ApiUser extends Controller
{
    public function authRequest($permission, $params = null) {
        $userId = Auth::guard('api')->id();
        $user = $userId ? User::find($userId) : null;

        if(!$user)
            return false;

        if(!$user->can($permission, $params))
            return false;

        return true;
    }

    public function get() {
        if(!$this->authRequest('user.list'))
            return response()->json(['message' => 'неудачная проверка подлинности']);

        $name = Input::get('name');

        $pageIndex = Input::get('pageIndex') - 1;
        $pageSize  = Input::get('pageSize');

        $sortField = Input::get('sortField') ?? 'id';
        $sortOrder = Input::get('sortOrder') ?? 'desc';

        if(empty($name)) {
            $users = User::with('role')
                ->limit($pageSize)
                ->offset($pageIndex * $pageSize)
                ->orderBy($sortField, $sortOrder)
                ->get();

            foreach ($users as $userIndex => $userValue) {
                foreach ($userValue->role()->get() as $roleIndex => $roleValue) {
                    switch ($roleValue->role) {
                        case 'admin':
                            $users[$userIndex]->is_admin = true;
                            break;
                        case 'user':
                            $users[$userIndex]->is_user = true;
                            break;
                    }
                }
            }

        } else {
            $users = Category::with('role')
                ->where('name', 'like', "%".$name."%")
                ->orderBy($sortField, $sortOrder)
                ->get();
        }

        $result = ['data' => $users, 'itemsCount' => User::count()];

        return response()->json($result);
    }

    public function post(UserParamsRequest $request) {
        if(!$this->authRequest('user.create'))
            return response()->json(['message' => 'неудачная проверка подлинности']);

        $params = Input::all();

        $user = User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => bcrypt($params['password']),
            'api_token' => str_random(60),
            'remember_token' => str_random(60),
        ]);

        // attaching roles
        $roleAdmin = Role::where('role', 'admin')
            ->first();

        if(!$roleAdmin) {
            return response()->json(['message' => 'не найдена роль администратора']);
        }

        $roleUser = Role::where('role', 'user')
            ->first();

        if(!$roleUser) {
            return response()->json(['message' => 'не найдена роль пользователя']);
        }

        if($params['is_admin']) {
            $user->role()->attach($roleAdmin->id, ['is_current' => 1]);
        }

        if($params['is_user']) {
            $user->role()->attach($roleUser->id, ['is_current' => 1]);
        }

        return response()->json($user);
    }

    public function put(UserParamsRequest $request) {

    }

    public function delete() {

    }
}
