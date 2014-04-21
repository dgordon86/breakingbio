<?php

remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'kopa_shortcode_gallery');

/**
 * 
 *
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_shortcode_gallery($atts, $content = null) {
    extract(shortcode_atts(array("ids" => '', "display_type" => 0), $atts));
    $output = '';

    if (isset($atts['ids'])) {
        $ids = explode(',', $atts['ids']);
        if ($ids) {
            if ((is_single() || is_page()) && (!is_home() || !is_front_page())) {

                $opt = array();
                $opt['data-thumbborderwidth'] = 'data-thumbborderwidth=1';
                $opt['data-thumbheight'] = 'data-thumbheight=55';
                $opt['data-thumbwidth'] = 'data-thumbwidth=55';  
                $opt['data-thumbmargin'] = 'data-thumbmargin=1';                  
                $opt['data-nav'] = 'data-nav="thumbs"';
                $opt['data-width'] = 'data-width="100%"';
                $opt['data-ratio'] = 'data-ratio="705/430"';
                $opt['data-allowfullscreen'] = sprintf('data-allowfullscreen="%s"', KopaOptions::get_option('gallery_allowfullscreen', 'true'));
                $opt['data-keyboard'] = sprintf('data-keyboard="%s"', KopaOptions::get_option('gallery_keyboard', 'true'));
                $opt['data-navposition'] = sprintf('data-navposition="%s"', ('false' == KopaOptions::get_option('gallery_navposition', 'false')) ? 'bottom' : 'top');
                $opt['data-arrows'] = sprintf('data-arrows="%s"', KopaOptions::get_option('gallery_arrows', 'true'));
                $opt['data-click'] = sprintf('data-click="%s"', KopaOptions::get_option('gallery_click', 'true'));
                $opt['data-swipe'] = sprintf('data-swipe="%s"', KopaOptions::get_option('gallery_swipe', 'true'));

                $opt = apply_filters('kopa_get_gallery_shortcode_args', $opt);

                $output.= sprintf('<div class="fotorama" %1$s>', implode(' ', $opt));
                foreach ($ids as $id) {
                    $obj = get_post($id);
                    $caption = $obj->post_excerpt;

                    $image = wp_get_attachment_image_src($id, 'full');
                    $image_croped = KopaImage::get_image_src($image[0], 'size_01');
                    $image_full = KopaImage::get_image_src($image[0], 'size_05');
                    if ($caption) {
                        $output.= sprintf('<a href="%1$s" data-caption="%3$s"><img src="%2$s"/></a>', $image_full, $image_croped, $caption);
                    } else {
                        $output.= sprintf('<a href="%1$s"><img src="%2$s"/></a>', $image_full, $image_croped);
                    }

                    wp_reset_query();
                    wp_reset_postdata();
                }
                $output.= '</div>';
            } else {
                $output.= '<div class="flexslider kp-single-slider"><ul class="slides">';
                $image_size = 'size_05';

                if (is_archive()) {
                    $image_size = 'size_02';
                }

                foreach ($ids as $id) {
                    $image = wp_get_attachment_image_src($id, 'full');
                    $image_croped = KopaImage::get_image_src($image[0], $image_size);
                    $output.= sprintf('<li><img src="%s" alt=""/></li >', $image_croped);
                }
                $output .= '</ul></div>';
            }
        }
    }

    return apply_filters('kopa_shortcode_gallery', force_balance_tags($output));
}