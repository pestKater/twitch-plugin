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
//$dir = plugin_dir_path(__FILE__);
require_once 'pk_functions.php';

if ( $typenow == 'twitch') {
    wp_enqueue_style( 'pk-admin-css', plugins_url( 'css/admin-twitch.css', __FILE__ ) );
}

/**
 * PROGRAMMLOGIK
 */
if(function_exists('pk_register_posttype')) {
    add_action('init', 'pk_register_posttype');
}

if(function_exists('pk_costum_metabox')) {
    add_action('add_meta_boxes', 'pk_costum_metabox');
}

add_action('save_post', 'pk_save_meta');
