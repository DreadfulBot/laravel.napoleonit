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
    public function loadRoles($users) {
        /* @var \App\User $user */
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
    }

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
        } else {
            $users = Category::with('role')
                ->where('name', 'like', "%".$name."%")
                ->orderBy($sortField, $sortOrder)
                ->get();
        }

        $this->loadRoles($users);

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
        if($params['is_admin'] == "true") {
            $user->role()->attach(1, ['is_current' => 1]);
        }

        if($params['is_user'] == "true") {
            $user->role()->attach(2, ['is_current' => 1]);
        }

        return response()->json($user);
    }

    public function delete() {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $user = User::find($_DELETE['id']);

        if(!$this->authRequest('user.delete', $user))
            return response()->json(['message' => 'неудачная проверка подлинности']);

        if(!$user)
            return response()->json(['message' => 'пользователь не найден']);

        // move all articles to admin
        foreach ($user->article()->get() as $article) {
            $article->update([
                'user_id' => 1
            ]);
        }

        // delete user
        $user->role()->detach();
        $result = $user->delete();
        return response()->json($result);
    }

    public function put(UserParamsRequest $request) {
        parse_str(file_get_contents("php://input"), $_PUT);
        $params = $_PUT;
        $user = User::find($_PUT['id']);

        if(!$this->authRequest('user.update', $user))
            return response()->json(['message' => 'неудачная проверка подлинности']);

        if(!$user)
            return response()->json(['message' => 'пользователь не найден']);

        // make all empty fields not-null
        foreach ($_PUT as $index => $value)
            if($value == "")
                $_PUT[$index] = null;

        $_PUT['api_token'] = str_random(60);
        $user->update($_PUT);

        // attaching roles
        $user->role()->detach();
        if($params['is_admin'] == "true") {
            $user->role()->attach(1, ['is_current' => 1]);
        }

        if($params['is_user'] == "true") {
            $user->role()->attach(2, ['is_current' => 1]);
        }

        $this->loadRoles($user);

        return response()->json($user);
    }
}
