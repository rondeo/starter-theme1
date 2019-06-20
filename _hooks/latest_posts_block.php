<?php

namespace Oneupweb;

add_action("wp_loaded", function () 
{
    if (is_admin())
        return;

    $registry = \WP_Block_Type_Registry::get_instance();

    $lp = $registry->get_registered('core/latest-posts');

    $registry->unregister('core/latest-posts');

    $lp->render_callback = function ($attributes) {        
        return latest_post_block($attributes);
    };

    $registry->register($lp);

}, 20);

function latest_post_block($attributes)
{
    global $post;

    $query_settings = array(
		'numberposts'   => (int) ($attributes['postsToShow'] ?: 5),
		'post_status'   => 'publish',
		'order'         => $attributes['order'] ?: 'DESC',
		'orderby'       => $attributes['orderBy'] ?: 'post_date',
        'category'      => $attributes['categories'] ?? [],
        'post_type'     => 'post'
    );

    $query_settings = apply_filters("Theme/latest_posts_block/query", $query_settings, $attributes);
    
    $recent_posts = get_posts( $query_settings );
    
    $list_items_markup = '';
    
    $template_part = apply_filters("Theme/latest_post_block/template_part", "components/post/excerpt", $attributes);

    foreach ($recent_posts as $post) 
    {
        setup_postdata($post);

        ob_start();

        get_template_part($template_part);

        $new_part = ob_get_clean();

        $list_items_markup .= apply_filters("Theme/latest_post_block/post_part", $new_part, $post, $attributes);
    }
    wp_reset_postdata();

	$class = "wp-block-latest-posts post-loop align{$attributes['align']} __$type";
	if ( isset( $attributes['postLayout'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' is-grid';
	}
	if ( isset( $attributes['columns'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' columns-' . $attributes['columns'];
    }    
	if ( isset( $attributes['className'] ) ) {
		$class .= ' ' . $attributes['className'];
    }
    
    $block_content = apply_filters("Theme/latest_post_block/block_content", $list_items_markup, $attributes);
    $block_classes = apply_filters("Theme/latest_post_block/block_classes", $class, $attributes);
    $block_wrapper = apply_filters("Theme/latest_post_block/block_wrapper", '<div class="%2$s">%1$s</div>', $attributes);
    
    $block = sprintf(
		$block_wrapper,		
        $block_content,
        esc_attr( $block_classes )
    );

    $block_wrapper = apply_filters("Theme/latest_post_block", $block, $attributes);   

    return $block;

}
