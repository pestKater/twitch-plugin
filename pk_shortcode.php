<?php
function pk_twitch_overview($atts, $content=null) {
    
    $atts = shortcode_atts(
                array(
                    'visible' => 'full'
                ), $atts
            );
    
    $args = array(
        'post_type' => 'twitch',
        'post_status' => 'publish'
    );
    
    $streams = new WP_Query($args);
    
    if($streams->have_posts()):
        
        $output = '<h2>Online</h2>';
        $output_fallback = '<p class="pk_stream_fallback">Im Moment ist kein Streamer online</p>';
        $output_online = '';
        $output_offline = '<h2>Offline</h2><ul class="pk_offline_avatar_list">';
        
        while($streams->have_posts()) : $streams->the_post();
            global $post;
            
            $accountname = get_post_meta(get_the_ID(), 'name', true);
            $apicall = 'https://api.twitch.tv/kraken/streams/'.$accountname;
            $api = json_decode(file_get_contents($apicall));

            if($api->stream != Null):
                
                $preview = str_replace('320x180', '240x135', $api->stream->preview->medium);
                $link = $api->stream->channel->url;
                
                $output_online .= '<div class="pk_VideoFrame">';
                $output_online .= '<div class="pk_ThumbnailFrame">';
                $output_online .= '<a href="'.$link.'">';
                $output_online .= '<img class="pk_Thumbnail" src="'.$preview.'">';
                $output_online .= '</a>';
                $output_online .= '</div>';
                $output_online .= '<div class="pk_StreamerImage">';
                $output_online .= '<a href="'.$link.'">';
                $output_online .= '<img src="'.$api->stream->channel->logo.'" width="48" height="48">';
                $output_online .= '</a>';
                $output_online .= '</div>';
                $output_online .= '<div class="pk_VideoFrameText">';
                $output_online .= '<img src="'.plugins_url('assets/thumbnail-lets-play.png', __FILE__ ).'" class="pk_GameIcon">';
                $output_online .= '<a class="pk_VideoGame" href="'.$link.'">'.$api->stream->game.'</a>';
                $output_online .= '<br>';
                $output_online .= '<a class="pk_VideoTitle" href="'.$link.'">'.$api->stream->channel->status.'</a>';
                $output_online .= '</div>';
                $output_online .= '</div>';
            
            else:
                $channelapi = json_decode(file_get_contents($api->_links->channel));
                $output_offline .= '<li class="pk_offline_avatar"><a href="'.$channelapi->url.'"><img src="'.$channelapi->logo.'" height="135" width="135"></a></li>'; 
            endif;
            
            
        endwhile;
        
        $output_offline .= '</ul>';
        
        if($output_online == '') :
            $output_online = $output_fallback;
        endif;
        
        if($atts['visible'] == 'online') :
            $output .= $output_online;
        else:
            $output .= $output_online.$output_offline;
        endif;
        
        
        
    endif;
    
    return $output;
}
