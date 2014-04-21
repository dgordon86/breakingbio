<?php

class KopaUIMultiText extends KopaUI {

    /**
     * 
     *
     * @package Kopa
     * @subpackage Core
     * @author thethangtran <tranthethang@gmail.com>
     * @since 1.0.0
     *      
     */
    protected function get_control() {
        $this->classes[] = 'kopa-ui-multi-text';
        $out = sprintf('<ul id="%1$s" class="%2$s">', $this->id, implode(' ', $this->classes));

        if ($this->value) {
            $value = unserialize($this->value);
            if (is_array($value)) {
                $value = array_filter($value);
                if (!empty($value)) {
                    $ids = $value['id'];
                    $features = $value['feature'];
                    for ($i = 0; $i < count($features); $i++) {
                        $out .= $this->_clone($ids[$i], $features[$i]);
                    }
                } else {
                    $out .= $this->_clone();
                }
            } else {
                $out .= $this->_clone();
            }
        } else {
            $out .= $this->_clone();
        }

        $out .= '</ul>';
        return $out;
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
    private function _clone($id = '', $feature = '') {        
        $id = empty($id) ? 'feature-index-' . wp_generate_password(10, false, false) : $id;

        $out = '<li class="clearfix">';
        $out .= sprintf('<i class="button kopa-sortable-handle">%s</i>', __('drag', kopa_get_domain()));
        $out .= sprintf('<input type="hidden" class="feature-id" name="%1$s[id][]" value="%2$s" autocomplete="off"/>', $this->name, $id);
        $out .= sprintf('<input type="text" class="form-control feature-feature" name="%1$s[feature][]" value="%2$s" autocomplete="off"/>', $this->name, $feature);
        $out .= sprintf('<a href="#" class="button button-primary" data-action="add">%1$s</a>', __('+', kopa_get_domain()));
        $out .= sprintf('<a href="#" class="button" data-action="delete">%1$s</a>', __('-', kopa_get_domain()));
        $out .= '</li>';

        return $out;
    }

}