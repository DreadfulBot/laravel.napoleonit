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
                        filter.api_token = '{{Auth::user()->api_token}}';
                        return $.ajax({
                            type: "GET",
                            url: "{{ route('api.user.get') }}",
                            data: filter,
                            dataType: "json"
                        });
                    },
                    updateItem: function (item) {
                        item.api_token = '{{Auth::user()->api_token}}';
                        return $.ajax({
                            type: "PUT",
                            url: "{{ route('api.user.put') }}",
                            data: item,
                            dataType: "json"
                        });
                    },
                    deleteItem: function (item) {
                        item.api_token = '{{Auth::user()->api_token}}';
                        return $.ajax({
                            type: "DELETE",
                            url: "{{ route('api.user.delete') }}",
                            data: item,
                            dataType: "json"
                        });
                    },
                    insertItem: function (item) {
                        item.api_token = '{{Auth::user()->api_token}}';
                        return $.ajax({
                            type: "POST",
                            url: "{{ route('api.user.post') }}",
                            data: item,
                            dataType: "json"
                        });
                    }
                },
                fields: [
                    {name: "id", width: "40px", title: "id", type: "number", filtering: false, editing: false, inserting: false},
                    {name: "name", title: "name", type: "text", filtering: true, editing: true},
                    {name: "email", title: "email", type: "text", filtering: false, editing: true},
                    {name: "password", title: "password", type: "text", filtering: true, editing: true},
                    {name: "remember_token", title: "remember_token", type: "text", filtering: false, editing: false, inserting: false},
                    {name: "api_token", title: "api_token", type: "text", filtering: false, editing: false, inserting: false},
                    {name: "is_user", title: "is_user", type: "checkbox", filtering: false, editing: true, inserting: true},
                    {name: "is_admin", title: "is_admin", type: "checkbox", filtering: false, editing: true, inserting: true},
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

