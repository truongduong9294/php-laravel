@extends('frontend.master')
@section('content')
    <div class="products-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>Featured Products</h1>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-12">
                    <div class="special-menu text-center">
                        <div class="button-group filter-button-group menu_button">
                            <a href="{{ route('home', ['fillter' => 'all']) }}" value="all" class="btn btn-primary active button_fillter" data-filter="*">All</a> --}}
                            {{-- @foreach($categories as $category) --}}
                                {{-- <a href="{{ route('home', ['fillter' => $category->category_name, 'search' => $search]) }}" class="button_fillter btn btn-primary" data-filter=".top-featured">{{ $category->category_name }}</a> --}}
                            {{-- <a href="{{ route('home', ['fillter' => 'hot']) }}" value="hot" class="btn btn-primary" data-filter=".best-seller">Hot</a> --}}
                            {{-- @endforeach --}}
                        {{-- </div>
                    </div>
                </div>
            </div> --}}
            <div class="row special-list">
                @foreach($products as $product)
                <div class="col-lg-3 col-md-6 special-grid">
                    <div class="products-single fix">
                        <div class="box-img-hover">
                            <div class="type-lb">
                                <p class="sale">Hot</p>
                            </div>
                            <img style="witdh: 255px; height: 255px;" src="{{ asset('uploads/' . $product->image) }}" class="img-fluid" alt="Image">
                            <div class="mask-icon">
                                <ul>
                                    <li><a href="{{ route('show.product',$product->id) }}" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                </ul>
                                <a class="cart add_to_cart" href="{{ route('addcart',$product->id) }}">Add to Cart</a>
                            </div>
                        </div>
                        <div class="why-text">
                            <h4>{{ $product->product_name }}</h4>
                            <h5> ${{ $product->price }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <?php
                $previous = $products->currentPage() - 1;
                $next     = $products->currentPage() + 1;
            ?>
            @if ($products->total() > 4)
                <div class="pagination pagination_user">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item <?php if ($products->currentPage() <= 1){ echo 'previos_disble'; } else{ echo 'previos_enable'; }  ?>"><a class="page-link" href="{{ route('home', ['page' => $previous, 'fillter' => $fillter, 'search' => $search]) }}">Previous</a></li>
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <li class="page-item"><a class="page-link <?php if ($products->currentPage() === $i) {echo "selected"; } ?>" href="{{ route('home', ['page' => $i, 'fillter' => $fillter, 'search' => $search]) }}">{{ $i }}</a></li>
                        @endfor
                            <li class="page-item <?php if ($products->currentPage() >= $products->lastPage()) { echo 'next_disable'; } else { echo "next_enable"; } ?>"><a class="page-link" href="{{ route('home', ['page' => $next, 'fillter' => $fillter, 'search' => $search]) }}">Next</a></li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
    <div class="products-box box-sale">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>Sale Products</h1>
                    </div>
                </div>
            </div>
            <div class="row special-list sale-product">
                {{ csrf_field() }}
                {{-- @foreach($saleProducts as $product) --}}
                {{-- <div class="col-lg-3 col-md-6 special-grid">
                    <div class="products-single fix">
                        <div class="box-img-hover">
                            <div class="type-lb">
                                <p class="sale">- {{ $product->stock . ' %' }}</p>
                            </div>
                            <img style="witdh: 255px; height: 255px;" src="{{ asset('uploads/' . $product->image) }}" class="img-fluid" alt="Image">
                            <div class="mask-icon">
                                <ul>
                                    <li><a href="{{ route('show.product',$product->id) }}" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                </ul>
                                <a class="cart add_to_cart" href="{{ route('addcart',$product->id) }}">Add to Cart</a>
                            </div>
                        </div>
                        <div class="why-text">
                            <h4> {{ $product->product_name }} </h4>
                            <div class="discount">
                                <h5 class="price_old"> ${{ $product->price }}</h5>
                                <h5> ${{ $product->price - (($product->price * $product->stock)/100)}}</h5>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- @endforeach --}}
            </div>
        </div>
        {{-- <div class="load_more">
            <button class="btn btn-primary">Load More</button>
        </div> --}}
    </div>

{{-- <script>
    $(document).ready(function(){
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
</script> --}}

{{-- <script>
    $(document).ready(function() {
        $('.add_to_cart').click(function (e) {
            var html = '';
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('addcart') }}",
                method: 'get',
                data: {id:id},
                dataType: 'json',
                success:function(data)
                {
                    $('.badge').html(Object.keys(data).length)
                    // $('cart-list')
                    html += ''
                }
            })
        });
    });
</script> --}}
{{-- <script>
    $(document).ready(function(){
        $(".menu_button button").click(function(event) {
            event.preventDefault();
            var searchValue = $(this).val();
            var html = '';
            $.ajax({
                url: "{{ route('search.product') }}",
                method: 'get',
                data: {searchValue : searchValue},
                dataType: 'json',
                success:function(data)
                {
                    $('.special-grid').remove();
                    $.each(data, function(key, value) {
                        html += "<div class='col-lg-3 col-md-6 special-grid'>\
                                    <div class='products-single fix'>\
                                        <div class='box-img-hover'>\
                                            <div class='type-lb'>\
                                                <p class='sale'>Sale</p>\
                                            </div>\
                                            <img src='{{ asset('frontend/images/img-pro-01.jpg') }}' class='img-fluid' alt='Image'>\
                                            <div class='mask-icon'>\
                                                <ul>\
                                                    <li><a href='#' data-toggle='tooltip' data-placement='right' title='View'><i class='fas fa-eye'></i></a></li>\
                                                    <li><a href='#'' data-toggle='tooltip' data-placement='right' title='Compare'><i class='fas fa-sync-alt'></i></a></li>\
                                                    <li><a href='#' data-toggle='tooltip' data-placement='right' title='Add to Wishlist'><i class='far fa-heart'></i></a></li>\
                                                </ul>\
                                                <a class='cart' href='#'>Add to Cart</a>\
                                            </div>\
                                        </div>\
                                        <div class='why-text'>\
                                            <h4>Lorem ipsum dolor sit amet</h4>\
                                            <h5> $7.79</h5>\
                                        </div>\
                                    </div>\
                                </div>"
                    });
                    $('.special-list').append(html);
                    // $('.special-list').add()
                }
            })
        });
    });
</script> --}}

<script>
    $(document).ready(function(){
        var _token = $('input[name="_token"]').val();
        var search = $('#search_product').val();
        load_data('', _token);
        function load_data(id="", _token, search) {
            $.ajax({
                url: "{{ route('loadmore.load_data') }}",
                method: "POST",
                data: {id:id, _token:_token, search:search},
                success: function(data)
                {
                    // console.log(data.loadmore);
                    $('.load_more').remove();
                    $('.sale-product').append(data);
                    // $('.box-sale').append(data);
                }
            });
        }

        $(document).on('click', '#load_more_button', function(){
            var id = $(this).data('id');
            $('#load_more_button').html('<b>Loading...</b>');
            load_data(id, _token);
        });
    });
</script>
@endsection