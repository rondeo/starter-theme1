<?php

add_filter('the_author', function ($name)
{
    global $post;

    if ($post) {
        $altname = get_post_meta($post->ID, '_alt-author', true);
        if (!empty($altname))
            $name = $altname;
    }

    return $name;
    
});