@extends('layouts.master')

@section('content')

    @include('category.block-categories-h')

    <div class="row">
        <div class="col-md-6"><a href="{{URL::previous()}}">Назад</a></div>
    </div>
@endsection