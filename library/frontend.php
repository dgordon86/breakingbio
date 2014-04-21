<?php
add_action('after_setup_theme', 'kopa_front_after_setup_theme');

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_front_after_setup_theme() {
    add_theme_support('post-formats', array('gallery', 'audio', 'video', 'quote', 'aside'));
    add_theme_support('post-thumbnails');
    add_theme_support('loop-pagination');
    add_theme_support('automatic-feed-links');
    add_theme_support('editor_style');
    add_editor_style('editor-style.css');

    global $content_width;
    if (!isset($content_width))
        $content_width = 700;

    register_nav_menus(array(
        'top-nav' => __('Top Menu', kopa_get_domain()),
        'primary-nav' => __('Primary Menu', kopa_get_domain()),
        'secondary-nav' => __('Seconday Menu', kopa_get_domain()),
        'bottom-nav' => __('Bottom Menu', kopa_get_domain()),
    ));

    if (!is_admin()) {
        add_action('wp_enqueue_scripts', 'kopa_front_enqueue_scripts');
        add_action('wp_footer', 'kopa_footer');
        add_action('wp_head', 'kopa_head');
        add_filter('widget_text', 'do_shortcode');
        add_filter('post_class', 'kopa_post_class');
        add_filter('body_class', 'kopa_body_class');
        add_filter('cancel_comment_reply_link', 'kopa_cancel_comment_reply_link');
        add_filter('wp_nav_menu_items', 'kopa_add_home_menuitem', 10, 2);
        add_action('pre_get_posts', 'kopa_edit_archive_query');
        add_filter('kopa_blog_is_display_blog_post_format', 'kopa_blog_is_display_blog_post_format');
        add_filter('kopa_blog_thumbnail_position', 'kopa_blog_thumbnail_position');
        add_filter('language_attributes', 'kopa_add_open_graph_xml_nameservers');
        add_filter('the_category', 'kopa_add_itemprop');
        add_filter('the_tags', 'kopa_add_itemprop');
    }
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_add_itemprop($thelist) {
    if (is_main_query() && 'true' == KopaOptions::get_option('seo_status', 'false')) {
        $thelist = str_replace('<a ', '<a itemprop="articleSection" ', $thelist);
    }
    return $thelist;
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_add_open_graph_xml_nameservers($doctype) {
    if ('true' == KopaOptions::get_option('seo_status', 'false')) {
        $nameservers = array();
        $nameservers[] = 'xmlns="http://www.w3.org/1999/xhtml"';
        $nameservers[] = 'xmlns:og="http://ogp.me/ns#"';
        $nameservers[] = 'xmlns:fb="http://www.facebook.com/2008/fbml"';

        $doctype.= sprintf(' %s ', implode(' ', $nameservers));
    }

    return $doctype;
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_blog_thumbnail_position($thumbnail_position) {
    global $wp_query;
    $private_thumbnail_position = 'inherit';

    if (!is_admin() && $wp_query->is_main_query()) {
        if (is_tag() || is_category()) {
            $id = get_queried_object_id();
            $key = sprintf('%s%s_%s', KOPA_OPT_PREFIX, 'thumbnail_position', $id);
            $private_thumbnail_position = get_option($key, 'inherit');
        }
    }

    if ('inherit' != $private_thumbnail_position) {
        $thumbnail_position = $private_thumbnail_position;
    }

    return $thumbnail_position;
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_blog_is_display_blog_post_format($is_display) {
    global $wp_query;
    $private_is_display = 'inherit';

    if (!is_admin() && $wp_query->is_main_query()) {
        if (is_tag() || is_category()) {
            $id = get_queried_object_id();
            $key = sprintf('%s%s_%s', KOPA_OPT_PREFIX, 'is_display_content_formatted', $id);
            $private_is_display = get_option($key, 'inherit');
        }
    }

    if ('inherit' != $private_is_display) {
        $is_display = $private_is_display;
    }

    return $is_display;
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_edit_archive_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        $post_per_page = 'inherit';

        if (is_tag()) {
            $slug = $query->query_vars['tag'];
            $tag = get_term_by('slug', $slug, 'post_tag');
            if (!empty($tag)) {
                $post_per_page = get_option(KOPA_OPT_PREFIX . 'posts_per_page_' . $tag->term_id, 'inherit');
            }
        } else if (is_category()) {
            $slug = $query->query_vars['category_name'];
            $cat = get_term_by('slug', $slug, 'category');
            if (!empty($cat)) {
                $post_per_page = get_option(KOPA_OPT_PREFIX . 'posts_per_page_' . $cat->term_id, 'inherit');
            }
        }

        if ('inherit' != $post_per_page) {
            switch ($post_per_page) {
                case '-1':
                    $query->query_vars['posts_per_page'] = -1;
                    break;
                default:
                    $query->query_vars['posts_per_page'] = (int) $post_per_page;
                    break;
            }
        }
    }
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_add_home_menuitem($items, $args) {
    if ('primary-nav' == $args->theme_location && 'main-menu' == $args->menu_id) {
        $home_html = sprintf('<li class="home-menu-icon"><a class="icon-home" href="%s" title="%s"></a></li>', home_url(), __('Home', kopa_get_domain()));
        $items = $home_html . $items;
    }

    return $items;
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_cancel_comment_reply_link($formatted_link) {
    $formatted_link = str_replace('<a', '<a class="kp-button" ', $formatted_link);
    return $formatted_link;
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_post_class($classes) {
    return $classes;
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_body_class($classes) {
    $kopa_layout = KopaInit::get_layouts();
    $kopaCurrentSetting = KopaLayout::get_current_setting();
    $kopaCurrentLayout = $kopaCurrentSetting['layout_slug'];
    $kopaCurrentSidebars = $kopaCurrentSetting['sidebars'][$kopaCurrentLayout];


    if (is_front_page() && !is_home()) {
        $classes[] = 'kp-home-page';
    } else if (is_home()) {
        if ('page' == get_option('show_on_front')) {
            $classes[] = 'kp-sub-page';
        } else {
            $classes[] = 'kp-home-page';
        }
    } else {
        $classes[] = 'kp-sub-page';
    }

    if (is_404()) {
        $classes[] = 'kp-one-sidebar';
        $classes[] = 'kp-no-sidebar';
    }

    $classes[] = "kopa-layout-{$kopaCurrentLayout}";

    $positions = $kopa_layout[$kopaCurrentLayout]['positions'];

    foreach ($positions as $index => $position) {
        if (!is_active_sidebar($kopaCurrentSidebars[$index])) {
            $classes[] = "kopa-hide-{$position}";
        } else {
            $classes[] = "kopa-show-{$position}";
        }
    }

    if (is_page() && 'front-page' == $kopaCurrentLayout) {
        $classes = array_diff($classes, array("kp-sub-page"));
        $classes[] = 'kp-home-page';
    }

    return $classes;
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_head() {
    /**
     * FAVICON
     */
    $favicon = KopaOptions::get_option('favicon');
    if ($favicon) {
        printf('<link rel="shortcut icon" type="image/x-icon"  href="%s">', do_shortcode($favicon));
    }

    /**
     * APPLE ICON
     */
    $apple_icon = KopaOptions::get_option('apple_icon');
    if ($apple_icon) {
        $apple_icon = do_shortcode($apple_icon);
        foreach (array(60, 76, 120, 152) as $size) {
            $tmp = bfi_thumb($apple_icon, array('width' => $size, 'height' => $size, 'crop' => true));
            printf('<link rel="apple-touch-icon" sizes="%1$sx%1$s" href="%2$s">', $size, $tmp);
        }
    }

    /**
     * VERIFICATION SERVICES
     */
    $verification_services = array(
        'google_verify_meta' => 'google-site-verification',
        'bing_verify_meta' => 'msvalidate.01',
        'pinterest_verify_meta' => 'p:domain_verify',
        'yandex_verify_meta' => 'yandex-verification'
    );

    foreach ($verification_services as $option_key => $meta_key) {
        $meta_value = KopaOptions::get_option($option_key);
        if ($meta_value) {
            printf('<meta name="%s" content="%s">', $meta_key, $meta_value);
        }
    }

    /**
     * SEO
     */
    if ('true' == KopaOptions::get_option('seo_status', 'false')) {
        $keywords = explode(',', str_replace(' ', '', KopaOptions::get_option('seo_keywords')));
        $description = KopaOptions::get_option('seo_descriptions');
        $thumbnail = array();        
        $url = home_url();
        $title = KopaSEO::get_title();
        $author = KopaOptions::get_option('seo_google_profile_url');

        $tmp_keywords = '';
        $tmp_description = '';

        if (is_singular() && !is_front_page()) {
            global $post;
            $tmp_keywords = KopaUtil::get_post_meta($post->ID, KOPA_OPT_PREFIX . 'seo_keywords', true);
            $tmp_description = KopaUtil::get_post_meta($post->ID, KOPA_OPT_PREFIX . 'seo_descriptions', true);
            $url = get_permalink($post->ID);
            $thumbnail[] = KopaImage::get_post_image_src($post->ID, 'size_03');
            
            $user_id = $post->post_author;
            $current_author = get_the_author_meta('google_profile', $user_id);
            $author = ($current_author) ? $current_author : $author;
        } else if (is_category() || is_tag()) {
            $term_id = get_queried_object_id();
            $tmp_keywords = get_option(KOPA_OPT_PREFIX . 'seo_keywords_' . $term_id);
            $tmp_description = get_option(KOPA_OPT_PREFIX . 'seo_descriptions_' . $term_id);
        }

        if ($tmp_keywords) {
            $tmp_keywords = explode(',', str_replace(' ', '', $tmp_keywords));
            $keywords = array_merge($keywords, $tmp_keywords);
        }

        $keywords = implode(',', array_unique($keywords));
        $description = ($tmp_description) ? $tmp_description : $description;

        $facebook_page_id = KopaOptions::get_option('seo_facebook_page_id');
        $facebook_app_id = KopaOptions::get_option('seo_facebook_app_id');
        $facebook_admins = KopaOptions::get_option('seo_facebook_admins');
        $facebook_og_type = KopaOptions::get_option('seo_facebook_og_type', 'website');
        $facebook_og_image = KopaOptions::get_option('seo_facebook_og_image');
        
        if($facebook_og_image){
            $thumbnail[] = do_shortcode($facebook_og_image);
        }
        

        printf('<meta name="keywords" content="%s">', $keywords);
        printf('<meta name="description" content="%s">', $description);

        /**
         * Open Graph
         */
        printf('<meta property="og:type" content="%s">', $facebook_og_type);
        printf('<meta property="og:description" content="%s">', $description);
        printf('<meta property="og:site_name" content="%s">', get_bloginfo('name'));
        printf('<meta property="og:url" content="%s">', $url);
        printf('<meta property="og:title" content="%s">', $title);
        printf('<meta property="og:locale" content="%s">', ('' == WPLANG) ? 'en_US' : WPLANG);
        
        foreach($thumbnail as $image){
            if(!empty($image)){
                printf('<meta property="og:image" content="%s">', $image);
            }
        }

        # Google Map
        $google_map = KopaOptions::get_option('contact_map');
        if ($google_map) {
            $maps_arr = explode(',', $google_map);
            if (2 == count($maps_arr)) {
                printf('<meta property="place:location:latitude" content="%s">', trim($maps_arr[0]));
                printf('<meta property="place:location:longitude" content="%s">', trim($maps_arr[1]));
                printf('<meta name="geo.position" content="%s;%s">', trim($maps_arr[0]), trim($maps_arr[1]));
            }
        }
        #Contact Information
        $contact_email = KopaOptions::get_option('contact_email');
        $contact_phone = KopaOptions::get_option('contact_phone');
        $contact_fax = KopaOptions::get_option('contact_fax');
        $contact_address = KopaOptions::get_option('contact_address');
        $contact_postal_code = KopaOptions::get_option('contact_postal_code');
        $contact_country_name = KopaOptions::get_option('contact_country_name');

        if ('website' || $facebook_og_type) {
            printf('<meta property="business:contact_data:email" content="%s">', $contact_email);
            printf('<meta property="business:contact_data:phone_number" content="%s">', $contact_phone);
            printf('<meta property="business:contact_data:fax_number" content="%s">', $contact_fax);
            printf('<meta property="business:contact_data:street_address" content="%s">', $contact_address);

            if ($contact_address && $contact_postal_code && $contact_country_name) {
                printf('<meta property="business:contact_data:locality" content="%s">', $contact_address);
                printf('<meta property="business:contact_data:postal_code" content="%s">', $contact_postal_code);
                printf('<meta property="business:contact_data:country_name" content="%s">', $contact_country_name);
            }
        }
        printf('<meta name="geo.placename" content="%s">', $contact_address);

        #TWITTER
        $twitter_name = KopaOptions::get_option('seo_twitter_name');
        if ($twitter_name) {
            printf('<meta name="twitter:card" content="%s">', 'summary');
            printf('<meta name="twitter:site" content="%s">', $twitter_name);
            printf('<meta name="twitter:creator" content="%s">', $twitter_name);
        }
        printf('<meta name="twitter:title" content="%s">', $title);
        printf('<meta name="twitter:description" content="%s">', $description);
        

        foreach($thumbnail as $image){
            if(!empty($image)){
                printf('<meta name="twitter:image" content="%s">', $image);                
            }
        }
        
        #FACEBOOK
        if ($facebook_page_id) {
            printf('<meta property="fb:page_id" content="%s">', $facebook_page_id);
        }
        if ($facebook_app_id) {
            printf('<meta property="fb:app_id" content="%s">', $facebook_app_id);
        }
        if ($facebook_admins) {
            printf('<meta property="fb:admins" content="%s">', $facebook_admins);
        }

        #GOOGLE PROFILE URL        
        if ($author)
            printf('<link rel="author" href="%s">', $author);
    }
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_footer() {
    echo htmlspecialchars_decode(stripslashes(KopaOptions::get_option('tracking_code')));
    wp_nonce_field('kopa_set_view_count', 'kopa_set_view_count_wpnonce', false);
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_front_enqueue_scripts() {
    if (!is_admin()) {
        global $wp_styles, $is_IE;
        $dir = get_template_directory_uri();

        #STYLESHEETs                
        wp_enqueue_style(KOPA_OPT_PREFIX . 'bootstrap', $dir . '/css/bootstrap.css', array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'yamm', $dir . '/css/yamm.css', array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'flexslider', $dir . '/css/flexslider.css', array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'icoMoon', $dir . '/css/icoMoon.css', array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'icon-socials', "{$dir}/library/css/kopa.iconSocials.css", array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'icon-front', "{$dir}/css/kopa.iconFront.css", array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'superfish', $dir . '/css/superfish.css', array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'prettyPhoto', $dir . '/css/prettyPhoto.css', array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'fotorama', $dir . '/assets/fotorama/fotorama.css', array(), NULL);
        wp_enqueue_style(KOPA_OPT_PREFIX . 'style', get_stylesheet_uri(), array(), NULL);

        if ($is_IE) {
            wp_register_style('kopa-ie', $dir . '/css/ie.css', array(), NULL);
            wp_enqueue_style('kopa-ie');
            $wp_styles->add_data('kopa-ie', 'conditional', 'lt IE 9');
        }

        wp_enqueue_style(KOPA_OPT_PREFIX . 'responsive', $dir . '/css/responsive.css', array(KOPA_OPT_PREFIX . 'style'), NULL);

        #SCRIPTS
        wp_enqueue_script('jquery');
        wp_localize_script('jquery', 'kopa_variable', kopa_variable_front());
        wp_localize_script('jquery', 'RecaptchaOptions', array(
            'theme' => KopaOptions::get_option('recaptcha_skin', 'off')
        ));

        if ($is_IE) {
            wp_enqueue_script(KOPA_OPT_PREFIX . 'html5shiv', $dir . '/js/html5shiv.js', array(), NULL, TRUE);
            wp_enqueue_script(KOPA_OPT_PREFIX . 'respond', $dir . '/js/respond.js', array('jquery'), NULL, TRUE);
            wp_enqueue_script(KOPA_OPT_PREFIX . 'css3-mediaqueries', $dir . '/js/css3-mediaqueries.js', array(), NULL, TRUE);
            wp_enqueue_script(KOPA_OPT_PREFIX . 'pie-ie678', $dir . '/js/PIE_IE678.js', array(), NULL, TRUE);
        }

        wp_enqueue_script(KOPA_OPT_PREFIX . 'maps-api', 'http://maps.google.com/maps/api/js?sensor=true', array('jquery'), NULL, TRUE);

        wp_enqueue_script('jquery-form');
        wp_enqueue_script(KOPA_OPT_PREFIX . 'bootstrap', $dir . '/js/bootstrap.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'carouFredSel', $dir . '/js/jquery.carouFredSel.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'flexslider', $dir . '/js/jquery.flexslider.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'isotope', $dir . '/js/jquery.isotope.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'masonry', $dir . '/js/jquery.masonry.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'mousewheel', $dir . '/js/jquery.mousewheel.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'validate', $dir . '/js/jquery.validate.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'modernizr', $dir . '/js/modernizr-transitions.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'retina', $dir . '/js/retina.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'superfish', $dir . '/js/superfish.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'gmaps', $dir . '/js/gmaps.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'navgoco', $dir . '/js/jquery.navgoco.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'prettyPhoto', $dir . '/js/jquery.prettyPhoto.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'audio-player', $dir . '/assets/audio-player/audio-player.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'fotorama', $dir . '/assets/fotorama/fotorama.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'flickr', $dir . '/js/jquery.flickr.js', array('jquery'), NULL, TRUE);
        wp_enqueue_script(KOPA_OPT_PREFIX . 'custom', $dir . '/js/custom.js', array('jquery'), NULL, TRUE);

        if (is_singular()) {
            wp_enqueue_script('comment-reply');
        }
    }
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_variable_front() {
    return array(
        'ajax' => array(
            'url' => admin_url('admin-ajax.php')
        ),
        'template' => array(
            'post_id' => (is_singular()) ? get_queried_object_id() : 0
        ),
        'url' => array(
            'audio_swf' => get_template_directory_uri() . '/assets/audio-player/player.swf'
        ),
        'lightbox' => array(
            'prettyPhoto' => array(
                'theme' => KopaOptions::get_option('lightbox_skin', 'dark_square'),
                'modal' => KopaOptions::get_option('is_lightbox_modal_mode', 'true'),
                'social_tools' => KopaOptions::get_option('is_lightbox_social_tools', 'true'),
                'opacity' => ((int) KopaOptions::get_option('lightbox_opacity', 70)) / 100
            )
        ),
        'contact' => array(
            'address' => KopaOptions::get_option('contact_address', ''),
            'marker' => do_shortcode(KopaOptions::get_option('contact_map_marker', '')),
        ),
        'recaptcha' => array(
            'status' => ('off' != KopaOptions::get_option('recaptcha_skin', 'off') && KopaOptions::get_option('recaptcha_public_key') && KopaOptions::get_option('recaptcha_private_key'))
        ),
        'i18n' => array(
            'VIEW' => __('View', kopa_get_domain()),
            'VIEWS' => __('Views', kopa_get_domain()),
            'validate' => array(
                'form' => array(
                    'CHECKING' => __('Checking', kopa_get_domain()),
                    'SUBMIT' => __('Submit', kopa_get_domain()),
                    'SENDING' => __('Sending...', kopa_get_domain())
                ),
                'recaptcha' => array(
                    'INVALID' => __('Your captcha is incorrect. Please try again', kopa_get_domain()),
                    'REQUIRED' => __('Captcha is required', kopa_get_domain())
                ),
                'name' => array(
                    'REQUIRED' => __('Please enter your name', kopa_get_domain()),
                    'MINLENGTH' => __('At least {0} characters required', kopa_get_domain())
                ),
                'email' => array(
                    'REQUIRED' => __('Please enter your email', kopa_get_domain()),
                    'EMAIL' => __('Please enter a valid email', kopa_get_domain())
                ),
                'url' => array(
                    'REQUIRED' => __('Please enter your url', kopa_get_domain()),
                    'URL' => __('Please enter a valid url', kopa_get_domain())
                ),
                'message' => array(
                    'REQUIRED' => __('Please enter a message', kopa_get_domain()),
                    'MINLENGTH' => __('At least {0} characters required', kopa_get_domain())
                )
            )
        )
    );
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_get_headline() {
    $limit = (int) KopaOptions::get_option('headline_limit', 4);
    if ($limit) {
        $prefix = KopaOptions::get_option('headline_prefix');
        $cats = KopaOptions::get_option('headline_cats');
        $tags = KopaOptions::get_option('headline_tags');
        $formats = KopaOptions::get_option('headline_formats');
        $timestamp = KopaOptions::get_option('headline_timestamp');

        $query = array(
            'post_type' => array('post'),
            'posts_per_page' => $limit,
            'post_status' => array('publish'),
            'ignore_sticky_posts' => true
        );

        if (!empty($cats)) {
            $query['tax_query'][] = array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $cats
            );
        }

        if (!empty($tags)) {
            $query['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field' => 'id',
                'terms' => $tags
            );
        }

        if (!empty($formats)) {
            $query['tax_query'][] = array(
                'taxonomy' => 'post_format',
                'field' => 'id',
                'terms' => $formats
            );
        }

        if (isset($query['tax_query']) && (count($query['tax_query']) >= 2)) {
            $query['tax_query']['relation'] = ('true' == KopaOptions::get_option('headline_relation')) ? 'AND' : 'OR';
        }


        global $wp_version;

        if (version_compare($wp_version, '3.7.0', '>=')) {
            if (isset($timestamp) && !empty($timestamp)) {
                $y = date('Y', strtotime($timestamp));
                $m = date('m', strtotime($timestamp));
                $d = date('d', strtotime($timestamp));

                $query['date_query'] = array(
                    array(
                        'after' => array(
                            'year' => (int) $y,
                            'month' => (int) $m,
                            'day' => (int) $d
                        )
                    )
                );
            }
        }

        $posts = new WP_Query($query);
        if ($posts->have_posts()) {
            ?>
            <div class="kp-headline-wrapper pull-left clearfix">
                <?php if ($prefix): ?>
                    <span class="kp-headline-title"><?php echo $prefix; ?></span>
                <?php endif; ?>
                <div class="kp-headline clearfix">                        
                    <dl class="ticker-1 clearfix">
                        <?php
                        while ($posts->have_posts()) {
                            $posts->the_post();
                            $post_url = get_permalink();
                            $post_title = get_the_title();
                            ?>
                            <dd><a href="<?php echo $post_url; ?>"><span  class="date updated"><?php echo get_the_date(); ?></span> - <?php echo $post_title; ?></a></dd>                            
                            <?php
                        }
                        ?>                       
                    </dl>                    
                </div>                
            </div>
            <?php
        }
        wp_reset_postdata();
    }
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_get_related_posts() {
    if (is_single()) {
        $get_by = get_option('post_related_posts_get_by', 'post_tag');
        $limit = (int) KopaOptions::get_option('post_related_posts_limit', 4);

        if ($limit > 0) {
            global $post;
            $taxs = array();
            if ('category' == $get_by) {
                $cats = get_the_category(($post->ID));
                if ($cats) {
                    $ids = array();
                    foreach ($cats as $cat) {
                        $ids[] = $cat->term_id;
                    }
                    $taxs [] = array(
                        'taxonomy' => 'category',
                        'field' => 'id',
                        'terms' => $ids
                    );
                }
            } else {
                $tags = get_the_tags($post->ID);
                if ($tags) {
                    $ids = array();
                    foreach ($tags as $tag) {
                        $ids[] = $tag->term_id;
                    }
                    $taxs [] = array(
                        'taxonomy' => 'post_tag',
                        'field' => 'id',
                        'terms' => $ids
                    );
                }
            }
            if ($taxs) {
                $related_args = array(
                    'tax_query' => $taxs,
                    'post__not_in' => array($post->ID),
                    'posts_per_page' => $limit
                );
                $related_posts = new WP_Query($related_args);
                if ($related_posts->have_posts()):
                    ?>
                    <div id="related-post">
                        <h4><?php _e('Related Articles', kopa_get_domain()); ?></h4>
                        <div class="masonry-wrapper">
                            <ul class="masonry-container transitions-enabled centered clearfix masonry">
                                <?php
                                while ($related_posts->have_posts()):
                                    $related_posts->the_post();
                                    $post_id = get_the_ID();
                                    $post_url = get_permalink();
                                    $post_title = get_the_title();
                                    ?>
                                    <li <?php post_class('masonry-box'); ?>>
                                        <article class="entry-item clearfix">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                $image = KopaUtil::get_image_src($post_id, 'full');
                                                $image_croped = bfi_thumb($image, array('width' => 52, 'height' => 52, 'crop' => true));
                                                ?>
                                                <div class="entry-thumb"><a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a></div>
                                                <?php
                                            }
                                            ?>                                          
                                            <div class="entry-content">
                                                <h6 class="entry-title"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></h6>
                                                <span class="entry-date clearfix"><span class="entry-icon icon-clock"></span><span  class="date updated"><?php echo get_the_date(); ?></span></span>
                                            </div>
                                            <!-- entry-content -->
                                        </article>                                        
                                    </li>                            
                                    <?php
                                endwhile;
                                ?>
                            </ul>
                        </div>                
                    </div>
                    <?php
                endif;
                wp_reset_postdata();
            }
        }
    }
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_get_sharing_buttons($args = array('id' => '', 'classes' => array())) {
    global $kopa;

    $title = KopaSEO::get_title();
    $email_subject = htmlspecialchars(get_bloginfo('name')) . ': ' . $title;
    $email_body = __('I recommend this page: ', kopa_get_domain()) . $title . __('. You can read it on: ', kopa_get_domain()) . get_permalink();
    if (has_post_thumbnail()) {
        $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
        $thumbnail = wp_get_attachment_image_src($post_thumbnail_id);
    }
    $id = (isset($args['id'])) ? $args['id'] : 'kopa-share-this-post';
    $classes = (isset($args['classes'])) ? ((is_array($args['classes'])) ? implode(' ', $args['classes']) : $args['classes']) : 'clearfix';
    ?>
    <div id="<?php echo $id; ?>" class="<?php echo $classes; ?>">
        <label class="pull-left"><?php _e('Share This Story, Choose Your Platform!', kopa_get_domain()); ?></label>
        <ul class="pull-left">
            <li class="">
                <a class="kopa-sharing-item kopa-tooltip" href="http://www.facebook.com/share.php?u=<?php echo urlencode(get_permalink()); ?>" title="Facebook" target="_blank">
                    <i class="<?php echo $kopa['icon']['social']['facebook']; ?>"></i>
                </a>
            </li>
            <li class="">
                <a class="kopa-sharing-item kopa-tooltip" href="http://twitter.com/home?status=<?php echo get_the_title() . ':+' . urlencode(get_permalink()); ?>" title="Twitter" target="_blank">
                    <i class="<?php echo $kopa['icon']['social']['twitter']; ?>"></i>
                </a>
            </li>
            <li class="">
                <a class="kopa-sharing-item kopa-tooltip" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" title="Google" target="_blank">
                    <i class="<?php echo $kopa['icon']['social']['google-plus']; ?>"></i>
                </a></li>
            <li class="">
                <a class="kopa-sharing-item kopa-tooltip" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>&amp;summary=<?php echo urlencode(get_the_excerpt()); ?>&amp;source=<?php echo urlencode(get_bloginfo('name')); ?>" title="Linkedin" target="_blank">
                    <i class="<?php echo $kopa['icon']['social']['linkedin']; ?>"></i>
                </a>
            </li>
            <li class="">
                <a class="kopa-sharing-item kopa-tooltip" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;media=<?php echo isset($thumbnail[0]) ? urlencode($thumbnail[0]) : ''; ?>&amp;description=<?php the_title(); ?>" title="Pinterest" target="_blank">
                    <i class="<?php echo $kopa['icon']['social']['pinterest']; ?>"></i>
                </a>
            </li>
            <li class="">
                <a class="kopa-sharing-item kopa-tooltip" href="mailto:?subject=<?php echo rawurlencode($email_subject); ?>&amp;body=<?php echo rawurlencode($email_body); ?>" title="Email" target="_self">
                    <i class="<?php echo $kopa['icon']['social']['email']; ?>"></i>
                </a>
            </li>
        </ul>
    </div>
    <?php
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_get_about_author() {
    if ('true' == KopaOptions::get_option('is_display_post_author_information', 'true')) {
        global $post;

        $user_id = $post->post_author;
        $description = get_the_author_meta('description', $user_id);
        $email = get_the_author_meta('user_email', $user_id);
        $name = get_the_author_meta('display_name', $user_id);
        $url = trim(get_the_author_meta('user_url', $user_id));
        $link = ($url) ? $url : get_author_posts_url($user_id);
        ?>

        <div class="about-author clearfix">
            <h4><?php _e('About the author', kopa_get_domain()); ?></h4>
            <a class="avatar-thumb" target="_blank" href="<?php echo $link; ?>"><?php echo get_avatar($email, 112); ?></a>                

            <div class="author-content">
                <h5 itemprop="author"><a target="_blank" itemscope="itemscope" itemtype="http://schema.org/Person" class="vcard author" href="<?php echo $link; ?>"><span class="fn" itemprop="name"><?php echo $name; ?></span></a></h5>

                <?php echo ($description) ? "<div>{$description}</div>" : ''; ?>

                <footer class="clearfix">
                    <?php if ($url): ?>
                        <span class="pull-left"><strong><?php _e('Website:', kopa_get_domain()); ?>&nbsp;</strong><a target="_blank"  href="<?php echo $url; ?>"><?php echo $url; ?></a></span>
                    <?php endif; ?>

                    <?php if ('true' == KopaOptions::get_option('is_display_post_author_social_links', 'true')): ?>
                        <ul class="pull-right social-links">
                            <li><strong><?php _e('Social links:', kopa_get_domain()); ?>&nbsp;</strong></li>
                            <?php
                            $socials = array('facebook', 'twitter', 'dribbble', 'flickr', 'pinterest');
                            foreach ($socials as $social) {
                                $tmp = get_the_author_meta($social, $user_id);
                                if ($tmp) {
                                    ?>
                                    <li><a target="_blank" href="<?php echo $tmp; ?>" class="<?php echo "icon-$social"; ?>"></a></li>
                                    <?php
                                }
                            }
                            ?>                        
                            <li><a target="_blank" href="<?php echo get_author_feed_link($user_id); ?>" class="icon-feed"></a></li>                        
                        </ul>
                    <?php endif; ?>   
                    <!-- social-links -->
                </footer>    
            </div><!--author-content-->
        </div>
        <?php
    }
}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_get_social_links() {
    return NULL;
}
