<?php

namespace Oneupweb;

function add_nojs_class($classes) {
    $classes .= " no-js";
    return trim($classes);
}
add_filter('Theme/body_classes', 'Oneupweb\add_nojs_class');

function swap_nojs_class_script() { ?>
    
    <script>

        document.body.classList.remove("no-js");
        document.body.classList.add("js");        

    </script>

<?php }
add_action('Theme/open_body', 'Oneupweb\swap_nojs_class_script');