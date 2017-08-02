<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function test() {
        $user = new User([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678')
        ]);
        $user->save();

        $user1 = User::first();
        dd($user1);
    }
}
