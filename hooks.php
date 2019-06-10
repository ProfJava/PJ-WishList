<?php
if (!defined('ABSPATH')) {
    die;
}

add_action( 'wp_ajax_wish_list_process', 'pjwl_user_process' );
add_action( 'wp_ajax_nopriv_wish_list_process','pjwl_guest_process' );

function pjwl_guest_process() {
        $var['message'] = $_POST['post_ids'];
        //Send back the $var value in json format. You can send it in other format if you want
        echo json_encode( $var );

    // $post_id   = $_POST['post_id'];

//    wp_send_json_success( [
//        'code' => 0,
//        'type'    => 'success',
//        'title'   => __('Favorites','pjwl'),
//        'message' => __('Added To Favorites','pjwl')
//    ] );
//
//    wp_send_json_success( [
//        'code' => 1,
//        'type'    => 'info',
//        'title'   => __('Favorites','pjwl'),
//        'message' => __('Already Added To Favorites','pjwl')
//    ] );


//    $cookie_list = array();
//
//    $cookie_post_id = $_POST['post_id'];
//
//    array_push( $cookie_list, $cookie_post_id );
//
//    $json = json_encode($cookie_list);
//
//    setcookie('favorites', $json, time() + 86400, "/");

//    $cardArray=array(
//        'CARD 1'=>array('FRONT I', 'BACK I'),
//        'CARD 2'=>array('FRONT 2', 'BACK 2')
//    );
//
//    $json = json_encode($cardArray);
//    setcookie('cards', $json);


//    if ( !in_array( $cookie_post_id, $cookie_list ) ) {
//        array_push( $cookie_list, $cookie_post_id );
//        setcookie('favorites', $cookie_list, time() + 86400, "/");
//        wp_send_json_success( [
//            'code' => 0,
//            'type'    => 'success',
//            'title'   => __('Favorites','pjwl'),
//            'message' => __('Added To Favorites','pjwl')
//        ] );
//    }  else {
////        foreach ($cookie_list as $key => $value) {
////            if ($value == $cookie_post_id) {
////                unset($cookie_list[$key]);
////            }
////        }
//        wp_send_json_success( [
//            'code' => 1,
//            'type'    => 'info',
//            'title'   => __('Favorites','pjwl'),
//            'message' => __('Already Added To Favorites','pjwl')
//        ] );
//    }




//    if(isset($_COOKIE[$cookie_name])) {
//        $body = $_COOKIE[$cookie_name];
//        print_r($body);
//    } else {
//        $body = $cookie_post_id;
//    }
}

function pjwl_user_process() {
    $post_id    = $_POST['post_id'];
    $user_id    = get_current_user_id();
    $pjwl_list  = (array) get_user_meta( $user_id, 'pjwl_list', true );
    $pjwl_popup = get_option('pjwl-popup'); // Show or Hide The Popup
    $pjwl_pst   = get_option('pjwl-pst');   // Popup Success Title
    $pjwl_psm   = get_option('pjwl-psm');   // Popup Success Message
    $pjwl_pet   = get_option('pjwl-pet');   // Popup Error Title
    $pjwl_pem   = get_option('pjwl-pem');   // Popup Error Message
    if ( ! in_array( $post_id, $pjwl_list ) ) {
        array_push( $pjwl_list, $post_id );
        update_user_meta( $user_id, 'pjwl_list', $pjwl_list );
        wp_send_json_success( [
            'code'      => 0,
            'state'     => $pjwl_popup,
            'type'      => 'success',
            'title'     => __($pjwl_pst,'pjwl'),
            'message'   => __($pjwl_psm,'pjwl')
        ] );
    } else {
        foreach ($pjwl_list as $key => $value) {
            if ($value == $post_id) {
                unset($pjwl_list[$key]);
            }
        }
        update_user_meta($user_id, 'pjwl_list', $pjwl_list);
        wp_send_json_success( [
            'code'      => 1,
            'state'     => $pjwl_popup,
            'type'      => 'error',
            'title'     => __($pjwl_pet,'pjwl'),
            'message'   => __($pjwl_pem,'pjwl')
        ] );
    }
}

/* ShortCodes */
add_shortcode( 'pj-wish-list-btn', 'pjwl_love_btn' );
/* Add Love Btn In Product Card */
$pjwl_cp = get_option('pjwl-cp');
if($pjwl_cp == 0) {
    add_action('woocommerce_after_shop_loop_item','pjwl_love_btn');
}

function pjwl_love_btn() {
    $pjwl_icon = get_option('pjwl-icon');
    $pjwl_text = get_option('pjwl-text');
?>
    <button type="button" class="pjwl-love-btn" data-post-id="<?php echo esc_attr(get_the_ID()); ?>">
        <span><?php esc_html_e($pjwl_text,'pjwl') ?></span>
        <?php if($pjwl_icon !== "pjwl-dis") { ?>
            <i class="<?php echo $pjwl_icon; ?>"></i>
        <?php } ?>
    </button>
<?php
}


