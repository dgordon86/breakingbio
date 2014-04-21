<?php

add_action('widgets_init', 'kopa_widgets_init');

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_widgets_init() {
    $widgets = array(
        'KopaPostsListAlpha',
        'KopaPostsListBeta',
        'KopaMediaCenter',
        'KopaNewsletter',
        'KopaQuickViews',
        'KopaPostsListFlexSlider',
        'KopaSocialLinks',
        'KopaFlickr'
    );

    $widgets = apply_filters('kopa_widgets', $widgets);

    if (!empty($widgets)) {
        foreach ($widgets as $widget) {
            register_widget($widget);
        }
    }
}