<?php

/**
 * 
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_options_extra() {
    /*
     * ADDITIONAL FEATURE
     * **************************** */

    $groups['additional-feature'] = array(
        'icon' => '',
        'title' => __('Additional Features', kopa_get_domain()),
        'fields' => array()
    );

    $groups['additional-feature']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_use_custom_thumbnail',
        'name' => 'is_use_custom_thumbnail',
        'value' => 'false',
        'default' => 'false',
        'label' => __('Custom thumbnail for each post', kopa_get_domain()),
        'help' => __('By default, image will be auto crop. Enable this feature, you can manual upload image for each size.', kopa_get_domain()),
        'true' => __('Enable', kopa_get_domain()),
        'false' => __('Disable', kopa_get_domain()),
    );

    $groups['additional-feature']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_use_breadcrumb',
        'name' => 'is_use_breadcrumb',
        'value' => 'true',
        'default' => 'true',
        'label' => __('Breadcrumb', kopa_get_domain()),
        'help' => NULL,
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
    );

    $groups['additional-feature']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_use_mobile_detect',
        'name' => 'is_use_mobile_detect',
        'value' => 'true',
        'default' => 'true',
        'label' => __('Optimize for mobile (tablet)', kopa_get_domain()),
        'help' => __('Auto detect device - mobile (tablet) - and convert image size to small. The load time of page is faster.', kopa_get_domain()),
        'true' => __('Yes', kopa_get_domain()),
        'false' => __('No', kopa_get_domain()),
    );


    /*
     * LIGHTBOX SHORTCODE
     * **************************** */

    $groups['lightbox'] = array(
        'icon' => '',
        'title' => __('Lightbox (Pretty Photo)', kopa_get_domain()),
        'fields' => array()
    );

    $groups['lightbox']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_play_video_on_lightbox',
        'name' => 'is_play_video_on_lightbox',
        'label' => __('Play video, gallery, audio on lighbox', kopa_get_domain()),
        'help' => NULL,
        'default' => 'true',
        'true' => __('Yes', kopa_get_domain()),
        'false' => __('No', kopa_get_domain()),
    );

    $groups['lightbox']['fields'][] = array(
        'type' => 'select',
        'id' => 'lightbox_skin',
        'name' => 'lightbox_skin',
        'label' => __('Skin', kopa_get_domain()),
        'help' => NULL,
        'default' => 'pp_default',
        'options' => array(
            'pp_default' => __('Default', kopa_get_domain()),
            'facebook' => __('Facebook', kopa_get_domain()),
            'dark_rounded' => __('Dark rounded', kopa_get_domain()),
            'dark_square' => __('Dark square', kopa_get_domain()),
            'light_rounded' => __('Light rounded', kopa_get_domain()),
            'light_square' => __('Light square', kopa_get_domain()),
        )
    );

    $groups['lightbox']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_lightbox_modal_mode',
        'name' => 'is_lightbox_modal_mode',
        'label' => __('Modal mode', kopa_get_domain()),
        'help' => __('If set to Yes, only the close button will close the window', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Enable', kopa_get_domain()),
        'false' => __('Disable', kopa_get_domain()),
    );

    $groups['lightbox']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_lightbox_show_title',
        'name' => 'is_lightbox_show_title',
        'label' => __('Title', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
    );

    $groups['lightbox']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_lightbox_social_tools',
        'name' => 'is_lightbox_social_tools',
        'label' => __('Sharing with Facebook, Twitter', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
    );

    $groups['lightbox']['fields'][] = array(
        'type' => 'select-number',
        'id' => 'lightbox_opacity',
        'name' => 'lightbox_opacity',
        'label' => __('Overlay Opacity', kopa_get_domain()),
        'help' => __('Value between 0% and 100%', kopa_get_domain()),
        'default' => 70,
        'min' => 0,
        'max' => 100,
        'step' => 5,
        'suffix' => '%'
    );

    /*
     * YOUTUBE SHORTCODE
     * **************************** */

    $groups['youtube'] = array(
        'icon' => '',
        'title' => __('Youtube (shortcode)', kopa_get_domain()),
        'fields' => array()
    );

    $groups['youtube']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_youtube_showinfo',
        'name' => 'is_youtube_showinfo',
        'label' => __('Video information', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
        'help' => __('If you set the parameter value to <code>Hide</code>, then the player will not display information like the video title and uploader before the video starts playing.', kopa_get_domain())
    );

    $groups['youtube']['fields'][] = array(
        'type' => 'select',
        'id' => 'youtube_theme',
        'name' => 'youtube_theme',
        'label' => __('Theme', kopa_get_domain()),
        'help' => NULL,
        'default' => 'light',
        'options' => array(
            'dark ' => __('The Dark', kopa_get_domain()),
            'light' => __('The Light', kopa_get_domain()),
        )
    );

    $groups['youtube']['fields'][] = array(
        'type' => 'select',
        'id' => 'youtube_controls',
        'name' => 'youtube_controls',
        'label' => __('Coltrols', kopa_get_domain()),
        'help' => NULL,
        'default' => 2,
        'options' => array(
            0 => __('Player controls DO NOT display in the player.', kopa_get_domain()),
            1 => __('Player controls display in the player', kopa_get_domain()),
            2 => __('Player controls ONLY display in the player (after the user initiates the video playback)', kopa_get_domain()),
        )
    );

    $groups['youtube']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_youtube_hd_enable',
        'name' => 'is_youtube_hd_enable',
        'label' => __('HD playback by default', kopa_get_domain()),
        'default' => 'false',
        'true' => __('Enable', kopa_get_domain()),
        'false' => __('Disable', kopa_get_domain()),
        'help' => __('This has no effect on the Chromeless Player.<br/> This also has no effect if an HD version of the video is not available.', kopa_get_domain())
    );

    $groups['youtube']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_youtube_rel_enable',
        'name' => 'is_youtube_rel_enable',
        'label' => __('Related videos', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
        'help' => __('This option indicates whether the player should show related videos when playback of the initial video ends', kopa_get_domain())
    );

    /*
     * VIMEO SHORTCODE
     * **************************** */

    $groups['vimeo'] = array(
        'icon' => '',
        'title' => __('Vimeo (shortcode)', kopa_get_domain()),
        'fields' => array()
    );

    $groups['vimeo']['fields'][] = array(
        'type' => 'color',
        'id' => 'vimeo_color',
        'name' => 'vimeo_color',
        'label' => __('Color', kopa_get_domain()),
        'help' => 'Specify the color of the video controls',
        'default' => '#00adef'
    );

    $groups['vimeo']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_show_vimeo_title',
        'name' => 'is_show_vimeo_title',
        'label' => __('Title', kopa_get_domain()),
        'default' => 'false',
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
        'help' => __('Show the title on the video', kopa_get_domain())
    );

    $groups['vimeo']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_show_vimeo_byline',
        'name' => 'is_show_vimeo_byline',
        'label' => __('Byline', kopa_get_domain()),
        'default' => 'false',
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
        'help' => __("Show the user's byline on the video", kopa_get_domain())
    );

    $groups['vimeo']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'is_show_vimeo_portrait',
        'name' => 'is_show_vimeo_portrait',
        'label' => __('Portrait', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Show', kopa_get_domain()),
        'false' => __('Hide', kopa_get_domain()),
        'help' => __("Show the user's portrait on the video", kopa_get_domain())
    );

    /*
     * GALLERY SHORTCODE (ON SINGLE POST)
     * **************************** */

    $groups['gallery'] = array(
        'icon' => '',
        'title' => __('Gallery (shortcode - on single post)', kopa_get_domain()),
        'fields' => array()
    );

    $groups['gallery']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'gallery_allowfullscreen',
        'name' => 'gallery_allowfullscreen',
        'label' => __('Allow full screen', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Yes', kopa_get_domain()),
        'false' => __('No', kopa_get_domain()),
        'help' => __("This will show an icon at the top-right that toggles the fullscreen", kopa_get_domain())
    );

    $groups['gallery']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'gallery_keyboard',
        'name' => 'gallery_keyboard',
        'label' => __('Keyboard navigation', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Enable', kopa_get_domain()),
        'false' => __('Disable', kopa_get_domain()),
        'help' => __("Turn on keyboard navigation with the arrows", kopa_get_domain())
    );

    $groups['gallery']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'gallery_arrows',
        'name' => 'gallery_arrows',
        'label' => __('Arrows', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Enable', kopa_get_domain()),
        'false' => __('Disable', kopa_get_domain()),
        'help' => __("Turn on keyboard navigation with the arrows", kopa_get_domain())
    );

    $groups['gallery']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'gallery_click',
        'name' => 'gallery_click',
        'label' => __('Click to change', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Enable', kopa_get_domain()),
        'false' => __('Disable', kopa_get_domain()),
        'help' => NULL
    );

    $groups['gallery']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'gallery_swipe',
        'name' => 'gallery_swipe',
        'label' => __('Swipe to change', kopa_get_domain()),
        'default' => 'true',
        'true' => __('Enable', kopa_get_domain()),
        'false' => __('Disable', kopa_get_domain()),
        'help' => NULL
    );

    $groups['gallery']['fields'][] = array(
        'type' => 'radio-truefalse',
        'id' => 'gallery_navposition',
        'name' => 'gallery_navposition',
        'label' => __('Navigation position', kopa_get_domain()),
        'default' => 'false',
        'true' => __('Top', kopa_get_domain()),
        'false' => __('Bottom', kopa_get_domain()),
        'help' => NULL
    );

    return apply_filters('kopa_options_extra', $groups);
}

