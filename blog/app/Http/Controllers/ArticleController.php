<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleParamsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    public function viewCreate() {
        return view('article.page-create')
            ->with(['actionRoute' => route('article.create.submit')]);
    }

    public function submitCreate(ArticleParamsRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = Input::all();

            // create article
            $article = Article::create($params);

            // move image to dir
            $imageName = $article->id . '-' . str_random(10) . '.' .
                $request->file('image')->getClientOriginalExtension();

            // assign image
            $request->file('image')->move(
                base_path() . env('ARTICLE_ABS_IMAGE_PATH'), $imageName
            );

            $article->update(
                ['image' => $imageName]
            );

            DB::commit();
            return response()->redirectToRoute('article.view', ['articleId' => $article->id]);

        } catch(\Exception $e) {
            DB::rollBack();
            return response()->redirectTo('/');
        }
    }

    public function submitUpdate(ArticleParamsRequest $request) {
        try {
            $params = Input::all();

            if (empty($params['article_id']))
                return redirect('/');

            $article = Article::findOrFail($params['article_id']);
            $article->update($params);

            // move image to dir
            $imageName = $article->id . '-' . str_random(10) . '.' .
                $request->file('image')->getClientOriginalExtension();

            // assign image
            $request->file('image')->move(
                base_path() . env('ARTICLE_ABS_IMAGE_PATH'), $imageName
            );

            $article->update(
                ['image' => $imageName]
            );

            DB::commit();
            return response()->redirectToRoute('article.view', ['articleId' => $article->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->redirectTo('/');
        }
    }

    public function viewUpdate($articleId) {
        $article = Article::findOrFail($articleId);

        $data = [
            'actionRoute' => route('article.update.submit'),
            'article' => $article
        ];

        return view('article.page-update')
            ->with($data);
    }

    public function viewArticle($articleId) {
        $article = Article::findOrFail($articleId);

        return view('article.page-view')
            ->with(['article' => $article]);
    }

}
