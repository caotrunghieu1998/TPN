@extends('layouts.admin')

@section('title')
<title>List Product</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('admins/product/index/list.css') }}">
@endsection

@section('header')
@include('partials.header-category')
@endsection

@section('content')

<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'product', 'key' => 'List'])

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('product.create') }}" class="btn btn-success float-right m-2">Add</a>

                </div>
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{number_format($product->price) }}</td>
                                <td>
                                    <img class="product_img_150_100 img-fluid" src="{{ $product->feature_image_path }}" alt="">
                                </td>
                                <td>{{ optional($product->category)->name }}</td>
                                <td>
                                    <!-- ('category-edit') -->
                                    <a href="{{ route('product.edit',['id'=>$product->id]) }}" class="btn btn-default">Edit</a>

                                    <!-- ('category-delete') -->
                                    <a 
                                    href="" 
                                    data-url="{{ route('product.delete',['id'=>$product->id]) }}"
                                    class="btn btn-danger action_delete"
                                    >Delete</a>


                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script src="{{ asset('vendor/sweetAlert2/sweetalert2@11.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/product/index/list.js') }}"></script>
@endsection