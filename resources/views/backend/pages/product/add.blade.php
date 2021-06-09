@extends('backend.master')
@section('content')
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-1">
                        <div class="card card-default">
                            <div class="card-header title">
                                <h3 class="card-title">Add Product</h3>
                            </div>
                        </div>
                        <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data" id="formProduct">
                            @csrf
                            <div class="form-group">
                                <label>Category Name</label>
                                <select class="form-control" style="width: 100%;" name="category_id">
                                    @foreach($categories as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="product_name" placeholder="Product Name" value="{{old('product_name')}}">
                            </div>
                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" name="price" placeholder="Price" value="{{old('price')}}">
                            </div>
                            <div class="button">
                                <button class="btn btn-primary button-submit">Add</button>
                                <a class="btn btn-primary button-submit" href="{{ route('product.list') }}">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection