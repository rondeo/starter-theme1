<?php 

namespace Oneupweb;

?>
<!doctype html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">        

        <?php 
        
        if (class_exists('AMPenburg') && AMPenburg::use_ampenburg()) 
        {
            if (is_singular())
                $url = get_permalink(get_queried_object_id());
            else if (is_archive())
                $url = get_termlink(get_queried_object()->term_id);

            echo AMPenburg::link_amphtml($url ?? "");
        }

        ?>
        
        <?php wp_head() ?>

        <?php do_action("Theme/header") ?>        
        
        <?php if (defined('GTM_ID')): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?=GTM_ID?>"></script>
        <?php endif ?>

    </head>

    <?php $mobile = wp_is_mobile() ? "__is-mobile" : "__is-desktop" ?>
    <body <?php body_class(apply_filters('Theme/body_classes', $mobile)) ?>>

        <?php if (defined('GTM_ID')): ?>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments) }
            gtag('js', new Date());
            gtag('config', GTM_ID);
        </script>
        <?php endif ?>

        <?php do_action("Theme/open_body") ?>

        <?php get_template_part("components/layout/navigation") ?>
