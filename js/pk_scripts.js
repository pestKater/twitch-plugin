//jQuery(document).ready(function(){
    //jQuery(".pk_show-stream").click(function(){
       //var accountname = jQuery(".pk_show-stream").attr("username");
       //var panel = '.pk_streampanel-' + accountname;
       
       //console.log(panel);
       
       //jQuery(panel).append('<iframe src="https://player.twitch.tv/?channel=' + accountname + '" frameborder="0" scrolling="no" height="378" width="620"></iframe>');   
       //jQuery(panel).slideToggle("slow");
       
    //});
    
    
    function showLiveStream( accountname ) {
        var panel = '#pk_streampanel-' + accountname;
        var hasIframe = jQuery(panel + ' iframe').length;
        
        if(hasIframe === 0) { 
            jQuery(panel).append('<iframe class="stream" src="https://player.twitch.tv/?channel=' + accountname + '" frameborder="0" scrolling="no" height="378" width="620"></iframe>');   
            jQuery(panel).slideToggle("slow");
        } else {
            jQuery(panel).slideToggle("slow");
            jQuery(panel + ' .stream').remove();   
        }
    }
    
//});
