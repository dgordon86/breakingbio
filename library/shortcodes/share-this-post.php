<?php

add_shortcode('share_this_post', 'kopa_shortcode_share_this_post');

/**
 * 
 *
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_shortcode_share_this_post($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));

    if (is_main_site() || is_singular()) {
        global $post;
        $user_id = $post->post_author;
        $twitter = get_the_author_meta('twitter', $user_id);

        $title = htmlspecialchars(get_the_title());
        $email_subject = htmlspecialchars(get_bloginfo('name')) . ': ' . $title;
        $email_body = __('I recommend this page: ', kopa_get_domain()) . $title . __('. You can read it on: ', kopa_get_domain()) . get_permalink();

        $out = '<div class="share-box pull-right">';
        $out.= '<ul class="clearfix">';
        $out.= '<li class="clearfix">';
        $out.= sprintf('<a class="pull-left t-first" href="mailto:?subject=%s&amp;body=%s"><span class="icon-envelope"></span>%s</a>', $email_subject, rawurlencode($email_body), __('Mail', kopa_get_domain()));
        $out.= sprintf('<a class="pull-left" href="javascript:window.print();"><span class="icon-print"></span>%s</a>', __('Print', kopa_get_domain()));
        $out.= '</li>';
        $out.= '<li class="clearfix">';
        $out.= '<div class="pull-left social-links">';
        $out.= sprintf('<span class="clearfix"><span class="icon-plus"></span>%s</span>', __('Share', kopa_get_domain()));
        $out.= '<ul>';
        $out.= sprintf('<li><a href="http://twitter.com/home?status=%s"><span class="icon-twitter-2"></span>%s</a></li>', get_the_title() . ':+' . urlencode(get_permalink()), __('Twitter', kopa_get_domain()));
        $out.= sprintf('<li><a href="http://www.facebook.com/share.php?u=%s"><span class="icon-facebook-2"></span>%s</a></li>', urlencode(get_permalink()), __('Facebook', kopa_get_domain()));
        $out.= sprintf('<li><a href="https://plus.google.com/share?url=%s"><span class="icon-google-plus-2"></span>%s</a></li>', urlencode(get_permalink()), __('Google +', kopa_get_domain()));
        $out.= '</ul>';
        $out.= '</div>';
        $out.= sprintf('<a class="pull-left" href="#respond"><span class="icon-bubble"></span>%s</a>', __('Comments', kopa_get_domain()));
        $out.= '</li>';
        if ($twitter) {
            $out.= '<li class="clearfix text-center">';
            $out.= sprintf('<a href="%s"><span class="icon-twitter-2"></span>%s</a>', $twitter, __('Follow author', kopa_get_domain()));
            $out.= '</li>';
        }
        $out.= '</ul>';
        $out.= '</div>';
    }
    return apply_filters('kopa_shortcode_share_this_post', force_balance_tags($out));
}

