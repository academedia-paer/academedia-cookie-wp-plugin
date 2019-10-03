<?php
/**
* Plugin Name: Academedia cookie-bar
* Plugin URI: https://github.com/academedia-paer/academedia-cookie-wp-plugin/
* Description: Let's meet at the cookie-bar
* Version: 1.00
* Author: Pär Henriksson, academedia
**/

defined( 'ABSPATH' ) or die( 'Forbidden' );
define( 'PLUGIN_DIR', dirname(__FILE__).'/' );

include( PLUGIN_DIR . 'options.php');

function cookie_bar_show_revoke()
{
	switch_to_blog(1);
	$show_revoke = get_option('show_revoke', true);
	restore_current_blog();
	return $show_revoke;
}

function add_cookie_bar() {
	include(PLUGIN_DIR . 'cookie-bar.php');
}
add_action( 'wp_head', 'add_cookie_bar', 1);
add_action('body_class', function ($classes) {
	if ( ! cookie_bar_show_revoke() )
	{
		$classes[] = 'hide-revoke';
	}

	return $classes;
});


if (! cookie_bar_show_revoke()) {

	function cookie_inline_css() {
			$custom_css = "
				.cc-revoke {
					display: none!important;
				}";
	  wp_add_inline_style( 'cookie-hide-revoke', $custom_css ); 
	}
	add_action( 'wp_enqueue_scripts', 'cookie_inline_css' ); 

}
