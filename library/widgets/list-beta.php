<?php

class KopaPostsListBeta extends KopaWidgetPosts {

    public function __construct() {
        $id_base = 'kopa_posts_list_beta';
        $name = __('Kopa Posts List B', kopa_get_domain());
        $widget_options = array('classname' => 'kopa_posts_list_beta kp-most-popular-widget', 'description' => __('Display posts with thumbnail (align : right)', kopa_get_domain()));
        $control_options = array('width' => '500', 'height' => 'auto');
        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $query = $this->build_query($instance);

        $posts = new WP_Query($query);
        if ($posts->have_posts()):

            global $post;
            ?>
            <ul>
                <?php
                while ($posts->have_posts()):
                    $posts->the_post();
                    $post_id = get_the_ID();
                    $post_title = get_the_title();
                    $post_url = get_permalink();
                    ?>            
                    <li <?php post_class(); ?>>
                        <article class="entry-item clearfix">
                            <header>
                                <?php if ('true' != $instance['is_hide_title']): ?>
                                    <h6 class="entry-title"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></h6>
                                <?php endif; ?>

                                <?php if ('true' != $instance['is_hide_created_date']): ?>
                                    <span class="entry-date clearfix"><span class="entry-icon icon-clock"></span><span class="date updated"><?php echo get_the_date(); ?></span></span>
                                <?php endif; ?>

                                <?php if ('true' != $instance['is_hide_comments']): ?>
                                    <span class="entry-comments clearfix"><span class="entry-icon icon-bubble"></span><?php comments_popup_link(__('No Comment', kopa_get_domain()), __('1 Comment', kopa_get_domain()), __('% Comments', kopa_get_domain()), '', __('Comment Off', kopa_get_domain())); ?></span>                                    
                                <?php endif; ?>

                                <?php if ('true' != $instance['is_hide_views']): ?>
                                    <span class="entry-views clearfix"><span class="entry-icon icon-eye"></span><a href="<?php echo $post_url; ?>"><?php echo KopaUtil::get_views($post_id); ?></a></span>                                
                                <?php endif; ?>
                            </header>

                            <?php
                            if (has_post_thumbnail()):
                                $image_croped = KopaImage::get_post_image_src($post_id, 'size_02');
                                ?>
                                <div class="entry-thumb">
                                    <a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>
                                </div>
                                <?php
                            endif;
                            ?>

                            <!-- entry-thumb -->
                            <div class="entry-content">
                                <?php
                                if ('true' != $instance['is_hide_excerpt']) {
                                    if ((int) $instance['excerpt_character_limit'] > 0) {
                                        $excerpt = KopaUtil::substr($post->post_content, (int) $instance['excerpt_character_limit']);
                                        echo ($excerpt) ? sprintf('<p>%s</p>', $excerpt) : '';
                                    } else {
                                        the_excerpt();
                                    }
                                }
                                ?>

                                <?php if ('true' != $instance['is_hide_readmore']): ?>
                                    <a class="more-link clearfix" href="<?php echo $post_url; ?>">
                                        <span class="entry-icon icon-popup"></span><span><?php _e('Read more ...', kopa_get_domain()); ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <!-- entry-content -->
                        </article>                                            
                    </li>
                    <?php
                endwhile;
                ?>
            </ul>
            <?php
        else:
            _e('Posts not found. Pleae config this widget again!', kopa_get_domain());
        endif;
        wp_reset_postdata();

        echo $after_widget;
    }

}