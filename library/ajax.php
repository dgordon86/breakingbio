<?php

if (!function_exists('kopa_add_sidebar')) {
    add_action('wp_ajax_kopa_add_sidebar', 'kopa_add_sidebar');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_add_sidebar() {
        check_ajax_referer('kopa_add_sidebar', 'ajax_nonce');

        $new_sidebar = $_POST['new_sidebar'];
        $new_sidebar_slug = KopaUtil::str_uglify($new_sidebar);

        $result = array();
        $result['log'] = '';
        $result['html'] = '';

        // check exists with hidden sidebar
        if ('sidebar_hide' == $new_sidebar_slug) {
            $result['log'] = __('This sidebar is existing. Please enter other name.', kopa_get_domain());
        } else {
            //get all sidebars
            $sidebars = get_option(KOPA_OPT_PREFIX . 'sidebars');
            $exist_sidebars = array_keys($sidebars);

            // check exists with current sidebars
            if (in_array($new_sidebar_slug, $exist_sidebars)) {
                $result['log'] = __('This sidebar is existing. Please enter other name.', kopa_get_domain());
            } else {
                // add new
                $sidebars[$new_sidebar_slug] = $new_sidebar;
                update_option(KOPA_OPT_PREFIX . 'sidebars', $sidebars);

                // return html
                $result['html'] = '<tr>';
                $result['html'].= sprintf('<td><span>%s<span></td>', $new_sidebar);
                $result['html'].= sprintf('<td><a href="#" onclick="KopaSidebar.rename(event, jQuery(this),\'%s\');" class="btn btn-success btn-sm"><i class="dashicons dashicons-edit"></i></a></td>', $new_sidebar_slug);
                $result['html'].= sprintf('<td><a href="#" onclick="KopaSidebar.remove(event, jQuery(this),\'%s\',\'%s\');" class="btn btn-danger btn-sm"><i class="dashicons dashicons-trash"></i></a></td>', $new_sidebar_slug, $new_sidebar);
                $result['html'].= '</tr>';
            }
        }

        echo json_encode($result);
        exit();
    }

}

if (!function_exists('kopa_remove_sidebar')) {
    add_action('wp_ajax_kopa_remove_sidebar', 'kopa_remove_sidebar');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_remove_sidebar() {
        check_ajax_referer('kopa_remove_sidebar', 'ajax_nonce');

        $sidebar_slug = $_POST['sidebar_slug'];

        $result = array();
        $result['log'] = '';

        // check exists with hidden sidebar
        if ('sidebar_hide' == $sidebar_slug) {
            $result['log'] = __('This sidebar is existing. Please enter other name.', kopa_get_domain());
        } else {
            $is_using = false;

            $layout_settings = get_option(KOPA_OPT_PREFIX . 'layout_settings');
            foreach ($layout_settings as $template => $setting) {
                $current_layout = $setting['layout_slug'];
                $sidebar_in_use = $setting['sidebars'][$current_layout];
                if (in_array($sidebar_slug, $sidebar_in_use)) {
                    $is_using = true;
                    $result['log'] = sprintf(__('This sidebar is using for Template: %s - Layout: %s.', kopa_get_domain()), $template, $current_layout);
                    break;
                }
            }




            if (!$is_using) {
                //get all sidebars
                $sidebars = get_option(KOPA_OPT_PREFIX . 'sidebars');
                //remove a sidebar by sidebar_slug
                unset($sidebars[$sidebar_slug]);
                //update sidebar list to database
                update_option(KOPA_OPT_PREFIX . 'sidebars', $sidebars);
            }
        }

        echo json_encode($result);

        exit();
    }

}

if (!function_exists('kopa_rename_sidebar')) {
    add_action('wp_ajax_kopa_rename_sidebar', 'kopa_rename_sidebar');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_rename_sidebar() {
        check_ajax_referer('kopa_rename_sidebar', 'ajax_nonce');
        $sidebar_slug = $_POST['sidebar_slug'];
        $new_sidebar_name = $_POST['new_sidebar_name'];

        $sidebars = get_option(KOPA_OPT_PREFIX . 'sidebars');
        $sidebars[$sidebar_slug] = $new_sidebar_name;
        update_option(KOPA_OPT_PREFIX . 'sidebars', $sidebars);

        exit();
    }

}

if (!function_exists('kopa_save_theme_options')) {
    add_action('wp_ajax_kopa_save_theme_options', 'kopa_save_theme_options');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_save_theme_options() {
        check_ajax_referer('kopa_save_theme_options', 'ajax_nonce');

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
        exit();
    }

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_save_theme_options_loop($field, &$opts) {
        $name = $field['name'];
        $data = (isset($_POST[$name])) ? $_POST[$name] : (isset($field['default']) ? $field['default'] : '');
        $value = KopaControl::filter_post_data($field, $data);

        $opts[$name] = $value;

        if (isset($field['sub_fields'])) {
            $sub_fields = $field['sub_fields'];
            foreach ($sub_fields as $sub_field) {
                kopa_save_theme_options_loop($sub_field, $opts);
            }
        }

        if ('radio-list' == $field['type']) {
            $options = $field['options'];
            if ($options) {
                foreach ($options as $option) {
                    if (isset($option['sub_fields'])) {
                        foreach ($option['sub_fields'] as $sub_field) {
                            kopa_save_theme_options_loop($sub_field, $opts);
                        }
                    }
                }
            }
        }
    }

}

if (!function_exists('kopa_reset_theme_options')) {
    add_action('wp_ajax_kopa_reset_theme_options', 'kopa_reset_theme_options');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_reset_theme_options() {
        check_ajax_referer('kopa_reset_theme_options', 'ajax_nonce');

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
        exit();
    }

}

if (!function_exists('kopa_save_layout_setting')) {
    add_action('wp_ajax_kopa_save_layout_setting', 'kopa_save_layout_setting');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_save_layout_setting() {
        check_ajax_referer('kopa_save_layout_setting', 'ajax_nonce');

        $kopa_template_hierarchy = KopaInit::get_template_hierarchy();

        $data = $_POST;
        $new_data = array();
        foreach ($kopa_template_hierarchy as $slug => $info) {
            $new_data[$slug] = $data[$slug];
        }

        update_option(KOPA_OPT_PREFIX . 'layout_settings', $new_data);

        exit();
    }

}

if (!function_exists('kopa_send_contact')) {
    add_action('wp_ajax_kopa_send_contact', 'kopa_send_contact');
    add_action('wp_ajax_nopriv_kopa_send_contact', 'kopa_send_contact');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_send_contact() {
        check_ajax_referer('kopa_send_contact', 'ajax_nonce');
        foreach ($_POST as $key => $value) {
            if (ini_get('magic_quotes_gpc')) {
                $_POST[$key] = stripslashes($_POST[$key]);
            }
            $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
        }

        $name = $_POST["contact_name"];
        $email = $_POST["contact_email"];
        $url = $_POST["contact_url"];
        $message = $_POST["contact_message"];


        $mail_template = html_entity_decode(stripcslashes(KopaOptions::get_option('contact_reply_template', '<p>Aloha!</p><p>You have a new message from  [contact_name] ([contact_email] : [contact_url])</p><div>[contact_message]</div><p>Thanks!</p>')));

        $body = str_replace('[contact_name]', $name, $mail_template);
        $body = str_replace('[contact_email]', $email, $body);
        $body = str_replace('[contact_url]', sprintf('<a href="mailto:%1$s">%1$s</a>', $url), $body);
        $body = str_replace('[contact_message]', $message, $body);

        $to = get_option('__contact_email', get_bloginfo('admin_email'));
        $subject = __("Contact Form:", kopa_get_domain()) . " $name";

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= sprintf('To: %1$s', $to) . "\r\n";
        $headers .= sprintf('From: %1$s', $email) . "\r\n";
        $headers .= sprintf('Cc: %1$s', $email) . "\r\n";

        $result = '<p class="failure">' . __('Oops! errors occured. Please try again ...', kopa_get_domain()) . '</p>';
        if (wp_mail($to, $subject, $body, $headers)) {
            $result = '<p class="success">' . __('Success! Your email address has been sent.', kopa_get_domain()) . '</p>';
        }

        echo $result;

        exit();
    }

}

if (!function_exists('kopa_check_recaptcha')) {
    add_action('wp_ajax_kopa_check_recaptcha', 'kopa_check_recaptcha');
    add_action('wp_ajax_nopriv_kopa_check_recaptcha', 'kopa_check_recaptcha');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_check_recaptcha() {
        check_ajax_referer('kopa_check_recaptcha', 'ajax_nonce_recaptcha');

        $recaptcha_skin = KopaOptions::get_option('recaptcha_skin', 'off');
        $publickey = KopaOptions::get_option('recaptcha_public_key');
        $privatekey = KopaOptions::get_option('recaptcha_private_key');

        $data['is_valid'] = false;

        if ('off' != $recaptcha_skin && $publickey && $privatekey) {
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge"], $_POST["recaptcha_response"]);
            $data['is_valid'] = $resp->is_valid;
        }

        echo json_encode($data);

        exit();
    }

}


if (!function_exists('kopa_set_view_count')) {

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_set_view_count() {
        check_ajax_referer('kopa_set_view_count', 'wpnonce');
        if (!empty($_POST['post_id'])) {
            $post_id = (int) $_POST['post_id'];
            $data['count'] = KopaUtil::set_views($post_id);
            echo json_encode($data);
        }
        die();
    }

    add_action('wp_ajax_kopa_set_view_count', 'kopa_set_view_count');
    add_action('wp_ajax_nopriv_kopa_set_view_count', 'kopa_set_view_count');
}

if (!function_exists('kopa_load_post')) {
    add_action('wp_ajax_kopa_load_post', 'kopa_load_post');
    add_action('wp_ajax_nopriv_kopa_load_post', 'kopa_load_post');

    /**
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0         
     */
    function kopa_load_post() {
        check_ajax_referer('kopa_load_post', 'ajax_nonce');

        $post_id = $_GET['post_id'];
        $post_format = $_GET['post_format'];

        $shortcodes = array();

        switch ($post_format) {
            case 'audio':
                $shortcodes = array('audio', 'soundcloud');
                break;
            case 'gallery':
                $shortcodes = array('gallery');
                break;
            case 'video':
                $shortcodes = array('video', 'youtube', 'vimeo');
                break;
        }

        if (!empty($shortcodes)) {
            global $post;
            $post = get_post($post_id);

            $items = KopaUtil::get_shortcode($post->post_content, true, $shortcodes);

            if (!empty($items)) {
                foreach ($items as $item) {
                    echo do_shortcode($item['shortcode']);
                }
            } else {
                echo do_shortcode($post->post_content);
            }

            wp_reset_query();
            wp_reset_postdata();
        } else {
            _e('Content load found', kopa_get_domain());
        }

        exit();
    }

}