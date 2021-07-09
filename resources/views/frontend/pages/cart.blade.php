@extends('frontend.master')
@section('content')
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        @if (session()->has('cart'))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Images</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Session::get('cart') as $cart)
                                            <tr id="cart{{$cart['id']}}">
                                                <td class="thumbnail-img">
                                                    <a href="#">
                                                        <img class="img-fluid" src="{{ asset('uploads/' . $cart['image']) }}" alt="" />
                                                    </a>
                                                </td>
                                                <td class="name-pr">
                                                    <a href="#">
                                                        {{ $cart['product_name'] }}
                                                    </a>
                                                </td>
                                                <td class="price-pr">
                                                    <p>$ {{ $cart['price'] }}</p>
                                                </td>
                                                <td class="quantity-box"><input type="number" size="4" value="{{ $cart['quantity'] }}" min="0" step="1" class="c-input-text qty text"></td>
                                                <td class="total-pr">
                                                    <p>$ {{ $cart['price'] * $cart['quantity'] }}</p>
                                                </td>
                                                <td class="remove-pr">
                                                    <a href="#">
                                                        <i class="fas fa-times"></i>
                                                    </a>
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
                <div class="col-lg-12">
                    <div class="shopping-box col-12 d-flex">
                        {{-- <input value="Update Cart" type="submit"> --}}
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
                <div class="col-12 d-flex shopping-box"><a href="{{ route('insert.card') }}" class="ml-auto btn hvr-hover">Checkout</a> </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $('.qty').change(function(){
            var id = $(this).parent().parent().find('#cart_id').val();
            var quantity = $(this).val()
            var total = 0;
            $.ajax({
                url: "{{ route('update.cart') }}",
                method: 'get',
                data: {id:id, quantity:quantity},
                dataType: 'json',
                success:function(data)
                {
                    $('#cart' + id).find('.total-qty').val(data['cart'][id]['quantity']);
                    $('#cart' + id).find('.total-pr').html('$ '+ data['cart'][id]['total']);
                    // $(".total-pr p").each(function( index, value ) {
                    //     eTotal = $(this).text()
                    //     total_el = parseInt(eTotal.split("$ ")[1])
                    //     total += total_el
                    // });
                    $('.gr-total').find('.ml-auto').html('$ '+ data['grandTotal'])
                }
            })
        });

        $(".remove-pr").click(function(e) {
            e.preventDefault();
            var total = 0;
            var id = $(this).parent().find('#cart_id').val();
                if (confirm("Are you sure you want to Delete this data?")) {
                    $.ajax({
                    url: "{{ route('delete.cart') }}",
                    method: 'get',
                    data: {id:id},
                    dataType: 'json',
                    success:function(data)
                    {
                        $('#cart' + id).remove();
                        // $(".total-pr p").each(function( index, value ) {
                        //     eTotal = $(this).text()
                        //     total_el = parseInt(eTotal.split("$ ")[1])
                        //     total += total_el
                        // });
                        $('.gr-total').find('.ml-auto').html('$ '+ data['grandTotal'])
                    }
                })
            }else {
                return false;
            }
        });
    });
</script>
@endsection