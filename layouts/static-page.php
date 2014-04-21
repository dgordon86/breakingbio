<?php get_header(); ?>

<?php global $kopaCurrentSidebars; ?>

<div class="main-content">

    <div class="col-a">                
        <?php KopaLayout::get_breadcrumb(); ?>

        <?php
        if (have_posts()):
            while (have_posts()) : the_post();
                ?>
                <div <?php post_class(array('entry-box', 'clearfix')); ?>>
                    <?php the_content(); ?>    

                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links pull-right"><span class="page-links-title">' . __('Parts', kopa_get_domain()) . '</span>',
                        'after' => '</div>',
                        'next_or_number' => 'number',
                        'pagelink' => '%',
                        'echo' => 1
                    ));
                    ?>            

                    <?php comments_template(); ?>
                </div>
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

    <?php
    if (is_active_sidebar($kopaCurrentSidebars[0])):
        echo '<div class="sidebar">';
        dynamic_sidebar($kopaCurrentSidebars[0]);
        echo '</div>';
    endif;
    ?>

    <?php
    if (is_active_sidebar($kopaCurrentSidebars[1])):
        echo '<div class="col-b widget-area-5">';
        dynamic_sidebar($kopaCurrentSidebars[1]);
        echo '</div>';
    endif;
    ?>

    <div class="clear"></div>

    <?php
    if (is_active_sidebar($kopaCurrentSidebars[3])):
        echo '<div class="widget-area-6">';
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