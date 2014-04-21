<?php

add_shortcode('caption', 'kopa_shortcode_caption');

/**
 * 
 *
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_shortcode_caption($atts, $content = null) {
    $html = NULL;

    if (!empty($content)) {
        $html = sprintf('<h6 class="elements-title">%s</h6>', $content);
    }

    return apply_filters('kopa_shortcode_heading', force_balance_tags($html));
}
