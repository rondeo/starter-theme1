<?php

namespace Oneupweb;

function add_schema($post=null)
{
    if (empty($post)) {
        global $post;
    }

    if (is_numeric($post)) {
        $post = get_post($post);
    } 
    
    if (!is_object($post)){
        return false;   
    }

    $thumbnail_id = get_post_thumbnail_id($post);
    if (!empty($thumbnail_id)) {
        $feature = wp_get_attachment_image_src($thumbnail_id, "large");
        $thumbnail = wp_get_attachment_image_src($thumbnail_id, "post_thumbnail");
    }

    setup_postdata($post);

    $schema = [
        "@context"          => "http://schema.org",
        "@type"             => "BlogPosting",
        "headline"          => get_the_title($post),
        "datePublished"     => get_the_time('c', $post),
        "dateModified"      => get_the_time('c', $post),
        "description"       => get_the_excerpt($post),
        "mainEntityOfPage"  => get_permalink($post),
        "author" => [
            "@type" => "Person",
            "name"  => get_the_author(),
        ]        
    ];
    
    /*"publisher" => [
        "@type" => "Organization",
        "name"  => "RondaRousey.com",
        "logo" => [
            "@type"     => "ImageObject",
            "url"       => THEME_ASSETS_URI . "/images/logo.svg"
        ]
    ]*/
    
    if (!empty($feature))
    {
        $schema["image"] = [
            "@type"   => "ImageObject",
            "url"     => $feature[0],
            "height"  => $feature[1],
            "width"   => $feature[2]
        ];
    }

    add_action("wp_head", function () use ($schema) { ?>

        <script type="application/ld+json">
            <?= json_encode($schema) ?>
        </script>

    <?php });

    wp_reset_postdata();

}
