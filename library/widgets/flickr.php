<?php

class KopaFlickr extends KopaWidget {

    public function __construct() {
        $id_base = 'kopa_flickr';
        $name = __('Kopa Flickr', kopa_get_domain());
        $widget_options = array('classname' => 'kp-flickr-widget', 'description' => __('Display list photo from flickr', kopa_get_domain()));
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

        $col_1['fields']['id'] = array(
            'type' => 'text',
            'id' => 'id',
            'name' => 'id',
            'default' => '71865026@N00',
            'classes' => array(),
            'label' => __('ID', kopa_get_domain()),
            'help' => __('Get your flickr ID. Click <a href="http://idgettr.com/" target="_blank">here</a>', kopa_get_domain())
        );

        $col_1['fields']['limit'] = array(
            'type' => 'number',
            'id' => 'limit',
            'name' => 'limit',
            'default' => '12',
            'classes' => array(),
            'label' => __('Number of photos', kopa_get_domain()),
            'help' => NULL
        );

        $this->groups['col-1'] = $col_1;
    }

    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        $id = $instance['id'];
        $limit = $instance['limit'];

        $out = sprintf('<div class="flickr-wrap clearfix" data-id="%s" data-limit="%s" data-tag="">', $id, $limit);
        $out .= '<ul class="clearfix list-unstyled"></ul>';
        $out .= '</div>';


        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        echo apply_filters('kopa_flickr_widget', $out);
        echo $after_widget;
    }

}