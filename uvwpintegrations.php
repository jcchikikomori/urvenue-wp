<?php
/**
 * @package uvwpintegrations
 */
/*
Plugin Name: uvwpintegrations
Plugin URI: http://urvenue.com/
Description: UrVenue Wordpress plugin.
Version: 0.1
Author: UrVenue - aa
Author URI: http://urvenue.com/
*/


define('URVENUE_VERSION', '0.1');


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


$uv_coreurl = plugin_dir_url(__FILE__) . "uvcore";
$uv_corepath = plugin_dir_path(__FILE__) . "uvcore";

include_once(plugin_dir_path(__FILE__) . "uvwp.lib.php");
include_once(plugin_dir_path(__FILE__) . "uvwp.functions.php");
require_once(plugin_dir_path(__FILE__) . "uvwp.shortcodes.php");





