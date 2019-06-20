<blockquote cite="<?=get_permalink()?>" <?php post_class('excerpt post-excerpt') ?>>

    <h3><a href="<?=get_permalink()?>"><?php the_title() ?></a></h3>

    <?php the_excerpt() ?>

    <nav>

        <a href="<?=get_permalink()?>" class="btn __primary">Read It</a>

    </nav>    

</blockquote>