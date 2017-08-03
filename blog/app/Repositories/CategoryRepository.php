<?php

namespace App\Repositories;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryRepository extends Controller
{
    public static function getAll() {
        return Category::get();
    }
}
