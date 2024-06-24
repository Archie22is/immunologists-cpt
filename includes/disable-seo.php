<?php
/**
 * Disable All in One SEO (AIOSEO) on the specific custom post type (Immunologists)
 * @author Archie M
 * 
 */

function disable_aioseo_on_immunologist_post_type($disable, $post_type) {

    if ($post_type === 'immunologist') {
        return true; // Disable AIOSEO on this custom post type
    }
    return $disable;

}
add_filter('aioseo_disable', 'disable_aioseo_on_immunologist_post_type', 10, 2);
 