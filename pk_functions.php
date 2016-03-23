<?php

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
        'supports'              => array('title','thumbnail')
    );
    
    register_post_type('twitch', $args);
}

/**
 * COSTUM METABOX
 * Eigene Metabox (Formularfeld) beim Erstellen des Posts
 * ToDo: Multilanguage
 */
function pk_costum_metabox() {
    add_meta_box('twitchdata','Streamdaten','pk_metabox_callback');
}

/**
 * METABOX CALLBACK
 */
function pk_metabox_callback($post) {
    wp_nonce_field(basename(__FILE__), 'pk_twitch_nounce');
    $stored_meta = get_post_meta($post->ID);
    ?>
 
    <div>
        <div class="pk-meta-row">
            <div class="pk-meta-th pk-float-left">
                <label for="twitchname">Twitchname:</label>
            </div>
            <div class="pk-meta-td pk-float-left">
                <input type="text" id="twitchname" name="name" value="<?php if(!empty($stored_meta['name'])) echo esc_attr($stored_meta['name'][0]) ?>" />
            </div>
            <div class="pk-clear-float"></div>
        </div>

        <div class="pk-meta-row">
            <div class="pk-meta-th">
                <label for="channel-description">Kanalbeschreibung:</label>
            </div>
            <div class="pk-meta-td">
                <?php
                    if(!empty($stored_meta['description'])){
                        $content = esc_attr($stored_meta['description'][0]);
                    }
                    $editor = 'channel-description';
                    $settings = array(
                        'textarea_rows' => 8,
                        'media_buttons' => false
                    );

                    wp_editor($content, $editor, $settings);
                ?>
            </div>
        </div>
    </div>
    <?php
}

/**
 * DATAHANDLER
 */
function pk_save_meta($post_id) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'pk_twitch_nounce' ] ) && wp_verify_nonce( $_POST[ 'pk_twitch_nounce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    
    if ( isset( $_POST[ 'name' ] ) ) {
    	update_post_meta( $post_id, 'name', sanitize_text_field( $_POST[ 'name' ] ) );
    }
    if ( isset( $_POST[ 'description' ] ) ) {
    	update_post_meta( $post_id, 'name', sanitize_text_field( $_POST[ 'description' ] ) );
    }
}

/**
 * CSS UND JS EINBINDEN
 */
function pk_admin_enqueue_scripts() {
    global $pagenow, $typenow;
    
    if ( $typenow == 'twitch') {
        wp_enqueue_style( 'pk-admin-css', plugins_url( 'css/admin-twitch.css', __FILE__ ) );
    }
}

/**
 * SETTINGS HINZUFÜGEN
 */
function pk_create_submenue_entry(){
    add_submenue_page($parent_slug, $page_title, $menue_title, $capability, $menu_slug, $function);
}