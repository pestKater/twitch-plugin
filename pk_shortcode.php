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
                
                $output_online .= '<div class="frontpageVideoFrame">';
                $output_online .= '<div class="frontpageThumbnail">';
                $output_online .= '<a href="#">';
                $output_online .= '<img src="'.$preview.'">';
                $output_online .= '</a>';
                $output_online .= '</div>';
                $output_online .= '<div class="frontpageAuthorImage">';
                $output_online .= '<a href="#">';
                $output_online .= '<img src="'.$api->stream->channel->logo.'" width="48" height="48">';
                $output_online .= '</a>';
                $output_online .= '</div>';
                $output_online .= '<div class="frontpageVideoFrameText">';
                $output_online .= '<img src="https://zockerfurs.de/wp-content/uploads/2015/11/thumbnail-lets-play.png" class="frontpageEpisodeIcon">';
                $output_online .= '<a class="frontPageVideoGame" href="#">'.$api->stream->game.'</a>';
                $output_online .= '<br>';
                $output_online .= '<a class="frontpageVideoTitle" href="#">'.$api->stream->channel->status.'</a>';
                $output_online .= '</div>';
                $output_online .= '</div>';
            
            else:
                $channelapi = json_decode(file_get_contents($api->_links->channel));
                $output_offline .= '<li class="pk_offline_avatar"><a href="#"><img src="'.$channelapi->logo.'" height="135" width="135"></a></li>'; 
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
