<?php
/**
 * Shows the posts from users that the current user follows
 *
 * @access      private
 * @since       1.0
 * @return      string
 */

function pwuf_following_posts_shortcode( $atts, $content = null ) {

	// Make sure the current user follows someone
	if( empty( pwuf_get_following() ) )
		return;

	$items = new WP_Query( array(
		'post_type'      => 'any',
		'posts_per_page' => 15,
		'author__in'     => pwuf_get_following()
	) );

	ob_start(); ?>
<ul>
<ul><?php if( $items->have_posts() ) : ?> <?php while( $items->have_posts() ) : $items->the_post(); ?>
	<li class="pwuf_following_post"><?php the_title(); ?></li>
</ul>
</ul>
<?php endwhile; ?> <?php wp_reset_postdata(); ?> <?php else : ?>
<ul>
<ul>
	<li class="pwuf_following_post pwuf_following_no_results"><?php _e( 'None of the users you follow have posted anything.', 'pwuf' ); ?></li>
</ul>
</ul>
<?php endif;
	return ob_get_clean();

}
add_shortcode( 'following_posts', 'pwuf_following_posts_shortcode' );