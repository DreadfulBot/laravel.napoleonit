@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href=" {{ asset("css/jsgrid.min.css") }}">
    <link rel="stylesheet" href=" {{ asset("css/jsgrid-theme.min.css") }}">
    <link rel="stylesheet" href=" {{ asset("css/jsgrid.custom.css") }}">
@endsection

@section('scripts')
    <script src="{{asset('js/jsgrid.min.js')}}" language="JavaScript"></script>
@endsection

@section('script')
    <script type="text/javascript">
        function initCategoriesGrid() {
            var grid = '#categories-grid';

            $(grid).jsGrid({
                height: "400px",
                width: "100%",
                filtering: true,
                inserting: true,
                editing: true,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 20,
                pageButtonCount: 5,
                pageLoading: true,
                deleteConfirm: "Вы действительно хотите удалить элемент?",
                controller: {
                    loadData: function (filter) {
                        filter.api_token = '{{Auth::user()->api_token}}';
                        return $.ajax({
                            type: "GET",
                            url: "{{ route('api.category.get') }}",
                            data: filter,
                            dataType: "json"
                        });
                    },
                    updateItem: function (item) {
                        item.api_token = '{{Auth::user()->api_token}}';
                        return $.ajax({
                            type: "PUT",
                            url: "{{ route('api.category.put') }}",
                            data: item,
                            dataType: "json"
                        });
                    },
                    deleteItem: function (item) {
                        item.api_token = '{{Auth::user()->api_token}}';
                        return $.ajax({
                            type: "DELETE",
                            url: "{{ route('api.category.delete') }}",
                            data: item,
                            dataType: "json"
                        });
                    },
                    insertItem: function (item) {
                        item.api_token = '{{Auth::user()->api_token}}';
                        return $.ajax({
                            type: "POST",
                            url: "{{ route('api.category.post') }}",
                            data: item,
                            dataType: "json"
                        });
                    }
                },
                fields: [
                    {name: "id", width: "40px", title: "id", type: "number", filtering: false, editing: false, inserting: false},
                    {name: "category", title: "category", type: "text", filtering: true, editing: true},
                    {
                        name: "created_at",
                        title: "created_at",
                        type: "timestamp",
                        filtering: false,
                        editing: false,
                        inserting: false
                    },
                    {
                        name: "updated_at",
                        title: "updated_at",
                        type: "timestamp",
                        filtering: false,
                        editing: false,
                        inserting: false
                    },
                    {type: "control"}
                ]
            });
        }

        $(document).ready(function () {
            initCategoriesGrid();
        });
    </script>
@endsection

@section('content')
        <div id="categories-grid" style="height: 400px;"></div>
@endsection

