var kopaContainerType = 'tab';

(function() {
    tinymce.create('tinymce.plugins.kopa_shortcode', {
        createControl: function(n, cm) {
            switch (n) {
                case 'kopa_shortcode':
                    var c = cm.createSplitButton('kopa_shortcode', {
                        title: kopa_variable.i18n.shortcodes,
                        image: kopa_variable.dir_images + '/icons/shortcodes.png',
                        onclick: function() {

                        }
                    });
                    c.onRenderMenu.add(function(c, m) {
                        m.add({title: kopa_variable.i18n.shortcodes, 'class': 'mceMenuItemTitle'}).setDisabled(1);


                        /**
                         * CONTAINER
                         */
                        var grid = m.addMenu({title: kopa_variable.i18n.grid, icon: 'grid'});
                        var grid_icons = new Array(
                                '11',
                                '12_12',
                                '13_13_13',
                                '13_23',
                                '14_12_14',
                                '14_14_14_14',
                                '14_34',
                                '16_46_16',
                                '16_16_16_12',
                                '16_16_16_16_16_16',
                                '23_13',
                                '56_16');

                        var grid_titles = new Array(
                                '1/1',
                                '1/2 - 1/2',
                                '1/3 - 1/3 - 1/3',
                                '1/3 - 2/3',
                                '1/4 - 1/2 - 1/4',
                                '1/4 - 1/4 - 1/4 - 1/4',
                                '1/4 - 3/4',
                                '1/6 - 4/6 - 1/6',
                                '1/6 - 1/6 - 1/6 - 1/2',
                                '1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6',
                                '2/3 - 1/3',
                                '5/6 - 1/6'
                                );

                        var grid_shortcodes = new Array(10);

                        // Row: 1/1
                        grid_shortcodes[0] = '[col col=12]TEXT[/col]<br/>';

                        // Row: 1/2 + 1/2
                        grid_shortcodes[1] = '[col col=6]TEXT[/col]<br/>';
                        grid_shortcodes[1] += '[col col=6]TEXT[/col]<br/>';

                        // Row: 1/3 - 1/3 - 1/3
                        grid_shortcodes[2] = '[col col=4]TEXT[/col]<br/>';
                        grid_shortcodes[2] += '[col col=4]TEXT[/col]<br/>';
                        grid_shortcodes[2] += '[col col=4]TEXT[/col]<br/>';

                        // Row: 1/3 - 2/3
                        grid_shortcodes[3] = '[col col=4]TEXT[/col]<br/>';
                        grid_shortcodes[3] += '[col col=8]TEXT[/col]<br/>';

                        // Row: 1/4 - 1/2 - 1/4
                        grid_shortcodes[4] = '[col col=3]TEXT[/col]<br/>';
                        grid_shortcodes[4] += '[col col=6]TEXT[/col]<br/>';
                        grid_shortcodes[4] += '[col col=3]TEXT[/col]<br/>';

                        // Row: 1/4 - 1/4 - 1/4 - 1/4
                        grid_shortcodes[5] = '[col col=3]TEXT[/col]<br/>';
                        grid_shortcodes[5] += '[col col=3]TEXT[/col]<br/>';
                        grid_shortcodes[5] += '[col col=3]TEXT[/col]<br/>';
                        grid_shortcodes[5] += '[col col=3]TEXT[/col]<br/>';

                        // Row: 1/4 - 3/4
                        grid_shortcodes[6] = '[col col=3]TEXT[/col]<br/>';
                        grid_shortcodes[6] += '[col col=9]TEXT[/col]<br/>';

                        // Row: 1/6 - 4/6 - 1/6
                        grid_shortcodes[7] = '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[7] += '[col col=6]TEXT[/col]<br/>';
                        grid_shortcodes[7] += '[col col=2]TEXT[/col]<br/>';

                        // Row: 1/6 - 1/6 - 1/6 - 1/2
                        grid_shortcodes[8] = '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[8] += '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[8] += '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[8] += '[col col=6]TEXT[/col]<br/>';

                        // Row: 1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6
                        grid_shortcodes[9] = '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[9] += '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[9] += '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[9] += '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[9] += '[col col=2]TEXT[/col]<br/>';
                        grid_shortcodes[9] += '[col col=2]TEXT[/col]<br/>';

                        // Row: 2/3 - 1/3
                        grid_shortcodes[10] = '[col col=8]TEXT[/col]<br/>';
                        grid_shortcodes[10] += '[col col=4]TEXT[/col]<br/>';

                        // Row: 5/6 - 1/6
                        grid_shortcodes[11] = '[col col=10]TEXT[/col]<br/>';
                        grid_shortcodes[11] += '[col col=2]TEXT[/col]<br/>';

                        jQuery.each(grid_titles, function(index, title) {
                            grid.add({title: title, icon: grid_icons[index], onclick: function() {
                                    var shortcode = '[row]<br/>';
                                    shortcode += grid_shortcodes[index];
                                    shortcode += '[/row]<br/>';

                                    tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
                                }});
                        });

                        /**
                         * CONTAINER
                         */
                        var container = m.addMenu({title: kopa_variable.i18n.container, icon: 'container'});
                        container.add({title: 'Tab', icon: 'tabs', onclick: function() {
                                kopaContainerType = 'tab';

                                jQuery.colorbox({
                                    inline: true,
                                    top: 50,
                                    innerWidth: '80%',
                                    maxWidth: '100%',
                                    overlayClose: false,
                                    href: "#kopa_container_builder"
                                });
                            }});
                        container.add({title: kopa_variable.i18n.accordion, icon: 'accordion', onclick: function() {
                                kopaContainerType = 'accordion';

                                jQuery.colorbox({
                                    inline: true,
                                    top: 50,
                                    innerWidth: '80%',
                                    maxWidth: '100%',
                                    overlayClose: false,
                                    href: "#kopa_container_builder"
                                });
                            }});
                        container.add({title: kopa_variable.i18n.toggle, icon: 'accordion', onclick: function() {
                                kopaContainerType = 'toggle';

                                jQuery.colorbox({
                                    inline: true,
                                    top: 50,
                                    innerWidth: '80%',
                                    maxWidth: '100%',
                                    overlayClose: false,
                                    href: "#kopa_container_builder"
                                });
                            }});

                        /**
                         * 
                         * VIDEO
                         */
                        var video = m.addMenu({title: kopa_variable.i18n.video, icon: 'video'});
                        video.add({title: kopa_variable.i18n.youtube, icon: 'youtube', onclick: function() {
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[youtube url="http://www.youtube.com/watch?v=1iIZeIy7TqM"]');
                            }});

                        video.add({title: kopa_variable.i18n.vimeo, icon: 'vimeo', onclick: function() {
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[vimeo url="http://vimeo.com/7449107"]');
                            }});

                        video.add({title: kopa_variable.i18n.mp4, icon: 'mp4', onclick: function() {
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[video mp4="http://link-to-file.mp4"][/video]');
                            }});

                        /**
                         * 
                         * DROPCAPS
                         */
                        var dropcap = m.addMenu({title: kopa_variable.i18n.dropcap, icon: 'dropcap'});
                        dropcap.add({title: kopa_variable.i18n.square, icon: 'square', onclick: function() {
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[dropcap class="kp-dropcap"]' + tinyMCE.activeEditor.selection.getContent() + '[/dropcap]');
                            }});

                        dropcap.add({title: kopa_variable.i18n.circle, icon: 'circle', onclick: function() {
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[dropcap class="kp-dropcap radius"]' + tinyMCE.activeEditor.selection.getContent() + '[/dropcap]');
                            }});

                        /**
                         * 
                         * Heading
                         */
                        m.add({
                            title: kopa_variable.i18n.caption,
                            icon: 'caption',
                            onclick: function() {
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[caption]' + tinyMCE.activeEditor.selection.getContent() + '[/caption]');
                            }
                        });

                        /**
                         * 
                         * Button
                         */
                        m.add({
                            title: kopa_variable.i18n.button,
                            icon: 'button',
                            onclick: function() {
                                jQuery.colorbox({
                                    inline: true,
                                    innerWidth: '80%',
                                    top: 50,
                                    maxWidth: '100%',
                                    overlayClose: false,
                                    href: "#kopa_button_builder"
                                });
                            }
                        });

                        /**
                         * 
                         * Contact
                         */
                        m.add({
                            title: kopa_variable.i18n.share_this_post,
                            icon: 'share',
                            onclick: function() {
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[share_this_post]');
                            }
                        });

                        /**
                         * 
                         * Contact
                         */
                        m.add({
                            title: kopa_variable.i18n.contact_form,
                            icon: 'mail',
                            onclick: function() {
                                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[contact_form]');
                            }
                        });



                        m.showMenu(100, 100);

                    });
                    return c;
            }
            return null;
        }
    });
    tinymce.PluginManager.add('kopa_shortcode', tinymce.plugins.kopa_shortcode);
})();

