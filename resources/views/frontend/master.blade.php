<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('frontend/images/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <title>Document</title>
</head>
<body>
    <header>
        @include('frontend.layouts.header')
    </header>
    <div class="top-search">
        <div class="container"> 
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <form id="form_search" action="{{ route('home') }}" style="width:95%;">
                    <input name="search" id="search_product" type="text" class="form-control" placeholder="Search">
                </form>
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    @yield('content')
    <footer>
        @include('frontend.layouts.footer')
    </footer>

    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.superslides.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('frontend/js/inewsticker.js') }}"></script>
    {{-- <script src="{{ asset('frontend/js/bootsnav.js.') }}"></script> --}}
    <script src="{{ asset('frontend/js/images-loded.min.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('frontend/js/form-validator.min.js') }}"></script>
    <script src="{{ asset('frontend/js/contact-form-script.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
</body>
</html>