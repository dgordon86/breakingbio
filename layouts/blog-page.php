<?php get_header(); ?>
<?php global $kopaCurrentSidebars; ?>

<div class="main-content">

    <div class="col-a">

        <?php
        if (is_active_sidebar($kopaCurrentSidebars[2])):
            echo '<div class="widget-area-3">';
            dynamic_sidebar($kopaCurrentSidebars[2]);
            echo '</div>';
        endif;
        ?>

        <!-- widget-area-3 -->
        <?php KopaLayout::get_breadcrumb(); ?>
        <!-- breadcrumb -->
        
        <?php
        if (have_posts()):
            global $post;
            $exceprt_type = KopaOptions::get_option('exceprt_type', 'limit');
            $excerpt_limit = (int) KopaOptions::get_option('excerpt_limit', 200);
            $is_display_blog_post_format = apply_filters('kopa_blog_is_display_blog_post_format', KopaOptions::get_option('is_display_blog_post_format', 'true'));
            $is_display_created_date = KopaOptions::get_option('is_display_created_date', 'true');
            $is_display_comments = KopaOptions::get_option('is_display_comments', 'true');
            $is_display_views = KopaOptions::get_option('is_display_views', 'true');
            $blog_thumbnail_position = apply_filters('kopa_blog_thumbnail_position', KopaOptions::get_option('blog_thumbnail', 'left'));
            ?>
            <ul class="entry-list clearfix">
                <?php
                $is_even = false;
                while (have_posts()) : the_post();
                    $post_id = get_the_ID();
                    $post_url = get_permalink();
                    $post_title = get_the_title();
                    $post_format = get_post_format();

                    $post_classes = array();
                    switch ($blog_thumbnail_position) {
                        case 'left':
                            $post_classes[] = 'odd';
                            break;
                        case 'right':
                            $post_classes[] = 'even';
                            break;
                        case 'zebra';
                            $post_classes[] = ($is_even) ? 'even' : 'odd';
                            break;
                    }

                    $is_even = !$is_even;
                    ?>               
                    <li <?php post_class($post_classes); ?>>
                        <article class="entry-item clearfix">
                            <header>
                                <h6 class="entry-title"><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></h6>

                                <?php if ('true' == $is_display_created_date): ?>
                                    <span class="entry-date clearfix"><span class="entry-icon icon-clock"></span><span class="date updated"><?php echo get_the_date(); ?></span></span>
                                <?php endif; ?>

                                <?php if ('true' == $is_display_comments): ?>
                                    <span class="entry-comments clearfix"><span class="entry-icon icon-bubble"></span><?php comments_popup_link(__('No Comment', kopa_get_domain()), __('1 Comment', kopa_get_domain()), __('% Comments', kopa_get_domain()), 'entry-comment', __('Comment Off', kopa_get_domain())); ?></span>                                                                                                                       
                                <?php endif; ?>

                                <?php if ('true' == $is_display_views): ?>
                                    <span class="entry-views clearfix"><span class="entry-icon icon-eye"></span><a href="<?php echo $post_url; ?>"><?php echo KopaUtil::get_views($post_id); ?></a></span>                                
                                <?php endif; ?>
                            </header>

                            <?php
                            if (has_post_thumbnail() && 'full' != $exceprt_type && 'none' != $blog_thumbnail_position && !is_search()) {
                                $image = KopaUtil::get_image_src($post_id, 'full');

                                if ('true' == $is_display_blog_post_format) {
                                    $image_croped = KopaImage::get_post_image_src($post_id, 'size_02');

                                    if (in_array($post_format, array('video', 'gallery', 'audio'))) {
                                        $shortcode = NULL;

                                        switch ($post_format) {
                                            case 'video':
                                                $shortcode = KopaUtil::get_shortcode($post->post_content, false, array('vimeo', 'youtube', 'video'));
                                                break;
                                            case 'audio':
                                                $shortcode = KopaUtil::get_shortcode($post->post_content, false, array('audio', 'soundcloud'));
                                                break;
                                            case 'gallery':
                                                $shortcode = KopaUtil::get_shortcode($post->post_content, false, array('gallery'));
                                                break;
                                            default:
                                                break;
                                        }

                                        if (!empty($shortcode)) {
                                            ?>
                                            <div class="kopa-post-content-formated entry-thumb">
                                                <?php echo do_shortcode($shortcode[0]['shortcode']); ?>
                                            </div>
                                            <?php
                                        } else {
                                            ?>  
                                            <div class="entry-thumb">
                                                <a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>                                
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>      
                                        <div class="entry-thumb">
                                            <a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>                                
                                        </div>
                                        <?php
                                    }
                                } else {
                                    $image_croped = KopaImage::get_post_image_src($post_id, 'size_02');
                                    ?>      
                                    <div class="entry-thumb">
                                        <a href="<?php echo $post_url; ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>                                
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                            <!-- entry-thumb -->
                            <div class="entry-content">
                                <?php
                                if ('excerpt' == $exceprt_type) {
                                    if (has_excerpt()) {
                                        printf('<p>%s</p>', get_the_excerpt());
                                    } else {
                                        global $post;
                                        if (strpos($post->post_content, '<!--more-->')) {
                                            the_content(' ');
                                        } else {
                                            printf('<p>%s</p>', get_the_excerpt());
                                        }
                                    }
                                } elseif ('full' == $exceprt_type) {
                                    global $more;
                                    $more = true;
                                    the_content();
                                } else {
                                    if ($excerpt_limit) {
                                        $excerpt = KopaUtil::substr($post->post_content, $excerpt_limit);
                                        echo ($excerpt) ? sprintf('<p>%s</p>', $excerpt) : '';
                                    }
                                }
                                ?>

                                <a href="<?php echo $post_url; ?>" class="more-link clearfix"><span class="entry-icon icon-popup"></span><span><?php _e('Read more ...', kopa_get_domain()); ?></span></a>
                            </div>
                            <!-- entry-content -->
                        </article>
                        <!-- entry-item -->
                    </li>
                    <?php
                endwhile;
                ?>
            </ul>
            <?php get_template_part('pagination'); ?>    
            <?php
        else:
            printf('<blockquote>%1$s</blockquote>', __('Nothing Found...', kopa_get_domain()));
        endif;
        ?>             
    </div>
    <!-- col-a -->


    <?php
    if (is_active_sidebar($kopaCurrentSidebars[0])):
        echo '<div class="sidebar">';
        dynamic_sidebar($kopaCurrentSidebars[0]);
        echo '</div>';
    endif;
    ?>

    <!-- sidebar -->


    <?php
    if (is_active_sidebar($kopaCurrentSidebars[1])):
        echo '<div class="col-b widget-area-5">';
        dynamic_sidebar($kopaCurrentSidebars[1]);
        echo '</div>';
    endif;
    ?>

    <!-- col-b -->

    <div class="clear"></div>
    <?php
    if (is_active_sidebar($kopaCurrentSidebars[3])):
        echo '<div class="widget-area-6">';
        dynamic_sidebar($kopaCurrentSidebars[3]);
        echo '</div>';
    endif;
    ?> 
</div>
<!-- main-content -->


<div id="bottom-sidebar">

    <?php
    if (has_nav_menu('bottom-nav')) {
        echo '<div class="text-center">';
        wp_nav_menu(
                array(
                    'theme_location' => 'bottom-nav',
                    'container' => 'nav',
                    'container_id' => 'bottom-nav',
                    'container_class' => 'text-center',
                    'menu_id' => 'bottom-menu',
                    'menu_class' => 'clearfix'
                )
        );
        echo '</div>';
    }
    ?>       


    <?php
    if (is_active_sidebar($kopaCurrentSidebars[4]) || is_active_sidebar($kopaCurrentSidebars[5]) || is_active_sidebar($kopaCurrentSidebars[6]) || is_active_sidebar($kopaCurrentSidebars[7]) || is_active_sidebar($kopaCurrentSidebars[8])):
        ?>

        <div class="kp-divider"></div>
        <div class="row">
            <?php
            if (is_active_sidebar($kopaCurrentSidebars[4])):
                echo '<div class="col-md-2">';
                dynamic_sidebar($kopaCurrentSidebars[4]);
                echo '</div>';
            endif;

            if (is_active_sidebar($kopaCurrentSidebars[5])):
                echo '<div class="col-md-2">';
                dynamic_sidebar($kopaCurrentSidebars[5]);
                echo '</div>';
            endif;

            if (is_active_sidebar($kopaCurrentSidebars[6])):
                echo '<div class="col-md-2">';
                dynamic_sidebar($kopaCurrentSidebars[6]);
                echo '</div>';
            endif;

            if (is_active_sidebar($kopaCurrentSidebars[7])):
                echo '<div class="col-md-2">';
                dynamic_sidebar($kopaCurrentSidebars[7]);
                echo '</div>';
            endif;

            if (is_active_sidebar($kopaCurrentSidebars[8])):
                echo '<div class="col-md-4">';
                dynamic_sidebar($kopaCurrentSidebars[8]);
                echo '</div>';
            endif;
            ?>        
        </div>   
    <?php endif; ?>
</div>

<?php get_footer(); ?>