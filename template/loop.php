<?php
get_header();
if ( is_user_logged_in() ) {
	$user_id  = get_current_user_id();
	$post_ids = get_user_meta( $user_id, 'dw_wish_list', true );
} else {
	$post_ids = [];
}
$args     = [
	'post_type'      => 'any',
	'posts_per_page' => - 1,
	'post__in'       => $post_ids
];
$query = new WP_Query( $args );
if ( $query->have_posts() ):
	?>
	<?php
	while ( $query->have_posts() ): $query->the_post();
		the_title();
		?>
		<br>
	<?php
	endwhile;
	?>
<?php
else:
	wp_safe_redirect( home_url() );
	?>


<?php
endif;
wp_reset_postdata();
get_footer();
