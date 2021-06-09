<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 col-md-offset-1">
                <div class="login" style="text-align: center">
                    <h3>Login</h3>
                </div>
                @if(session()->has('message'))  
                    <div class="alert-message">
                        <div class="alert alert-danger message-message">
                            {{ session()->get('message') }}
                        </div>
                    </div>
                @endif
                @if(session()->has('success'))  
                <div class="alert-message">
                        <div class="alert alert-success message-success">
                            {{ session()->get('success') }}
                        </div>
                    </div>
                @endif
                <form action="{{ route('user.login.process') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" class="form-control" name="user_name" placeholder="User Name">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="button_submit" style="text-align: center">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <div>
                    <a href="{{ route('forgot') }}">Forgot Password?</a>
                </div>
                <div>
                    <a href="{{ route('user.register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>