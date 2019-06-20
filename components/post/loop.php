<blockquote <?php post_class("the-post loop") ?> cite="<?=get_permalink()?>">

    <?php if (has_post_thumbnail()): ?>

        <figure class="--thumbnail">
            <a href="<?= get_permalink() ?>"><?php the_post_thumbnail("feed_hero") ?></a>
        </figure>

    <?php endif; ?>

    <nav class="--share">

        <label>Share this:</label>

        <?php Oneupweb\social_icons_template() ?>

    </nav>

    <div class="--excerpt">

        <h3><a href="<?= get_permalink() ?>"><?php the_title() ?></a></h3>

        <div class="--meta">

            <time class="related-post--pubdate" datetime="<?php the_time('c') ?>"><?php
                the_time('M j Y')
            ?></time>

            <?php the_author() ?>

        </div>

        <?php the_excerpt() ?>            

    <a href="<?= get_permalink() ?>" class="btn __primary">Read<span class='screen-reader-text'> '<?php the_title() ?>'</a>

    </div>

</blockquote>