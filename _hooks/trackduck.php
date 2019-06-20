<?php

if (defined('TRACKDUCK_ID') && WP_DEBUG) {

    add_action("wp_footer", function () { ?>
        
        <script src="//cdn.trackduck.com/toolbar/prod/td.js" async 
            data-trackduck-id="<?=TRACKDUCK_ID?>"></script>

    <?php });

}