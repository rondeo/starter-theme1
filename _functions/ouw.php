<?php

namespace Oneupweb;

if (!defined('ABSPATH'))
    return;

function autoload_folder($dir)
{
    $contained = scandir($dir);

    foreach($contained as $file)
    {
        if (substr($file,0,1) === '.')
            continue;

        if (is_dir($dir . '/' . $file) && is_file("$dir/$file/$file.php"))
        {
            include_once "$dir/$file/$file.php";
            continue;
        }

        if (!is_file($dir . '/' . $file))
            continue;

        if (pathinfo($dir . '/' . $file, PATHINFO_EXTENSION) != 'php')
            continue;

        include_once $dir . '/' . $file;
    }
}

function enqueue_asset($what, $file, $footer=true, $requires=array()) 
{
    enqueue_assets([$what], $file, $footer, $requires);
}

function enqueue_assets($what, $files, $footer=true, $requires=array()) 
{
    
    add_action("wp_enqueue_scripts", function() use ($what, $files, $footer, $requires) 
    {

        $prefix = defined('THEME_NAME') ? THEME_NAME : '';               
        
        if ($what === "style") 
        {
            foreach($files as $file) 
            {
                $baseurl = in_array(substr($file, 0, 2), ["ht", "//"]) ? "" : THEME_ASSETS_URI;
                $name = $prefix . sanitize_title($file);
                $filename = basename($file);

                wp_enqueue_style($name, $baseurl . $file, $requires, THEME_VERSION);
            }
        } 
        else if ($what === "script") 
        {
            foreach($files as $file) 
            {
                $name = $prefix . sanitize_title($file);
                $baseurl = in_array(substr($file, 0, 2), ["ht", "//"]) ? "" : THEME_ASSETS_URI;
                $filename = basename($file);

                wp_localize_script($name, THEME_DOMAIN, [
                    'assetsUri' => THEME_ASSETS_URI,
                    'mobileWidth' => MOBILE_SIZE
                ]);
                wp_enqueue_script($name, $baseurl . $file, $requires, THEME_VERSION, $footer);
            }
        }

    }, 11);
    
}

function enqueue_registered($what, $name)
{

    add_action("wp_enqueue_scripts", function() use ($what, $name)
    {

        if ($what === "style")
            wp_enqueue_style($name);

        else if ($what === "script")
            wp_enqueue_script($name);

    }, 99);

}

function rest_response($data, $status=null, $location=null)
{

    if (is_string($data))
        $data = array("message" => $data);
    else if (isset($data["message"]))
        $data["message"] = $data["message"];

    if (isset($data["status_code"]) || !is_null($status))
    {
        $status_code = !is_null($status) ? $status : $data["status_code"];
        if (empty($data["status"]))
        {
            if ($status_code >= 100 && $status_code <= 199)
                $data["status"] = "information";
            else if ($status_code >= 200 && $status_code <= 299)
                $data["status"] = "success";
            else if ($status_code >= 300 && $status_code <= 399)
                $data["status"] = "warning";
            else if ($status_code >= 400)
                $data["status"] = "danger";
        }
    }
    $response = new \WP_REST_Response($data);
    if (isset($status_code))
        $response->set_status($status_code);


    if (isset($data["redirect"]) || !is_null($location))
        $response->header('Location', $location ?: $data["redirect"]);

    return $response;

}

function string_to_array($string)
{
    $array = array();

    $attributes = explode(" ", $string);
    foreach($attributes as $attr)
    {
        $sides = explode("=", $attr, 2);
        if (count($sides) === 1)
        {
            $array[$sides[0]] = '"' . $sides[0] . '"';
        }
        else
        {
            $right = trim($sides[1], '"\'');
            $array[$sides[0]] = $right;
        }
    }

    return $array;
}


function expand_html_attrs($attrs=array())
{
    $attributes = "";
    foreach($attrs as $key => $value)
        $attributes .= sprintf(' %s="%s" ', \sanitize_title($key), \esc_attr($value));
    $attributes = trim($attributes);

    return $attributes;
}

function get_related_posts($max_posts = 5, $post=null) {

    if (empty($post)) {
        global $post;        
    }
    if (is_object($post)) {
        $post_id = $post->ID;
    }
    if (is_numeric($post)) {
        $post_id = $post;
    }
    if (empty($post_id))
        return [];

    //$thispost = get_post($post_id);
    $tags = wp_get_post_tags($post_id, array(
            'fields' => 'ids'
        ));

    $posts = get_posts(array(
            //"orderby"=>"rand",
            "posts_per_page" => $max_posts,
            "tag__in" => $tags,
            "post__not_in" => array($post_id)
        ));

    return $posts;

}

function social_icons_template($classes='', $networks=['facebook', 'twitter', 'google', 'linkedin', 'email']) {

    $title = esc_attr(get_the_title());
    $url = esc_url(get_permalink());

    ?>

    <ul class="social-sharing <?=$classes?>">

    <?php if (in_array('facebook', $networks)): ?>

        <li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?=$url?>&quote=" target="_blank" title="Share on Facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('<?=$url?>') + '&quote=' + encodeURIComponent('<?=$title?>')); return false;"><?=use_icon('facebook-share-icon')?></a></li>

    <?php endif; if (in_array('twitter', $networks)): ?>

        <li class="twitter"><a href="https://twitter.com/intent/tweet?source=<?=$url?>&text=<?=$title?>" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent('<?=$title?>') + ':%20'  + encodeURIComponent('<?=$url?>')); return false;"><?=use_icon('twitter-share-icon')?></a></li>

    <?php endif; if (in_array('linkedin', $networks)): ?>

        <li class="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?=$url?>&title=<?=$title?>&summary=&source=<?=$url?>" target="_blank" title="Share on LinkedIn" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent('<?=$url?>') + '&title=' +  encodeURIComponent('<?=$title?>')); return false;"><?=use_icon('linkedin-share-icon')?></a></li>

    <?php endif; if (in_array('email', $networks)): ?>

        <li class="email"><a href="mailto:?subject=<?=rawurlencode(html_entity_decode(get_the_title(), ENT_QUOTES))?>&body=<?=rawurlencode("Check out this article I read on " . get_bloginfo('title') . ", " . get_permalink())?>" title="Share by Email"><?=use_icon('email-share-icon')?></a></li>

    <?php endif; ?>

    </ul>

    <?php

}


function icon_url($id, $iconset=null)
{
    if (is_null($iconset))
        $iconset = 'general';
    
    $icon_url = THEME_ASSETS_URI . 'images/' . ($iconset == 'general' ? 'icons' : $iconset) . '.svg';

    $icon_url .= "?v=" . THEME_VERSION;

    return $icon_url . "#icon--{$iconset}__$id";
}

function use_icon($id, $iconset=null)
{
    if (is_null($iconset))
        $iconset = 'general';

    $icon_url = icon_url($id, $iconset);

    $class = apply_filters('OSP/icon_classes', "icon --$iconset __$id");

    $code = sprintf('<svg class="%2$s"><use xlink:href="%1$s"></use></svg>',
        $icon_url,
        $class
    );

    return $code;
}

function inline_icon($filename)
{
    if (file_exists(THEME_ASSETS_DIR . '/icons/' . $filename . '.svg'))
        $path = THEME_ASSETS_DIR . '/icons/';
    else
        return '';
  

    return file_get_contents($path . $filename . '.svg');
}
