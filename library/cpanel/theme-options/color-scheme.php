<?php
/**
 * 
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_options_color_scheme() {
    $groups['main-color'] = array(
        'icon' => '',
        'title' => __('Pre defined colors', kopa_get_domain()),
        'fields' => array()
    );

    $groups['main-color']['fields'][] = array(
        'type' => 'color-swatches-single',
        'id' => 'colors',
        'name' => 'colors',
        'label' => NULL,
        'help' => '',
        'default' => '#222222',
        'control_begin' => '<div class="col-xs-12">',
        'control_end' => '</div>',
        'colors' => array(
            array(
                'primary' => '#222222',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#2c3e50',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#406589',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#3156a3',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#16a085',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#15caa6',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#8A9B0F',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#E97F02',
                'label' => NULL,
                'classes' => array()
            ),                       
            array(
                'primary' => '#C02942',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#ed1c24',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => '#542437',
                'label' => NULL,
                'classes' => array()
            ),
            array(
                'primary' => 'customize',
                'label' => '<i class="dashicons dashicons-plus"></i>',
                'classes' => array('color-swatches-single-custom')
            ),
        )
    );

    /**
     * CUSTOM COLORS
     */
    $groups['custom-color'] = array(
        'icon' => '',
        'title' => __('Custom colors', kopa_get_domain()),
        'fields' => array()
    );
    $groups['custom-color']['fields'][] = array(
        'type' => 'color',
        'id' => 'primary_color',
        'name' => 'primary_color',
        'label' => __('Primary color', kopa_get_domain()),
        'help' => '',
        'default' => '#222222',
        'classes' => array('mc-primary')
    );

    $groups['custom-color']['fields'][] = array(
        'type' => 'color',
        'id' => 'link_color',
        'name' => 'link_color',
        'label' => __('Link color', kopa_get_domain()),
        'help' => __("It's color of tag <code>a</code>", kopa_get_domain()),
        'default' => '#222222',
        'classes' => array('mc-primary')
    );

    $groups['custom-color']['fields'][] = array(
        'type' => 'color',
        'id' => 'link_color_hover',
        'name' => 'link_color_hover',
        'label' => __('Link color hover', kopa_get_domain()),
        'help' => __("It's color of tag <code>a:hover</code>", kopa_get_domain()),
        'default' => '#ed1c24',
        'classes' => array('mc-secondary')
    );

    $groups['custom-color']['fields'][] = array(
        'type' => 'color',
        'id' => 'text_color',
        'name' => 'text_color',
        'label' => __('Text color', kopa_get_domain()),
        'help' => __("It's color of body, post content, widget content, ...", kopa_get_domain()),
        'default' => '#666666'
    );
    $groups['custom-color']['fields'][] = array(
        'type' => 'color',
        'id' => 'heading_color',
        'name' => 'heading_color',
        'label' => __('Heading color', kopa_get_domain()),
        'help' => __("It's color of tag <code>h1</code> <code>h2</code> <code>h3</code> <code>h4</code> <code>h5</code> <code>h6</code>", kopa_get_domain()),
        'default' => '#222222'
    );

    $groups['custom-color']['fields'][] = array(
        'type' => 'color',
        'id' => 'nav_link_color',
        'name' => 'nav_link_color',
        'label' => __('Menu item link color', kopa_get_domain()),
        'help' => '',
        'default' => '#222222'
    );
    $groups['custom-color']['fields'][] = array(
        'type' => 'color',
        'id' => 'nav_link_hover_color',
        'name' => 'nav_link_hover_color',
        'label' => __('Menu item link color hover (active)', kopa_get_domain()),
        'help' => '',
        'default' => '#ed1c24'
    );
    $groups['custom-color']['fields'][] = array(
        'type' => 'color',
        'id' => 'icon_color',
        'name' => 'icon_color',
        'label' => __('Icon color', kopa_get_domain()),
        'help' => __("It's color of icon-comment, icon-view, icon-readmore,...", kopa_get_domain()),
        'default' => '#6A6A6A'
    );
    return apply_filters('kopa_options_styling', $groups);
}