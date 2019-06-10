function pjwl_toast_type(type, title, message) {
    if (type === 'error') {
        toastr.error(message, title);
    }
    if (type === 'warning') {
        toastr.warning(message, title);
    }
    if (type === 'info') {
        toastr.info(message, title);
    }
    if (type === 'success') {
        toastr.success(message, title);
    }
}

toastr.options.positionClass = 'toast-top-center';
toastr.options.progressBar = true;
toastr.options.toastClass = 'pjwl_toastr';

(function ($) {

    let wishList = [];
    if (localStorage.wishList) {
        wishList = [...JSON.parse(localStorage.getItem("wishList"))];
    }

    // var xmlhttp = new XMLHttpRequest();
    // xmlhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         var myArr = JSON.parse(this.responseText);
    //         document.getElementById("demo").innerHTML = myArr[0];
    //     }
    // };
    // xmlhttp.open("GET", "json_demo_array.txt", true);
    // xmlhttp.send();

    let ajax_url = pjwl_ajax_object.ajax_url,
        ajax_nonce = pjwl_ajax_object.ajax_nonce;
    $('.pjwl-love-btn').on('click', function (e) {
        e.preventDefault();
        if ($('.pjwl-love-btn i').hasClass("pjwl-heart")) {
            $(this).addClass('pjwl-heart-empty')
        }
        //$(this).find('i').hasClass('pjwl-heart-empty').removeClass('pjwl-heart-empty').addClass('pjwl-heart');
        //$(this).find('i').hasClass('pjwl-heart').removeClass('pjwl-heart').addClass('pjwl-heart-empty');
        let love_id = $(this).data('post-id');

        wishList =[...wishList , love_id];

        // if(wishList.includes(love_id)) {
        //
        // }

        const uniqueWl = wishList.filter((x, i, a) => a.indexOf(x) == i);

        localStorage.setItem(
            "wishList",
            JSON.stringify(uniqueWl)
        );
        let target_wl = [...JSON.parse(localStorage.getItem("wishList"))];
        console.log(target_wl);
        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url,
            data: {
                action: "wish_list_process",
                post_ids:target_wl,
                post_id: love_id,
                nonce: ajax_nonce,
            },
            success: function (response) {
                console.log(target_wl);
                if (response.success && response.data.state == 0) {
                    pjwl_toast_type(response.data.type, response.data.title, response.data.message);
                } /* else {
                    console.log(response);
                } */
            }
        });
    });

    $(".prof-add-to-cart-ajax").on('click', function (e) {
        e.preventDefault();
        // console.log($(this).data('id'));
        let cart_selector = $('.cart-total'),
            cart_counter = parseInt(cart_selector.html()),
            product_id = $(this).data('product_id'),
            product_sku = $(this).data('product_sku');
        $.ajax({
            type: "post",
            dataType: "json",
            url: ajax_url,
            data: {
                action: 'prof_ajax_add_to_cart',
                product_id: product_id,
                product_sku: product_sku,
                quantity: 1,
                nonce: ajax_nonce,
            },
            success: function (response) {
                if (response.success) {
                    pjwl_toast_type(response.data.type, response.data.title, response.data.message);
                    $('.cart-total').text(cart_counter + 1);
                } // else {
                //     setTimeout(
                //         function () {
                //             window.location.href = response.data.url;
                //         }, 3000
                //     );
                // }
            }
        });
    });

})(jQuery);