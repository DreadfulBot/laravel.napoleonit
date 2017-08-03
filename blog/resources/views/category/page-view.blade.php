@extends('layouts.master')

@section('content')

    @include('category.block-categories-h')

    <div class="row">
        <div class="col-md-12">
            <h3>Просмотр категории "{{$category->category}}"</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <table class="table table-striped">
                <tr>
                    <td>Заголовок</td>
                    <td>Краткое описание</td>
                    <td>Автор</td>
                    <td>Дата публикации</td>
                    <td>Действия</td>
                </tr>

                @foreach($articles as $article)
                    <tr>
                        <td>{{$article->title}}</td>
                        <td>{{$article->description}}</td>
                        <td>{{$article->user->name}}</td>
                        <td>{{$article->created_at}}</td>

                        <td>
                            @can('article.view')
                                <a href="{{route('article.view', ['articleId' => $article->id])}}">Просмотр</a>
                            @endcan

                            @can('article.update')
                                <a href="{{route('article.update.view', ['articleId' => $article->id])}}">Изменение</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6"><a href="{{URL::previous()}}">Назад</a></div>
    </div>
@endsection