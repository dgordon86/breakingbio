<?php

class KopaOptions {

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    public static function get_option($key, $default = NULL) {
        global $kopaOptions;
        $value = $default;

        if (!isset($kopaOptions) || empty($kopaOptions)) {
            $kopaOptions = get_option(KOPA_OPT_PREFIX . 'options');
        }

        if (isset($kopaOptions[$key])) {
            $value = $kopaOptions[$key];
        }

        return $value;
    }

}