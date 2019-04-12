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
		'showposts' => 1,
		'posts_per_page' => 15,
		'author__in'     => pwuf_get_following()
	) );



	ob_start(); ?>
<?php if( $items->have_posts() ) : ?> <?php while( $items->have_posts() ) : $items->the_post(); 
		$traveler_id = get_the_author_meta('ID');
		$traveler_name = get_user_meta($traveler_id,'first_name',true);
		$traveler_last_name = get_user_meta($traveler_id,'last_name',true);
    $age = get_user_meta($traveler_id,'calculate_age',true);
		$description = get_user_meta($traveler_id,'a_propos_de_moi_pm',true);
		$shortdescription = wp_trim_words( $description , 17);
		$kindtravel = get_user_meta($traveler_id,'pour_voyager_je_suis_plutt_pm',true);
		$languagues = get_user_meta($traveler_id,'langues_parles_pm',true);
		$budgeth = get_user_meta($traveler_id,'budget_habituel_pm',true);
		$countryv = get_user_meta($traveler_id,'pays_de_rsidence_pm',true);
	?>
	<div class="ms-horizontal-card  ms-horizontal-card-traveler" id="favorite-traveler-id-<?php echo $traveler_id?>">
	 <div class="ms-image-traveller">
     <?php 
      echo get_avatar($traveler_id, '150', 'https://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=150');
     ?>
   </div>
   <div class="ms-info-traveller">
     <h3><?php echo $traveler_name . ' ' . $traveler_last_name; ?> - <span><?php echo $age . 'ans';?></span></h3>
     <p><?php echo $shortdescription; ?></p>
     <p>
       <span class="ms-title-card">Type de voyage: </span> 
       <?php 
          foreach ($kindtravel as $key => $value) {
            echo $value;
          }
       ?>
     </p>
     <p><span class="ms-title-card">Langues:</span><?php echo $languagues; ?></p>
     <p><span class="ms-title-card">Budget habituel:</span><?php echo $budgeth; ?></p>
     <hr>
     <?php 
      echo pwuf_get_follow_unfollow_links( $traveler_id ); 
      ?>
     <p><span class="ms-title-card">Pays de résidence:</span><?php echo $countryv ?></p>
   </div>		
	</div>

	
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