@extends('layouts.admin')

@section('title')
<title>Trang chủ</title>
@endsection

@section('js')
<script src="{{ asset('vendors/sweetAlert2/sweetalert2@9.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/main.js') }}"></script>
@endsection

@section('header')
@include('partials.header-category')
@endsection

@section('content')

<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'Menu', 'key' => 'List'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- ('category-add') -->
                    <a href="{{ route('menus.create') }}" class="btn btn-success float-right m-2">Add</a>

                </div>
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên menu</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($menus as $menu)
                            <tr>
                                <th scope="row">{{ $menu->id }}</th>
                                <td>{{ $menu->name }}</td>
                                <td>
                                    <!-- ('category-edit') -->
                                    <a href="{{ route('menus.edit', ['id' => $menu->id]) }}" class="btn btn-default">Edit</a>

                                    <!-- ('category-delete') -->
                                    <a href="{{ route('menus.delete', ['id' => $menu->id]) }}" class="btn btn-danger action_delete">Delete</a>


                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    {{ $menus->links() }}
                </div>

            </div>
        </div>
    </div>

</div>

@endsection