var KopaShortcode = {
    add_container_element: function(event, wrap) {
        event.preventDefault();
        var last_item = wrap.find('.kopa_shortcode_container_element').last();
        var clone = last_item.clone();
        clone.find('textarea').text('');
        clone.insertAfter(last_item);
        jQuery.colorbox.resize();
    },
    remove_container_element: function(event, obj) {
        event.preventDefault();
        var items = obj.parents('.kopa_shortcode_inline').find('.kopa_shortcode_container_element');
        if (items.length > 1) {
            obj.parents('.kopa_shortcode_container_element').remove();
        } else {
            items.find('textarea').val('');
        }

        jQuery.colorbox.resize();
    },
    create_button: function(event, type) {
        event.preventDefault();

        if ('button' === type) {
            var text = jQuery('.ks_button_text').val();
            var link = jQuery('.ks_button_link').val();
            var link_target = jQuery('.ks_button_link_target option:selected').val();
            var type = jQuery('.ks_button_type:checked').val();

            if ('' !== jQuery.trim(text)) {
                var shortcode = '[button class="' + type + '" link="' + link + '" target="' + link_target + '"]' + text + '[/button]';
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
                jQuery.colorbox.close();

                jQuery('.ks_button_text').val('');
                jQuery('.ks_button_link').val('');
                jQuery('.ks_button_link_target option').first().attr('selected', 'selected');
                jQuery('.ks_button_type').first().attr('checked', 'checked');
            } else {
                alert('Please enter button text.');
            }
        } else if ('container' === type) {
            kopaContainerType = ('' !== kopaContainerType) ? kopaContainerType : 'tab';

            var elements = jQuery('.kopa_shortcode_container_element');

            var shortcode = '[' + kopaContainerType + 's]<br/>';
            jQuery.each(elements, function() {
                title = jQuery(this).find('.kopa_container_element_title').val();
                content = jQuery(this).find('.kopa_container_element_content').val();

                shortcode += '[' + kopaContainerType + ' title="' + title + '"]<br/>';
                shortcode += content + '<br/>';
                shortcode += '[/' + kopaContainerType + ']<br/>';
            });
            shortcode += '[/' + kopaContainerType + 's]<br/>';


            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
            jQuery.colorbox.close();
        }

    }
};
