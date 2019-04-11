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
