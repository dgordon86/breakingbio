<!DOCTYPE html>
<html <?php language_attributes(); ?>>              
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />                   
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo KopaSEO::get_title(); ?></title>                
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />               
        <?php wp_head(); ?>
        
    </head>    
    <body <?php body_class(); ?>>  
        <div class="wrapper">
            <div class="kp-page-header">
                <div class="header-top">
                    <?//php kopa_get_headline(); ?>

                    <?php
                    if (has_nav_menu('top-nav')) {
                        wp_nav_menu(
                                array(
                                    'theme_location' => 'top-nav',
                                    'container' => false,
                                    'menu_id' => 'top-menu',
                                    'menu_class' => 'clearfix'
                                )
                        );
                    }
                    ?>                                         
                    <!-- top-menu -->
                    <div class="clear"></div>
                </div>
                <!-- header-top -->
                <div class="header-middle">
                    <?php
                    $logo = KopaOptions::get_option('logo');
                    if (!empty($logo)):
                        ?>
                        <div id="logo-image" class="pull-left">
                            <a href="<?php echo home_url(); ?>"><img src="<?php echo do_shortcode($logo); ?>" alt="<?php bloginfo('name'); ?>"/></a>
                        </div>                        
                    <?php endif; ?>

                    <?php
                    $top_banner_image = KopaOptions::get_option('top_banner_image');
                    $top_banner_code = KopaOptions::get_option('top_banner_code');
                    if ($top_banner_image || $top_banner_code):
                        ?>
                        <div id="top-banner" class="pull-right">
                            <?php if ($top_banner_code): ?>
                                <?php echo htmlspecialchars_decode(stripslashes($top_banner_code)); ?>
                            <?php elseif ($top_banner_image): ?>
                                <?php $top_banner_target = ('true' == KopaOptions::get_option('is_open_top_banner_on_new_tab', 'true')) ? 'target=_blank' : ''; ?>
                                <a <?php echo $top_banner_target; ?> href="<?php echo KopaOptions::get_option('top_banner_url'); ?>"><img src="<?php echo do_shortcode($top_banner_image); ?>" alt=""/></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>
                <!-- header-middle -->
                <div class="header-bottom">
                    <?php
                    if (has_nav_menu('primary-nav')) {
                        echo '<nav id="main-nav" class="pull-left">';
                        wp_nav_menu(
                                array(
                                    'theme_location' => 'primary-nav',
                                    'container' => false,
                                    'container_id' => null,
                                    'container_class' => null,
                                    'menu_id' => 'main-menu',
                                    'menu_class' => 'clearfix'
                                )
                        );
                        echo '<div id="mobile-menu">';
                        printf('<span>%s</span>', __('Menu', kopa_get_domain()));
                        wp_nav_menu(
                                array(
                                    'theme_location' => 'primary-nav',
                                    'container' => false,
                                    'container_id' => null,
                                    'container_class' => null,
                                    'menu_id' => 'toggle-view-menu',
                                    'menu_class' => 'clearfix'
                                )
                        );
                        echo '</div>';
                        echo '</nav>';
                    }
                    ?>                     
                    <!-- main-nav -->
                    <div class="search-box pull-right clearfix">
                        <?php get_search_form(); ?>                                               
                    </div>
                    <!--search-box-->
                    <div class="clear"></div>
                    <?php
                    if (has_nav_menu('secondary-nav')) {
                        wp_nav_menu(
                                array(
                                    'theme_location' => 'secondary-nav',
                                    'container' => 'nav',
                                    'container_id' => 'secondary-nav',
                                    'menu_id' => 'secondary-menu',
                                    'menu_class' => 'clearfix'
                                )
                        );
                    }
                    ?>                 
                    <!-- secondary-nav -->
                </div>
                <!-- header-bottom -->
            </div>            