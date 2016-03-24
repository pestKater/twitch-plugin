<?php
function pk_twitch_overview($atts, $content=null) {
    
    $atts = shortcode_atts(
                array(
                    'visible' => 'all'
                ), $atts
            );
    
    return $atts['visible'];
}
