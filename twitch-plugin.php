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
 * POSTTYPE ANLEGEN
 * ToDo: Multilanguage-Support
 */
function pk_register_posttype() {
    
    $singular = 'Livestream';
    $plural = 'Livestreams';
    
    // Workingtitles
    $labels = array(
        'name'                  => $plural,
        'singular_name'         => $singular,
        'add_name'              => 'Hinzufügen',
        'add_new_item'          => $singular.' hinzufügen',
        'edit_item'             => $singular.' bearbeiten',
        'view'                  => $singular.' ansehen',
        'view_item'             => $singular.' ansehen',
        'search_term'           => $plural.' suchen',
        'parent'                => 'Parent test',
        'not_found'             => 'Keinen '.$singular.' gefunden',
        'not_found_in_trash'    => 'Keine '.$singular.' im Papierkorb'
    );
    
    // ToDo: Dynamische Settings
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'exclude_from_seach'    => false,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_admin_bar'     => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-video-alt3',
        'can_export'            => true,
        'delete_with_user'      => false,
        'hierachical'           => false,
        'has_archive'           => false,
        'query_var'             => true,
        'capability_type'       => 'page',
        'map_meta_cap'          => true,
        'rewrite'               => array(
                                    'slug'          => 'streams',
                                    'with_front'    => true,
                                    'pages'         => true,
                                    'feeds'         => false
                                ),
        'supports'              => array(
                                    'title',
                                    'editor',
                                    'author',
                                    'custom-fields',
                                    'thumbnail'
                                )
    );
    
    register_post_type('twitch', $args);
}
add_action('init', 'pk_register_posttype');