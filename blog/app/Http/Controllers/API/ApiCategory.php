<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryParamsRequest;
use App\Http\Requests\UserParamsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ApiCategory extends Controller
{
    public function get() {
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

        header("Content-Type: application/json");
        echo json_encode($result);
    }

    public function post(CategoryParamsRequest $request) {
        $params = Input::all();
        $result = Category::create([
            'category' => $params['category']
        ]);

        header("Content-Type: application/json");
        echo json_encode($result);
    }

    public function delete() {
        parse_str(file_get_contents("php://input"), $_DELETE);

        // category "without category" must live
        if($_DELETE['id'] == 6)
            return false;

        $category = Category::find($_DELETE['id']);
        if(!$category)
            return;

        // move all categories to "without category"
        foreach ($category->article()->get() as $article) {
            $article->update([
               'category_id' => 6
            ]);
        }

        $result = $category->delete();

        header("Content-Type: application/json");
        echo json_encode($result);
    }

    public function put(CategoryParamsRequest $request) {
        parse_str(file_get_contents("php://input"), $_PUT);
        $category = Category::find($_PUT['id']);
        if(!$category)
            return;

        // make all empty fields not-null
        foreach ($_PUT as $index => $value)
            if($value == "")
                $_PUT[$index] = null;

        $category->update($_PUT);

        header("Content-Type: application/json");
        echo json_encode($category);
    }
}
