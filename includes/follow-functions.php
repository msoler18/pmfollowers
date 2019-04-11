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
  if ( empty( $user_id ) ) {
      $user_id = get_current_user_id();
    }

    $following = get_user_meta( $user_id, '_pwuf_following', true );

    return (array) apply_filters( 'pwuf_get_following', $following, $user_id );
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
  if ( empty( $user_id ) ) {
      $user_id = get_current_user_id();
    }

    $followers = get_user_meta( $user_id, '_pwuf_followers', true );
    
    return (array) apply_filters( 'pwuf_get_followers', $followers, $user_id );
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
  $following = pwuf_get_following( $user_id );
    
    if ( $following && is_array( $following ) ) {
      $following[] = $user_to_follow;
    } else {
      $following = array();
      $following[] = $user_to_follow;
    }

    // retrieve the IDs of all users who are following $user_to_follow
    $followers = pwuf_get_followers( $user_to_follow );
    
    if ( $followers && is_array( $followers ) ) {
      $followers[] = $user_id;
    } else {
      $followers = array();
      $followers[] = $user_id;
    }

    do_action( 'pwuf_pre_follow_user', $user_id, $user_to_follow );

    // update the IDs that this user is following
    $followed = update_user_meta( $user_id, '_pwuf_following', $following );

    // update the IDs that follow $user_id
    $followers = update_user_meta( $user_to_follow, '_pwuf_followers', $followers );

    // increase the followers count
    $followed_count = pwuf_increase_followed_by_count( $user_to_follow ) ;

    if ( $followed ) {
      
      do_action( 'pwuf_post_follow_user', $user_id, $user_to_follow );

      return true;
    }
    return false;
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
  do_action( 'pwuf_pre_unfollow_user', $user_id, $unfollow_user );

    // get all IDs that $user_id follows
    $following = pwuf_get_following( $user_id );

    if ( is_array( $following ) && in_array( $unfollow_user, $following ) ) {

      $modified = false;
      
      foreach ( $following as $key => $follow ) {
        if ( $follow == $unfollow_user ) {
          unset( $following[$key] );
          $modified = true;
        }
      }

      if ( $modified ) {
        if ( update_user_meta( $user_id, '_pwuf_following', $following ) ) {
          pwuf_decrease_followed_by_count( $unfollow_user );
        }
      }

    }

    // get all IDs that follow the user we have just unfollowed so that we can remove $user_id
    $followers = pwuf_get_followers( $unfollow_user );
    
    if ( is_array( $followers ) && in_array( $user_id, $followers ) ) {
      
      $modified = false;
      
      foreach ( $followers as $key => $follower ) {
        if ( $follower == $user_id ) {
          unset( $followers[$key] );
          $modified = true;
        }
      }

      if ( $modified ) {
        update_user_meta( $unfollow_user, '_pwuf_followers', $followers );
      }

    }

    if ( $modified ) {
      do_action( 'pwuf_post_unfollow_user', $user_id, $unfollow_user );
      return true;
    }

    return false;
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
  if ( empty( $user_id ) ) {
      $user_id = get_current_user_id();
    }

    $following = pwuf_get_following( $user_id );

    $count = 0;

    if ( $following ) {
      $count = count( $following );
    }

    return (int) apply_filters( 'pwuf_get_following_count', $count, $user_id );
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
  if ( empty( $user_id ) ) {
      $user_id = get_current_user_id();
    }

    $followed_count = get_user_meta( $user_id, '_pwuf_followed_by_count', true );

    $count = 0;

    if ( $followed_count ) {
      $count = $followed_count;
    }

    return (int) apply_filters( 'pwuf_get_follower_count', $count, $user_id );
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
  do_action( 'pwuf_pre_increase_followed_count', $user_id );

    $followed_count = pwuf_get_follower_count( $user_id );
    
    if ( $followed_count !== false ) {
      
      $new_followed_count = update_user_meta( $user_id, '_pwuf_followed_by_count', $followed_count + 1 );
    
    } else {
    
      $new_followed_count = update_user_meta( $user_id, '_pwuf_followed_by_count', 1 );
    
    }

    do_action( 'pwuf_post_increase_followed_count', $user_id );

    return $new_followed_count;
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
  
  do_action( 'pwuf_pre_decrease_followed_count', $user_id );

  $followed_count = pwuf_get_follower_count( $user_id );

  if ( $followed_count ) {

    $count = update_user_meta( $user_id, '_pwuf_followed_by_count', ( $followed_count - 1 ) );

    do_action( 'pwuf_post_increase_followed_count', $user_id );

  }
  return $count;
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
  $following = pwuf_get_following( $user_id );
    
    $ret = false; // is not following by default

    if ( is_array( $following ) && in_array( $followed_user, $following ) ) {
      $ret = true; // is following
    }

    return (bool) apply_filters( 'pwuf_is_following', $user_id, $followed_user );
}