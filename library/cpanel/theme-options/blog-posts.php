<?php
/**
 * 
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_options_blog_posts() {
    $groups['archive'] = array(
        'icon' => '',
        'title' => __('Blog post', kopa_get_domain()),
        'fields' => array()
    );

    $groups['archive']['fields'][] = array(
        'type' => 'radio-list',
        'id' => 'exceprt_type',
        'name' => 'exceprt_type',
        'label' => __('For each article in list, show', kopa_get_domain()),
        'default' => 'limit',
        'help' => '',
        'options' => array(
            array(
                'value' => 'excerpt',
                'label' => __('Excerpt', kopa_get_domain()),
            ),
            array(
                'value' => 'full',
                'label' => __('Full content', kopa_get_domain()),
            ),
            array(
                'value' => 'limit',
                'label' => __('Limit number characters', kopa_get_domain()),
                'sub_fields' => array(
                    array(
                        'type' => 'number',
                        'id' => 'excerpt_limit',
                        'name' => 'excerpt_limit',
                        'default' => 200,
                        'value' => KopaOptions::get_option('excerpt_limit', 100)
                    )
                )
            )
        ),
        'option_args' => array(
            'wrap_begin' => '<div class="row cleafix"><div class="col-xs-12">',
            'wrap_end' => '</div></div>',
            'label_begin' => '',
            'label_end' => '',
            'control_begin' => '',
            'control_end' => '',
        )
    );

    $groups['archive']['fields'][] = array(
        'type' => 'radio-list',
        'id' => 'blog_thumbnail',
        'name' => 'blog_thumbnail',
        'value' => 'left',
        'default' => 'left',
        'label' => __('Blog thumbnail', kopa_get_domain()),
        'options' => array(
            array(
                'value' => 'none',
                'label' => sprintf('<img src="%s">', get_template_directory_uri() . '/library/images/thumbs/none.png'),
                'is_append_label_before_control' => true,
                'wrap_begin' => '<div class="blog-thumbnai-style col-sm-6 col-md-3 col-xs-6"><div class="blog-position-outer blog-position-left">',
                'wrap_end' => '</div></div>',
            ),
            array(
                'value' => 'left',
                'label' => sprintf('<img src="%s">', get_template_directory_uri() . '/library/images/thumbs/left.png'),
                'is_append_label_before_control' => true,
                'wrap_begin' => '<div class="blog-thumbnai-style col-sm-6 col-md-3 col-xs-6"><div class="blog-position-outer blog-position-left">',
                'wrap_end' => '</div></div>',
            ),
            array(
                'value' => 'right',
                'label' => sprintf('<img src="%s">', get_template_directory_uri() . '/library/images/thumbs/right.png'),
                'is_append_label_before_control' => true,
                'wrap_begin' => '<div class="blog-thumbnai-style col-sm-6 col-md-3 col-xs-6"><div class="blog-position-outer blog-position-right">',
                'wrap_end' => '</div></div>',
            ),
            array(
                'value' => 'zebra',
                'label' => sprintf('<img src="%s">', get_template_directory_uri() . '/library/images/thumbs/zebra.png'),
                'is_append_label_before_control' => true,
                'wrap_begin' => '<div class="blog-thumbnai-style col-sm-6 col-md-3 col-xs-6"><div class="blog-position-outer blog-position-zebra">',
                'wrap_end' => '</div></div>',
            )
        ),
        'option_args' => array(
            'label_begin' => '',
            'label_end' => '',
            'control_begin' => '',
            'control_end' => '',
        ),
        'control_begin' => '<div class="col-xs-9"><div class="row_space15 row cleafix">',
        'control_end' => '</div></div>',
    );
    
    $groups['archive']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_display_blog_post_format',
        'name' => 'is_display_blog_post_format',
        'value' => 'false',
        'default' => 'false',
        'label' => __('Display content formatted', kopa_get_domain()),
        'help_classes' => '',
        'help' => __('If value is <code>Yes</code>, thumbnails has been replaced by video, audio or gallery shortcode', kopa_get_domain()),
        'true' => __('Yes', kopa_get_domain()),
        'false' => __('No', kopa_get_domain()),
    );

    $groups['archive']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_display_created_date',
        'name' => 'is_display_created_date',
        'value' => 'true',
        'default' => 'true',
        'label' => __('Created Date', kopa_get_domain()),
        'help_classes' => array(),
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
    );

    $groups['archive']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_display_comments',
        'name' => 'is_display_comments',
        'value' => 'true',
        'default' => 'true',
        'label' => __('Comment count', kopa_get_domain()),
        'help_classes' => array(),
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
    );

    $groups['archive']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_display_views',
        'name' => 'is_display_views',
        'value' => 'true',
        'default' => 'true',
        'label' => __('View count', kopa_get_domain()),
        'help_classes' => array(),
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
    );


    return apply_filters('kopa_options_blog_posts', $groups);
}