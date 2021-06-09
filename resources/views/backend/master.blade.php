<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('backend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/js/main.js') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <title>Document</title>
</head>
<body>
    <header>
        @include('backend.layouts.header')
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        @include('backend.layouts.footer')
    </footer>
</body>
</html>
<script>
    $(document).ready(function(){
      var path = window.location.href.split('?')[0];
      $('.nav-item a').each(function() {
        if (this.href === path) {
          $(this).addClass('active');
        }
      });
    });
</script>