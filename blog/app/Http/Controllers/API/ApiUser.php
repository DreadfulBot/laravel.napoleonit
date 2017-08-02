<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserParamsRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ApiUser extends Controller
{
    public function authRequest($permission) {
        $userId = Auth::guard('api')->id();
        $user = $userId ? User::find($userId) : null;

        if(!$user)
            return false;

        if(!$user->can($permission))
            return false;

        return true;
    }

    public function get() {
        if(!$this->authRequest('user.list'))
            return response()->json(['message' => 'неудачная проверка подлинности']);

    }

    public function post(UserParamsRequest $request) {
        $params = Input::all();
        //
        // $user = User::create([
        //     'name' => $params['name'],
        //     'email' => $params['email'],
        //     'password' => bcrypt($params['password'])
        // ]);

        header("Content-Type: application/json");
        echo json_encode($user);
    }

    public function put(UserParamsRequest $request) {

    }

    public function delete() {

    }
}
