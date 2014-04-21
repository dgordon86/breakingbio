jQuery(window).load(function() {
    /**
     * GET LASTEST PHOTOS FROM FLICKR.COM BY USER-ID
     */
    var flickrs = jQuery('.flickr-wrap');
    if (flickrs.length > 0) {
        jQuery.each(flickrs, function(index, item) {
            id = jQuery(this).attr('data-id');
            limit = parseInt(jQuery(this).attr('data-limit'));

            jQuery(this).find('ul').jflickrfeed({
                qstrings: {
                    id: id
                },
                limit: (limit > 0) ? limit : 20,
                itemTemplate:
                        '<li class="flickr-item">' +
                        '<a target="_blank" href="{{link}}" class="kopa-tool-tip" title="{{title}}">' +
                        '<img src="{{image_s}}" class="img-responsive" width=75 height=75>' +
                        '</a>' +
                        '</li>'
            }, function(data) {
                jQuery('.flickr-item > a').tooltip();
            });
        });
    }
});


jQuery(document).ready(function() {
    AudioPlayer.setup(kopa_variable.url.audio_swf, {
        width: '100%'
    });
});

jQuery(window).load(function() {
    var audios = jQuery('.kopa-audio-player');
    jQuery.each(audios, function() {
        AudioPlayer.embed(jQuery(this).attr('id'), {soundFile: jQuery(this).attr('data-file')});
    });
});

var KopaLightbox = {
    openInline: function(event, obj) {
        event.preventDefault();
        obj.parents('.entry-item').find('.kopa-popup-inline a.lightbox').first().click();
    },
    openGallery: function(event, obj) {
        event.preventDefault();
        obj.parents('.entry-item').find('.kopa-popup-gallery a.lightbox').first().click();
    },
    openVideo: function(event, obj) {
        event.preventDefault();
        obj.parents('.entry-item').find('.kopa-popup-video a.lightbox').first().click();
    }
};
/* =========================================================
 prettyPhoto
 ============================================================ */
jQuery(document).ready(function() {
    init_image_effect();
});
jQuery(window).resize(function() {
    init_image_effect();
});
function init_image_effect() {
    var view_p_w = jQuery(window).width();
    var pp_w = 500;
    var pp_h = 344;
    if (view_p_w <= 479) {
        pp_w = '120%';
        pp_h = '100%';
    }
    else if (view_p_w >= 480 && view_p_w <= 599) {
        pp_w = '100%';
        pp_h = '170%';
    }

    var pp_args = new Object();

    pp_args.deeplinking = false;
    pp_args.default_width = pp_w;
    pp_args.default_height = pp_h;
    pp_args.theme = kopa_variable.lightbox.prettyPhoto.theme;
    pp_args.modal = ('true' === kopa_variable.lightbox.prettyPhoto.modal) ? true : false;
    pp_args.opacity = parseFloat(kopa_variable.lightbox.prettyPhoto.opacity);

    if ('false' === kopa_variable.lightbox.prettyPhoto.social_tools) {
        pp_args.social_tools = '';
    }

    jQuery("a[rel^='lightbox']").prettyPhoto(pp_args);
}


