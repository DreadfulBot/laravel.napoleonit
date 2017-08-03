<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listCategories() {
        return view('admin.categories');
    }

    public function showCategories() {
        return view('category.page-list');
    }

    public function showCategory($categoryId) {
        $category = Category::findOrFail($categoryId);

        $articles = Article::where('category_id', $categoryId)
            ->orderBy('created_at')->get();

        $data = [
            'category' => $category,
            'articles' => $articles
        ];

        return view('category.page-view', $data);
    }
}
