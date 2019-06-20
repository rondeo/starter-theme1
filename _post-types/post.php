<?php

namespace Oneupweb;

global $osp_posts_seen;

add_action("init", function () 
{
	register_meta( 'post', '_alt-author', [
        'single' => true,
        'show_in_rest' => true,
        'description'  => 'Alternate Author Attribution',
        'type' => 'integer'		
	]);
	

});

add_action('add_meta_boxes', function () 
{
	add_meta_box( 
		'post_settings', 
		'Content Settings', 
		'Oneupweb\render_post_settings_metabox',
		'post', 
		'side' 
	);
});


function render_post_settings_metabox($post) 
{ ?>

    <input type="hidden" name="_post_settings_nonce" value="<?=wp_create_nonce("post-settings")?>" />

	<div class="components-base-control">

		<div class="components-panel__row">
			<label for="alt-author-toggle-0">Author byline</label>
			<input class="components-text-control__input" type="text" name="_alt-author" id="alt-author-toggle-0" value="<?php
				echo esc_attr(get_post_meta($post->ID, "_alt-author", true)) ?>">
		</div>
		
	</div>


<?php }


function save_post_settings_meta($post_id) 
{

	if (!isset($_POST["_post_settings_nonce"]) || !wp_verify_nonce($_POST["_post_settings_nonce"], 'post-settings'))
		return;

	update_post_meta($post_id, "_alt-author", filter_input(INPUT_POST, "_alt-author", FILTER_SANITIZE_STRING));

}
add_action('save_post', 'Oneupweb\save_post_settings_meta');
