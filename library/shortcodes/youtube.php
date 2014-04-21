<?php

$youtube_params = array();
$youtube_params['showinfo'] = ('true' == KopaOptions::get_option('is_youtube_showinfo', 'false')) ? 1 : 0;
$youtube_params['hd'] = (int) ('true' == KopaOptions::get_option('is_youtube_hd_enable', 'false')) ? 1 : 0;
$youtube_params['rel'] = (int) ('true' == KopaOptions::get_option('is_youtube_rel_enable', 'false')) ? 1 : 0;
$youtube_params['theme'] = KopaOptions::get_option('youtube_theme', 'light');
$youtube_params['controls'] = (int) KopaOptions::get_option('youtube_controls', '2');

$youtube_url_params = array();
foreach ($youtube_params as $key => $val) {
    $youtube_url_params[] = "{$key}={$val}";
}

add_shortcode('youtube', 'kopa_shortcode_youtube');

/**
 * 
 *
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_shortcode_youtube($atts, $content = null) {
    extract(shortcode_atts(array('url' => ''), $atts));
    $out = NULL;

    if (isset($atts['url']) && !empty($atts['url'])) {
        global $youtube_url_params;

        $matches = array();
        preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $atts['url'], $matches);
        if (isset($matches[2]) && $matches[2] != '') {
            $out .= '<div class="video-wrapper"><iframe src="http://www.youtube.com/embed/' . $matches[2] . '?' . implode('&', $youtube_url_params) . '" frameborder="0" allowfullscreen></iframe></div>';
        }
    }

    return apply_filters('kopa_shortcode_youtube', force_balance_tags($out));
}