/* Add To Cart */

add_action( 'wp_ajax_prof_ajax_add_to_cart', 'prof_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_prof_ajax_add_to_cart', 'prof_ajax_add_to_cart' );
function prof_ajax_add_to_cart() {
    check_ajax_referer( 'prof_ajax_requests', 'nonce' );
    $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
    $quantity          = 1;
    $variation_id      = absint( $_POST['variation_id'] );
    $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
    $product_status    = get_post_status( $product_id );
    if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id ) && 'publish' === $product_status ) {
        do_action( 'woocommerce_ajax_added_to_cart', $product_id );
        if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
            wc_add_to_cart_message( array( $product_id => $quantity ), true );
        }
        wp_send_json_success( [
            'type'    => 'success',
            'title'   => __('السلة','pjwl'),
            'message' => __('تم إضافة المنتج للسلة','pjwl')
        ] );
    } else {
        wp_send_json_error( [
            'type'    => 'warning',
            'title'   => __('السلة','pjwl'),
            'message' => __( 'فشل إضافة المنتج للسلة', 'pjwl' ),
            'url'     => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
        ] );
    }
}

function prof_add_to_cart() {
    global $product;
    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="add-to-cart button prof-add-to-cart %s %s product_type_%s"%s>Add To Cart</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( $product->get_id() ),
            esc_attr( $product->get_sku() ),
            $product->get_type() == 'simple' ? 'prof-add-to-cart-ajax' : '',
            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
            esc_attr( $product->get_type() ),
            $product->get_type() == 'external' ? ' target="_blank"' : ''
        ),
        $product );
}

/**********************************************/
/**********************************************/
/**********************************************/

add_shortcode( 'pj-wish-list', 'pjwl_page' );
function pjwl_page() {
    if (!is_user_logged_in()) :

        $wishList = "<script>wishList = localStorage.getItem(\"wishList\")
document.writeln(wishList);</script>";
//
//        $body = json_decode(file_get_contents("php://input"), true);
//        echo $body["username"];


        $str_arr = preg_split ("/\,/", $wishList);
        print_r($str_arr);

        //var_dump($str_json);

    echo "<br>";

        var_dump($wishList);
//        $data = $_POST['data'];
//        print_r($data);

    else:

        $user_id    = get_current_user_id();
        $post_ids   = get_user_meta( $user_id, 'pjwl_list', true );

    endif;

    if(!empty($post_ids)) :
        $args = [
            'post_type'      => 'any',
            'post__in'       => $post_ids,
        ];
        $query = new WP_Query( $args );

        if ( $query->have_posts() ) { ?>
            <table class="table pj-wish-list-page">

                <thead>
                <tr> <?php current_theme_supports('') ?>
                    <th><?php esc_html_e('Image','pjwl') ?></th>
                    <th><?php esc_html_e('Title','pjwl') ?></th>
                    <?php if(class_exists('woocommerce')) : ?>
                        <th><?php esc_html_e('Price','pjwl') ?></th>
                        <th><?php esc_html_e('Stock','pjwl') ?></th>
                        <th><?php esc_html_e('Actions','pjwl') ?></th>
                    <?php else : ?>
                        <th><?php esc_html_e('Actions','pjwl') ?></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php while ( $query->have_posts() ) {
                        $query->the_post(); ?>
                            <tr>
                                <td class="pjwl-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('pj_small_post'); ?>
                                    </a>
                                </td>
                                <td class="pjwl-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </td>
                                <?php if(class_exists('woocommerce')) :
                                        global $product;
                                    ?>
                                    <td class="pjwl-price">
                                        <?php woocommerce_template_loop_price(); ?>
                                    </td>
                                    <td class="pjwl-stock">
                                        <?php $product->is_in_stock() ? _e('In Stock','') : _e('Not Available','pjwl') ?>
                                    </td>
                                    <td class="pjwl-actions">
                                        <button type="button" class="pjwl-love-btn" data-post-id="<?php echo esc_attr(get_the_ID()); ?>">
                                            X
                                        </button>
                                        <span class="pjwl-add-to-cart">
                                            <?php prof_add_to_cart(); ?>
                                        </span>
                                    </td>
                                <?php else : ?>
                                    <td>
                                        <button type="button" class="pjwl-love-btn" data-post-id="<?php echo esc_attr(get_the_ID()); ?>">
                                            X
                                        </button>
                                    </td>
                                <?php endif; ?>
                            </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php }
        wp_reset_postdata();
    else: ?>
        <div class="">
            <h3><?php esc_html_e('Your WishList Is Empty','pjwl') ?></h3>
            <a href="<?php echo home_url('/') ?>" class="btn btn-info mt-2">
                <?php esc_html_e('Return Homepage','pjwl') ?>
            </a>
        </div>
    <?php endif;
}

/* Thumbnail Size */
add_image_size( 'pj_small_post', 100, 100, true );