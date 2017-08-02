<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listCategories() {
        return view('admin.categories');
    }
}
