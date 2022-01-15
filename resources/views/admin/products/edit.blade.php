@extends('layouts.admin')

@section('title')
<title>Edit Product</title>
@endsection

@section('css')
<link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admins/product/edit/edit.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'product', 'key' => 'Edit'])
    <form action="{{ route('product.update',['id'=>$product->id]) }}" method="post" enctype="multipart/form-data">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">

                        @csrf
                        <!-- Name input -->
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" class="form-control" name="name" placeholder="Nhập tên sản phẩm" value="{{ $product->name }}">
                        </div>
                        <!-- Price input -->
                        <div class="form-group">
                            <label>Giá sản phẩm</label>
                            <input type="text" class="form-control" name="price" placeholder="Nhập giá sản phẩm" value="{{ $product->price }}">
                        </div>
                        <!-- Image -->
                        <div class="form-group">
                            <label>Hình ảnh đại diện sản phẩm</label>
                            <input type="file" class="form-control-file" name="feature_image_path">
                            <div class="col-md-4 container_feature_img_product">
                                <div class="row">
                                    <img class="img-fluid feature_img_product" src="{{ $product->feature_image_path }}" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- Detail Image -->
                        <div class="form-group">
                            <label>Ảnh chi tiết</label>
                            <input type="file" multiple class="form-control-file mb-2 preview_image_detail" name="image_path[]">
                            <div class="col-md-12 container_img_detail">
                                <div class="row">
                                    @foreach($product->productImages as $productImageItem)
                                    <div class="col-md-3">
                                        <img class="img-fluid img_detail_product" src="{{ $productImageItem->image_path }}" alt="">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Category -->
                        <div class="form-group">
                            <label>Chọn danh mục</label>
                            <select class="form-control select2-init" name="category_id">
                                <option>Chọn danh mục</option>
                                {!! $htmlOption !!}
                            </select>
                        </div>
                        <!-- Tag -->
                        <div class="form-group">
                            <label>Tags sản phẩm</label>
                            <select name="tags[]" class="form-control tag-select-choose" multiple="multiple">
                                @foreach($product->tags as $tagItem)
                                <option value="{{ $tagItem->name }}" selected>{{ $tagItem->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Content -->
                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="form-control tinymce_editor_init" name="content" rows="10">{{ $product->content }}</textarea>
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
<script src="{{ asset('admins/product/edit/edit.js') }}"></script>
@endsection