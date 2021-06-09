@extends('backend.master')
@section('content')
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
                        <h3 class="card-title">Import Product</h3>
                        </div>
                    </div>
                    <form action="{{ route('product.process') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Choose File Excel</label>
                            <input type="file" name="excel" class="form-control">
                        </div>
                        <div class="button">
                            <button class="btn btn-primary button-submit">Import</button>
                            <a class="btn btn-primary button-submit" href="{{ route('product.list') }}">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection