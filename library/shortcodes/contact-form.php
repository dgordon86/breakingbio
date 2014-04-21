<?php

add_shortcode('contact_form', 'kopa_shortcode_contact_form');

/**
 * 
 *
 * @package Kopa
 * @subpackage Core
 * @author thethangtran <tranthethang@gmail.com>
 * @since 1.0.0
 *      
 */
function kopa_shortcode_contact_form($atts, $content = null) {
    global $kopa;
    $content = '';

    #Get config information
    $mail = KopaOptions::get_option('contact_email');
    $phone = KopaOptions::get_option('contact_phone');
    $fax = KopaOptions::get_option('contact_fax');
    $address = KopaOptions::get_option('contact_address');
    $google_map = KopaOptions::get_option('contact_map');
    $description = KopaOptions::get_option('contact_description');
    $recaptcha_skin = KopaOptions::get_option('recaptcha_skin', 'off');
    $publickey = KopaOptions::get_option('recaptcha_public_key');
    $privatekey = KopaOptions::get_option('recaptcha_private_key');

    if ($google_map) {
        $maps_arr = explode(',', $google_map);
        if (2 == count($maps_arr)) {
            $content .= sprintf("<div id='kp-map' class='kp-map' data-latitude='%s' data-longitude='%s'></div>", $maps_arr[0], $maps_arr[1]);
        }
    }
    if ($description || $mail || $phone || $fax || $address) {
        $content .= "<div class='kopa-contact-description row'>";
        if ($mail || $phone || $fax || $address) {
            $content .= "<div class='col-sm-6'>{$description}</div>";

            $content .= "<div class='col-sm-6 kopa-contact-information'>";
            if ($mail)
                $content .= sprintf('<p class="kopa-contact-info"><span><i class="kpf-paperplane"></i><span>%1$s</span></span><a href="mailto:%2$s">%2$s</a></p>', __('Email', kopa_get_domain()), $mail);

            if ($phone)
                $content .= sprintf('<p class="kopa-contact-info"><span><i class="kpf-phone"></i><span>%1$s</span></span><a href="tel:%2$s">%2$s</a></p>', __('Phone', kopa_get_domain()), $phone);

            if ($fax)
                $content .= sprintf('<p class="kopa-contact-info"><span><i class="kpf-printer"></i><span>%1$s</span></span>%2$s</p>', __('Fax', kopa_get_domain()), $fax);

            if ($address)
                $content .= sprintf('<p class="kopa-contact-info"><span><i class="kpf-location"></i><span>%1$s</span></span>%2$s</p>', __('Address', kopa_get_domain()), $address);


            $content .= "</div>";
        } else {
            $content .= "<div class='col-sm-12'>{$description}</div>";
        }

        $content .= '</div>';
    }

    $content .= '<div id="contact-box">';

    #HEADING
    $content .= '<h4>' . __('Send to us a message', kopa_get_domain()) . '</h4>';
    $content .= '<form id="contact-form" class ="clearfix" action="' . admin_url('admin-ajax.php') . '" method="post" autocomplete="off">';

    #NAME
    $content .= '<div class="row clearfix">';

    $content .= '<div class="col-md-4">';
    $content .= '<p class="input-block">';
    $content .= '<label for="contact_name" class="required">' . __('Name (<span>required</span>)', kopa_get_domain()) . '</label>';
    $content .= '<input type="text" placeholder="" class="" id="contact_name" name="contact_name">';
    $content .= '</p>';

    #EMAIL
    $content .= '<p class="input-block">';
    $content .= '<label for="contact_email" class="required">' . __('Email (<span>required</span>)', kopa_get_domain()) . '</label>';
    $content .= '<input type="text" placeholder="" class="" id="contact_email" name="contact_email">';
    $content .= '</p>';

    #WEBSITE
    $content .= '<p class="input-block">';
    $content .= '<label for="contact_url" class="required">' . __('Website', kopa_get_domain()) . '</label>';
    $content .= '<input type="text" placeholder="" class="" id="contact_url" name="contact_url">';
    $content .= '</p>';

    $content .= '</div>';

    #MESSAGE
    $content .= '<div class="col-md-8">';
    $content .= '<p class="textarea-block">';
    $content .= '<label for="contact_message" class="required">' . __('Enter your message (<span>required</span>)', kopa_get_domain()) . '</label>';
    $content .= '<textarea placeholder="" class="" id="contact_message" name="contact_message"></textarea>';
    $content .= '</p>';
    $content .= '</div>';

    $content .= '</div>';

    if ('off' != $recaptcha_skin && $publickey && $privatekey) {
        $content .= '<div class="recaptcha-block clearfix">';
        $content .= recaptcha_get_html($publickey);
        $content .= '</div>';
    }

    #SUBMIT
    $content .= '<div class="clear"></div>';
    $content .= '<p class="contact-button">';
    $content .= '<input type="hidden" name="action" value="kopa_send_contact">';
    $content .= wp_nonce_field('kopa_send_contact', 'ajax_nonce', true, false);
    $content .= wp_nonce_field('kopa_check_recaptcha', 'ajax_nonce_recaptcha', false, false);
    $content .= '<input type="submit" name="submit-contact" id="submit-contact" class="btn" value="' . __('Send', kopa_get_domain()) . '">';
    $content .= '</p>';

    $content .= '</form>';

    $content .= '</div>';

    $content .= '<div id="contact_response" class="clearfix"></div>';

    return $content;
}
