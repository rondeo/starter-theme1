<?php get_header(); ?>

<main class="main page">

    <?php if (have_posts()): the_post(); ?>

    <article <?php post_class("page--article --article")?>>

        <header class="page--header --header">

            <?php if ( has_post_thumbnail() ): ?>

            <?php the_post_thumbnail('banner', ['alt'=>'', 'class' => 'page--header--background --header--background --background']) ?>

            <?php else: ?>

            <img src="<?= THEME_ASSETS_URI ?>/images/skyline.jpg" alt="" class="page--header--background --header--background --background">

            <?php endif; ?>

            <h1 class="page--headline --headline"><?php the_title() ?></h1>

        </header>

        <div class="page--content --content">

            <?php the_content() ?>

        </div>        

        <?php do_action("Template/page/after_content") ?>
        
    </article>

    <?php else: ?>

    <?php get_template_part("components/404") ?>

    <?php endif ?>

</main>

<?php get_footer() ?>