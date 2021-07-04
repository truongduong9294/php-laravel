$(document).ready(function(){
    $('.side-menu').click(function() {
        $('.side').addClass('on');
    });

    $('.close-side').click(function() {
        $('.side').removeClass('on');
    });

    // $('.qty').change(function(){
    //     var id = $('#cart_id').val()
    //     $.ajax({
    //         url: "{{ route('update.cart') }}",
    //         method: 'post',
    //         data: {id:id},
    //         dataType: 'json',
    //         success:function(data)
    //         {
    //             console.log(data);
    //             // $('#category_name').val(data.category_name);
    //             // $('#category_id').val(id);
    //             // $('#categoryModal').modal('show');
    //             // $('#action').val('Edit');
    //             // $('.modal-title').text('Edit Data');
    //             // $('#button_action').val('update');
    //         }
    //     })
    //     // var quantity = $(this).val();
    //     // var price_dolla = $('.price-pr p').html();
    //     // var price = price_dolla.slice(1, price_dolla.length);
    //     // var total = quantity * price;
    //     // $('.total-pr p').html('$ '+ total);
    // });
});