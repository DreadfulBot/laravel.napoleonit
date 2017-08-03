<div class="row">
    <h3>Категории</h3>
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{route('category.view.id', ['categoryId' => $category->id])}}">
                    {{$category->category}}
                </a>
            </li>
        @endforeach
    </ul>
</div>