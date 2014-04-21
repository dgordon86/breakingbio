<?php

class KopaPostsListAlpha extends KopaWidgetPosts {

    public function __construct() {
        $id_base = 'kopa_posts_list_alpha';
        $name = __('Kopa Posts List A', kopa_get_domain());
        $widget_options = array('classname' => 'kopa_posts_list_alpha kp-article-list-widget', 'description' => __('Display posts with thumbnail (align : left)', kopa_get_domain()));
        $control_options = array('width' => '500', 'height' => 'auto');
        parent::__construct($id_base, $name, $widget_options, $control_options);


        $this->groups['col-2']['fields']['layout'] = array(
            'type' => 'select',
            'id' => 'layout',
            'name' => 'layout',
            'label' => __('Layout', kopa_get_domain()),
            'default' => 'small_thumbs',
            'options' => array(
                'small_thumbs' => __('Small thumbnail for each post', kopa_get_domain()),
                'thumb_for_first' => __('Only a thumbnail for first post', kopa_get_domain()),
                'big_and_small' => __('Big thumbnail for first post, small for other', kopa_get_domain()),
                'medium_and_small_none' => __('Medium thumbnail for first, small for second, none for other', kopa_get_domain()),
            )
        );
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
            switch ($instance['layout']) {
                case 'thumb_for_first':
                    $this->layout_thumb_for_first($posts, $instance);
                    break;
                case 'big_and_small':
                    $this->layout_big_and_small($posts, $instance);
                    break;
                case 'medium_and_small_none':
                    $this->layout_medium_and_small_none($posts, $instance);
                    break;
                default:
                    $this->layout_small_thumbs($posts, $instance);
                    break;
            }
        else:
            _e('Posts not found. Pleae config this widget again!', kopa_get_domain());
        endif;
        wp_reset_postdata();

        echo $after_widget;
    }

    private function layout_medium_and_small_none($posts, $instance) {
        global $post;
        $index = 0;
        while ($posts->have_posts()):
            $posts->the_post();
            $post_id = get_the_ID();
            $post_title = get_the_title();
            $post_url = get_permalink();

            if (0 == $index) {
                ?>            
                <article class="entry-item latest-item clearfix">
                    <?php
                    if (has_post_thumbnail()):
                        $image_croped = KopaImage::get_post_image_src($post_id, 'size_03');
                        ?>
                        <div class="entry-thumb">
                            <a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>
                        </div>
                        <?php
                    endif;
                    ?>
                    <div class="entry-content">
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
                        if ('true' != $instance['is_hide_excerpt']) {
                            if ((int) $instance['excerpt_character_limit'] > 0) {
                                $excerpt = KopaUtil::substr($post->post_content, (int) $instance['excerpt_character_limit'] * 3);
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
                </article>
                <?php
                echo ((int) $instance['posts_per_page'] > 1) ? '<ul class="older-post">' : '';
            } else {
                if (1 == $index) {
                    ?>
                    <li <?php post_class(); ?>>
                        <article class="entry-item clearfix">
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
                        </article>                            
                    </li>
                    <?php
                }else {
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
                        </article>                            
                    </li>
                    <?php
                }
            }

            $index++;
        endwhile;
        echo ((int) $instance['posts_per_page'] > 1) ? '</ul>' : '';
    }

    private function layout_big_and_small($posts, $instance) {
        global $post;
        $is_first = true;
        while ($posts->have_posts()):
            $posts->the_post();
            $post_id = get_the_ID();
            $post_title = get_the_title();
            $post_url = get_permalink();

            if ($is_first) {
                $is_first = false;
                ?>            
                <article class="entry-item latest-item clearfix">
                    <?php
                    if (has_post_thumbnail()):
                        $image_croped = KopaImage::get_post_image_src($post_id, 'size_04');
                        ?>
                        <div class="entry-thumb">
                            <a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>
                        </div>
                        <?php
                    endif;
                    ?>
                    <div class="entry-content">
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
                        if ('true' != $instance['is_hide_excerpt']) {
                            if ((int) $instance['excerpt_character_limit'] > 0) {                                
                                $excerpt = KopaUtil::substr($post->post_content, (int) $instance['excerpt_character_limit'] * 3);
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
                </article>
                <?php
                echo ((int) $instance['posts_per_page'] > 1) ? '<ul class="older-post">' : '';
            } else {
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
                            
                        </div>                                
                    </article>                            
                </li>
                <?php
            }
        endwhile;
        echo ((int) $instance['posts_per_page'] > 1) ? '</ul>' : '';
    }

    private function layout_small_thumbs($posts, $instance) {
        global $post;
        ?>
        <ul class="kopa_lists_a_layout_small_thumbs">
            <?php
            while ($posts->have_posts()):
                $posts->the_post();
                $post_id = get_the_ID();
                $post_title = get_the_title();
                $post_url = get_permalink();
                ?>            
                <li <?php post_class(); ?>>
                    <article class="entry-item clearfix">
                        <?php
                        if (has_post_thumbnail()):
                            $image_croped = KopaImage::get_post_image_src($post_id, 'size_01');                            
                            ?>
                            <div class="entry-thumb">
                                <a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>
                            </div>
                            <?php
                        endif;
                        ?>

                        <div class="entry-content">
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
                    </article>                            
                </li>
                <?php
            endwhile;
            ?>
        </ul>
        <?php
    }

    private function layout_thumb_for_first($posts, $instance) {
        global $post;
        $is_first = true;
        ?>
        <ul class="kopa_lists_a_layout_thumb_for_first">
            <?php
            while ($posts->have_posts()):
                $posts->the_post();
                $post_id = get_the_ID();
                $post_title = get_the_title();
                $post_url = get_permalink();
                ?>            
                <li <?php post_class(); ?>>
                    <article class="entry-item clearfix">
                        <?php if ($is_first): ?>
                            <header class="post-list-header-1" style="display: none;">
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
                        <?php endif; ?>
                        <?php
                        if (has_post_thumbnail() && $is_first):
                            $image_croped = KopaImage::get_post_image_src($post_id, 'size_02');                                
                            ?>
                            <div class="entry-thumb">
                                <a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>
                            </div>
                            <?php
                        endif;
                        ?>

                        <div class="entry-content">
                            <header class="<?php echo ($is_first) ? 'post-list-header-2' : ''; ?>">
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
                    </article>                            
                </li>
                <?php
                $is_first = false;
            endwhile;
            ?>
        </ul>
        <?php
    }

}