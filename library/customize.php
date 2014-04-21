<?php

if (!is_admin())
    require_once get_template_directory() . '/library/cpanel/theme-options/typography.php';


new KopaCustomize();

class KopaCustomize {

    /**
     * An array include custom colors - selected by admin
     *
     * @var array
     */
    public $color_scheme;

    /**
     * An array include custom font (family, size, weight, line-height) - selected by admin
     * 
     * @var array
     */
    public $typography;

    public function __construct() {
        $this->color_scheme = KopaOptions::get_option('colors', '#222222');
        $this->typography = array();

        add_filter('body_class', array(&$this, 'body_class'));
        add_action('wp_footer', array(&$this, 'wp_footer'), 20);
        add_action('admin_enqueue_scripts', array(&$this, 'theme_options_enqueue'));
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
    }

    /**
     * Modify body classes by theme-option
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     * 
     * @param array
     * @return array
     */
    function body_class($classes) {
        return $classes;
    }

    /**
     * Print custom style from Color Scheme, Typography, Custom CSS
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     * @return NULL
     */
    function wp_footer() {
        $css = array();

        $primary_colors = KopaOptions::get_option('primary_color', '#222222');
        $link_color = KopaOptions::get_option('link_color', '#222222');
        $link_color_hover = KopaOptions::get_option('link_color_hover', '#ed1c24');
        $text_color = KopaOptions::get_option('text_color', '#666666');
        $heading_color = KopaOptions::get_option('heading_color', '#222222');
        $nav_link_color = KopaOptions::get_option('nav_link_color', '#222222');
        $nav_link_hover_color = KopaOptions::get_option('nav_link_hover_color', '#ed1c24');
        $icon_color = KopaOptions::get_option('icon_color', '#6A6A6A');

        /* primary color */
        $css['.kp-headline-title']['color'] = $primary_colors;
        $css['.header-bottom']['border-top-color'] = $primary_colors;
        $css['#bottom-sidebar']['border-top-color'] = $primary_colors;
        $css['#main-menu li.home-menu-icon a']['background-color'] = $primary_colors;
        $css['.kp-button:hover']['background-color'] = $primary_colors;
        $css['.kp-bline-button:hover']['background-color'] = $primary_colors;
        $css['.kp-dropcap']['background-color'] = $primary_colors;
        $css['.kp-dropcap.radius']['background-color'] = $primary_colors;
        $css['.kopa-tabs .nav-tabs > li.active a']['background-color'] = $primary_colors;
        $css['.kopa-tabs .nav-tabs > li:hover a']['background-color'] = $primary_colors;
        $css['.panel-heading.active']['border-bottom-color'] = $primary_colors;
        $css['.panel-heading .panel-title span.kopa-collapse']['color'] = $primary_colors;
        $css['#back-top a:hover']['background-color'] = $primary_colors;
        $css['.tooltip-inner']['background-color'] = $primary_colors;
        $css['.tooltip.top .tooltip-arrow']['border-top-color'] = $primary_colors;
        $css['.main-pagination span.page-numbers.current']['color'] = $primary_colors;
        $css['blockquote']['border-left-color'] = $primary_colors;
        $css['p.kopa-contact-info > span > i']['color'] = $primary_colors;
        $css['.fotorama__thumb-border']['border-color'] = $primary_colors;

        /* icon post format color */
        $css['.entry-icon']['color'] = $icon_color . ' !important';

        /* link color */
        $css['a']['color'] = $link_color;
        $css['a:hover']['color'] = $link_color_hover;
        $css['.widget_calendar tbody a']['color'] = $link_color_hover;

        /* text color */
        $css['body']['color'] = $text_color;

        /* heading color */
        $css['h1']['color'] = $heading_color;
        $css['h2']['color'] = $heading_color;
        $css['h3']['color'] = $heading_color;
        $css['h4']['color'] = $heading_color;
        $css['h5']['color'] = $heading_color;
        $css['h6']['color'] = $heading_color;

        /* navigation link color */
        $css['#main-menu li a']['color'] = $nav_link_color;

        /* navigation link color hover */
        $css['#main-menu li a:hover']['color'] = $nav_link_hover_color;

        $typo_selector = array();
        foreach ($this->typography as $slug => $typo) {
            if ('off' != $typo['family']) {
                switch ($slug) {
                    case 'body_font':
                        $typo_selector[$slug] = 'body';
                        break;
                    case 'widget_title_main_font':
                        $typo_selector[$slug] = '.main-content .widget .widget-title';
                        break;
                    case 'widget_title_footer_font':
                        $typo_selector[$slug] = '#bottom-sidebar .widget .widget-title';
                        break;
                    case 'entry_title_font':
                        $typo_selector[$slug] = '.entry-box h1.entry-title';
                        break;
                    case 'entry_content_font':
                        $typo_selector[$slug] = '.entry-box .entry-content, .entry-box .entry-content p';
                        break;
                    case 'nav_top_font':
                        $typo_selector[$slug] = '#top-menu li a';
                        break;
                    case 'nav_bottom_font':
                        $typo_selector[$slug] = '#bottom-menu li a';
                        break;
                    case 'nav_primary_font':
                        $typo_selector[$slug] = '#main-menu li a';
                        break;
                    case 'nav_secondary_font':
                        $typo_selector[$slug] = '#secondary-menu li a';
                        break;
                    case 'h1_font':
                        $typo_selector[$slug] = 'h1';
                        break;
                    case 'h2_font':
                        $typo_selector[$slug] = 'h2';
                        break;
                    case 'h3_font':
                        $typo_selector[$slug] = 'h3';
                        break;
                    case 'h4_font':
                        $typo_selector[$slug] = 'h4';
                        break;
                    case 'h5_font':
                        $typo_selector[$slug] = 'h5';
                        break;
                    case 'h6_font':
                        $typo_selector[$slug] = 'h6';
                        break;
                }
            }
        }

        if (!empty($typo_selector)) {
            foreach ($typo_selector as $slug => $selector) {
                $css[$selector]['font-family'] = "'{$this->typography[$slug]['family']}'";
                $css[$selector]['font-size'] = $this->typography[$slug]['size'] . 'px';
                $css[$selector]['font-weight'] = $this->typography[$slug]['weight'];
                $css[$selector]['line-height'] = $this->typography[$slug]['line-height'] . 'px';
                $css[$selector]['text-transform'] = $this->typography[$slug]['text-transform'];
            }
        }

        if ('true' != KopaOptions::get_option('is_lightbox_show_title', 'true')) {
            $css['.pp_description']['display'] = 'none !important';
        }

        #MARGIN FOR LOGO
        $css['#logo-image']['margin-top'] = sprintf('%spx', KopaOptions::get_option('logo_margin_top', 40));
        $css['#logo-image']['margin-bottom'] = sprintf('%spx', KopaOptions::get_option('logo_margin_bottom', 10));
        $css['#logo-image']['margin-left'] = sprintf('%spx', KopaOptions::get_option('logo_margin_left', 0));
        $css['#logo-image']['margin-right'] = sprintf('%spx', KopaOptions::get_option('logo_margin_right', 0));

        $css = apply_filters('kopa_customize', $css);

        #PRINT CUSTOMIZE RULES     
        if (!empty($css)) {
            $out = '';
            foreach ($css as $element => $rules) {
                $tmp = '';
                foreach ($rules as $rule => $value) {
                    $tmp .= sprintf('%s : %s;', $rule, $value);
                }
                $out .= sprintf('%s{%s}', $element, $tmp);
            }

            printf('<style id="kopa-customize-style" type="text/css">%s</style>', $out);
        }

        #PRINT CUSTOMIZE CSS (from theme options)
        $custom_css = htmlspecialchars_decode(stripslashes(KopaOptions::get_option('custom_css')));
        if ($custom_css)
            printf('<style type="text/css">%s</style>', $custom_css);

        printf('<link rel="stylesheet"  media="all" type="text/css" href="%s"></script>', get_template_directory_uri() . '/assets/media-element/skin/skin.css');
    }

