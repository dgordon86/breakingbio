<?php get_header(); ?>

<?php global $kopaCurrentSidebars; ?>

<div class="main-content">

    <div class="col-a">                
        <?php KopaLayout::get_breadcrumb(); ?>

        <div class="page-404 clearfix">
            <section class="error-404 clearfix">
                <div class="left-col">
                    <p><?php _e('404', kopa_get_domain()); ?></p>
                </div><!--left-col-->
                <div class="right-col">
                    <h1><?php _e('Page not found...', kopa_get_domain()); ?></h1>
                    <p><?php _e("We're sorry, but we can't find the page you were looking for. It's probably some thing we've done wrong but now we know about it we'll try to fix it. In the meantime, try one of this options:", kopa_get_domain()); ?></p>
                    <ul class="arrow-list">
                        <li><a href="javascript: history.go(-1);"><?php _e('Go back to previous page', kopa_get_domain()); ?></a></li>
                        <li><a href="<?php echo home_url(); ?>"><?php _e('Go to homepage', kopa_get_domain()); ?></a></li>
                    </ul>
                </div><!--right-col-->
            </section><!--error-404-->
        </div>

    </div>
    <div class="clear"></div>
    <?php
    if (is_active_sidebar($kopaCurrentSidebars[0])):
        echo '<div class="widget-area-6">';
        dynamic_sidebar($kopaCurrentSidebars[0]);
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
    if (is_active_sidebar($kopaCurrentSidebars[1]) || is_active_sidebar($kopaCurrentSidebars[2]) || is_active_sidebar($kopaCurrentSidebars[3]) || is_active_sidebar($kopaCurrentSidebars[4]) || is_active_sidebar($kopaCurrentSidebars[5])):
        ?>
        <div class="kp-divider"></div>
        <div class="row">
            <?php
            if (is_active_sidebar($kopaCurrentSidebars[1])):
                echo '<div class="col-md-2">';
                dynamic_sidebar($kopaCurrentSidebars[1]);
                echo '</div>';
            endif;

            if (is_active_sidebar($kopaCurrentSidebars[2])):
                echo '<div class="col-md-2">';
                dynamic_sidebar($kopaCurrentSidebars[2]);
                echo '</div>';
            endif;

            if (is_active_sidebar($kopaCurrentSidebars[3])):
                echo '<div class="col-md-2">';
                dynamic_sidebar($kopaCurrentSidebars[3]);
                echo '</div>';
            endif;

            if (is_active_sidebar($kopaCurrentSidebars[4])):
                echo '<div class="col-md-2">';
                dynamic_sidebar($kopaCurrentSidebars[4]);
                echo '</div>';
            endif;

            if (is_active_sidebar($kopaCurrentSidebars[5])):
                echo '<div class="col-md-4">';
                dynamic_sidebar($kopaCurrentSidebars[5]);
                echo '</div>';
            endif;
            ?>        
        </div>    
    <?php endif; ?>
</div>

<?php get_footer(); ?>