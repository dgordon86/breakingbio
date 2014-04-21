<?php get_header(); ?>

<?php global $kopaCurrentSidebars; ?>

<div class="main-content">

    <div class="col-a">                
        <?php KopaLayout::get_breadcrumb(); ?>

        <?php
        if (have_posts()):
            $is_display_post_thumbnail_standard = KopaOptions::get_option('is_display_post_thumbnail_standard', 'true');
            $is_display_post_thumbnail_other = KopaOptions::get_option('is_display_post_thumbnail_other', 'false');
            $is_display_post_category = KopaOptions::get_option('is_display_post_category', 'true');
            $is_display_post_tag = KopaOptions::get_option('is_display_post_tag', 'true');
            $is_display_post_datetime = KopaOptions::get_option('is_display_post_datetime', 'true');
            $is_display_post_views = KopaOptions::get_option('is_display_post_views', 'true');
            $is_display_post_comments = KopaOptions::get_option('is_display_post_comments', 'true');
            $is_display_pre_next_post = KopaOptions::get_option('is_display_post_prev_next_links', 'true');


            while (have_posts()) : the_post();
                $post_id = get_the_ID();
                $post_url = get_permalink();
                $post_title = get_the_title();
                $post_format = get_post_format();
                ?>

                <div <?php post_class(array('entry-box', 'clearfix')); ?>>
                    <header>
                        <h1 class="entry-title" itemprop="name"><?php echo $post_title; ?></h1>

                        <?php if ('true' == $is_display_post_datetime): ?>
                            <span class="entry-date clearfix"><span class="entry-icon icon-clock"></span><span  class="date updated" itemprop="datePublished" content="<?php get_the_date('F S, Y'); ?>"><?php echo get_the_date(); ?></span></span>
                        <?php endif; ?>

                        <?php if ('true' == $is_display_post_comments): ?>
                            <span class="entry-comments clearfix"><span class="entry-icon icon-bubble"></span><?php comments_popup_link(__('No Comment', kopa_get_domain()), __('1 Comment', kopa_get_domain()), __('% Comments', kopa_get_domain()), '', __('Comment Off', kopa_get_domain())); ?></span>                                    
                        <?php endif; ?>

                        <?php if ('true' == $is_display_post_views): ?>
                            <span class="entry-views clearfix"><span class="entry-icon icon-eye"></span><a href="<?php echo $post_url; ?>" class="kopa-total-views-for-singular"><?php echo KopaUtil::get_views($post_id); ?></a></span>                                
                        <?php endif; ?>
                    </header>

                    <?php
                    if (has_post_thumbnail()) {
                        $exp1 = empty($post_format) && ('true' == $is_display_post_thumbnail_standard);
                        $exp2 = $post_format && ('true' == $is_display_post_thumbnail_other);

                        if ($exp1 || $exp2) {
                            $size = apply_filters('kopa_set_thumbnail_size_for_single_post', 'size_03');
                            $classes = apply_filters('kopa_set_thumbnail_classes_for_single_post', array('entry-thumb', 'pull-right'));
                            $image_croped = KopaImage::get_post_image_src($post_id, $size);
                            ?>
                            <div class="<?php echo implode(' ', $classes); ?>">
                                <img src="<?php echo $image_croped; ?>" alt="" />                        
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="entry-content clearfix" itemprop="articleBody">
                        <?php the_content(); ?>    
                    </div>

                    <!-- tag-box -->
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="clearfix"><div class="page-links pull-right"><span class="page-links-title">' . __('Parts', kopa_get_domain()) . '</span>',
                        'after' => '</div></div>',
                        'next_or_number' => 'number',
                        'pagelink' => '%',
                        'echo' => 1
                    ));
                    ?>  

                    <!-- entry-content -->
                    <?php if ('true' == $is_display_post_category && has_category()): ?>
                        <div class="terms-box categories-box clearfix">
                            <span><?php _e('In : ', kopa_get_domain()); ?></span>
                            <?php the_category(', '); ?>
                        </div>
                    <?php endif; ?>

                    <div class="clear"></div>

                    <?php if ('true' == $is_display_post_tag && has_tag()): ?>
                        <div class="terms-box tags-box clearfix">                            
                            <?php the_tags('', ' '); ?>                        
                        </div>
                    <?php endif; ?>

                    <div class="clear"></div>

                    <!-- page-links -->                    
                    <?php
                    if ('true' == $is_display_pre_next_post):
                        $prev_and_next = KopaLayout::get_pre_next_post();
                        if ($prev_and_next):
                            ?>
                            <footer class="clearfix">
                                <?php if (isset($prev_and_next['prev'])): ?>
                                    <p class="prev-post pull-left clearfix">                        
                                        <a class="clearfix" href="<?php echo $prev_and_next['prev']['url']; ?>"><span class="icon-arrow-left"></span><?php _e('Previous article', kopa_get_domain()); ?></a>                            
                                        <a href="<?php echo $prev_and_next['prev']['url']; ?>" class="article-title"><?php echo $prev_and_next['prev']['title']; ?></a>                           
                                    </p>
                                <?php endif; ?>

                                <?php if (isset($prev_and_next['next'])): ?>
                                    <p class="next-post pull-right clearfix">
                                        <a class="clearfix" href="<?php echo $prev_and_next['next']['url']; ?>"><?php _e('Next article', kopa_get_domain()); ?><span class="icon-arrow-right"></span></a>
                                        <a href="<?php echo $prev_and_next['next']['url']; ?>" class="article-title"><?php echo $prev_and_next['next']['title']; ?></a>                           
                                    </p>
                                <?php endif; ?>
                            </footer>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php kopa_get_about_author(); ?>

                <?php kopa_get_related_posts(); ?>

                <?php comments_template(); ?>               

                <?php
            endwhile;
        else:
            printf('<blockquote>%1$s</blockquote>', __('Nothing Found...', kopa_get_domain()));
        endif;
        ?>   

        <?php
        if (is_active_sidebar($kopaCurrentSidebars[2])):
            echo '<div class="widget-area-4 clearfix">';
            dynamic_sidebar($kopaCurrentSidebars[2]);
            echo '</div>';
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
        echo '<div class="widget-area-6 clearfix">';
        dynamic_sidebar($kopaCurrentSidebars[3]);
        echo '</div>';
    endif;
    ?>
</div>

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