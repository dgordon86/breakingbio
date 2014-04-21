<?php

add_shortcode('tabs', 'kopa_shortcode_tabs');
add_shortcode('tab', 'kopa_shortcode_tab');

/**
 * 
 *
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_shortcode_tabs($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));

    $items = KopaUtil::get_shortcode($content, true, array('tab'));
    $navs = array();
    $panels = array();

    if ($items) {
        $prefix = 'tab_' . wp_generate_password(4, false, false) . '_';
        $active = 'active';
        foreach ($items as $item) {
            $title = $item['atts']['title'];
            $item_id = $prefix . wp_generate_password(4, false, false) . '_' . KopaUtil::str_uglify($title);

            $navs[] = sprintf('<li class="%3$s"><a href="#%1$s" data-toggle="tab">%2$s</a></li>', $item_id, $title, $active);
            $panels[] = sprintf('<div class="tab-pane fade in %3$s" id="%1$s">%2$s</div>', $item_id, do_shortcode($item['content']), $active);

            $active = '';
        }
    }
    $output = '<div class="kopa-tabs clearfix">';
    $output.= '<ul class="nav nav-tabs clearfix">';
    $output.= implode('', $navs);
    $output.= '</ul>';
    $output.= '<div class="tab-content clearfix">';
    $output.= implode('', $panels);
    $output.= '</div>';
    $output.= '</div>';

    return apply_filters('kopa_shortcode_tabs', $output);
}

/**
 * 
 *
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_shortcode_tab() {
    return false;
}