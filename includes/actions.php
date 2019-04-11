<?php

/**
 * Ajax Actions
 *
 * @package     Planet Meetup Traveler Followers
 * @subpackage  Ajax Actions
 * @copyright   Copyright (c) 2019, Gradiweb
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
*/


/**
 * Processes the ajax request to follow a user
 *
 * @access      private
 * @since       1.0
 * @return      void
 */

function pwuf_process_new_follow() {
	if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
		if( pwuf_follow_user( absint( $_POST['user_id'] ), absint( $_POST['follow_id'] ) ) ) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}
	die();
}
add_action('wp_ajax_follow', 'pwuf_process_new_follow');


/**
 * Processes the ajax request to unfollow a user
 *
 * @access      private
 * @since       1.0
 * @return      void
 */

function pwuf_process_unfollow() {
	if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
		if( pwuf_unfollow_user( absint( $_POST['user_id'] ), absint( $_POST['follow_id'] ) ) ) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}
	die();
}
add_action('wp_ajax_unfollow', 'pwuf_process_unfollow');