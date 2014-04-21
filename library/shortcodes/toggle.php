<?php

add_shortcode('toggles', 'kopa_shortcode_toggles');
add_shortcode('toggle', 'kopa_shortcode_toggle');

/**
 * 
 *
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_shortcode_toggles($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));

    $items = KopaUtil::get_shortcode($content, true, array('toggle'));
    $panels = array();
    $toggles_id = 'toggle_' . wp_generate_password(4, false, false);

    if ($items) {
        $prefix = $toggles_id . '_';
        $collapse = 'in';
        $active = 'active';
        foreach ($items as $item) {
            $title = $item['atts']['title'];
            $item_id = $prefix . wp_generate_password(4, false, false) . '_' . KopaUtil::str_uglify($title);

            $tmp = '<div class="panel panel-default">';
            $tmp .= sprintf('<div class="panel-heading %s">', $active);
            $tmp .= '<p class="panel-title">';
            $tmp .= sprintf('<a data-toggle="collapse" href="#%s"><span class="kp-acc-title">%s</span><span class="kopa-collapse">%s</span></a>', $item_id, $title, empty($active) ? '+' : '-');
            $tmp .= '</p>';
            $tmp .= '</div>';
            $tmp .= sprintf('<div id="%1$s" class="panel-collapse collapse %2$s">', $item_id, $collapse);
            $tmp .= '<div class="panel-body">';
            $tmp .= do_shortcode($item['content']);
            $tmp .= '</div>';
            $tmp .= '</div>';
            $tmp .= '</div>';

            $collapse = '';
            $active = '';
            $panels[] = $tmp;
        }
    }
    $output = sprintf('<div id="%1$s" class="kopa-toggle panel-group">', $toggles_id);
    $output.= implode('', $panels);
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
function kopa_shortcode_toggle() {
    return false;
}