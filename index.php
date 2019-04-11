<?php
/*
  Plugin Name:  Planet Meetup Autor Followers
  Version: 1.0
  Plugin URI: https://gradiweb.com
  Description: Followers system for Planet Meetup Web App
  Author URI: https://github.com/msoler18/
  Author: msoler18
  License: GPL2
 */
 
  function wp_authors_tbl_create() {
      global $wpdb;
   
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}author_subscribe");
   
      $sql1 = "CREATE TABLE {$wpdb->prefix}author_subscribe (
          id int(11) NOT NULL AUTO_INCREMENT,
          activation_code varchar(255) NOT NULL,
          email varchar(75) NOT NULL,
          status int(11) NOT NULL,
          followed_authors text NOT NULL,
          PRIMARY KEY (id)
      ) ENGINE=InnoDB AUTO_INCREMENT=1;";
   
      dbDelta($sql1);
   
      $sql2 = ("CREATE TABLE {$wpdb->prefix}author_followers (
          id int(11) NOT NULL AUTO_INCREMENT,
          author_id int(11) NOT NULL,
          followers_list text NOT NULL,
          PRIMARY KEY (id)
      ) ENGINE=InnoDB AUTO_INCREMENT=1;");
   
      dbDelta($sql2);
  }
   
  register_activation_hook(__FILE__, 'wp_authors_tbl_create');



  add_shortcode("contributors", "contributors");
   
  function contributors() {
   $authors = get_users();
    
       $authorsList = '<div id="wp_authors_list">';
       foreach ($authors as $author) {
           if (user_can($author->ID, 'publish_posts')) {
               $authorsList .= '<div class="auth_row">
                       <div class="auth_image">' . get_avatar($author->ID) . '</div>
                       <div class="auth_info">
                           <p class="title">' . get_the_author_meta('display_name', $author->ID) . '</p>
                           <p class="desc">' . get_the_author_meta('description', $author->ID) . '</p>
                       </div>
                       <div class="auth_follow"><input type="button" class="follow" value="Follow"
                       data-author="' . $author->ID . '" /></div>
                       <div class="frm_cls"></div>
                   </div>';
           }
       }
    
       $authorsList .= '</div>';
  }
   

  add_shortcode("form", "form");  
  function form() { 
    $output = '<div id="wp_authors_panel">
        <div id="wp_authors_head">Follow WP Authors</div>
        <div id="wp_authors_form">
            <div class="frm_row">
                <div id="frm_msg" class="' . $actClass . '">' . $actStatus . '</div>
                <div class="frm_label">Enter Your Email</div>
                <div class="frm_field"><input type="text" name="user_email" id="user_email"
    value="' . $confirmedEmail . '" /></div>
                <div class="frm_cls"></div>
            </div>
            <div class="frm_row">
                <div class="frm_label">&nbsp;</div>
                <div class="frm_control"><input type="button" value="Subscribe" id="subscribeAuthors" /></div>
                <div class="frm_control"><input type="button" value="Load" id="loadFollowers" /></div>
                <div class="frm_cls"></div>
            </div>
        </div>
        ' . $authorsList . '
    </div>';
     
    echo $output;
  }


  function apply_wp_author_scripts() {
   
      wp_enqueue_script('jquery');
   
      wp_register_script('followjs', plugins_url('follow.js', __FILE__));
      wp_enqueue_script('followjs');
   
      wp_register_style('followCSS', plugins_url('follow.css', __FILE__));
      wp_enqueue_style('followCSS');
   
      $config_array = array(
          'ajaxUrl' => admin_url('admin-ajax.php'),
          'ajaxNonce' => wp_create_nonce('follow-nonce'),
          'currentURL' => $_SERVER['REQUEST_URI']
      );
      wp_localize_script('followjs', 'ajaxData', $config_array);
  }
   
  add_action('wp_enqueue_scripts', 'apply_wp_author_scripts');
