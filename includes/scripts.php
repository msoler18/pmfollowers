<?php

/**
 * Loads plugin scripts
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

function pwuf_load_scripts() {
	wp_enqueue_script( 'pwuf-follow', PWUF_FOLLOW_URL . 'js/follow.js', array( 'jquery' ) );
	wp_localize_script( 'pwuf-follow', 'pwuf_vars', array(
		'processing_error' => __( 'There was a problem processing your request.', 'pwuf' ),
		'login_required'   => __( 'Oops, you must be logged-in to follow users.', 'pwuf' ),
		'logged_in'        => is_user_logged_in() ? 'true' : 'false',
		'ajaxurl'          => admin_url( 'admin-ajax.php' ),
		'nonce'            => wp_create_nonce( 'follow_nonce' )
	) );
}
add_action( 'wp_enqueue_scripts', 'pwuf_load_scripts' );