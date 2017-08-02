<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryParamsRequest;
use App\Http\Requests\UserParamsRequest;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;

class ApiCategory extends Controller
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
        if(!$this->authRequest('category.list'))
            return response()->json(['message' => 'неудачная проверка подлинности']);

        $category = Input::get('category');

        $pageIndex = Input::get('pageIndex') - 1;
        $pageSize  = Input::get('pageSize');

        $sortField = Input::get('sortField') ?? 'id';
        $sortOrder = Input::get('sortOrder') ?? 'desc';

        if(empty($category)) {
            $categories = Category::limit($pageSize)
                ->offset($pageIndex * $pageSize)
                ->orderBy($sortField, $sortOrder)
                ->get();
        } else {
            $categories = Category::where('category', 'like', "%".$category."%")
                ->orderBy($sortField, $sortOrder)
                ->get();
        }

        $result = ['data' => $categories, 'itemsCount' => Category::count()];

        return response()->json($result);
    }

    public function post(CategoryParamsRequest $request) {
        if(!$this->authRequest('category.create'))
            return response()->json(['message' => 'неудачная проверка подлинности']);

        $params = Input::all();
        $result = Category::create([
            'category' => $params['category']
        ]);

        return response()->json($result);
    }

    public function delete() {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $category = Category::find($_DELETE['id']);

        if(!$this->authRequest('category.delete', $category))
            return response()->json(['message' => 'неудачная проверка подлинности']);

        if(!$category)
            return response()->json(['message' => 'категория не найдена']);

        // move all articles to "without category"
        foreach ($category->article()->get() as $article) {
            $article->update([
               'category_id' => 1
            ]);
        }

        //delete category
        $result = $category->delete();

        return response()->json($result);
    }

    public function put(CategoryParamsRequest $request) {
        parse_str(file_get_contents("php://input"), $_PUT);
        $category = Category::find($_PUT['id']);

        if(!$this->authRequest('category.update', $category))
            return response()->json(['message' => 'неудачная проверка подлинности']);

        if(!$category)
            return response()->json(['message' => 'категория не найдена']);

        // make all empty fields not-null
        foreach ($_PUT as $index => $value)
            if($value == "")
                $_PUT[$index] = null;

        $category->update($_PUT);

        return response()->json($category);
    }
}
