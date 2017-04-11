<?php
/**
 * @package uvwpintegrations
 */
/*
Plugin Name: UrVenue
Plugin URI: http://urvenue.com/
Description: UrVenue Wordpress plugin.
Version: 1.0.1
Author: UrVenue
Author URI: http://urvenue.com/
*/


define('URVENUE_VERSION', '1.0.1');


add_action('admin_menu', 'uvwp_add_settings');
add_filter('plugin_action_links', 'uvwp_add_pluginlist_links', 10, 5);
add_action('admin_init', 'uvwp_register_settings');
add_action('wp_enqueue_scripts', 'uvwp_enqueue_urvenue_files');
add_action('wp_ajax_nopriv_uvwp_loadcal', 'uvwp_loadcal');
add_action('wp_ajax_uvwp_loadcal', 'uvwp_loadcal');
add_action('wp_ajax_nopriv_uvwp_sendresform', 'uvwp_sendresform');
add_action('wp_ajax_uvwp_sendresform', 'uvwp_sendresform');
add_action('wp_ajax_nopriv_uvwp_packagespopurl', 'uvwp_packagespopurl');
add_action('wp_ajax_uvwp_packagespopurl', 'uvwp_packagespopurl');
add_action('wp_ajax_nopriv_uvwp_loadalbumpop', 'uvwp_loadalbumpop');
add_action('wp_ajax_uvwp_loadalbumpop', 'uvwp_loadalbumpop');

/*UvCore Inclutions*/
include_once(plugin_dir_path(__FILE__) . "uv.options.php");
include_once($uv_corepath . "/uvcore.functions.php");

/*UvWP Inclutions*/
include_once(plugin_dir_path(__FILE__) . "uvwp.lib.php");
include_once(plugin_dir_path(__FILE__) . "uvwp.functions.php");
require_once(plugin_dir_path(__FILE__) . "uvwp.shortcodes.php");





