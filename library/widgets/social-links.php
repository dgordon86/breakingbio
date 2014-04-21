<?php

class KopaSocialLinks extends KopaWidget {

    public function __construct() {
        $id_base = 'kopa_social_links';
        $name = __('Kopa Social Links', kopa_get_domain());
        $widget_options = array('classname' => 'kopa-social-links', 'description' => __('Display your social links', kopa_get_domain()));
        $control_options = array('width' => 'auto', 'height' => 'auto');
        parent::__construct($id_base, $name, $widget_options, $control_options);

        $col_1 = array(
            'size' => 12,
            'fields' => array()
        );

        $col_1['fields']['title'] = array(
            'type' => 'text',
            'id' => 'title',
            'name' => 'title',
            'default' => '',
            'classes' => array(),
            'label' => __('Title', kopa_get_domain()),
            'help' => NULL
        );

        $col_1['fields']['is_use_color'] = array(
            'type' => 'checkbox',
            'id' => 'is_use_color',
            'name' => 'is_use_color',
            'default' => 'false',
            'classes' => array(),
            'label' => __('Is display icon color', kopa_get_domain()),
            'help' => NULL,
            'is_append_label_before_control' => false
        );

        $this->groups['col-1'] = $col_1;
    }

    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $social_links = KopaInit::get_social_icons();
        echo '<div class="kopa-social-link-wrapper clearfix">';
        foreach ($social_links as $slug => $info) {
            $href = KopaOptions::get_option("social_link_{$slug}");

            if ('rss' == $slug) {
                if (empty($href)) {
                    $href = get_bloginfo_rss('rss2_url');
                } elseif ('HIDE' == $href) {
                    $href = '';
                }
            }

            $style = ('true' == $instance['is_use_color']) ? sprintf('style="color:%1$s; border-color:%1$s;"', $info['color']) : '';            
            
            if (!empty($href)) {
                printf('<a class="kopa-social-link pull-left" href="%1$s" target="_blank" title="%2$s" %3$s><i class="%4$s"></i></a>', $href, $info['title'], $style, $info['icon']);
            }
        }
        echo '</div>';

        echo $after_widget;
    }

}