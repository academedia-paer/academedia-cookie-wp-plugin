<?php
/**
* Plugin Name: Cookie control
* Plugin URI: https://www.ohmy.co
* Description: This plugin adds a cookiebar and options for it.
* Version: 0.22
* Author: Oh My Interactive AB
* Author URI: https://www.ohmy.co
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

if (! cookie_bar_show_revoke()) { ?>
	<style>
		.cc-revoke {
			display: none!important;
		}
	</style>
<?php }