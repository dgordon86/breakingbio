<?php
class KopaNewsletter extends KopaWidget {
    
    public function __construct() {
        $id_base = 'kopa_newsletter';
        $name = __('Kopa Newsletter', kopa_get_domain());
        $widget_options = array('classname' => 'kp-newsletter-widget', 'description' => __('Display email subscriptions form (by http://feedburner.google.com)', kopa_get_domain()));
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

        $col_1['fields']['uri'] = array(
            'type' => 'text',
            'id' => 'uri',
            'name' => 'uri',
            'default' => 'KopaTheme',
            'classes' => array(),
            'label' => __('URI', kopa_get_domain())
        );

        $col_1['fields']['description'] = array(
            'type' => 'textarea',
            'id' => 'description',
            'name' => 'description',
            'default' => '',
            'classes' => array(),
            'label' => __('Description', kopa_get_domain())
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
        $uri = $instance['uri'];        
        $description = $instance['description'];

        if ($uri) {
            ?>
            <form class="newsletter-form clearfix" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $uri; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520'); return true;">        
                      <?php                      
                      echo ($description) ? "<p>{$description}</p>" : '';
                      ?>
                <p class="input-email clearfix">
                    <input type="text" name="email" value="" placeholder="<?php _e('Your Emails', kopa_get_domain()); ?>" class="email">                
                    <input type="hidden" value="<?php echo $uri; ?>" name="uri"/>
                    <input type="hidden" name="loc" value="en_US"/>                
                    <input type="submit" value="<?php _e('Subscribe', kopa_get_domain()); ?>" class="submit">
                </p>                    
            </form>
            <?php
        }
        echo $after_widget;
    }

}