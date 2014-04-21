<?php

class KopaMediaCenter extends KopaWidgetPosts {

    public function __construct() {
        $id_base = 'kopa_media_center';
        $name = __('Kopa Media Center', kopa_get_domain());
        $widget_options = array('classname' => 'kopa_media_center kp-gallery-widget', 'description' => __('Display lists post with small thumbnail', kopa_get_domain()));
        $control_options = array('width' => '750', 'height' => 'auto');
        parent::__construct($id_base, $name, $widget_options, $control_options);

        $col3 = array(
            'size' => 2,
            'fields' => array()
        );
        $col3['fields']['post_per_row'] = array(
            'type' => 'select-number',
            'id' => 'post_per_row',
            'name' => 'post_per_row',
            'label' => __('Post per row', kopa_get_domain()),
            'default' => 6,
            'min' => 1,
            'max' => 6,
            'step' => 1,
            'suffix' => __(' column', kopa_get_domain()),
        );

        $sizes = KopaInit::get_image_sizes();
        $col3['fields']['image_size'] = array(
            'type' => 'select',
            'id' => 'image_size',
            'name' => 'image_size',
            'label' => __('Thumbnail size', kopa_get_domain()),
            'default' => 'size_02',
            'options' => array(
                'size_02' => $sizes['size_02']['name'],
                'size_03' => $sizes['size_03']['name'],
                'size_05' => $sizes['size_05']['name'],
                'size_06' => $sizes['size_06']['name'],
                'size_07' => $sizes['size_07']['name']
            )
        );

        $this->groups['col-3'] = $col3;
        $this->groups['col-1']['size'] = 4;
        $this->groups['col-2']['size'] = 6;
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
        if ($posts->have_posts()) {
            global $post;

            $post_per_row = (int) $instance['post_per_row'];
            $row_classes = array('row', 'clearfix');
            $row_classes[] = empty($title) ? 'widget-hide-title' : '';
            $col_classes = array();
            $image_size = isset($instance['image_size']) ? $instance['image_size'] : 'size_02';

            switch ($post_per_row) {
                case 2:
                    $col_classes[] = "col-sm-6";
                    break;
                case 3:
                    $col_classes[] = "col-sm-4";
                    break;
                case 4:
                    $col_classes[] = "col-sm-3";
                    break;
                case 5:
                    $col_classes[] = "col20perc";
                    break;
                case 6:
                    $col_classes[] = "col-sm-2";
                    break;
                default:
                    $col_classes[] = "col-sm-12";
            }

            $index = 0;
            while ($posts->have_posts()):
                $posts->the_post();
                $post_id = get_the_ID();
                $post_title = get_the_title();
                $post_url = get_permalink();
                $post_format = get_post_format();

                if (0 == $index % $post_per_row) {
                    if (0 != $index) {
                        echo '</div></div>';
                    }
                    printf('<div class="kopa-media-row-outer"><div class="%s">', implode(' ', $row_classes));
                }

                $classes = $col_classes;
                $classes[] = 'kopa-media-item';
                ?>
                <div class="<?php echo implode(' ', $classes); ?>">
                    <article class="entry-item clearfix">
                        <?php
                        if (has_post_thumbnail()) {
                            $light_box_url = NULL;
                            $light_box_classes = array();
                            $light_box_thumb_classes = array();
                            $light_box_inline = NULL;
                            $light_box_onclick = NULL;

                            $image_croped = KopaImage::get_post_image_src($post_id, $image_size);

                            $icon = NULL;
                            switch ($post_format) {
                                case 'audio':
                                    $light_box_classes[] = 'audio-icon';
                                    break;
                                case 'video':
                                    $light_box_classes[] = 'video-icon';
                                    break;
                                case 'gallery':
                                    $light_box_classes[] = 'standard-icon';
                                    break;
                            }

                            if ('true' == KopaOptions::get_option('', 'true') && in_array($post_format, array('audio', 'gallery', 'video'))) {
                                $light_box_classes[] = 'hover-icon';

                                if ('audio' == $post_format) {
                                    $audios = KopaUtil::get_shortcode($post->post_content, true, array('audio', 'soundcloud'));
                                    if (!empty($audios)) {
                                        $rel = sprintf('lightbox[audio-%s]', rand(0, 500));
                                        $light_box_inline = '<div class="kopa-popup-inline hide">';
                                        foreach ($audios as $audio) {
                                            $inline_id = sprintf('kopa-popup-inline-%s', rand(0, 500));
                                            if ('audio' == $audio['type']) {
                                                $light_box_inline.= sprintf('<div id="%s"><p id="audio-%s" class="kopa-audio-player" data-file="%s"></p></div>', $inline_id, $inline_id, $audio['atts']['mp3']);
                                                $light_box_inline.= sprintf('<a class="lightbox" href="#%s" rel="%s"></a>', $inline_id, $rel);
                                            } elseif ('soundcloud' == $audio['type']) {
                                                $light_box_inline.= sprintf('<a class="lightbox" href="https://w.soundcloud.com/player/?url=%s&iframe=true&height=100" rel="%s"></a>', $audio['atts']['url'], $rel);
                                            }
                                        }
                                        $light_box_inline.= '</div>';
                                        $light_box_url = '#';
                                        $light_box_onclick = 'onclick="KopaLightbox.openInline(event, jQuery(this));"';
                                    }
                                } elseif ('gallery' == $post_format) {
                                    $galleries = KopaUtil::get_shortcode($post->post_content, true, array('gallery'));
                                    if (!empty($galleries)) {
                                        $rel = sprintf('lightbox[gallery-%s]', rand(0, 100));
                                        $light_box_inline = '<div class="kopa-popup-gallery hide">';
                                        foreach ($galleries as $gallery) {
                                            if (isset($gallery['atts']['ids'])) {
                                                $ids = explode(',', $gallery['atts']['ids']);
                                                if (is_array($ids) && !empty($ids)) {
                                                    foreach ($ids as $id) {
                                                        $img_tmp = wp_get_attachment_image_src($id, 'full');
                                                        if (!empty($img_tmp[0])) {
                                                            $img_tmp_cropped = KopaImage::get_image_src($img_tmp[0], 'size_05');
                                                            $img_tmp_obj = get_post($id);
                                                            $light_box_inline.= sprintf('<a class="lightbox" href="%s" title="%s" rel="%s"></a>', $img_tmp_cropped, $img_tmp_obj->post_excerpt, $rel);
                                                            wp_reset_query();
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $light_box_inline.= '</div>';
                                        $light_box_url = '#';
                                        $light_box_onclick = 'onclick="KopaLightbox.openGallery(event, jQuery(this));"';
                                    }
                                    ?>
                                    <?php
                                } elseif ('video' == $post_format) {
                                    $videos = KopaUtil::get_shortcode($post->post_content, true, array('youtube', 'vimeo', 'video'));
                                    if (!empty($videos)) {
                                        $rel = sprintf('lightbox[video-%s]', rand(0, 100));
                                        $light_box_inline = '<div class="kopa-popup-video hide">';

                                        foreach ($videos as $video) {
                                            if (in_array($video['type'], array('youtube', 'vimeo'))) {
                                                if (in_array($video['type'], array('youtube', 'vimeo'))) {
                                                    if (isset($video['atts']['url']) && !empty($video['atts']['url'])) {
                                                        $light_box_inline.= sprintf('<a class="lightbox" href="%s" title="%s" rel="%s"></a>', $video['atts']['url'], $post_title, $rel);
                                                    }
                                                }
                                            } else if ('video' == $video['type']) {
                                                $ajax_url = admin_url(sprintf('admin-ajax.php?ajax=true&post_id=%s&post_format=%s&action=kopa_load_post&ajax_nonce=%s', $post_id, $post_format, wp_create_nonce('kopa_load_post')));
                                                $light_box_inline.= sprintf('<a class="lightbox" href="%s&height=280" rel="%s"></a>', $ajax_url, $rel);
                                            }
                                        }

                                        $light_box_inline.= '</div>';
                                        $light_box_url = '#';
                                        $light_box_onclick = 'onclick="KopaLightbox.openVideo(event, jQuery(this));"';
                                    }
                                }
                            } else {
                                $light_box_url = $post_url;
                            }
                            ?>
                            <div class="entry-thumb hover-effect">
                                <a href="<?php echo $light_box_url; ?>" <?php echo $light_box_onclick; ?> class="<?php echo implode(' ', $light_box_thumb_classes) ?>"><img src="<?php echo $image_croped; ?>" alt="" /></a>                                        
                                <?php if (!empty($light_box_classes)) { ?>
                                    <a href="<?php echo $light_box_url; ?>" class="<?php echo implode(' ', $light_box_classes); ?>" <?php echo $light_box_onclick; ?>></a>
                                <?php } ?>                                
                            </div>
                            <?php echo (!empty($light_box_inline)) ? $light_box_inline : ''; ?>
                            <?php
                        }
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
                                <a class="more-link clearfix" href="<?php echo $post_url; ?>"><span class="entry-icon icon-popup"></span><span><?php _e('Read more ...', kopa_get_domain()); ?></span></a>
                                    <?php endif; ?>
                        </div>                            
                    </article>                        
                </div>
                <?php
                $index++;
            endwhile;
            if ((0 !== ($posts->post_count - 1) % $post_per_row) || 1 == $post_per_row || ($posts->post_count < $post_per_row)) {
                echo '</div></div>';
            }                        
        } else {
            _e('Posts not found. Pleae config this widget again!', kopa_get_domain());
        }
        wp_reset_postdata();

        echo $after_widget;
    }

}