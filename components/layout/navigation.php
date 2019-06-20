<?php

/**
 * this theme uses the Customizer for selecting a logo
 * to adjust, log in as admin, click 'Customize' in the admin bar
 */

$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image( $custom_logo_id , 'full' );

?>

<header class="header-navigation <?= $image ? "__has-logo" : "__no-logo" ?>">

    <nav aria-label="<?=esc_attr(get_bloginfo('title'))?>" class="header-navigation--nav --nav">

        <figure class="header-navigation--logo --logo">

            <a href="<?= esc_url(get_bloginfo('url')) ?>"><?php

            echo $image;
            
            ?></a>

            <figcaption><a href="<?= esc_url(get_bloginfo('url')) ?>"><?php bloginfo('title') ?></a></figcaption>

        </figure>        

        <div tabindex="-1" class="header-navigation--menu --menu" aria-hidden="true" id="website-navigation">

            <button class="btn header-navigation--btn" aria-expanded="false" aria-controls="website-navigation">
            
                <span class="__show-when-hidden">MENU</span>

                <span class="header-navigation--btn--icon --icon __show-when-hidden"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 17" preserveAspectRatio="xMidYMid meet"><path fill-rule="evenodd" d="M0.005,17.002 L0.005,14.003 L48.011,14.003 L48.011,17.002 L0.005,17.002 ZM0.005,7.003 L48.011,7.003 L48.011,10.002 L0.005,10.002 L0.005,7.003 ZM0.005,0.007 L48.011,0.007 L48.011,3.005 L0.005,3.005 L0.005,0.007 Z"/></svg></span>

                <span class="header-navigation--btn--icon --icon __show-when-expanded"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" preserveAspectRatio="xMidYMid meet"><path d="M4.471 12.471l3.529-3.529 3.529 3.529 0.943-0.943-3.529-3.529 3.529-3.529-0.943-0.943-3.529 3.529-3.529-3.529-0.943 0.943 3.529 3.529-3.529 3.529z"></path></svg></span>

            </button>

            <?php  
            
            wp_nav_menu(apply_filters("Theme/primary_nav_args", [
                'theme_location'    => 'primary', 
                'items_wrap'        => '<ul role="menubar" class="%2$s">%3$s</ul>',
                'container'         => '',
                'menu_class'        => 'menu header-navigation--list --list',
                'walker'            => new Oneupweb\A11y_Navwalker(),
                'depth'             => 2
            ]));

            ?>

        </div>

    </nav>

</header>