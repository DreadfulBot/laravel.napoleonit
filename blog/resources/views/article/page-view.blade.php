@extends('layouts.master')

@section('content')

    @include('category.block-categories-h')


    <div class="row">
        <div class="col-md-12"><h3>Просмотр статьи</h3></div>
    </div>

    <div class="row">
        <div class="col-md-12"><h3>{{$article->title}}</h3></div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @if(!empty($article->image) && File::exists(base_path() . env("ARTICLE_ABS_IMAGE_PATH").$article->image))
                <img src="{{asset(env("ARTICLE_REL_IMAGE_PATH").$article->image)}}">
            @endif
        </div>
        <div class="col-md-8">
            <h3>Краткое описание:</h3>
            <p>{{$article->description}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Текст статьи:</h3>
            <p>{{$article->content}}</p>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-3"><p>Автор:</p>{{$article->user->name}}</div>
        <div class="col-md-3"><p>Категория</p>{{$article->category->category}}</div>
        <div class="col-md-3"><p>Дата создания:</p>{{$article->created_at}}</div>
    </div>

    <div class="row">
        <div class="col-md-6"><a href="{{URL::previous()}}">Назад</a></div>
        @can('article.update')
            <div class="col-md-6"><a href="{{route('article.update.view', ['articleId' => $article->id])}}">Изменить</a></div>
        @endcan

    </div>
@endsection