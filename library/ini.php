<?php

add_action('init', 'kopa_initial_database');

class KopaInit {

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    static function get_positions() {
        $positions = array();
        $positions['position_1'] = array('title' => __('Widget Area 1', kopa_get_domain()));
        $positions['position_2'] = array('title' => __('Widget Area 2', kopa_get_domain()));
        $positions['position_3'] = array('title' => __('Widget Area 3', kopa_get_domain()));
        $positions['position_4'] = array('title' => __('Widget Area 4', kopa_get_domain()));
        $positions['position_5'] = array('title' => __('Widget Area 5', kopa_get_domain()));
        $positions['position_6'] = array('title' => __('Widget Area 6', kopa_get_domain()));
        $positions['position_7'] = array('title' => __('Widget Area 7', kopa_get_domain()));
        $positions['position_8'] = array('title' => __('Widget Area 8', kopa_get_domain()));
        $positions['position_9'] = array('title' => __('Widget Area 9', kopa_get_domain()));
        $positions['position_10'] = array('title' => __('Widget Area 10', kopa_get_domain()));
        $positions['position_11'] = array('title' => __('Widget Area 11', kopa_get_domain()));

        return apply_filters('kopa_init_get_positions', $positions);
    }

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    static function get_layouts() {
        $layouts = array();
        $layouts['front-page'] = array(
            'title' => __('Front Page', kopa_get_domain()),
            'slug' => 'front-page',
            'positions' => array(
                'position_1',
                'position_2',
                'position_3',
                'position_4',
                'position_5',
                'position_6',
                'position_7',
                'position_8',
                'position_9',
                'position_10',
                'position_11'
            )
        );

        $layouts['blog-page'] = array(
            'title' => __('Blog Page', kopa_get_domain()),
            'slug' => 'blog-page',
            'positions' => array(
                'position_1',
                'position_4',
                'position_5',
                'position_6',
                'position_7',
                'position_8',
                'position_9',
                'position_10',
                'position_11'
            )
        );


        $layouts['single-post'] = array(
            'title' => __('Single Post', kopa_get_domain()),
            'slug' => 'single-post',
            'positions' => array(
                'position_1',
                'position_4',
                'position_5',
                'position_6',
                'position_7',
                'position_8',
                'position_9',
                'position_10',
                'position_11'
            )
        );

        $layouts['static-page'] = array(
            'title' => __('Static Page', kopa_get_domain()),
            'slug' => 'static-page',
            'positions' => array(
                'position_1',
                'position_4',
                'position_5',
                'position_6',
                'position_7',
                'position_8',
                'position_9',
                'position_10',
                'position_11',
            )
        );

        $layouts['error-404'] = array(
            'title' => __('Error 404', kopa_get_domain()),
            'slug' => 'error-404',
            'positions' => array(
                'position_6',
                'position_7',
                'position_8',
                'position_9',
                'position_10',
                'position_11'
            )
        );

        return apply_filters('kopa_init_get_layouts', $layouts);
    }

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    static function get_template_hierarchy() {
        $template = array();

        $template['home'] = array(
            'icon' => 'dashicons dashicons-admin-home',
            'title' => __('Home', kopa_get_domain()),
            'layouts' => array(
                'blog-page'
            )
        );

        $template['front-page'] = array(
            'icon' => 'dashicons dashicons-welcome-view-site',
            'title' => __('Front Page', kopa_get_domain()),
            'layouts' => array(
                'front-page'
            )
        );

        $template['post'] = array(
            'icon' => 'dashicons dashicons-admin-post',
            'title' => __('Single Post', kopa_get_domain()),
            'layouts' => array(
                'single-post',
            )
        );

        $template['page'] = array(
            'icon' => 'dashicons dashicons-admin-page',
            'title' => __('Static Page', kopa_get_domain()),
            'layouts' => array(
                'static-page',
                'front-page',
            )
        );

        $template['archive'] = array(
            'icon' => 'dashicons dashicons-images-alt',
            'title' => __('Archive', kopa_get_domain()),
            'layouts' => array(
                'blog-page',
            )
        );

        $template['taxonomy'] = array(
            'icon' => 'dashicons dashicons-tag',
            'title' => __('Category | Tag', kopa_get_domain()),
            'layouts' => array(
                'blog-page',
            )
        );

        $template['author'] = array(
            'icon' => 'dashicons dashicons-businessman',
            'title' => __('Author', kopa_get_domain()),
            'layouts' => array(
                'blog-page',
            )
        );

        $template['search'] = array(
            'icon' => 'dashicons dashicons-search',
            'title' => __('Search Result', kopa_get_domain()),
            'layouts' => array(
                'blog-page',
            )
        );

        $template['_404'] = array(
            'icon' => 'dashicons dashicons-sos',
            'title' => __('404 Page not found', kopa_get_domain()),
            'layouts' => array(
                'error-404'
            )
        );

        return apply_filters('kopa_init_get_template_hierarchy', $template);
    }

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    static function get_sidebars() {
        $sidebars = array();

        $sidebars['sidebar_hide'] = __('-- None --', kopa_get_domain());
        $sidebars['sidebar_1'] = __('Sidebar 1', kopa_get_domain());
        $sidebars['sidebar_2'] = __('Sidebar 2', kopa_get_domain());
        $sidebars['sidebar_3'] = __('Sidebar 3', kopa_get_domain());
        $sidebars['sidebar_4'] = __('Sidebar 4', kopa_get_domain());
        $sidebars['sidebar_5'] = __('Sidebar 5', kopa_get_domain());
        $sidebars['sidebar_6'] = __('Sidebar 6', kopa_get_domain());
        $sidebars['sidebar_7'] = __('Sidebar 7', kopa_get_domain());
        $sidebars['sidebar_8'] = __('Sidebar 8', kopa_get_domain());
        $sidebars['sidebar_9'] = __('Sidebar 9', kopa_get_domain());
        $sidebars['sidebar_10'] = __('Sidebar 10', kopa_get_domain());
        $sidebars['sidebar_11'] = __('Sidebar 11', kopa_get_domain());

        return apply_filters('kopa_init_get_sidebars', $sidebars);
    }

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    static function get_sidebar_args() {
        $args = array(
            'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
            'after_widget' => '</div>',
            'before_title' => '<h6 class="widget-title">',
            'after_title' => '</h6>'
        );

        return apply_filters('kopa_ini_get_sidebar_args', $args);
    }

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    static function get_theme_option_fields() {
        $tabs = array();
        $tabs['general-setting'] = array(
            'title' => __('General Setting', kopa_get_domain()),
            'groups' => kopa_options_general(),
            'icon' => 'dashicons dashicons-admin-settings'
        );
        $tabs['blog-posts'] = array(
            'title' => __('Blog Posts', kopa_get_domain()),
            'groups' => kopa_options_blog_posts(),
            'icon' => 'dashicons dashicons-screenoptions'
        );
        $tabs['single-post'] = array(
            'title' => __('Single Post', kopa_get_domain()),
            'groups' => kopa_options_single_post(),
            'icon' => 'dashicons dashicons-format-aside'
        );
        $tabs['contact'] = array(
            'title' => __('Contact', kopa_get_domain()),
            'groups' => kopa_options_contact(),
            'icon' => 'dashicons dashicons-email'
        );
        $tabs['social-links'] = array(
            'title' => __('Social Links', kopa_get_domain()),
            'groups' => kopa_options_social_links(),
            'icon' => 'dashicons dashicons-share'
        );
        $tabs['typography'] = array(
            'title' => __('Typography', kopa_get_domain()),
            'groups' => kopa_options_typography(),
            'icon' => 'dashicons dashicons-editor-textcolor'
        );
        $tabs['color-scheme'] = array(
            'title' => __('Color Scheme', kopa_get_domain()),
            'groups' => kopa_options_color_scheme(),
            'icon' => 'dashicons dashicons-admin-appearance'
        );
        $tabs['custom-css'] = array(
            'title' => __('Custom CSS', kopa_get_domain()),
            'groups' => kopa_options_custom_css(),
            'icon' => 'dashicons dashicons-edit'
        );
        $tabs['extra'] = array(
            'title' => __('Extra', kopa_get_domain()),
            'groups' => kopa_options_extra(),
            'icon' => 'dashicons dashicons-star-filled'
        );
        $tabs['seo'] = array(
            'title' => __('SEO', kopa_get_domain()),
            'groups' => kopa_options_seo(),
            'icon' => 'dashicons dashicons-chart-line'
        );

        return $tabs;
    }

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    static function get_social_icons() {
        $socials = array();
        $socials['facebook'] = array(
            'title' => __('Facebook', kopa_get_domain()),
            'icon' => 'kps-facebook',
            'color' => '#3B5998'
        );
        $socials['twitter'] = array(
            'title' => __('Twitter', kopa_get_domain()),
            'icon' => 'kps-twitter',
            'color' => '#00A0D1'
        );
        $socials['google-plus'] = array(
            'title' => __('Google plus', kopa_get_domain()),
            'icon' => 'kps-google-plus',
            'color' => '#C63D2D'
        );
        $socials['pinterest'] = array(
            'title' => __('Pinterest', kopa_get_domain()),
            'icon' => 'kps-pinterest',
            'color' => '#E3262E'
        );
        $socials['linkedin'] = array(
            'title' => __('Linkedin', kopa_get_domain()),
            'icon' => 'kps-linkedin',
            'color' => '#006699'
        );
        $socials['foursquare'] = array(
            'title' => __('Foursquare', kopa_get_domain()),
            'icon' => 'kps-foursquare',
            'color' => '#0072B1'
        );
        $socials['Dribbble'] = array(
            'title' => __('Dribbble', kopa_get_domain()),
            'icon' => 'kps-dribbble',
            'color' => '#ea4c89'
        );
        $socials['tumblr'] = array(
            'title' => __('Tumblr', kopa_get_domain()),
            'icon' => 'kps-tumblr',
            'color' => '#2d4661'
        );
        $socials['steam'] = array(
            'title' => __('Steam', kopa_get_domain()),
            'icon' => 'kps-steam',
            'color' => '#517FA4'
        );
        $socials['Stumbleupon'] = array(
            'title' => __('Stumbleupon', kopa_get_domain()),
            'icon' => 'kps-stumbleupon',
            'color' => '#EB4924'
        );
        $socials['deviantart'] = array(
            'title' => __('Deviantart', kopa_get_domain()),
            'icon' => 'kps-deviantart',
            'color' => '#B1E03E'
        );
        $socials['flickr'] = array(
            'title' => __('Flickr', kopa_get_domain()),
            'icon' => 'kps-flickr',
            'color' => '#FE0883'
        );
        $socials['picassa'] = array(
            'title' => __('Picassa', kopa_get_domain()),
            'icon' => 'kps-picassa',
            'color' => '#e04a3f'
        );
        $socials['google-drive'] = array(
            'title' => __('Google drive', kopa_get_domain()),
            'icon' => 'kps-google-drive',
            'color' => '#007EE5'
        );
        $socials['dropbox'] = array(
            'title' => __('Dropbox', kopa_get_domain()),
            'icon' => 'kps-dropbox',
            'color' => '#2895F1'
        );
        $socials['youtube'] = array(
            'title' => __('Youtube', kopa_get_domain()),
            'icon' => 'kps-youtube',
            'color' => '#cc181e'
        );
        $socials['vimeo'] = array(
            'title' => __('Vimeo', kopa_get_domain()),
            'icon' => 'kps-vimeo',
            'color' => '#44BBFF'
        );
        $socials['github'] = array(
            'title' => __('Github', kopa_get_domain()),
            'icon' => 'kps-github',
            'color' => '#4183c4'
        );
        $socials['soundcloud'] = array(
            'title' => __('Soundcloud', kopa_get_domain()),
            'icon' => 'kps-soundcloud',
            'color' => '#dd5524'
        );
        $socials['xing'] = array(
            'title' => __('Xing', kopa_get_domain()),
            'icon' => 'kps-xing',
            'color' => '#006464'
        );
        $socials['instagram'] = array(
            'title' => __('Instagram', kopa_get_domain()),
            'icon' => 'kps-instagram',
            'color' => '#517FA4'
        );
        $socials['forrst'] = array(
            'title' => __('Forrst', kopa_get_domain()),
            'icon' => 'kps-forrst',
            'color' => '##6c9c76'
        );

        $socials['reddit'] = array(
            'title' => __('Reddit', kopa_get_domain()),
            'icon' => 'kps-reddit',
            'color' => '#e75018'
        );
        $socials['lastfm'] = array(
            'title' => __('Lastfm', kopa_get_domain()),
            'icon' => 'kps-lastfm',
            'color' => '#e31b23'
        );
        $socials['delicious'] = array(
            'title' => __('Delicious', kopa_get_domain()),
            'icon' => 'kps-delicious',
            'color' => '#0b79e5'
        );
        $socials['stackoverflow'] = array(
            'title' => __('Stackoverflow', kopa_get_domain()),
            'icon' => 'kps-stackexchange',
            'color' => '#fd8a07'
        );
        $socials['qq'] = array(
            'title' => __('QQ', kopa_get_domain()),
            'icon' => 'kps-qq',
            'color' => '#458FCE'
        );
        $socials['evernote'] = array(
            'title' => __('Evernote', kopa_get_domain()),
            'icon' => 'kps-evernote',
            'color' => '#5FB336'
        );
        $socials['renren'] = array(
            'title' => __('Renren', kopa_get_domain()),
            'icon' => 'kps-renren',
            'color' => '#005EAC'
        );
        $socials['sina-weibo'] = array(
            'title' => __('Sina weibo', kopa_get_domain()),
            'icon' => 'kps-sina-weibo',
            'color' => '#F62638'
        );
        $socials['behance'] = array(
            'title' => __('Behance', kopa_get_domain()),
            'icon' => 'kps-behance',
            'color' => '#1769FF'
        );

        $socials['smashing'] = array(
            'title' => __('Smashing', kopa_get_domain()),
            'icon' => 'kps-smashing',
            'color' => '#E95C33'
        );
        $socials['flattr'] = array(
            'title' => __('Flattr', kopa_get_domain()),
            'icon' => 'kps-flattr',
            'color' => '#F67C1A'
        );
        $socials['mixi'] = array(
            'title' => __('Mixi', kopa_get_domain()),
            'icon' => 'kps-mixi',
            'color' => '#d49c2d'
        );
        $socials['yahoo'] = array(
            'title' => __('Yahoo', kopa_get_domain()),
            'icon' => 'kps-yahoo',
            'color' => '#efc036'
        );
        $socials['skype'] = array(
            'title' => __('Skype', kopa_get_domain()),
            'icon' => 'kps-skype',
            'color' => '#0078ca',
            'help' => __('Enter value with format <code>skype:your_name?call</code>', kopa_get_domain())
        );
        $socials['rss'] = array(
            'title' => __('RSS', kopa_get_domain()),
            'icon' => 'kps-rss',
            'color' => '#fa9b39',
            'help' => __('Display the RSS feed button with the default RSS feed or enter a custom feed above. <br/>Enter <code>HIDE</code> if you want to hide it', kopa_get_domain())
        );

        return apply_filters('kopa_init_get_social_icons', $socials);
    }

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    static function get_image_sizes() {
        $sizes = array();

        $sizes['size_01'] = array(
            'name' => __('52 x 52 (pixel)', kopa_get_domain()),
            'width' => 52,
            'height' => 52,
            'crop' => true,
            'desc' => __("This size using for Widget small list, Widget quick views", kopa_get_domain())
        );

        $sizes['size_02'] = array(
            'name' => __('230 x 140 (pixel)', kopa_get_domain()),
            'width' => 230,
            'height' => 140,
            'crop' => true,
            'desc' => __("This size using for blog posts and mobile device", kopa_get_domain())
        );

        $sizes['size_03'] = array(
            'name' => __('445 x 270 (pixel)', kopa_get_domain()),
            'width' => 445,
            'height' => 270,
            'crop' => true,
            'desc' => __("This size using for the most of widgets", kopa_get_domain())
        );

        $sizes['size_04'] = array(
            'name' => __('335 x 470 (pixel)', kopa_get_domain()),
            'width' => 335,
            'height' => 470,
            'crop' => true,
            'desc' => __("This size using for Widget Flex Slider (Small)", kopa_get_domain())
        );

        $sizes['size_05'] = array(
            'name' => __('705 x 430 (pixel)', kopa_get_domain()),
            'width' => 705,
            'height' => 430,
            'crop' => true,
            'desc' => __("This size using for Widget Flex Slider (Small)", kopa_get_domain())
        );

        $sizes['size_06'] = array(
            'name' => __('890 x 545 (pixel)', kopa_get_domain()),
            'width' => 890,
            'height' => 545,
            'crop' => true,
            'desc' => __("This size using for Widget Flex Slider (Medium)", kopa_get_domain())
        );

        $sizes['size_07'] = array(
            'name' => __('1225 x 750 (pixel)', kopa_get_domain()),
            'width' => 1225,
            'height' => 750,
            'crop' => true,
            'desc' => __("This size using for Widget Flex Slider (Large)", kopa_get_domain())
        );


        return apply_filters('kopa_init_get_image_sizes', $sizes);
    }

}

