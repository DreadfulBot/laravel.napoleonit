<form action="{{$actionRoute}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    @if(!empty($article))
        <input type="hidden" name="article_id" value="{{$article->id}}">
    @endif

    <div class="form-group">
        <label for="title">Заголовок:</label>
        <input type="text" class="form-control" name="title"
               placeholder="Заголовок" maxlength="255" value="{{$article->title ?? old('title')}}" data-error="обязательное поле" required>
        <div class="help-block with-errors" id="help-block-title">{{$errors->first('title')}}</div>
    </div>


     <div class="form-group">
        <label for="description">Краткое описание:</label>
        <input type="text" class="form-control" name="description"
               placeholder="Краткое описание" maxlength="255" value="{{$article->description ?? old('description')}}"
               data-error="обязательное поле" required>
        <div class="help-block with-errors" id="help-block-title">{{$errors->first('description')}}</div>
    </div>


    <div class="form-group">
        <label for="content">Текст статьи:</label>
        <textarea name="content" placeholder="Текст статьи" class="form-control"
                  data-error="обязательное поле" required>{{$article->content ?? old('content')}}</textarea>
        <div class="help-block with-errors" id="help-block-title">{{$errors->first('content')}}</div>
    </div>


    <div class="form-group">
        <label for="category">Категория:</label>
        <select name="category_id" title="category_id" class="form-control" data-error="обязательное поле" required>
            @foreach($categories as $category)
                <option value="{{$category->id}}" @if($category->id == old('category') ||
                $category == isset($article) ? $article->category_id : $category) selected @endif>
                    {{$category->category}}
                </option>
            @endforeach
        </select>
        <div class="help-block with-errors" id="help-block-title">{{$errors->first('category')}}</div>
    </div>


    <div class="form-group">
        <label for="image">Изображение:</label>
        <input type="file" name="image" data-error="обязательное поле">
        <div class="help-block with-errors" id="help-block-title">{{$errors->first('image')}}</div>
    </div>


    <div class="form-group">
        <input type="submit" class="btn btn-default" value="Отправить">
    </div>


</form>