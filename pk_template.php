<?php
/**
 * SETTINGSPAGE
 * Under Constructions
 */
function pk_render_settings_page() {
    global $post;
    $args = array(
        'post_type'                 => 'twitch',
        'orderby'                   => 'menu_order',
        'order'                     => 'ASC',
        'no_found_rows'             => true,
        'update_post_term_cache'    => false,
        'post_per_page'             => 50
    );
    
    $streams = new WP_Query($args);
    ?>

<div class="wrap">
    <ul>
        <?php while($streams->have_posts()) : $streams->the_post(); ?>
            <li id="<?php the_id(); ?>">
                <?php 
                    $metadata = get_metadata('post', $post-ID);
                    var_dump($metadata['name']);
                ?>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

    <?php
    
    echo '<pre>';
    //var_dump($streams);
    echo '</pre>';
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