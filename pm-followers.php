
<?php
/*
Plugin Name: Planet Meetup Traveler Followers
Plugin URI: https://www.gradiweb.com
Description: Allows traveler to follow other traveler and see updates from traveler they follow
Version: 1.0
Author: msoler18
Author URI: https://www.gradiweb.com
*/


/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/

if(!defined('PWUF_FOLLOW_DIR')) define('PWUF_FOLLOW_DIR', dirname( __FILE__ ) );
if(!defined('PWUF_FOLLOW_URL')) define('PWUF_FOLLOW_URL', plugin_dir_url( __FILE__ ) );


/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function pwuf_textdomain() {
  load_plugin_textdomain( 'pwuf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('init', 'pwuf_textdomain');


/*
|--------------------------------------------------------------------------
| FILE INCLUDES
|--------------------------------------------------------------------------
*/

include_once( PWUF_FOLLOW_DIR . '/includes/actions.php' );
include_once( PWUF_FOLLOW_DIR . '/includes/scripts.php' );
include_once( PWUF_FOLLOW_DIR . '/includes/shortcodes.php' );
include_once( PWUF_FOLLOW_DIR . '/includes/follow-functions.php' );
include_once( PWUF_FOLLOW_DIR . '/includes/display-functions.php' );