    /**
     * Enqueue customize scripts (or style) for frontend
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     * 
     * @param string
     * @return NULl
     */
    function enqueue_scripts($hook) {
        $this->load_font();
    }

    /**
     * Enqueue customize scripts (or style) for backend
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     * 
     * @param string
     * @return NULl
     */
    function theme_options_enqueue($hook) {
        if ('toplevel_page_kopa_cpanel_theme_options' == $hook) {
            $this->load_font();
        }
    }

    /**
     * Enqueue custom font - selected by admin
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     * @return NULl
     */
    function load_font() {
        global $google_font;
        $typos = kopa_options_typography();
        foreach ($typos as $group) {
            foreach ($group['fields'] as $field) {
                if ('font' == $field['type']) {
                    $value = KopaOptions::get_option($field['name'], $field['default']);
                    if (isset($value) || !empty($value)) {
                        if ('off' != $value['family']) {
                            $font_family = str_replace(' ', '+', $google_font['items'][$value['family']]['family']);
                            $cssID = sprintf('css-dynamic-%s-family', $field['name']);
                            $tmp = sprintf('http://fonts.googleapis.com/css?family=%s:%s', $font_family, $value['weight']);

                            wp_enqueue_style($cssID, $tmp);

                            $this->typography[$field['name']] = $value;
                            $this->typography[$field['name']]['family'] = $google_font['items'][$value['family']]['family'];
                        }
                    }
                }
            }
        }

        if (!isset($this->typography['nav_font'])) {
            wp_enqueue_style('css-default-nav-font', 'http://fonts.googleapis.com/css?family=Oswald:400,300,700');
        }
    }

}