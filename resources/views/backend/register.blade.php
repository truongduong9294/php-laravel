<html>    
    <head>
        <title>My Awesome Login Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container h-100">
            <div class="d-flex justify-content-center h-100">
                <div class="user_card user_card_register">
                    <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <img src="https://cdn.freebiesupply.com/logos/large/2x/pinterest-circle-logo-png-transparent.png" class="brand_logo" alt="Logo">
                        </div>
                    </div>
                    <div class="form_container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('user.register.process') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="user_name" class="form-control input_user" placeholder="User Name" value="{{ old('user_name') }}">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                </div>
                                <input type="text" name="name" class="form-control input_pass" placeholder="Name" value="{{ old('name') }}">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control input_pass" placeholder="Email" value="{{ old('email') }}">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control input_pass" placeholder="Password">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="far fa-image"></i></span>
                                </div>
                                <input type="file" name="avatar" class="form-control input_pass">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-hand-pointer"></i></span>
                                </div>
                                <select class="form-control input_pass" name="role_id">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button class="btn login_btn">Sign Up</button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex links">
                            <a href="{{ route('user.login') }}" class="btn btn-primary ml-2">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
