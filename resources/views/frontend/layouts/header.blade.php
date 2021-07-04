<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('frontend/images/logo.png') }}" class="logo" alt=""></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                <li class="nav-item active"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Category</a>
                    <ul class="dropdown-menu">
                        @foreach ($categories as $item)
                            <li><a href="{{ route('home', ['fillter' => $item->category_name]) }}">{{ $item->category_name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @if (Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('auth.logout') }}">Logout</a></li>
                @else
                    <li class="nav-item login"><a class="nav-link" href="">Login</a></li>
                    <li class="nav-item register"><a class="nav-link" href="">Register</a></li>
                @endif
            </ul>
        </div>
        <?php
            if (Session::has('cart')) {
                $count = count(Session::get('cart'));
            }else {
                $count = 0;
            }
        ?>
        <div class="attr-nav">
            <ul>
                <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                <li class="side-menu">
                    <a href="#" class="open_cart">
                        <i class="fa fa-shopping-bag"></i>
                        <span class="badge">{{ $count }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="side">
        <a href="#" class="close-side"><i class="fa fa-times"></i></a>
        <li class="cart-box">
            <ul class="cart-list">
                @if (Session::has('cart')) 
                    @foreach(Session::get('cart') as $cart)
                        <li class="cart_item">
                            <a href="#" class="photo"><img src="{{ asset('uploads/' . $cart['image']) }}" class="cart-thumb" alt="" /></a>
                            <h6><a href="#"> {{ $cart['product_name'] }} </a></h6>
                            <p><span class="price">{{ $cart['quantity'] }} x ${{ $cart['price'] }}</span></p>
                        </li>
                    @endforeach
                @endif
                <li class="total">
                    <a href="{{ route('view.cart') }}" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                    <span class="float-right total_price_cart"><strong>Total</strong>: $180.00</span>
                </li>
            </ul>
        </li>
    </div>
</nav>
@if (Auth::check())
    <input type="hidden" id="check_login" value="true">
@else
    <input type="hidden" id="check_login" value="false">
@endif
<div id="loginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="login_form">
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <label class="lab-category-name">User Name</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="lab-category-name">Password</label>
                        <input type="password" name="password" id="password" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                </div>
            </form>
        </div>
    </div>
</div>
<div id="registerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="register_form" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Register</h4>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_register_output"></span>
                    <div class="form-group">
                        <label class="lab-category-name">User Name</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="lab-category-name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="lab-category-name">email</label>
                        <input type="text" name="email" id="email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="lab-category-name">avatar</label>
                        <input type="file" name="avatar" id="avatar" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="lab-category-name">Password</label>
                        <input type="password" name="password" id="password" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" id="action" value="Register" class="btn btn-info" />
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.open_cart').click(function(e) {
            e.preventDefault();
            var check_login = $('#check_login').val();
            if (check_login == 'false' ) {
                $('.side').css('right', -1000);
                $('#loginModal').modal('show');
            }
            var total = 0;
            var html = "Total: ";
            $('.cart-list .cart_item p span').each(function( index, value ) {
                arrayPrice = $(this).html().split(' x $');
                price_record = arrayPrice[0] * arrayPrice[1]
                total += price_record
            });
            $('.total_price_cart').html(html + total)
        });

        $('.search').click(function(e) {
            e.preventDefault();
            $('.top-search').css('display','block')
        });

        $('.close-search').click(function(e) {
            $('.top-search').css('display','none')
        });

        $('#search_product').blur(function(){
            $('#form_search').submit();
            // var search = $(this).val()
            // var urlString = window.location.href;
            // var fillter = 'all';
            // var url = new URL(urlString);
            // if (urlString.includes('fillter')) {
            //     fillter = url.searchParams.get("fillter");
            // }
            // $.ajax({
            //     url: "{{ route('search.product') }}",
            //     method: 'get',
            //     data: {search:search, fillter:fillter},
            //     dataType: 'json',
            //     success:function(data)
            //     {
            //         location.reload();
            //         // $('#cart' + id).remove();
            //         // $(".total-pr p").each(function( index, value ) {
            //         //     eTotal = $(this).text()
            //         //     total_el = parseInt(eTotal.split("$ ")[1])
            //         //     total += total_el
            //         // // });
            //         // $('.gr-total').find('.ml-auto').html('$ '+ data['grandTotal'])
            //     }
            // })
        });


        $('.login').click(function(e) {
            e.preventDefault();
            $('#loginModal').modal('show');
            $('#login_form')[0].reset();
            $('#form_output').html('');
            $('#button_action').val('login');
            $('#action').val('Login');
            $('modal-title').text('Login');
        });

        $('#login_form').on('submit', function(e){
            var html = '';
            e.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "{{ route('auth.login') }}",
                method: "POST",
                data: form_data,
                dataType: "json",
                success: function(data)
                {
                    if (data.error.length > 0) {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++) {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_output').html(error_html);
                    }else {
                        $('#form_output').html(data.success);
                        $('#login_form')[0].reset();
                        $('#action').val('Login');
                        $('.modal-title').text('Login');
                        $('#button_action').val('login');
                        var url = window.location.href
                        window.location.href = url
                    }
                }
            });
        });

        $('.register').click(function(e) {
            e.preventDefault();
            $('#registerModal').modal('show');
            $('#register_form')[0].reset();
            $('#form_register_output').html('');
            $('#button_action').val('Register');
            $('#action').val('Register');
            $('modal-title').text('Register');
        });

        $('#register_form').on('submit', function(e){
            var html = '';
            e.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "{{ route('auth.register') }}",
                method: "POST",
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data)
                {
                    if (data.error.length > 0) {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++) {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_register_output').html(error_html);
                    }else {
                        $('#form_register_output').html(data.success);
                        $('#register_form')[0].reset();
                        $('#action').val('Register');
                        $('.modal-title').text('Register');
                        $('#button_action').val('Register');
                        var url = window.location.href
                        window.location.href = url
                    }
                }
            });
        });
    });
</script>