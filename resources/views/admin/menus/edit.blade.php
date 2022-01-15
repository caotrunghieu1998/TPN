
@extends('layouts.admin')

@section('title')
    <title>Trang chu</title>
@endsection


@section('content')

    <div class="content-wrapper">
        @include('partials.content-header', ['name' => 'Menu', 'key' => 'Edit'])

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('menus.update',['id'=> $menuFollowEdit->id]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Tên menu</label>
                                <input type="text"
                                       class="form-control"
                                       name="name"
                                       placeholder="Nhập tên menu"
                                       value="{{ $menuFollowEdit->name }}"
                                >
                            </div>

                            <div class="form-group">
                                <label>Chọn menu cha</label>
                                <select class="form-control" name="parent_id">
                                    <option value="0">Chọn menu cha</option>
                                    {!! $htmlOption !!}
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

