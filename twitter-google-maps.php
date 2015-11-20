<?php
/**
* Plugin Name: Twitter Google Maps
* Plugin URI: http://mypluginuri.com/
* Description: Showing you location with the latest tweet.
* Version: 1.0
* Author: HMC Advertising 
* Author URI: http://wearehmc.com
* License: A "Slug" license name e.g. GPL12
*/

function gMap(){
	wp_enqueue_script("google_map", "https://maps.googleapis.com/maps/api/js?key=AIzaSyD1n6pUKrhmbVb9_MAnvfkJlra6GcGPaJ0&#038;sensor=true&#038;ver=1.0.0", "1.0.0" , false);
}
add_action( 'wp_enqueue_scripts', 'gMap' );

require_once "twitter_gmap_config.php";
require_once 'twitter_gmap_options.php';
require_once 'twitter_gmap_shortcodes.php';
