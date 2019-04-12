<?php
/**
 * Retrieves the follow / unfollow links
 *
 * @access      public
 * @since       1.0
 * @param 	    int $user_id - the ID of the user to display follow / unfollow links for
 * @return      string
 */

function pwuf_get_follow_unfollow_links( $follow_id = null ) {

	global $user_ID;

	if( empty( $follow_id ) )
		return;

	if( ! is_user_logged_in() )
		return;

	if ( $follow_id == $user_ID )
		return;

	ob_start(); ?>
	<div class="follow-links">
		<?php
		$following = pwuf_get_following( $user_ID );
		if ( is_array( $following ) && in_array( $follow_id, $following ) ) {?>
		  <a href="#" class="unfollow followed" data-user-id="<?php echo $user_ID; ?>" data-follow-id="<?php echo $follow_id; ?>">arrête de suivre</a>		
		<?php } else {?>
		  <a href="#" class="follow" data-user-id="<?php echo $user_ID; ?>" data-follow-id="<?php echo $follow_id; ?>">Suivre ce membre</a>	
		<?php } ?>	

		<img src="<?php echo PWUF_FOLLOW_URL; ?>/images/loading.gif" class="pwuf-ajax" style="display:none;"/>
	</div>
	<?php
	return ob_get_clean();
}

