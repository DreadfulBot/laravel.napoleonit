<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserParamsRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ApiUser extends Controller
{
    public function get() {

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
