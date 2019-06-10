<?php
if (!is_user_logged_in()) :
    wp_safe_redirect(home_url('/'));
    exit;
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
        <table class="table">
            <thead>
                <tr>
                    <th><?php esc_html_e('Image','pjwl') ?></th>
                    <th><?php esc_html_e('Title','pjwl') ?></th>
                    <?php if(class_exists('woocommerce')) : ?>
                        <th><?php esc_html_e('Price','pjwl') ?></th>
                        <th><?php esc_html_e('Stock','pjwl') ?></th>
                        <th><?php esc_html_e('Actions','pjwl') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php while ( $query->have_posts() ) {
                $query->the_post(); ?>
                    <tr>
                        <td>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail(); ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </td>
                        <?php if(class_exists('woocommerce')) : ?>
                            <td><?php woocommerce_template_loop_price(); ?></td>
                            <td>@mdo</td>
                            <td>
                                <a href="" class="pjcf-remove" data-post-id="<?php echo esc_attr(get_the_ID()); ?>">
                                    X
                                </a>
                                <?php woocommerce_template_loop_add_to_cart(); ?>
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