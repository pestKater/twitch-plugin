<?php
/**
 * Plugin Name: Twitch Plugin
 * Plugin URI: https://zockerfurs.de
 * Description: This Plugin easily enables a embedding-backend to display costumized Twitch-Status on your Wordpress-Page.
 * Author: Halldor Rolandsson
 * Version: 0.0.1
 * Licence: GPLv3
 */

/**
 * SICHERHEITSABFRAGE
 * Wenn Code direkt aufgerufen wird, wird er sofort beendet.
 */
if(!defined('ABSPATH')) {
    exit;
}

/**
 * FILECONFIG
 */

//Problem wegen nicht unixoiden Systems
require_once plugin_dir_path(__FILE__).'pk_functions.php';
require_once plugin_dir_path(__FILE__).'pk_template.php';
require_once plugin_dir_path(__FILE__).'pk_shortcode.php';


/**
 * PROGRAMMLOGIK
 */

add_action('init', 'pk_register_posttype');
add_action('add_meta_boxes', 'pk_costum_metabox');
add_action('save_post', 'pk_save_meta');
add_action('wp_enqueue_scripts', 'pk_admin_enqueue_scripts');


/**
 * SHORTCODES
 */
add_shortcode('twitch_overview', 'pk_twitch_overview');