<?php

if (isset($_GET["amp"])) 
{
    include "single.amp.php";
    exit;
}

//Oneupweb\AMPenburg::enable();
//Oneupweb\Schema::setup();

$s = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);

get_header(); ?>

<main class="main archive search<?php if (is_active_sidebar( 'post-sidebar' )) echo " __has-sidebar" ?>">

    <header class="search--header archive--header --header">

        <img src="<?= THEME_ASSETS_URI ?>/images/skyline.jpg" alt="" class="page--header--background --header--background --background">

        <h1 class="archive--headline --headline">Search Results</h1>            

    </header>

    <div class="search--loop archive--loop --loop">

        <h2>Results for '<?= $s ?>'</h2>

        <?php if (have_posts()): while(have_posts()): the_post() ?>

        <?php get_template_part('components/post/loop', get_post_type()) ?>

        <?php endwhile; else: ?>

        <div class="search--result --result __no-results">

            <h3>Nothing matching your search could be found.</h3>

        </div>

        <?php endif ?>

        <div class="search--pagination archive--pagination --pagination">

        <?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>

        </div>

        <div class="search--result --result __something-else">

            <p>Looking for something else? <a target="_blank" href="https://www.downtowntc.com/index.php/search?query=<?=urlencode($s)?>">Try searching DowntownTC.com!</a></p>

        </div>        

    </div>        

    <?php if ( is_active_sidebar( 'post-sidebar' ) ) : ?>

    <div class="search--sidebar archive--sidebar --sidebar" role="complementary">

        <?php dynamic_sidebar( 'post-sidebar' ); ?>
        
    </div>

    <?php endif; ?>

</main>

<?php get_footer() ?>