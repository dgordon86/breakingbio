<?php

class KopaUtil {

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function log($message) {
        if (WP_DEBUG === true) {
            if (is_array($message) || is_object($message)) {
                error_log(print_r($message, true));
            } else {
                error_log($message);
            }
        }
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_image_src($post_id = 0, $size = 'thumbnail') {
        $thumb = get_the_post_thumbnail($post_id, $size);
        if (!empty($thumb)) {
            $_thumb = array();
            $regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
            preg_match($regex, $thumb, $_thumb);
            $thumb = $_thumb[2];
        }
        return $thumb;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_the_terms($post_id, $taxonomy = 'category', $separator = ', ', $class = 'meta-taxonomy', $echo = TRUE) {
        $html = array();
        $terms = get_the_terms($post_id, $taxonomy);
        if ($terms) {
            foreach ($terms as $term) {
                $html[] = '<a class="' . $class . '" href="' . get_term_link($term, $taxonomy) . '" title="' . sprintf(__("View all posts in %s", kopa_get_domain()), $term->name) . '" ' . '>' . $term->name . '</a>';
            }
        }
        if (count($html)):
            if ($echo)
                echo implode($separator, $html);
            else
                return implode($separator, $html);
        endif;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_client_IP() {
        $IP = NULL;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //check if IP is from shared Internet
            $IP = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //check if IP is passed from proxy
            $ip_array = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            $IP = trim($ip_array[count($ip_array) - 1]);
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            //standard IP check
            $IP = $_SERVER['REMOTE_ADDR'];
        }
        return $IP;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_post_meta($post_id, $key = '', $single = false, $type = 'String', $default = '') {
        $data = get_post_meta($post_id, $key, $single);
        switch ($type) {
            case 'Int':
                return ($data) ? (int) $data : $default;
                break;
            default:
                return ($data) ? $data : $default;
                break;
        }
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function convert_hex2rgba($color, $opacity = false) {
        $default = 'rgb(0,0,0)';
        //Return default if no color provided
        if (empty($color))
            return $default;
        //Sanitize $color if "#" is provided 
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }
        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);
        //Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }
        //Return rgb(a) color string
        return $output;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function adjust_color_lighten_darken($color_code, $percentage_adjuster = 0) {
        $percentage_adjuster = round($percentage_adjuster / 100, 2);
        if (is_array($color_code)) {
            $r = $color_code["r"] - (round($color_code["r"]) * $percentage_adjuster);
            $g = $color_code["g"] - (round($color_code["g"]) * $percentage_adjuster);
            $b = $color_code["b"] - (round($color_code["b"]) * $percentage_adjuster);

            return array("r" => round(max(0, min(255, $r))),
                "g" => round(max(0, min(255, $g))),
                "b" => round(max(0, min(255, $b))));
        } else if (preg_match("/#/", $color_code)) {
            $hex = str_replace("#", "", $color_code);
            $r = (strlen($hex) == 3) ? hexdec(substr($hex, 0, 1) . substr($hex, 0, 1)) : hexdec(substr($hex, 0, 2));
            $g = (strlen($hex) == 3) ? hexdec(substr($hex, 1, 1) . substr($hex, 1, 1)) : hexdec(substr($hex, 2, 2));
            $b = (strlen($hex) == 3) ? hexdec(substr($hex, 2, 1) . substr($hex, 2, 1)) : hexdec(substr($hex, 4, 2));
            $r = round($r - ($r * $percentage_adjuster));
            $g = round($g - ($g * $percentage_adjuster));
            $b = round($b - ($b * $percentage_adjuster));

            return "#" . str_pad(dechex(max(0, min(255, $r))), 2, "0", STR_PAD_LEFT)
                    . str_pad(dechex(max(0, min(255, $g))), 2, "0", STR_PAD_LEFT)
                    . str_pad(dechex(max(0, min(255, $b))), 2, "0", STR_PAD_LEFT);
        }
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function substr($excerpt, $lenght = 100) {
        $excerpt = preg_replace(" (\[.*?\])", '', $excerpt);
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = strip_tags($excerpt);

        if (strlen($excerpt) > $lenght) {
            $excerpt = substr($excerpt, 0, $lenght);
            $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
            $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
        }
        return $excerpt;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_shortcode($content, $enable_multi = false, $shortcodes = array()) {
        $media = array();
        $regex_matches = '';
        $regex_pattern = get_shortcode_regex();
        preg_match_all('/' . $regex_pattern . '/s', $content, $regex_matches);

        foreach ($regex_matches[0] as $shortcode) {
            $regex_matches_new = '';
            preg_match('/' . $regex_pattern . '/s', $shortcode, $regex_matches_new);

            if (in_array($regex_matches_new[2], $shortcodes)) :
                $media[] = array(
                    'shortcode' => $regex_matches_new[0],
                    'type' => $regex_matches_new[2],
                    'content' => $regex_matches_new[5],
                    'atts' => shortcode_parse_atts($regex_matches_new[3])
                );

                if (false == $enable_multi) {
                    break;
                }
            endif;
        }

        return $media;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_audio($content = '', $shortcodes = array('audio', 'soundcloud')) {
        $audio = array();

        if (!empty($content)) {
            $shortcode = self::get_shortcode($content, false, $shortcodes);
            if (!empty($shortcode)) {
                $audio['type'] = $shortcode[0]['type'];
                $audio['shortcode'] = $shortcode[0]['shortcode'];
                switch ($audio['type']) {
                    case 'audio':
                        $audio['mp3'] = $shortcode[0]['atts']['mp3'];
                        break;
                }
            }
        }

        return $audio;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_video($content = '', $shortcodes = array('youtube', 'vimeo', 'video')) {
        $video = array();

        if (!empty($content)) {
            $shortcode = self::get_shortcode($content, false, $shortcodes);
            if (!empty($shortcode)) {
                $video['type'] = $shortcode[0]['type'];
                $video['shortcode'] = $shortcode[0]['shortcode'];
                switch ($video['type']) {
                    case 'youtube':
                    case 'vimeo':
                        $video['url'] = $shortcode[0]['atts']['url'];
                        break;
                    case 'video':
                        $video['url']['mp4'] = isset($shortcode[0]['atts']['mp4']) ? $shortcode[0]['atts']['mp4'] : '';
                        $video['url']['webm'] = isset($shortcode[0]['atts']['webm']) ? $shortcode[0]['atts']['webm'] : '';
                        $video['url']['m4v'] = isset($shortcode[0]['atts']['m4v']) ? $shortcode[0]['atts']['m4v'] : '';
                        $video['url']['ogv'] = isset($shortcode[0]['atts']['ogv']) ? $shortcode[0]['atts']['ogv'] : '';
                        $video['url']['wmv'] = isset($shortcode[0]['atts']['wmv']) ? $shortcode[0]['atts']['wmv'] : '';
                        $video['url']['flv'] = isset($shortcode[0]['atts']['flv']) ? $shortcode[0]['atts']['flv'] : '';
                        break;
                }
            }
        }

        return $video;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function str_beautify($string) {
        return ucwords(str_replace('_', ' ', $string));
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function str_uglify($string) {
        $string = preg_replace('/\s+/', ' ', $string);
        $string = preg_replace("/[^a-zA-Z0-9\s]/", '', $string);
        return strtolower(str_replace(' ', '_', $string));
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_theme_info() {
        $xml = new stdClass();
        $xml->version = '1.0';
        $xml->name = 'Passion';
        $xml->download = '';
        $xml->changelog = '';
        try {
            $db_cache_field = KOPA_OPT_PREFIX . 'notifier_cache';
            $db_cache_field_last_updated = KOPA_OPT_PREFIX . 'notifier_last_updated';

            $last = get_option($db_cache_field_last_updated);
            $now = time();
            if (!$last || (( $now - $last ) > KOPA_UPDATE_TIMEOUT)) {
                if (function_exists('curl_init')) {
                    $ch = curl_init(KOPA_UPDATE_URL);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    $cache = curl_exec($ch);
                    curl_close($ch);
                } else {
                    $cache = file_get_contents(KOPA_UPDATE_URL);
                }
                if ($cache) {
                    update_option($db_cache_field, $cache);
                    update_option($db_cache_field_last_updated, time());
                }
                $notifier_data = get_option($db_cache_field);
            } else {
                $notifier_data = get_option($db_cache_field);
            }
            $xml = simplexml_load_string($notifier_data);
        } catch (Exception $e) {
            error_log($e);
        }
        return $xml;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_views($post_id, $return_only_number = false) {
        $meta_key = KOPA_OPT_PREFIX . 'total_view';
        $count = KopaUtil::get_post_meta($post_id, $meta_key, true, 'Int', 0);
        if ($return_only_number) {
            return $count;
        } else {
            if ($count <= 1) {
                return sprintf(__('%1$s View', kopa_get_domain()), $count);
            } else {
                return sprintf(__('%1$s Views', kopa_get_domain()), $count);
            }
        }
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function set_views($post_id) {
        $new_view_count = 0;
        $meta_key = KOPA_OPT_PREFIX . 'total_view';
        $current_views = (int) get_post_meta($post_id, $meta_key, true);
        if ($current_views) {
            $new_view_count = $current_views + 1;
            update_post_meta($post_id, $meta_key, $new_view_count);
        } else {
            $new_view_count = 1;
            add_post_meta($post_id, $meta_key, $new_view_count);
        }
        return $new_view_count;
    }

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_comments($post_id) {
        $count = NULL;

        if (comments_open($post_id)) {
            $comment_number = (int) get_comments_number($post_id);
            switch ($comment_number) {
                case 0:
                    $count = __('Comment Now', kopa_get_domain());
                    break;
                case 1:
                    $count = sprintf('%s %s', $comment_number, __('Comment', kopa_get_domain()));
                    break;
                default:
                    $count = sprintf('%s %s', $comment_number, __('Comments', kopa_get_domain()));
                    break;
            }
        } else {
            $count = __('Comment Off', kopa_get_domain());
        }
        return apply_filters('kopa_util_get_comments', $count);
    }

}