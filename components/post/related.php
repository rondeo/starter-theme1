<?php

    $classes = 'related-post ';
    if (OSP\post_is_gated()) {
        $classes .= OSP\post_is_locked() ? '__locked' : '__unlocked';
    }

?>
<blockquote cite="<?=get_permalink()?>" <?php post_class($classes) ?>>

    <?php if (has_post_thumbnail()): ?>

    <a class="--thumbnail" href="<?=get_permalink()?>"><?php the_post_thumbnail('block_thumbnail') ?></a>

    <?php endif ?>

    <h5><a href="<?=get_permalink()?>"><?php the_title() ?></a></h5>

    <div class="--meta">

        <time class="--pubdate" datetime="<?php the_time('c') ?>"><?php
            the_time('M j Y')
        ?></time>

        <?php the_author() ?>

    </div>

</blockquote>