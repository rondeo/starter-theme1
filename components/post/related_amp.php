<?php

    $classes = 'related-post ';
    if (OSP\post_is_gated()) {
        $classes .= OSP\post_is_locked() ? '__locked' : '__unlocked';
    }

    $thumbnail_id = get_post_thumbnail_id();
    if (!empty($thumbnail_id)) {
        $thumbnail = wp_get_attachment_image_src($thumbnail_id, "post_thumbnail");
    }

    $srcset = wp_get_attachment_image_srcset($thumbnail_id, 'post_thumbnail');

?>
<blockquote cite="<?=get_permalink()?>" <?php post_class($classes) ?>>

    <?php if (has_post_thumbnail()): ?>

        <amp-img class="feature-image"
            src="<?=$thumbnail[0]?>"
            width="<?=$thumbnail[1]?>"
            height="<?=$thumbnail[2]?>"
            <?=($srcset ? sprintf('srcset="%s"', $srcset) : '')?>
            layout="responsive">

            <noscript>
                <img
                src="<?=$thumbnail[0]?>"
                width="<?=$thumbnail[1]?>"
                height="<?=$thumbnail[2]?>"
                >
            </noscript>
        </amp-img>

    <?php endif ?>

    <h5><a href="<?=get_permalink()?>"><?php the_title() ?></a></h5>

    <div class="--meta">

        <time class="--pubdate" datetime="<?php the_time('c') ?>"><?php
            the_time('M j Y')
        ?></time>

        <?php the_author() ?>

    </div>

</blockquote>