jQuery(document).ready(function($) {
    var social_links = jQuery('a.kopa-social-link');
    if (social_links.length > 0) {
        social_links.tooltip({});
    }

    if (kopa_variable.template.post_id > 0) {
        jQuery.ajax({
            type: 'POST',
            url: kopa_variable.ajax.url,
            dataType: 'json',
            async: true,
            timeout: 5000,
            data: {
                action: 'kopa_set_view_count',
                wpnonce: jQuery('#kopa_set_view_count_wpnonce').val(),
                post_id: kopa_variable.template.post_id
            },
            beforeSend: function(XMLHttpRequest, settings) {
            },
            complete: function(XMLHttpRequest, textStatus) {
            },
            success: function(data) {
                count = parseInt(data.count);
                if (count > 0) {
                    if (1 === count && jQuery('.kopa-total-views-for-singular').length > 0) {
                        jQuery('.kopa-total-views-for-singular').html(count + ' ' + kopa_variable.i18n.VIEW);
                    } else {
                        jQuery('.kopa-total-views-for-singular').html(count + ' ' + kopa_variable.i18n.VIEWS);
                    }
                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
});

/* =========================================================
 Sub menu
 ==========================================================*/
(function($) {
    jQuery(document).ready(function() {
        jQuery('#main-menu').superfish({
            cssArrows: false
        });
    });

    jQuery("#main-menu  ul.sub-menu").parent().find('a:first').append("<span></span>");

    jQuery('#mobile-menu > span').click(function() {
        var mobile_menu = jQuery('#toggle-view-menu');
        if (mobile_menu.is(':hidden')) {
            mobile_menu.slideDown('300');
        } else {
            mobile_menu.slideUp('300');
        }
    });

    jQuery("#toggle-view-menu").navgoco({
        caret: '<span class="mobile-caret">+</span>',
        accordion: false,
        openClass: 'open',
        save: true,
        cookie: {
            name: 'navgoco',
            expires: false,
            path: '/'
        },
        slide: {
            duration: 400,
            easing: 'swing'
        },
        onToggleAfter: function(submenu, opened) {
            var caret = submenu.parent().find('span.mobile-caret').first();
            if (opened) {
                caret.text('-');
            } else {
                caret.text('+');
            }
        }
    });

    if (jQuery('#secondary-nav').length > 0) {
        createMobileMenu('#secondary-nav', 'secondary-responsive-menu');
    }
    if (jQuery('#bottom-nav').length > 0) {
        createMobileMenu('#bottom-nav', 'responsive-menu');
    }

})(jQuery);

/**
 * 
 * @param {object} menu_id
 * @param {string} mobile_menu_id
 */

function createMobileMenu(menu_id, mobile_menu_id) {
    // Create the dropdown base
    jQuery("<select />").appendTo(menu_id);
    jQuery(menu_id).find('select').first().attr("id", mobile_menu_id);

    // Populate dropdown with menu items
    jQuery(menu_id).find('a').each(function() {
        var el = jQuery(this);

        var selected = '';
        if (el.parent().hasClass('current-menu-item')) {
            selected = "selected='selected'";
        }

        var depth = el.parents("ul").size();
        var space = '';
        if (depth > 1) {
            for (i = 1; i < depth; i++) {
                space += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }

        jQuery("<option " + selected + " value='" + el.attr("href") + "'>" + space + el.text() + "</option>").appendTo(jQuery(menu_id).find('select').first());
    });
    jQuery(menu_id).find('select').first().change(function() {
        window.location = jQuery(this).find("option:selected").val();
    });
}

/* =========================================================
 HeadLine Scroller
 ============================================================ */
jQuery(function() {
    if (jQuery('.ticker-1').length > 0) {
        var _scroll = {
            delay: 1000,
            easing: 'linear',
            items: 1,
            duration: 0.07,
            timeoutDuration: 0,
            pauseOnHover: 'immediate'
        };
        jQuery('.ticker-1').carouFredSel({
            width: 1000,
            align: false,
            items: {
                width: 'variable',
                height: 35,
                visible: 1
            },
            scroll: _scroll
        });
        jQuery('.caroufredsel_wrapper').css('width', '100%');
    }
});
/* =========================================================
 Flex slider
 ============================================================ */
jQuery(window).load(function() {
    var sliders = jQuery('.kp-featured-widget');
    if (sliders.length > 0) {
        jQuery.each(sliders, function(index, val) {
            var container = jQuery(this);
            var slideshow = ('true' == container.find('input.is_disable_slideshow').val()) ? false : true;
            
            jQuery(this).find('.flex-carousel').flexslider({
                animation: "slide",
                controlNav: false,
                directionNav: false,
                animationLoop: false,
                slideshow: slideshow,
                itemWidth: 111,
                itemMargin: 5,
                asNavFor: jQuery(this).find('.kp-featured-desktop-slider'),
                start: function(slider) {
                    container.find('.flex-carousel .slides > li').click(function() {
                        index = jQuery(this).attr('data-index');
                        container.find(".kp-featured-text-slider .flex-control-paging > li > a:contains('" + index + "')").click();
                    });
                }
            });
            jQuery(this).find('.kp-featured-news-slider').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: slideshow,
                sync: jQuery(this).find(".flex-carousel"),
                start: function(slider) {
                    jQuery('body').removeClass('loading');
                    container.find('.kp-featured-news-slider .flex-direction-nav li .flex-next').click(function() {
                        container.find('.kp-featured-text-slider .flex-direction-nav li .flex-next').click();
                    });

                    container.find('.kp-featured-news-slider .flex-direction-nav li .flex-prev').click(function() {
                        container.find('.kp-featured-text-slider .flex-direction-nav li .flex-prev').click();
                    });
                }
            });



            jQuery(this).find('.kp-featured-text-slider').flexslider({
                animation: "slide",
                controlNav: true,
                animationLoop: false,
                slideshow: slideshow,
                start: function(slider) {
                    jQuery('body').removeClass('loading');
                }
            });              
        });
    }

    if (jQuery(".kp-single-slider").length > 0) {
        jQuery('.kp-single-slider').flexslider({
            animation: "slide",
            controlNav: false,
            slideshow: true,
            start: function(slider) {
                jQuery('body').removeClass('loading');
            }
        });
    }
});


/* =========================================================
 Masonry
 ============================================================ */
jQuery(function() {
    var container = jQuery('.masonry-container');
    if (container.length > 0) {
        container.imagesLoaded(function() {
            container.masonry({
                itemSelector: '.masonry-box',
                columnWidth: 1,
                isAnimated: !Modernizr.csstransitions,
                isFitWidth: true
            });
        });
    }
});
/* =========================================================
 Dropdown sharebox
 ============================================================ */
jQuery(document).ready(function() {
    jQuery(".share-box .social-links").hover(function() {
        jQuery(this).find("ul").first().slideDown(100);
    }, function() {
        jQuery(this).find("ul").first().slideUp(100);
    });
});
jQuery(document).ready(function() {
    /**
     * BOOTSTRAP COLLAPSE
     */
    var panel_titles = jQuery('.panel-title a');
    if (panel_titles.length > 0) {
        panel_titles.click(function() {
            parent = jQuery(this).attr('data-parent');
            //ACCORDION
            if (undefined !== parent) {
                var obj_actived = jQuery(parent).find('.panel-heading.active');
                obj_actived.removeClass('active');
                obj_actived.find('span.kopa-collapse').html('+');
                if (jQuery(this).hasClass('collapsed')) {
                    jQuery(this).parents('.panel-heading').addClass('active');
                    jQuery(this).find('span.kopa-collapse').html('-');
                } else {
                    jQuery(this).parents('.panel-heading').removeClass('active');
                    jQuery(this).find('span.kopa-collapse').html('+');
                }
            } else {
                //TOGGLE
                parent = jQuery(this).parents('.panel-heading');
                if (parent.hasClass('active')) {
                    parent.removeClass('active');
                    jQuery(this).find('span.kopa-collapse').html('+');
                } else {
                    parent.addClass('active');
                    jQuery(this).find('span.kopa-collapse').html('-');
                }
            }
        });
    }

    if (jQuery('#kp-map').length > 0) {
        var lat = parseFloat(jQuery('#kp-map').attr('data-latitude'));
        var lng = parseFloat(jQuery('#kp-map').attr('data-longitude'));
        gmap = new GMaps({
            el: '#kp-map',
            lat: lat,
            lng: lng,
            zoomControl: true,
            zoomControlOpt: {
                style: 'SMALL',
                position: 'TOP_LEFT'
            },
            panControl: false,
            streetViewControl: false,
            mapTypeControl: false,
            overviewMapControl: false
        });

        var marker_info = {
            lat: lat,
            lng: lng
        };

        if ('' !== kopa_variable.contact.marker) {
            marker_info.icon = kopa_variable.contact.marker;
        }

        if ('' !== kopa_variable.contact.address) {
            marker_info.infoWindow = {
                content: kopa_variable.contact.address
            };
        }
        gmap.addMarker(marker_info);
    }
    if (jQuery("#contact-form").length > 0) {
        var i18n = kopa_variable.i18n.validate;
        jQuery('#contact-form').validate({
            rules: {
                contact_name: {
                    required: true,
                    minlength: 2
                },
                contact_email: {
                    required: true,
                    email: true
                },
                contact_url: {
                    url: true
                },
                contact_message: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                contact_name: {
                    required: i18n.name.REQUIRED,
                    minlength: jQuery.format(i18n.name.MINLENGTH)
                },
                contact_email: {
                    required: i18n.email.REQUIRED,
                    email: i18n.email.EMAIL
                },
                contact_url: {
                    required: i18n.url.REQUIRED,
                    url: i18n.url.URL
                },
                contact_message: {
                    required: i18n.message.REQUIRED,
                    minlength: jQuery.format(i18n.message.MINLENGTH)
                }
            },
            submitHandler: function(form) {
                var recaptcha_response = jQuery('#contact-form').find("[name=recaptcha_response_field]");

                if (kopa_variable.recaptcha.status) {
                    if (undefined !== recaptcha_response && '' !== jQuery.trim(recaptcha_response.val())) {
                        var recaptcha_challenge = jQuery('#contact-form').find("[name=recaptcha_challenge_field]");
                        jQuery.ajax({
                            type: 'POST',
                            url: kopa_variable.ajax.url,
                            dataType: 'json',
                            async: true,
                            data: {
                                action: 'kopa_check_recaptcha',
                                ajax_nonce_recaptcha: jQuery('#ajax_nonce_recaptcha').val(),
                                recaptcha_challenge: recaptcha_challenge.val(),
                                recaptcha_response: recaptcha_response.val()
                            },
                            beforeSend: function(XMLHttpRequest, settings) {
                                jQuery("#submit-contact").attr("value", i18n.form.CHECKING).attr('disabled', 'disabled');
                            },
                            complete: function(XMLHttpRequest, textStatus) {
                            },
                            success: function(data) {
                                if (data.is_valid) {
                                    jQuery("#submit-contact").attr("value", i18n.form.SENDING);

                                    jQuery(form).ajaxSubmit({
                                        success: function(responseText, statusText, xhr, $form) {
                                            jQuery("#contact_response").html(responseText).hide().slideDown("fast");
                                            jQuery("#submit-contact").attr("value", i18n.form.SUBMIT);

                                            jQuery(form).find('[name=contact_name]').val('');
                                            jQuery(form).find('[name=contact_email]').val('');
                                            jQuery(form).find('[name=contact_url]').val('');
                                            jQuery(form).find('[name=contact_message]').val('');
                                        }
                                    });
                                }
                                else {
                                    jQuery('#contact_response').html('<p class="failure">' + i18n.recaptcha.INVALID + '</p>');
                                }

                                Recaptcha.reload();
                                recaptcha_response.val('');
                                jQuery("#submit-contact").val(i18n.form.SUBMIT).removeAttr('disabled');
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                            }
                        });

                    } else {
                        jQuery('#contact_response').html('<p class="failure">' + i18n.recaptcha.REQUIRED + '</p>');
                    }
                } else {
                    jQuery(form).ajaxSubmit({
                        success: function(responseText, statusText, xhr, $form) {
                            jQuery("#submit-contact").attr("value", i18n.form.SENDING).attr('disabled', 'disabled');

                            jQuery("#contact_response").html(responseText).hide().slideDown("fast");
                            jQuery("#submit-contact").attr("value", i18n.form.SUBMIT);

                            jQuery(form).find('[name=contact_name]').val('');
                            jQuery(form).find('[name=contact_email]').val('');
                            jQuery(form).find('[name=contact_url]').val('');
                            jQuery(form).find('[name=contact_message]').val('');

                            jQuery("#submit-contact").val(i18n.form.SUBMIT).removeAttr('disabled');
                        }
                    });
                }

                return false;
            }
        });
    }
});

/**
 * BACK-TO-TOP
 */

jQuery(document).ready(function() {
    // hide #back-top first
    jQuery("#back-top").hide();
    // fade in #back-top
    jQuery(function() {
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > 200) {
                jQuery('#back-top').fadeIn();
            } else {
                jQuery('#back-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        jQuery('#back-top a').click(function() {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
});