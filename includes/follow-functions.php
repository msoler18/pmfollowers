<?php

/**
 * Follow Functions
 *
 * @package     Planet Meetup Traveler Followers
 * @subpackage  Follow Functions
 * @copyright   Copyright (c) 2019, Gradiweb
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */



/**
 * Retrieves all users that the specified user follows
 *
 * Gets all users that $user_id followers
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id - the ID of the user to retrieve following for
 * @return      array
 */

function pwuf_get_following( $user_id = 0 ) {

}


/**
 * Retrieves users that follow a specified user
 *
 * Gets all users following $user_id
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id - the ID of the user to retrieve followers for
 * @return      array
 */

function pwuf_get_followers( $user_id = 0 ) {

}


/**
 * Follow a user
 *
 * Makes a user follow another user
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id        - the ID of the user that is doing the following
 * @param 	int $user_to_follow - the ID of the user that is being followed
 * @return      bool
 */

function pwuf_follow_user( $user_id, $user_to_follow ) {

}


/**
 * Unfollow a user
 *
 * Makes a user unfollow another user
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id       - the ID of the user that is doing the unfollowing
 * @param 	int $unfollow_user - the ID of the user that is being unfollowed
 * @return      bool
 */

function pwuf_unfollow_user( $user_id, $unfollow_user ) {

}


/**
 * Retrieve following count
 *
 * Gets the total number of users that the specified user is following
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id - the ID of the user to retrieve a count for
 * @return      int
 */

function pwuf_get_following_count( $user_id ) {

}


/**
 * Retrieve follower count
 *
 * Gets the total number of users that are following the specified user
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id - the ID of the user to retrieve a count for
 * @return      int
 */

function pwuf_get_follower_count( $user_id ) {

}



/**
 * Increase follower count
 *
 * Increments the total count for how many users a specified user is followed by
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id - the ID of the user to increease the count for
 * @return      int
 */

function pwuf_increase_followed_by_count( $user_id ) {

}


/**
 * Decrease follower count
 *
 * Decrements the total count for how many users a specified user is followed by
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id - the ID of the user to decrease the count for
 * @return      int
 */

function pwuf_decrease_followed_by_count( $user_id ) {

}


/**
 * Check if a user is following another
 *
 * Increments the total count for how many users a specified user is followed by
 *
 * @access      private
 * @since       1.0
 * @param 	int $user_id       - the ID of the user doing the following
 * @param 	int $followed_user - the ID of the user to check if being followed by $user_id
 * @return      int
 */

function pwuf_is_following( $user_id, $followed_user ) {

}