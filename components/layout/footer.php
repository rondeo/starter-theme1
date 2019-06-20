<footer class="footer">

    <div class="footer--inside">

        <?php if (class_exists('Oneupweb\Snippets')): ?>

            <div class="footer--copy">

            <?= Oneupweb\Snippets::get_content('footer-text') ?>

            </div>

        <?php endif; ?>
	
        <nav class="footer--menu">
	
	<?php 
	
            wp_nav_menu([
                'theme_location' => 'footer', 
                'container' => '',
                'menu_class' => 'footer--menu',
                'depth' => 1                    
            ]);
    
        ?>        

    </div>

</footer>