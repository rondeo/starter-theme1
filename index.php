<?php

if (!defined('ABSPATH'))
    return;

get_header() ?>

<main class="main archive index<?php if (is_active_sidebar( 'post-sidebar' )) echo " __has-sidebar" ?>">

<?php if (is_archive()): ?>

    <header class="index--header archive--header --header">

        <img src="<?= THEME_ASSETS_URI ?>/images/skyline.jpg" alt="" class="page--header--background --header--background --background">

        <h1 class="index--headline --headline"><?php single_term_title() ?></h1>

    </header>

    <div class="index--loop archive--loop --loop">
        
        <?php if (have_posts()): while(have_posts()): the_post() ?>

        <?php get_template_part('components/post/loop', get_post_type()) ?>

        <?php endwhile; endif ?>

        <div class="search--pagination archive--pagination --pagination">

        <?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>

            </div>

    </div>        

    <?php if ( is_active_sidebar( 'post-sidebar' ) ) : ?>

    <div class="search--sidebar archive--sidebar --sidebar" role="complementary">

        <?php dynamic_sidebar( 'post-sidebar' ); ?>
        
    </div>

    <?php endif; ?>

<?php elseif (is_singular()): ?>

    <article class="page--article index--article --content">

        <header class="index--header page--header --header">

            <img src="<?= THEME_ASSETS_URI ?>/images/skyline.jpg" alt="" class="page--header--background --header--background --background">

            <h1 class="index--headline --headline"><?php the_title() ?></h1>

        </header>

        <div class="page--content index--content --content">

            <?php the_content() ?>

        </div>

    </article>

    <?php else: ?>

    <?php get_template_part('components/404') ?>

    <?php endif; ?>

</main>

<?php get_footer() ?>