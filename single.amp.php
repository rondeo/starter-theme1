<?php

the_post();

$thumbnail_id = get_post_thumbnail_id();
if (!empty($thumbnail_id)) {
    $feature = wp_get_attachment_image_src($thumbnail_id, "full");
    $thumbnail = wp_get_attachment_image_src($thumbnail_id, "post_thumbnail");
}

$description = get_post_meta(get_the_ID(), "_yoast_wpseo_metadesc", true);
if (empty($description))
    $description = get_the_excerpt();

OSP\set_skin_from_terms(get_the_category());

OSP\queue_style(OSP\current_skin());

Oneupweb\AMPenburg::enable();

?>
<!doctype html>
<html ⚡>
<head>
    <meta charset="utf-8">

    <title><?php wp_title('', true, false) ?></title>

    <link rel="canonical" href="<?= get_permalink() ?>">
    
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">

    <link rel="icon" href="" sizes="32x32" />
    <link rel="icon" href="" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="" />
    <meta name="msapplication-TileImage" content="" />

    <?php if (defined('FACEBOOK_APP_ID')): ?>
    <meta property="fb:app_id"             content="<?=FACEBOOK_APP_ID?>" />
    <?php endif; ?>
    <meta property="og:url"                content="<?=esc_url(get_permalink())?>" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="<?=esc_attr(get_the_title())?>" />
    <meta property="og:description"        content="<?=esc_attr($description)?>" />
    <?php if (!empty($feature)): ?>
    <meta property="og:image"              content="<?=esc_url($feature[0])?>" />
    <meta property="og:image:width"        content="<?=esc_attr($feature[1])?>" />
    <meta property="og:image:height"       content="<?=esc_attr($feature[2])?>" />
    <?php endif; ?>

    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>

    <?php if (class_exists('Oneupweb\AMPenburg')) echo Oneupweb\AMPenburg::output_libraries() ?>

    <link rel="stylesheet" href="https://use.typekit.net/azy5cwn.css" type="text/css">

    <?php 
    
        echo '<style amp-custom>';
        echo OSP\style();
        echo '</style>';

        $meta = get_post_meta(get_the_ID(), "_yoast_wpseo_metadesc", true);
        if (empty($meta))
            $meta = get_the_excerpt();

        if (!empty($meta)) {
            printf('<meta name="description" content="%s">',
                esc_attr($meta));
        }

        $schema = [
            "@context"          => "http://schema.org",
            "@type"             => "BlogPosting",
            "headline"          => get_the_title(),
            "datePublished"     => get_the_time('c'),
            "dateModified"      => get_the_time('c'),
            "description"       => get_the_excerpt(),
            "mainEntityOfPage"  => get_permalink(),
            "author" => [
                "@type" => "Person",
                "name"  => get_the_author(),
            ]            
        ];

        /* 
            "publisher" => [
                "@type" => "Organization",
                "name"  => "RondaRousey.com",
                "logo" => [
                    "@type"     => "ImageObject",
                    "url"       => THEME_ASSETS_URI . "/images/logo.svg"
                ]
            ]
        */
        
        if (!empty($feature))
        {
            $schema["image"] = [
                "@type"   => "ImageObject",
                "url"     => $feature[0],
                "height"  => $feature[1],
                "width"   => $feature[2]
            ];
        }

    ?>
    <script type="application/ld+json">
        <?=json_encode($schema)?>
    </script>

