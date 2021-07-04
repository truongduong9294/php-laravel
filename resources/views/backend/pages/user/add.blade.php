@extends('backend.master');
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header title">
                  <h3 class="card-title">Add User</h3>
                </div>
            </div>
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
                        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" name="user_name" placeholder="User Name" value="{{ old('user_name') }}">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="">Avatar</label>
                                <input type="file" name="avatar" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Role Name</label>
                                <select class="form-control" style="width: 100%;" name="role_id">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="button">
                                <a class="btn btn-primary button-submit" href="{{ route('user.list') }}">Back</a>
                                <button class="btn btn-primary button-submit">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection