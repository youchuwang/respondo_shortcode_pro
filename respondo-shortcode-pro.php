<?php

/*
  Plugin Name: Respondo Shortcodes Pro
  Plugin URI: 
  Description: 
  Version: 1.0
  Author: 
  Author URI: 
 */

// remove_filter( 'the_content', 'wpautop' );
// add_filter( 'the_content', 'wpautop' , 99);
// add_filter( 'the_content', 'shortcode_unautop',100 );

if (!defined('ABSPATH'))
    die("Can't load this file directly");

define( 'RESPONDO_SHORTCODE_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'RESPONDO_SHORTCODE_PLUGIN_URL', plugins_url().'/respondo-shortcode-pro/' );

load_plugin_textdomain('rs_shortcode', false, basename(dirname(__FILE__)) . '/lang/');

include RESPONDO_SHORTCODE_PLUGIN_PATH.'inc/classes/shortcodes-list.class.php';
include RESPONDO_SHORTCODE_PLUGIN_PATH.'inc/classes/respondo-shortcode.class.php';
?>