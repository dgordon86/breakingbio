var kopa_uploader;

function kopa_pattern_change(event, obj) {
    var parent = obj.parents('.row');
    if (!obj.hasClass('active')) {
        parent.find('.radio-pattern-item.active').removeClass('active');
        obj.addClass('active');
    }
}

function kopa_color_swatches_change(event, obj) {
    var primary = obj.attr('data-primary');
    var secondary = obj.attr('data-secondary');

    jQuery('#primary_color').iris('color', primary);
    jQuery('#link_color').iris('color', primary);
    jQuery('#secondary_color').iris('color', secondary);
    jQuery('#link_color_hover').iris('color', secondary);
}


jQuery(function($) {
    /*MULTI-TEXT*/
    var kopaUIMultiText = jQuery(".kopa-ui-multi-text");
    if (kopaUIMultiText.length > 0) {
        kopaUIMultiText.sortable({
            handle: '.kopa-sortable-handle',
            placeholder: 'multi-text-placeholder',
            tolerance: 'pointer'
        });

        kopaUIMultiText.on("click", 'a', function(e) {
            e.preventDefault();

            var button = jQuery(e.currentTarget);
            var li = button.parent();
            var ul = li.parent();

            switch (button.attr("data-action")) {
                case "add":
                    clone = li.clone();
                    clone.find("input[type=text]").val("").end();
                    clone.find("input[type=hidden]").val(new KopaUtil().getRandomID('rating-index-')).end();
                    li.after(clone);
                    break;
                case "delete":
                    if (ul.find('li').length > 1) {
                        li.remove();
                    } else {
                        li.find("input[type=text]").val("").end();
                    }
                    break;
            }
        });
    }
});

jQuery(function($) {
    /*RATING*/
    var kopaUIRating = jQuery(".kopa-ui-rating");
    if (kopaUIRating.length > 0) {
        kopaUIRating.sortable({
            handle: '.rating-handle',
            placeholder: 'rating-placeholder',
            tolerance: 'pointer'

        });

        kopaUIRating.on("click", 'a', function(e) {
            e.preventDefault();

            var button = jQuery(e.currentTarget);
            var li = button.parent();
            var ul = li.parent();

            switch (button.attr("data-action")) {
                case "add":
                    clone = li.clone();
                    clone.find("input[type=text]").val("").end();
                    clone.find("input[type=hidden]").val(new KopaUtil().getRandomID('rating-index-')).end();

                    li.after(clone);

                    break;
                case "delete":
                    if (ul.find('li').length > 1) {
                        li.remove();
                    } else {
                        li.find("input[type=text]").val("").end();
                    }
                    break;
            }
        });
    }


    /*UPLOADER*/
    kopa_uploader_init();

    /**
     * COLOR PICKER     
     */
    var colours = jQuery('.kopa-ui-color');
    if (colours.length > 0) {
        colours.wpColorPicker({
            defaultColor: false,
            change: function(event, ui) {
            },
            clear: function() {
            },
            hide: true,
            palettes: true
        });
    }
});

function KopaUtil() {
    this.getRandomID = function getRandomID(prefix) {
        return prefix + Math.random().toString(36).substr(2);
    };
}

function kopa_uploader_init() {
    jQuery('.kopa-ui-media-upload').click(function(event) {
        event.preventDefault();
        button = jQuery(this);
        if (kopa_uploader) {
            kopa_uploader.open();
            return;
        }
        kopa_uploader = wp.media.frames.kopa_uploader = wp.media({
            title: kopa_variable.i18n.uploader.media_center,
            button: {
                text: kopa_variable.i18n.uploader.choose_image
            },
            multiple: false
        });
        kopa_uploader.on('select', function() {
            attachment = kopa_uploader.state().get('selection').first().toJSON();
            button.addClass('ui-hide');
            button.parent().find('.kopa-ui-media').val(attachment.url);
            button.parent().find('img').attr('src', attachment.url).removeClass('ui-hide');
            button.parent().find('.kopa-ui-media-remove').removeClass('ui-hide');
            button.parent().addClass('has-image');
        });
        kopa_uploader.open();
    });

    jQuery('.kopa-ui-media-remove').click(function(event) {
        event.preventDefault();
        button = jQuery(this);
        button.addClass('ui-hide');
        button.parent().find('.kopa-ui-media').val('');
        button.parent().find('img').attr('src', '').addClass('ui-hide');
        button.parent().removeClass('has-image');
        button.parent().find('.kopa-ui-media-upload').removeClass('ui-hide');
    });
}


var KopaUI = {
    select_colorSwatchesSingle: function(event, obj) {
        var primary = obj.attr('data-primary');
        if ('customize' !== primary) {
            jQuery('#kopa-group-custom_colors').hide();
            jQuery('#primary_color').iris('color', primary);
            jQuery('#link_color_hover').iris('color', primary);
            jQuery('#nav_link_hover_color').iris('color', primary);
        } else {
            jQuery('#kopa-group-custom_colors').show();
        }
    }
};

jQuery(document).ready(function() {
    jQuery('.color-swatches-item input:checked').parent().click();
});