/**
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0         
 */
function kopa_initial_database() {
    $kopa_is_database_setup = get_option(KOPA_OPT_PREFIX . 'database_setup');
    if ($kopa_is_database_setup !== KOPA_INIT_VERSION) {
        $kopa_setting = array(
            'home' => array(
                'layout_slug' => 'blog-page',
                'sidebars' => array(
                    'blog-page' => array(
                        'sidebar_1',
                        'sidebar_4',
                        'sidebar_hide',
                        'sidebar_hide',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                )
            ),
            'front-page' => array(
                'layout_slug' => 'front-page',
                'sidebars' => array(
                    'front-page' => array(
                        'sidebar_1',
                        'sidebar_2',
                        'sidebar_3',
                        'sidebar_4',
                        'sidebar_5',
                        'sidebar_6',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                ),
            ),
            'post' => array(
                'layout_slug' => 'single-post',
                'sidebars' => array(
                    'single-post' => array(
                        'sidebar_1',
                        'sidebar_4',
                        'sidebar_hide',
                        'sidebar_hide',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                ),
            ),
            'page' => array(
                'layout_slug' => 'static-page',
                'sidebars' => array(
                    'static-page' => array(
                        'sidebar_1',
                        'sidebar_4',
                        'sidebar_hide',
                        'sidebar_hide',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    ),
                    'front-page' => array(
                        'sidebar_1',
                        'sidebar_2',
                        'sidebar_3',
                        'sidebar_4',
                        'sidebar_5',
                        'sidebar_6',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                ),
            ),
            'taxonomy' => array(
                'layout_slug' => 'blog-page',
                'sidebars' => array(
                    'blog-page' => array(
                        'sidebar_1',
                        'sidebar_4',
                        'sidebar_hide',
                        'sidebar_hide',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                )
            ),
            'author' => array(
                'layout_slug' => 'blog-page',
                'sidebars' => array(
                    'blog-page' => array(
                        'sidebar_1',
                        'sidebar_4',
                        'sidebar_hide',
                        'sidebar_hide',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                )
            ),
            'search' => array(
                'layout_slug' => 'blog-page',
                'sidebars' => array(
                    'blog-page' => array(
                        'sidebar_1',
                        'sidebar_4',
                        'sidebar_hide',
                        'sidebar_hide',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                )
            ),
            'archive' => array(
                'layout_slug' => 'blog-page',
                'sidebars' => array(
                    'blog-page' => array(
                        'sidebar_1',
                        'sidebar_4',
                        'sidebar_hide',
                        'sidebar_hide',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                )
            ),
            '_404' => array(
                'layout_slug' => 'error-404',
                'sidebars' => array(
                    'error-404' => array(
                        'sidebar_hide',
                        'sidebar_7',
                        'sidebar_8',
                        'sidebar_9',
                        'sidebar_10',
                        'sidebar_11'
                    )
                ),
            )
        );

        $kopa_sidebar = KopaInit::get_sidebars();
        update_option(KOPA_OPT_PREFIX . 'layout_settings', $kopa_setting);
        update_option(KOPA_OPT_PREFIX . 'sidebars', $kopa_sidebar);
        update_option(KOPA_OPT_PREFIX . 'database_setup', KOPA_INIT_VERSION);

        $saved_opts = get_option(KOPA_OPT_PREFIX . 'options');
        if (!$saved_opts) {
            $tabs = KopaInit::get_theme_option_fields();
            $opts = array();

            foreach ($tabs as $tab) {
                foreach ($tab['groups'] as $groups) {
                    foreach ($groups['fields'] as $field) {
                        kopa_save_theme_options_loop($field, $opts);
                    }
                }
            }

            update_option(KOPA_OPT_PREFIX . 'options', $opts);
        }
    }

    $sidebars = get_option(KOPA_OPT_PREFIX . 'sidebars');

    foreach ($sidebars as $key => $value) {
        if ('sidebar_hide' != $key) {
            $sidebar_args = KopaInit::get_sidebar_args();
            $sidebar_args['name'] = $value;
            $sidebar_args['id'] = $key;
            register_sidebar($sidebar_args);
        }
    }
}