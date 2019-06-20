<?php

//Oneupweb\AMPenburg::enable();
Oneupweb\Schema::setup();

get_header(); ?>

<main class="main page single<?php if (is_active_sidebar( 'post-sidebar' )) echo " __has-sidebar" ?>">

    <?php if (have_posts()): the_post(); ?>

    <article <?php post_class("single--article --article")?>>

        <header class="single--header --header">

            <?php if ( has_post_thumbnail() ): ?>

            <?php the_post_thumbnail('banner', ['alt'=>'', 'class' => 'page--header--background --header--background --background']) ?>

            <?php else: ?>

            <img src="<?= THEME_ASSETS_URI ?>/images/skyline.jpg" alt="" class="page--header--background --header--background --background">

            <?php endif; ?>

            <h1 class="single--headline --headline"><?php the_title() ?></h1>            

        </header>

        <div class="single--content --content">

            <?php the_content() ?>            

        </div>        

        <?php if ( is_active_sidebar( 'post-sidebar' ) ) : ?>

        <div class="single--sidebar --sidebar" role="complementary">

            <?php dynamic_sidebar( 'post-sidebar' ); ?>
            
        </div>

        <?php endif; ?>

    </article>

    <?php else: ?>

    <?php get_template_part("components/404") ?>

    <?php endif ?>

</main>

<?php get_footer() ?>
