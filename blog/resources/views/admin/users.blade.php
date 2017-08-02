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
        function initUsersGrid() {
            var grid = '#users-grid';

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
                        return $.ajax({
                            type: "GET",
                            url: "{{ route('api.category.get') }}",
                            data: filter,
                            dataType: "json"
                        });
                    },
                    updateItem: function (item) {
                        return $.ajax({
                            type: "PUT",
                            url: "{{ route('api.category.put') }}",
                            data: item,
                            dataType: "json"
                        });
                    },
                    deleteItem: function (item) {
                        return $.ajax({
                            type: "DELETE",
                            url: "{{ route('api.category.delete') }}",
                            data: item,
                            dataType: "json"
                        });
                    },
                    insertItem: function (item) {
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
                    {name: "name", title: "name", type: "text", filtering: true, editing: true},
                    {name: "email", title: "email", type: "text", filtering: true, editing: true},
                    {name: "password", title: "password", type: "text", filtering: true, editing: true},
                    {name: "remember_token", title: "remember_token", type: "text", filtering: true, editing: true},
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
            alert('при изменениие пароля пользователя следует указывать его в обычном виде' +
                ' - при сохранении он будет зашифрован');

            initUsersGrid();
        });
    </script>
@endsection

@section('content')
    <div id="users-grid" style="height: 400px;"></div>
@endsection

