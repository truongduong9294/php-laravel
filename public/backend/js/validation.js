$(document).ready(function() {
    $('#formProduct').validate({
        rules: {
            product_name: {
                required : true,
                minlength: 6,
                maxlength: 20,
            },
            price: {
                required : true,
                digits: true,
            },
        },
        messages: {
            category_name: {
                required: "Product Name is required.",
                minlength: "Product Name least 6 characters.",
                maxlength: "Product Name no more than 20 characters."
            },
            price: {
                required: "Price is required.",
                digits: "Price only digits."
            }
        }
    });

    // $('#formRole').validate({
    //     rules: {
    //         role_name: {
    //             required : true,
    //             minlength: 4,
    //             maxlength: 20,
    //         }
    //     },
    //     messages: {
    //         role_name: {
    //             required: "Role Name is required.",
    //             minlength: "Role Name least 4 characters.",
    //             maxlength: "Role Name no more than 20 characters."
    //         }
    //     }
    // });

    // $(document).ready(function(){
    //     $('#formRegister').validate({
    //         rules: {
    //             user_name: {
    //                 required : true,
    //                 minlength: 4,
    //                 maxlength: 20,
    //             },
    //             email: {
    //                 required: true,
    //                 email: true,
    //             },
    //             full_name: {
    //                 required: true,
    //                 minlength: 6,
    //                 maxlength: 30,
    //             },
    //             password: {
    //                 required: true,
    //                 minlength: 6,
    //                 maxlength: 30,
    //             }
    //         },
    //         messages: {
    //             user_name: {
    //                 required: "User Name is required.",
    //                 minlength: "User Name least 4 characters.",
    //                 maxlength: "User Name no more than 20 characters."
    //             },
    //             email: {
    //                 required: "Email is required.",
    //                 email: "Please enter a valid email."
    //             },
    //             full_name: {
    //                 required: "Full Name is required.",
    //                 minlength: "Full Name least 6 characters.",
    //                 maxlength: "Full Name no more than 30 characters."
    //             },
    //             password: {
    //                 required: "Password is required.",
    //                 minlength: "Password least 6 characters.",
    //                 maxlength: "Password no more than 30 characters."
    //             }
    //         }
    //     });
    // });
});
