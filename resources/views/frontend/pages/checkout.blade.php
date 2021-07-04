<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <title>Document</title>
</head>
<body>
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        @if (session()->has('cart'))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Session::get('cart') as $cart)
                                            <tr id="cart{{$cart['id']}}">
                                                <td class="name-pr">
                                                    <a href="#">
                                                        {{ $cart['product_name'] }}
                                                    </a>
                                                </td>
                                                <td class="price-pr">
                                                    <p>$ {{ $cart['price'] }}</p>
                                                </td>
                                                <td class="quantity-box">{{ $cart['quantity'] }}</td>
                                                <td class="total-pr">
                                                    <p>$ {{ $cart['price'] * $cart['quantity'] }}</p>
                                                </td>
                                                <input type="hidden" value="{{ $cart['id'] }}" id="cart_id">
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <?php echo "Không có mặt hàng nào"; ?>
                         @endif
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <hr>
                        <div class="d-flex gr-total">
                            <h5>Grand Total</h5>
                            <div class="ml-auto h5"> $ {{$grandTotal}}</div>
                        </div>
                        <hr> </div>
                </div>
                <div class="col-12 d-flex shopping-box"><a href="checkout.html" class="ml-auto btn hvr-hover">Checkout</a> </div>
            </div>
        </div>
    </div>
</body>
</html>