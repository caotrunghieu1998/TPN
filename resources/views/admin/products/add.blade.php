@extends('layouts.admin')

@section('title')
<title>Add Product</title>
@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admins/product/add/add.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'product', 'key' => 'Add'])
    <div class="col-md-12">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">

                        @csrf
                        <!-- Name input -->
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            name="name" 
                            placeholder="Nhập tên sản phẩm" 
                            value="{{ old('name') }}"
                            required>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Price input -->
                        <div class="form-group">
                            <label>Giá sản phẩm</label>
                            <input 
                            type="text" 
                            class="form-control @error('price') is-invalid @enderror" 
                            name="price" 
                            placeholder="Nhập giá sản phẩm" 
                            value="{{ old('price') }}"
                            required>
                            @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Image -->
                        <div class="form-group">
                            <label>Hình ảnh đại diện sản phẩm</label>
                            <input type="file" class="form-control-file" name="feature_image_path">
                        </div>
                        <!-- Detail Image -->
                        <div class="form-group">
                            <label>Ảnh chi tiết</label>
                            <input type="file" multiple class="form-control-file mb-2 preview_image_detail" name="image_path[]">
                            <div class="row image_detail_wrapper">

                            </div>

                        </div>
                        <!-- Category -->
                        <div class="form-group">
                            <label>Chọn danh mục</label>
                            <select class="form-control select2-init @error('category_id') is-invalid @enderror" name="category_id" required>
                                {!! $htmlOption !!}
                            </select>
                            @error('category_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Tag -->
                        <div class="form-group">
                            <label>Tags sản phẩm</label>
                            <select name="tags[]" class="form-control tag-select-choose" multiple="multiple">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Content -->
                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="@error('content') is-invalid @enderror form-control tinymce_editor_init" name="content" rows="10">
                                {{ old('content') }}
                            </textarea>
                            @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection

@section('js')
<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
<script src="{{ asset('admins/product/add/add.js') }}"></script>
@endsection