<?php

class KopaQuickViews extends KopaWidgetPosts {

    public function __construct() {
        $id_base = 'kopa_quick_views';
        $name = __('Kopa Quick Views', kopa_get_domain());
        $widget_options = array('classname' => 'kopa-quick-views kp-accordion-widget', 'description' => __('Display posts: popular - random - most comments', kopa_get_domain()));
        $control_options = array('width' => '600', 'height' => 'auto');
        parent::__construct($id_base, $name, $widget_options, $control_options);

        unset($this->groups['col-2']['fields']['orderby']);
        $this->groups['col-1']['fields']['posts_per_page']['label'] = __('Number of posts (for each section)', kopa_get_domain());

        $this->groups['col-2']['fields']['section_order'] = array(
            'type' => 'select',
            'id' => 'section_order',
            'name' => 'section_order',
            'default' => 'popular,rand,comment_count',
            'classes' => array(),
            'label' => __('Section order', kopa_get_domain()),
            'help' => NULL,
            'options' => array(
                'rand,popular,comment_count' => __('Random, Popular, Most Comments', kopa_get_domain()),
                'rand,comment_count,popular' => __('Random, Most Comments, Popular', kopa_get_domain()),
                'popular,rand,comment_count' => __('Popular, Random, Most Comments', kopa_get_domain()),
                'popular,comment_count,rand' => __('Popular, Most Comments, Random', kopa_get_domain()),
                'comment_count,rand,popular' => __('Most Comments, Random, Popular', kopa_get_domain()),
                'comment_count,popular,rand' => __('Most Comments, Popular, Random', kopa_get_domain()),
            )
        );
    }

    public function widget($args, $instance) {
        global $post;
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $section_label = array(
            'popular' => __('Popular Posts', kopa_get_domain()),
            'rand' => __('Random Posts', kopa_get_domain()),
            'comment_count' => __('Most Comment', kopa_get_domain())
        );

        $section_order = isset($instance['section_order']) ? explode(',', $instance['section_order']) : array('popular', 'rand', 'comment_count');

        $sections = array();
        foreach ($section_order as $key) {
            $sections[$key] = $section_label[$key];
        }

        $shortcode = '[accordions]';

        foreach ($sections as $slug => $section) {
            $instance['orderby'] = $slug;

            $query = $this->build_query($instance);
            $posts = new WP_Query($query);

            if ($posts->have_posts()) {

                $shortcode.= sprintf('[accordion title="%s"]', $section);
                $shortcode.= '<ul>';
                while ($posts->have_posts()) {
                    $posts->the_post();
                    $post_id = get_the_ID();
                    $post_title = get_the_title();
                    $post_url = get_permalink();

                    $shortcode.= '<li>';
                    $shortcode.= '<article class="entry-item clearfix">';
                    if (has_post_thumbnail()):
                        $image_croped = KopaImage::get_post_image_src($post_id, 'size_01');
                        $shortcode.= sprintf('<div class="entry-thumb"><a href="%s"><img src="%s" alt=""/></a></div>', $post_url, $image_croped);
                    endif;


                    $shortcode.= '<div class="entry-content">';
                    $shortcode.= '<header>';

                    if ('true' != $instance['is_hide_title']) {
                        $shortcode.= sprintf('<h6 class="entry-title"><a href="%s">%s</a></h6>', $post_url, $post_title);
                    }

                    if ('true' != $instance['is_hide_created_date']) {
                        $shortcode.= sprintf('<span class="entry-date clearfix"><span class="entry-icon icon-clock"></span><span class="date updated">%s</span></span>', get_the_date());
                    }

                    if ('true' != $instance['is_hide_comments']) {
                        $shortcode.= sprintf('<span class="entry-comments clearfix"><span class="entry-icon icon-bubble"></span><a href="%s">%s</a></span>', get_comments_link($post_id), KopaUtil::get_comments($post_id));
                    }

                    if ('true' != $instance['is_hide_views']) {
                        $shortcode.= sprintf('<span class="entry-views clearfix"><span class="entry-icon icon-eye"></span><a href="%s">%s</a></span>', $post_url, KopaUtil::get_views($post_id));
                    }

                    $shortcode.= '</header>';

                    if ('true' != $instance['is_hide_excerpt']) {
                        if ((int) $instance['excerpt_character_limit'] > 0) {
                            $excerpt = KopaUtil::substr($post->post_content, (int) $instance['excerpt_character_limit']);
                            $shortcode.= ($excerpt) ? sprintf('<p>%s</p>', $excerpt) : '';
                        } else {
                            $shortcode.= get_the_excerpt();
                        }
                    }

                    if ('true' != $instance['is_hide_readmore']) {
                        $shortcode.= sprintf('<a class="more-link clearfix" href="%s"><span class="entry-icon icon-popup"></span><span>%s</span></a>', $post_url, __('Read more ...', kopa_get_domain()));
                    }

                    $shortcode.= '</div>';
                    $shortcode.= '</article>';
                    $shortcode.= '</li>';
                }

                $shortcode.= '</ul>';
                $shortcode.= '[/accordion]';
            }
            wp_reset_postdata();
        }

        $shortcode.= '[/accordions]';

        echo do_shortcode($shortcode);

        echo $after_widget;
    }

}