</head>
<body <?php body_class('__amp-layout') ?>>

    <?php if (defined('GTM_ID')): ?>
    <amp-analytics config="https://www.googletagmanager.com/amp.json?id=<?=GTM_ID?>&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
    <?php endif; ?>
        
    <header class="page-header">

        <div class="page-header--logo">

            <a href="<?=get_bloginfo('url')?>"><?php echo file_get_contents(THEME_ASSETS_DIR . "/images/logo.svg") ?></a>

        </div>

    </header>

    <main class="single">

    <article <?php post_class("single--article __page-bg")?>>

        <header class="--header">

            <?php /*if (has_post_thumbnail()): ?>

            <amp-img class="feature-image"
                src="<?=$thumbnail[0]?>"
                width="<?=$thumbnail[1]?>"
                height="<?=$thumbnail[2]?>"
                srcset="<?=(wp_get_attachment_image_srcset($thumbnail_id, 'post_thumbnail') ?: '')?>"
                layout="responsive">

                <noscript>
                    <img
                    src="<?=$thumbnail[0]?>"
                    width="<?=$thumbnail[1]?>"
                    height="<?=$thumbnail[2]?>"
                    >
                </noscript>
            </amp-img>

            <?php endif;*/ ?>

            <h1 class="single--headline"><?php the_title() ?></h1>

            <div class="single--meta">

                <nav class="single--share">

                    <?php if (defined('FACEBOOK_APP_ID')): ?>
                    <amp-social-share type="facebook" data-param-app_id="<?=FACEBOOK_APP_ID?>"></amp-social-share>
                    <?php endif; ?>
                    <amp-social-share layout="flex-item" type="twitter"></amp-social-share>
                    <amp-social-share layout="flex-item" type="linkedin"></amp-social-share>
                    <amp-social-share layout="flex-item" type="pinterest"></amp-social-share>
                    <amp-social-share layout="flex-item" type="email"></amp-social-share>
                    <amp-social-share layout="flex-item" type="tumblr"></amp-social-share>
                    <amp-social-share layout="flex-item" type="system"></amp-social-share>

                </nav>

                
                <time class="single--pubdate" datetime="<?php the_time('c') ?>"><?php
                    the_time('M j Y')
                ?></time>

                <?php the_author() ?>

            </div>

        </header>

    

        <div class="the-content single--the-content">

            <?php if (! OSP\post_is_gated()): ?>

            <?php the_content() ?>

            <?php else: ?>

            <?php 

                if (has_post_thumbnail()): 

                    $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), "mediumlarge");

                    printf('

                    <amp-img class="image-block --featured-image"
                        src="%1$s"
                        width="%2$s"
                        height="%3$s"
                        layout="responsive">

                        <noscript>
                            <img
                            class="ampenburged-image"
                            src="%1$s"
                            width="%2$s"
                            height="%3$s"
                            >
                        </noscript>
                    </amp-img>',

                    $thumbnail[0],
                    $thumbnail[1],
                    $thumbnail[2]
                );

                endif 
                
            ?>

            <div class="__fade-out"><?php the_excerpt() ?></div>

            <h4>This content is only available to premium members!</h4>

            <p>Sorry, you can't see this premium content right now, but if you sign up to become a 
                Rowdy One, you can! For $2.99 per month, you'll get access to hours of exclusive
                video, news, and save 10% off ALL merch in the store. Here's the button to click 
                to sign up. Do it!</p>

            <div class="premium-buttons">

                <a class="btn __primary" data-action="add-to-cart" href="<?= get_bloginfo('url') ?>/account/">Log In</a>

                <?php $monthly = get_page_by_path('premium-membership-monthly', OBJECT, 'product'); if ($monthly): ?>
                <?php $product = wc_get_product($monthly); ?>
                <a class="btn __primary" data-action="add-to-cart" data-id="<?=$monthly->ID?>" href="<?= add_query_arg('add-to-cart', $monthly->ID, wc_get_cart_url()) ?>">Purchase Monthly - $<?=$product->get_price()?></a>
                <?php endif; ?>

                <?php $yearly = get_page_by_path('premium-membership-yearly', OBJECT, 'product'); if ($yearly): ?>
                <?php $product = wc_get_product($yearly); ?>
                <a class="btn __primary" data-action="add-to-cart" data-id="<?=$yearly->ID?>" href="<?= $product->get_permalink() ?>">Purchase Yearly - $<?=$product->get_price()?></a>
                <?php endif ?>

            </div>

            <?php endif; ?>

        </div>        

        

        <?php $related = Oneupweb\get_related_posts(2) ?>
        <?php if ($related): ?>

        <aside class="single--related-articles">

            <h6>Related Articles</h6>

            <ul>

                <?php foreach ($related as $post): setup_postdata($post); ?>

                <li>

                    <?php get_template_part("components/post/related_amp", get_post_format()) ?>

                </li>

                <?php endforeach; wp_reset_postdata(); ?>

            </ul>

        </aside>

        <?php endif; ?>

    </article>

    </main>

</body>
</html>