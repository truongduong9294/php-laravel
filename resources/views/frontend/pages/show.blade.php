@extends('frontend.master')
@section('content')
    <div class="shop-detail-box-main">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-6">
                    <div id="carousel-example-1" class="single-product-slider carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active"> <img class="d-block w-100" src="{{ asset('uploads/' . $product->image) }}" alt="First slide"> </div>
                        </div>
                        {{-- <a class="carousel-control-prev" href="#carousel-example-1" role="button" data-slide="prev"> 
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span> 
                        </a>
                            <a class="carousel-control-next" href="#carousel-example-1" role="button" data-slide="next"> 
                            <i class="fa fa-angle-right" aria-hidden="true"></i> 
                            <span class="sr-only">Next</span> 
                        </a> --}}
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-1" data-slide-to="0" class="active">
                                <img class="d-block w-100 img-fluid" src="images/smp-img-01.jpg" alt="" />
                            </li>
                            <li data-target="#carousel-example-1" data-slide-to="1">
                                <img class="d-block w-100 img-fluid" src="images/smp-img-02.jpg" alt="" />
                            </li>
                            <li data-target="#carousel-example-1" data-slide-to="2">
                                <img class="d-block w-100 img-fluid" src="images/smp-img-03.jpg" alt="" />
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-6">
                    <div class="single-product-details">
                        <h2>{{ $product->product_name }}</h2>
                        <h5> <del>$ 60.00</del> ${{ $product->price }}</h5>
                        <div class="price-box-bar">
                            <div class="cart-and-bay-btn">
                                <a class="btn hvr-hover" data-fancybox-close="" href="{{ route('addcart', $product->id) }}">Add to cart</a>
                            </div>
                        </div>
                        <div class="add-to-btn">
                            <div class="share-bar">
                                <a class="btn hvr-hover" href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                                <a class="btn hvr-hover" href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a>
                                <a class="btn hvr-hover" href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                <a class="btn hvr-hover" href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>
                                <a class="btn hvr-hover" href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>Featured Products</h1>
                    </div>
                    <div class="featured-products-box owl-carousel owl-theme">
                        @foreach ($products as $item)
                            <div class="item">
                                <div class="products-single fix">
                                    <div class="box-img-hover">
                                        <img style="withd: 278px; height: 278px;" src="{{ asset('uploads/' . $item->image) }}" class="img-fluid" alt="Image">
                                        <div class="mask-icon">
                                            <ul>
                                                <li><a href="{{ route('show.product',$item->id) }}" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                                <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                                <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                            </ul>
                                            <a class="cart" href="{{ route('addcart', $item->id) }}">Add to Cart</a>
                                        </div>
                                    </div>
                                    <div class="why-text">
                                        <h4>{{ $item->product_name }}</h4>
                                        <h5> ${{ $item->price }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection