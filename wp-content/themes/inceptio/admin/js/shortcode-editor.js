/*global tinyMCE */
/*global edCanvas */
/*global edInsertContent */
/*global tb_remove */
/*global Base64 */
/*global AdminUtil */
/*global alert */

var ShortCodeUtil = {

    addToEditor: function (sc) {
        "use strict";
        AdminUtil.addToEditor(sc);
    },

    replaceParagraphsWithShortCode: function (value) {
        "use strict";
        while (value.indexOf('<p>') >= 0) {
            value = value.replace('<p>', '[p]');
        }
        while (value.indexOf('<P>') >= 0) {
            value = value.replace('<P>', '[p]');
        }

        while (value.indexOf('</p>') >= 0) {
            value = value.replace('</p>', '[/p]');
        }
        while (value.indexOf('</P>') >= 0) {
            value = value.replace('</P>', '[/p]');
        }

        return value;
    },

    removeNewLine: function (value) {
        "use strict";
        while (value.indexOf('\n') >= 0) {
            value = value.replace('\n', '');
        }

        return value;
    },

    getShortCode: function (formId) {
        "use strict";
        var scName = jQuery('#' + formId).data('sc');
        var content = '';
        var attributes = '';
        jQuery('#' + formId + " :input").each(function () {
            var field = jQuery(this);
            var isHiddenField = field.attr('type') === 'hidden';
            if (isHiddenField || field.is(":visible")) {
                var attrType = field.data('attr-type');
                if (attrType) {
                    if (attrType === 'content') {
                        content = field.val().replace('\n', '');
                    } else {
                        var attrName = field.data('attr-name');
                        var val = field.val();
                        if (field.is(':checkbox')) {
                            val = field.is(':checked') ? 'true' : 'false';
                        }
                        if (val.length > 0) {
                            if (jQuery.isArray(val)) {
                                val = val.join(',');
                            }
                            attributes += ' ' + attrName + '="' + val + '"';
                        }
                    }
                }
            }
        });
        return '[' + scName + attributes + ']' + content + '[/' + scName + ']';
    },

    resetForm: function (formId) {
        "use strict";
        jQuery('#' + formId + " :input").each(function () {
            var field = jQuery(this);
            var tagName = field.prop("nodeName").toLowerCase();
            if (tagName === 'select') {
                field.prop('selectedIndex', 0);
            } else {
                if (field.is(':checkbox')) {
                    field.attr("checked", field.prop("defaultChecked"));
                } else {
                    var defaultValue = field.prop("defaultValue");
                    if (defaultValue) {
                        field.val(defaultValue);
                    } else {
                        field.val('');
                    }
                }
            }
        });
    },

    replaceAll: function (search, to, value) {
        while (value.indexOf(search) >= 0) {
            value = value.replace(search, to);
        }
        return value;
    }

};

(function ($) {
    "use strict";
    $.fn.mediaLibraryImageSelector = function () {
        var imgSrcSelector = $(this);
        var imgSrcSelectorId = imgSrcSelector.attr('id');
        var imgPreviewId = imgSrcSelectorId + '-preview';
        var imgPreviewer = $('#' + imgPreviewId);

        previewSelectedImage();

        imgSrcSelector.on('change', function () {
            previewSelectedImage();
        });

        function previewSelectedImage() {
            $('#' + imgSrcSelectorId + ' option:selected').each(function () {
                var imgSrc = $(this).data('src');
                if (imgSrc) {
                    imgPreviewer.attr('src', imgSrc);
                } else {
                    imgPreviewer.attr('src', '');
                }
            });
        }

    };

})(jQuery);

jQuery(document).ready(function ($) {
    "use strict";
    $(document).on('click', '#shortcode-editor-button-id', function () {
        return AdminUtil.openThickBoxDialog(this, {width: 900, height: 550}, function () {
            var windowTitleHeight = $("#TB_title").height();
            var windowHeight = $("#TB_window").height();
            var windowContentHeight = windowHeight - windowTitleHeight - 20;
            $('#TB_ajaxContent').height(windowContentHeight);
            $(".tabs").tabs();
            $(".accordion").accordion({
                header: '.accordion-title',
                active: false,
                animate: false,
                collapsible: true,
                autoHeight: false,
                heightStyle: 'content'
            });
            $(".color-thumbs").each(function () {
                $(this).colorRadioButtons();
            });
            $(".image-selector").each(function () {
                $(this).mediaLibraryImageSelector();
            });
            $(".sortable-slides").each(function () {
                $(this).sortable();
            });

            initDialogs();
            jQuery("#TB_window").on('tb_unload', function () {
                destroyDialogs();
            });

        });
    });

    function destroyDialogs() {
        $('#sc-imgg-slide-dialog').dialog('destroy');
        $('#sc-slider-slide-dialog').dialog('destroy');
    }

    function initDialogs() {

        var scImggSlideDialogSubmitListener;
        var scImggSlideDialogCancelListener;
        $("#sc-imgg-slide-dialog").dialog({
            autoOpen: false,
            width: 660,
            modal: true,
            resizable: false,
            dialogClass: 'wp-dialog',
            open: function () {
                scImggSlideDialogSubmitListener = function () {
                    if ($('#sc-imgg-slide-form').valid()) {

                        var imgNameSelector = $('#sc-imgg-slide-src');
                        var titleEl = $('#sc-imgg-slide-title');
                        var captionEl = $('#sc-imgg-slide-caption');
                        var urlEl = $('#sc-imgg-slide-url');

                        var title = titleEl.val();
                        var caption = captionEl.val();
                        var imgName = '';
                        var imgSrc = '';
                        var url = urlEl.val();
                        imgNameSelector.find('option:selected').each(function () {
                            imgSrc = $(this).data('src');
                            imgName = $(this).val();
                        });

                        imgName = ' data-img="' + imgName + '"';
                        caption = caption.length > 0 ? ' data-caption="' + caption + '"' : '';
                        title = title.length > 0 ? ' data-title="' + title + '"' : '';
                        url = url.length > 0 ? ' data-url="' + url + '"' : '';

                        var content = '<li' + imgName + caption + title + url + '>';
                        content += '<div><img alt="" src="' + imgSrc + '"></div>';
                        content += '<a href="#" class="delete-gallery-item">Delete</a>';
                        content += '</li>';

                        $('#sc-imgg-slides').append(content);
                        $("#sc-imgg-slide-dialog").dialog("close");
                    }
                    return false;
                };
                scImggSlideDialogCancelListener = function () {
                    $("#sc-imgg-slide-dialog").dialog("close");
                    return false;
                };
                $(document).on('click', '#sc-imgg-slide-form-submit', scImggSlideDialogSubmitListener);
                $(document).on('click', '#sc-imgg-slide-form-cancel', scImggSlideDialogCancelListener);
            },
            close: function () {
                $(document).off('click', '#sc-imgg-slide-form-submit', scImggSlideDialogSubmitListener);
                $(document).off('click', '#sc-imgg-slide-form-cancel', scImggSlideDialogCancelListener);
                var imgNameSelector = $('#sc-imgg-slide-src');
                var titleEl = $('#sc-imgg-slide-title');
                var captionEl = $('#sc-imgg-slide-caption');
                var urlEl = $('#sc-imgg-slide-url');

                imgNameSelector.val('').trigger('change');
                titleEl.val('');
                captionEl.val('');
                urlEl.val('');
            }
        });

        var scSliderSlideDialogSubmitListener;
        var scSliderSlideDialogCancelListener;
        var scSliderSlideTypeChangeListener;
        $("#sc-slider-slide-dialog").dialog({
            autoOpen: false,
            width: 660,
            modal: true,
            resizable: false,
            dialogClass: 'wp-dialog',
            open: function () {
                scSliderSlideTypeChangeListener = function () {
                    var imgNameDiv = $('#sc-slider-slide-src').parent();
                    var titleDiv = $('#sc-slider-slide-title').parent();
                    var imgPreviewEl = $('#sc-slider-slide-src-preview');
                    var videoDiv = $('#sc-slider-slide-video').parent();
                    if ($('#sc-slider-slide-type').val() === 'image') {
                        videoDiv.hide();
                        imgNameDiv.show();
                        titleDiv.show();
                        imgPreviewEl.show();
                    } else {
                        videoDiv.show();
                        imgNameDiv.hide();
                        titleDiv.hide();
                        imgPreviewEl.hide();
                    }
                    return false;
                };
                scSliderSlideDialogSubmitListener = function () {
                    if ($('#sc-slider-slide-form').valid()) {
                        var slideTypeSelector = $('#sc-slider-slide-type');
                        var imgNameSelector = $('#sc-slider-slide-src');
                        var titleEl = $('#sc-slider-slide-title');
                        var videoEl = $('#sc-slider-slide-video');

                        var imgSrc;
                        var content = '';
                        if (slideTypeSelector.val() === 'image') {
                            var title = titleEl.val();
                            var imgName = '';
                            imgNameSelector.find('option:selected').each(function () {
                                imgSrc = $(this).data('src');
                                imgName = $(this).val();
                            });

                            imgName = ' data-img="' + imgName + '"';
                            title = title.length > 0 ? ' data-title="' + title + '"' : '';
                            content += '<li' + imgName + title + '>';
                        } else {
                            imgSrc = '';
                            var video = Base64.encode(videoEl.val());
                            video = ' data-video="' + video + '"';
                            content += '<li' + video + '>';
                        }

                        content += '<div><img alt="" src="' + imgSrc + '"></div>';
                        content += '<a href="#" class="delete-gallery-item">Delete</a>';
                        content += '</li>';

                        $('#sc-slider-slides').append(content);
                        $("#sc-slider-slide-dialog").dialog("close");
                    }
                    return false;
                };
                scSliderSlideDialogCancelListener = function () {
                    $("#sc-slider-slide-dialog").dialog("close");
                    return false;
                };
                $(document).on('change', '#sc-slider-slide-type', scSliderSlideTypeChangeListener);
                $(document).on('click', '#sc-slider-slide-form-submit', scSliderSlideDialogSubmitListener);
                $(document).on('click', '#sc-slider-slide-form-cancel', scSliderSlideDialogCancelListener);
                scSliderSlideTypeChangeListener();
            },
            close: function () {
                var slideTypeSelector = $('#sc-slider-slide-type');
                var imgNameSelector = $('#sc-slider-slide-src');
                var titleEl = $('#sc-slider-slide-title');
                var videoEl = $('#sc-slider-slide-video');

                slideTypeSelector.val('image');
                imgNameSelector.val('').trigger('change');
                titleEl.val('');
                videoEl.val('');

                $(document).off('click', '#sc-slider-slide-form-submit', scSliderSlideDialogSubmitListener);
                $(document).off('click', '#sc-slider-slide-form-cancel', scSliderSlideDialogCancelListener);
                $(document).off('change', '#sc-slider-slide-type', scSliderSlideTypeChangeListener);

            }
        });

    }

    //---------------------------------------------------- DIVIDER ------------------------------------------------------

    $(document).on('click', '#sc-hr-form-submit', function () {
        if ($('#sc-hr-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-hr-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //----------------------------------------------- HORIZONTAL SPACE -------------------------------------------------

    $(document).on('click', '#sc-hs-form-submit', function () {
        if ($('#sc-hs-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-hs-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //---------------------------------------------------- BUTTON ------------------------------------------------------

    $(document).on('click', '#sc-button-form-submit', function () {
        if ($('#sc-button-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-button-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //---------------------------------------------------- LIST --------------------------------------------------------

    $(document).on('change', '#sc-list-type', function () {
        $('#sc-list-style-div-ul').toggle();
        $('#sc-list-style-div-ol').toggle();
    });

    $(document).on('click', '#sc-list-form-submit', function () {
        if ($('#sc-list-form').valid()) {
            var tagName = $('#sc-list-type').val();
            var className = $('#sc-list-style-' + tagName).val();
            var content = $('#sc-list-items').val();

            var sc = '<' + tagName + ' class="' + className + '">\n';
            var elements = content.split("\n");
            for (var i = 0; i < elements.length; i++) {
                if (elements[i].length > 0) {
                    sc += '<li>' + elements[i] + '</li>\n';
                }
            }
            sc += '</' + tagName + '>\n';
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //--------------------------------------------------- INFO BOX -----------------------------------------------------

    $(document).on('click', '#sc-infobox-form-submit', function () {
        if ($('#sc-infobox-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-infobox-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------------- ICON BOX -------------------------------------------------------

    $(document).on('click', '#sc-iconbox-form-submit', function () {
        if ($('#sc-iconbox-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-iconbox-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------------ INTRO BOX -------------------------------------------------------

    $(document).on('click', '#sc-intro-form-submit', function () {
        if ($('#sc-intro-form').valid()) {
            var id = $.trim($('#sc-intro-id').val());
            var type = $.trim($('#sc-intro-type').val());
            var body = $.trim($('#sc-intro-body').val());
            var footer = $.trim($('#sc-intro-footer').val());
            var ribbonImg = $.trim($('#sc-intro-ribbon-img').val());

            ribbonImg = ribbonImg.length > 0 ? ' ribbon_img="' + ribbonImg + '"' : '';
            type = ' type="' + type + '"';
            body = '[intro_body]' + ShortCodeUtil.removeNewLine(ShortCodeUtil.replaceParagraphsWithShortCode(body)) + '[/intro_body]';
            if (id.length > 0) {
                id = ' id="' + id + '"';
            }
            if (footer.length > 0) {
                footer = '[intro_footer]' + ShortCodeUtil.removeNewLine(ShortCodeUtil.replaceParagraphsWithShortCode(footer)) + '[/intro_footer]';
            }
            var sc = '[intro' + type + id + ribbonImg + ']' + body + footer + '[/intro]';
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //--------------------------------------------------- IMAGE --------------------------------------------------------

    $(document).on('click', '#sc-img-form-submit', function () {
        if ($('#sc-img-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-img-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //----------------------------------------------- IMAGE GALLERY ----------------------------------------------------

    $(document).on('click', '.delete-gallery-item', function () {
        var slide = $(this).parent();
        slide.fadeOut(function () {
            $(this).remove();
        });
        return false;
    });

    $(document).on('click', '#sc-imgg-form-submit', function () {
        if ($('#sc-imgg-form').valid()) {
            var galleryName = $('#sc-imgg-name').val();
            var size = $('#sc-imgg-size').val();
            var lightbox = $('#sc-imgg-lightbox').is(':checked');
            var captionEnable = $('#sc-imgg-captionenable').is(':checked');
            var captionType = $('#sc-imgg-captiontype').val();
            var columns = $('#sc-imgg-cols').val();
            var align = $('#sc-imgg-align').val();

            galleryName = galleryName.length > 0 ? ' name="' + galleryName + '"' : '';
            size = ' size="' + size + '"';
            columns = ' columns="' + columns + '"';
            if (captionEnable) {
                captionType = ' caption_type="' + captionType + '"';
            } else {
                captionType = '';
            }
            if (columns === '1') {
                align = align.length > 0 ? ' align="' + align + '"' : '';
            } else {
                align = '';
            }
            lightbox = lightbox ? ' lightbox="true"' : ' lightbox="false"';

            var sc = '[gallery' + galleryName + size + columns + captionType + align + lightbox + ']';
            $('#sc-imgg-slides').find('li').each(function () {
                var $this = $(this);
                var src = ' src="' + $this.data('img') + '"';
                var title = '';
                var url = '';
                var caption = '';

                if ($this.data('title')) {
                    title = ' title="' + $this.data('title') + '"';
                }
                if ($this.data('url')) {
                    url = ' url="' + $this.data('url') + '"';
                }
                if (captionEnable && $this.data('caption')) {
                    caption = ' caption="' + $this.data('caption') + '"';
                }
                sc += '[gallery_item' + src + title + url + caption + '][/gallery_item]';
            });
            sc += '[/gallery]';
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    $(document).on('change', '#sc-imgg-captionenable', function () {
        var captionDivEl = $('#sc-imgg-captiontype').parent();
        if ($(this).is(":checked")) {
            captionDivEl.show();
        } else {
            captionDivEl.hide();
        }
    });

    $(document).on('change', '#sc-imgg-cols', function () {
        var alignDivEl = $('#sc-imgg-align').parent();
        if (this.value === '1') {
            alignDivEl.show();
        } else {
            alignDivEl.hide();
        }
    });

    $(document).on('click', '#sc-imgg-form-add', function () {
        $('#sc-imgg-slide-dialog').dialog('open');
        return false;
    });

    //----------------------------------------------- MEDIA SLIDER -----------------------------------------------------

    $(document).on('click', '#sc-slider-form-submit', function () {
        if ($('#sc-slider-form').valid()) {
            var size = $('#sc-slider-size').val();
            var align = $('#sc-slider-align').val();
            var animation = $('#sc-slider-animation').val();
            var animationSpeed = $('#sc-slider-animspeed').val();
            var slideshow = $('#sc-slider-slideshow').is(':checked');
            var controlNav = $('#sc-slider-controlnav').is(':checked');
            var directionNav = $('#sc-slider-directionnav').is(':checked');
            var slideshowSpeed = $('#sc-slider-slideshowspeed').val();

            size = ' size="' + size + '"';
            align = align.length > 0 ? ' align="' + align + '"' : '';
            animation = ' animation="' + animation + '"';
            animationSpeed = animationSpeed.length > 0 ? ' animation_speed="' + animationSpeed + '"' : '';
            slideshow = slideshow ? ' slideshow="true"' : ' slideshow="false"';
            controlNav = controlNav ? ' control_nav="true"' : ' control_nav="false"';
            directionNav = directionNav ? ' direction_nav="true"' : ' direction_nav="false"';
            slideshowSpeed = slideshowSpeed.length > 0 ? ' slideshow_speed="' + slideshowSpeed + '"' : '';

            var sc = '[slider' + size + align + animation + animationSpeed + slideshow + slideshowSpeed + controlNav + directionNav + ']';
            $('#sc-slider-slides').find('li').each(function () {
                var $this = $(this);

                if ($this.data('video')) {
                    sc += '[slider_item]' + Base64.decode($this.data('video')) + '[/slider_item]';
                } else {
                    var src = '';
                    var title = '';
                    if ($this.data('title')) {
                        title = ' title="' + $this.data('title') + '"';
                    }
                    if ($this.data('img')) {
                        src = ' src="' + $this.data('img') + '"';
                    }
                    sc += '[slider_item' + src + title + '][/slider_item]';
                }

            });
            sc += '[/slider]';
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    $(document).on('click', '#sc-slider-form-add', function () {
        $('#sc-slider-slide-dialog').dialog('open');
        return false;
    });

    //------------------------------------------------ POST GALLERY ----------------------------------------------------

    $(document).on('click', '#sc-posts-form-submit', function () {
        if ($('#sc-posts-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-posts-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    $(document).on('change', '#sc-posts-dm', function () {
        var colsDivEl = $('#sc-posts-cols').parent();
        if (this.value === 'gallery') {
            colsDivEl.show();
        } else {
            colsDivEl.hide();
        }
    });

    $(document).on('change', '#sc-posts-dt', function () {
        var idsDivEl = $('#sc-posts-ids').parent();
        var catDivEl = $('#sc-posts-cat').parent();
        if (this.value === 'specific') {
            idsDivEl.show();
            catDivEl.show();
        } else {
            idsDivEl.hide();
            catDivEl.hide();
        }
    });

    //--------------------------------------------------- NEWS ---------------------------------------------------------

    $(document).on('click', '#sc-news-form-submit', function () {
        if ($('#sc-news-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-news-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //-------------------------------------------------- AUDIO ---------------------------------------------------------

    $(document).on('change', '#sc-audio-type', function () {
        if (this.value === 'ss') {
            $('.sc-audio-ss').show();
            $('.sc-audio-sf').hide();
        } else {
            $('.sc-audio-sf').show();
            $('.sc-audio-ss').hide();
        }
    });
    $(document).on('click', '#sc-audio-form-submit', function () {
        var align = $('#sc-audio-align').val();
        var audioType = $('#sc-audio-type').val();
        var loop = $('#sc-audio-loop').is(':checked');
        var autoplay = $('#sc-audio-autop').is(':checked');
        var preload = $('#sc-audio-preload').val();

        var src = '';
        if (audioType === 'ss') {
            var srcVal = $.trim($('#sc-audio-src').val());
            if (srcVal.length === 0) {
                alert('Please provide the source URL.');
                return false;
            }
            src = ' src="' + srcVal + '"';
        } else {
            var mp3 = $.trim($('#sc-audio-mp3').val());
            var mp4a = $.trim($('#sc-audio-mp4a').val());
            var ogg = $.trim($('#sc-audio-ogg').val());
            var wav = $.trim($('#sc-audio-wav').val());
            var wma = $.trim($('#sc-audio-wma').val());
            if (mp3 === '' && mp4a === '' && ogg === '' && wav === '' && wma === '') {
                alert('Please provide at least one source URL.');
                return false;
            }
            if (mp3.length > 0) {
                src += ' mp3="' + mp3 + '"';
            }
            if (mp4a.length > 0) {
                src += ' mp4a="' + mp4a + '"';
            }
            if (ogg.length > 0) {
                src += ' ogg="' + ogg + '"';
            }
            if (wav.length > 0) {
                src += ' wav="' + wav + '"';
            }
            if (wma.length > 0) {
                src += ' wma="' + wma + '"';
            }
        }
        loop = loop ? ' loop="true"' : ' loop="false"';
        autoplay = autoplay ? ' autoplay="true"' : ' autoplay="false"';
        preload = ' preload="' + preload + '"';

        var sc = '[audio' + src + loop + autoplay + preload + '][/audio]';
        if (align === 'left') {
            sc = '[gc layout="2"]' + sc + '|YOUR_TEXT_HERE[/gc]';
        } else if (align === 'right') {
            sc = '[gc layout="2"]YOUR_TEXT_HERE|' + sc + '[/gc]';
        }
        ShortCodeUtil.addToEditor(sc);
        return false;
    });

    //-------------------------------------------------- VIDEO ---------------------------------------------------------

    $(document).on('change', '#sc-video-type', function () {
        if (this.value === 'e') {
            $('.sc-video-e').show();
            $('.sc-video-ss').hide();
            $('.sc-video-sf').hide();
            $('.sc-video-sssf').hide();
        } else if (this.value === 'ss') {
            $('.sc-video-e').hide();
            $('.sc-video-ss').show();
            $('.sc-video-sf').hide();
            $('.sc-video-sssf').show();
        } else {
            $('.sc-video-e').hide();
            $('.sc-video-ss').hide();
            $('.sc-video-sf').show();
            $('.sc-video-sssf').show();
        }
    });
    $(document).on('click', '#sc-video-form-submit', function () {
        if ($('#sc-video-form').valid()) {
            var videoType = $('#sc-video-type').val();
            var align = $('#sc-video-align').val();
            var sc = '';
            if (videoType === 'e') {
                var content = $.trim($('#sc-video-content').val());
                sc = '[video]' + content + '[/video]';
            } else if (videoType === 'ss' || videoType === 'sf') {
                var src = '';
                var poster = $.trim($('#sc-video-poster').val());
                var loop = $('#sc-video-loop').is(':checked');
                var autoplay = $('#sc-video-autop').is(':checked');
                var preload = $('#sc-video-preload').val();
                var width = $.trim($('#sc-video-width').val());
                var height = $.trim($('#sc-video-height').val());

                if (videoType === 'ss') {
                    var srcVal = $.trim($('#sc-video-src').val());
                    if (srcVal.length === 0) {
                        alert('Please provide the source URL.');
                        return false;
                    }
                    src = ' src="' + srcVal + '"';
                } else {
                    var mp4 = $.trim($('#sc-video-mp4').val());
                    var m4v = $.trim($('#sc-video-m4v').val());
                    var webm = $.trim($('#sc-video-webm').val());
                    var ogv = $.trim($('#sc-video-ogv').val());
                    var wmv = $.trim($('#sc-video-wmv').val());
                    var flv = $.trim($('#sc-video-flv').val());
                    if (mp4.length === 0 && m4v.length === 0 && webm.length === 0 &&
                        ogv.length === 0 && wmv.length === 0 && flv.length === 0) {
                        alert('Please provide at least one source URL.');
                        return false;
                    }
                    if (mp4.length > 0) {
                        src += ' mp4="' + mp4 + '"';
                    }
                    if (m4v.length > 0) {
                        src += ' m4v="' + m4v + '"';
                    }
                    if (webm.length > 0) {
                        src += ' webm="' + webm + '"';
                    }
                    if (ogv.length > 0) {
                        src += ' ogv="' + ogv + '"';
                    }
                    if (wmv.length > 0) {
                        src += ' wmv="' + wmv + '"';
                    }
                    if (flv.length > 0) {
                        src += ' flv="' + flv + '"';
                    }
                }

                if (poster.length > 0) {
                    poster = ' poster="' + poster + '"';
                }
                loop = loop ? ' loop="true"' : '';
                autoplay = autoplay ? ' autoplay="true"' : '';
                preload = ' preload="' + preload + '"';
                width = ' width="' + width + '"';
                height = ' height="' + height + '"';
                sc = '[video' + src + poster + loop + autoplay + preload + width + height + '][/video]';
            }

            if (align === 'left') {
                sc = '[gc layout="2"]' + sc + '|YOUR_TEXT_HERE[/gc]';
            } else if (align === 'right') {
                sc = '[gc layout="2"]YOUR_TEXT_HERE|' + sc + '[/gc]';
            }
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //-------------------------------------------------- DROPCAPS ------------------------------------------------------

    $(document).on('click', '#sc-dropcap-form-submit', function () {
        if ($('#sc-dropcap-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-dropcap-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------------- HIGHLIGHT ------------------------------------------------------

    $(document).on('click', '#sc-highlight-form-submit', function () {
        if ($('#sc-highlight-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-highlight-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //----------------------------------------------- COMPUTER CODE ----------------------------------------------------

    $(document).on('click', '#sc-cc-form-submit', function () {
        if ($('#sc-cc-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-cc-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------------ BLOCK QUOTE -----------------------------------------------------

    $(document).on('click', '#sc-bq-form-submit', function () {
        if ($('#sc-bq-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-bq-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //----------------------------------------------- GRID COLUMNS -----------------------------------------------------

    $(document).on('click', '#sc-gc-form-submit', function () {
        if ($('#sc-gc-form').valid()) {
            var tag = $('#sc-gc-tag').val();
            var layout = $('#sc-gc-layout').val();
            var separator = $('#sc-gc-separator').val();

            var n = 2;
            if (layout === '3') {
                n = 3;
            } else if (layout === '4') {
                n = 4;
            }

            var sc = '[gc layout="' + layout + '" separator="' + separator + '" tag="' + tag + '"]';
            for (var i = 0; i < n; i++) {
                if (i > 0) {
                    sc += '|';
                }
                sc += 'COLUMN_' + (i + 1);
            }
            sc += "[/gc]";

            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------------ CONTAINER -------------------------------------------------------

    $(document).on('click', '#sc-container-form-submit', function () {
        if ($('#sc-container-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-container-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //---------------------------------------------- SOCIAL ICONS ------------------------------------------------------

    $(document).on('click', '#sc-social-form-submit', function () {
        if ($('#sc-social-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-social-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //---------------------------------------------- TEAM MEMBER -------------------------------------------------------

    $(document).on('click', '#sc-tm-form-submit', function () {
        if ($('#sc-tm-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-tm-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //----------------------------------------------------- TABS -------------------------------------------------------

    $(document).on('change', '#sc-tabs-ex', function () {
        var selectedValue = $(this).val();
        if (selectedValue === '') {
            $('#sc-tabs-content').val('');
        } else {
            var example = $(this).data(selectedValue);
            example = ShortCodeUtil.replaceAll('&#91;', '[', example);
            example = ShortCodeUtil.replaceAll('&#93;', ']', example);
            $('#sc-tabs-content').val(example);
        }
        return false;
    });

    $(document).on('click', '#sc-tabs-form-submit', function () {
        if ($('#sc-tabs-form').valid()) {
            var sc = $('#sc-tabs-content').val();
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //--------------------------------------------------- TOGGLES ------------------------------------------------------

    $(document).on('change', '#sc-toggles-type', function () {
        var selectedValue = $(this).val();
        if (selectedValue === '') {
            $('#sc-toggles-content').val('');
        } else {
            var example = $(this).data(selectedValue);
            example = ShortCodeUtil.replaceAll('&#91;', '[', example);
            example = ShortCodeUtil.replaceAll('&#93;', ']', example);
            $('#sc-toggles-content').val(example);
        }
        return false;
    });

    $(document).on('click', '#sc-toggle-form-submit', function () {
        if ($('#sc-toggles-form').valid()) {
            var sc = $('#sc-toggles-content').val();
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //--------------------------------------------- NOTIFICATION BOX ---------------------------------------------------

    $(document).on('click', '#sc-notifbox-form-submit', function () {
        if ($('#sc-notifbox-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-notifbox-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------ TESTIMONIALS CAROUSEL -------------------------------------------------

    $(document).on('click', '#sc-testimonials-carousel-form-submit', function () {
        if ($('#sc-testimonials-carousel-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-testimonials-carousel-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------------- SITE MAP -------------------------------------------------------

    $(document).on('click', '#sc-sm-form-submit', function () {
        if ($('#sc-sm-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-sm-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //--------------------------------------------------- FORM ---------------------------------------------------------

    $(document).on('click', '#sc-form-form-submit', function () {
        if ($('#sc-form-form').valid()) {
            var exampleType = $('#sc-form-ext').val();
            var example = $('#sc-form-ex-' + exampleType).val();
            var sc = ShortCodeUtil.getShortCode('sc-form-form');
            sc = sc.replace('[/form]', example + '[/form]');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------------- TOOLTIP --------------------------------------------------------

    $(document).on('click', '#sc-tooltip-form-submit', function () {
        if ($('#sc-tooltip-form').valid()) {
            var sc = ShortCodeUtil.getShortCode('sc-tooltip-form');
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //------------------------------------------------ GOOGLE MAP ------------------------------------------------------

    $(document).on('change', '#sc-gmap-type', function () {
        if (this.value === 'address') {
            $('#sc-gmap-lat-wrapper').hide();
            $('#sc-gmap-lng-wrapper').hide();
            $('#sc-gmap-address-wrapper').show();
        } else {
            $('#sc-gmap-address-wrapper').hide();
            $('#sc-gmap-lat-wrapper').show();
            $('#sc-gmap-lng-wrapper').show();
        }
        return false;
    });

    $(document).on('click', '#sc-gmap-form-submit', function () {
        if ($('#sc-gmap-form').valid()) {
            var locType = $('#sc-gmap-type').val();
            var address = $.trim($('#sc-gmap-address').val());
            var lat = $.trim($('#sc-gmap-lat').val());
            var lng = $.trim($('#sc-gmap-lng').val());
            var zoom = $.trim($('#sc-gmap-zoom').val());
            var height = $.trim($('#sc-gmap-height').val());

            if (locType === 'address' && address.length === 0) {
                alert('The address must not be empty!');
                return false;
            }

            if (locType !== 'address' && (lat.length === 0 || lng.length === 0)) {
                alert('The latitude and longitude must not be empty!');
                return false;
            }

            var locValue = '';
            if (locType === 'address') {
                locValue = 'address="' + address + '"';
            } else {
                locValue = 'lat="' + lat + '" lng="' + lng + '"';
            }

            var sc = '[gmap loc_type="' + locType + '" ' + locValue + ' zoom="' + zoom + '" height="' + height + '"][/gmap]';
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //-------------------------------------------------- CONTACT -------------------------------------------------------

    $(document).on('click', '#sc-contact-form-submit', function () {
        if ($('#sc-contact-form').valid()) {
            var title = $.trim($('#sc-contact-title').val());
            var phone = $.trim($('#sc-contact-phone').val());
            var mobile = $.trim($('#sc-contact-mobile').val());
            var fax = $.trim($('#sc-contact-fax').val());
            var email = $.trim($('#sc-contact-email').val());
            var tts = $.trim($('#sc-contact-tts').val());
            var tt = $.trim($('#sc-contact-tt').val());
            var addr = $.trim($('#sc-contact-addr').val());

            if (title.length > 0) {
                title = ' title="' + title + '"';
            }
            if (phone.length > 0) {
                phone = ' phone="' + phone + '"';
            }
            if (mobile.length > 0) {
                mobile = ' mobile="' + mobile + '"';
            }
            if (fax.length > 0) {
                fax = ' fax="' + fax + '"';
            }
            if (email.length > 0) {
                email = ' email="' + email + '"';
            }
            if (tt.length > 0) {
                while (tt.indexOf('\n') >= 0) {
                    tt = tt.replace('\n', tts);
                }
                tt = ' timetable="' + tt + '"';
            }
            if (tts.length > 0) {
                tts = ' timetable_sep="' + tts + '"';
            }

            var sc = '[contact' + title + phone + mobile + fax + email + tts + tt + ']' + addr + '[/contact]';
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //-------------------------------------------------- CLIENTS -------------------------------------------------------

    $(document).on('click', '#sc-clients-form-submit', function () {
        if ($('#sc-clients-form').valid()) {
            var _content = $('#sc-clients-content').val();
            var _carousel = $('#sc-clients-carousel').is(':checked');

            var sc = '[clients';
            if (_carousel) {
                sc += ' carousel="true"';
            }
            sc += ']' + _content + '[/clients]';
            ShortCodeUtil.addToEditor(sc);
        }
        return false;
    });

    //-------------------------------------------------- TABLE ---------------------------------------------------------

    $(document).on('click', '#sc-table-form-submit', function () {
        if ($('#sc-table-form').valid()) {
            var caption = $('#sc-table-caption').val();
            var footer = $('#sc-table-footer').val();
            var separator = $.trim($('#sc-table-separator').val());
            var columns = $.trim($('#sc-table-columns').val());
            var rows = $.trim($('#sc-table-rows').val());

            if (columns > 0 && rows > 0) {
                caption = caption.length > 0 ? ' caption="' + caption + '"' : '';
                footer = footer.length > 0 ? ' footer="' + footer + '"' : '';
                var colSep = (separator !== '|') ? ' col_sep="' + separator + '"' : '';
                var sc = '[table' + caption + footer + colSep + ']';
                sc += '\n[th]';
                for (var c = 0; c < columns; c++) {
                    if (c > 0) {
                        sc += separator;
                    }
                    sc += 'HEADER-' + c;
                }
                sc += '[/th]';
                for (var r = 0; r < rows; r++) {
                    sc += '\n[tr]';
                    for (c = 0; c < columns; c++) {
                        if (c > 0) {
                            sc += separator;
                        }
                        sc += 'ROW_' + r + '_COLUMN_' + c;
                    }
                    sc += '[/tr]';
                }
                sc += '\n[/table]';
                ShortCodeUtil.addToEditor(sc);
            } else {
                alert('The number of columns and the number of rows must be greater that zero.');
            }

        }
        return false;
    });

    //---------------------------------------- PROCESS (OUTLINE OF STEPS) ----------------------------------------------

    $(document).on('click', '#sc-ps-form-submit', function () {
        if ($('#sc-ps-form').valid()) {
            var cols = $.trim($('#sc-ps-cols').val());
            var stepsCount = $.trim($('#sc-ps-steps').val());

            if (stepsCount > 0) {
                var sc = '[process cols="' + cols + '"]\n';
                for (var i = 0; i < stepsCount; i++) {
                    var index = (i + 1);
                    sc += '[step title="STEP_' + index + '_TITLE"]STEP_' + index + '_CONTENT[/step]\n';
                }
                sc += '[/process]';
                ShortCodeUtil.addToEditor(sc);
            } else {
                alert('The number of steps must be greater that zero.');
            }

        }
        return false;
    });

    //---------------------------------------------- PRICING BOXES -----------------------------------------------------

    $(document).on('click', '#sc-pb-form-submit', function () {
        if ($('#sc-pb-form').valid()) {
            var displayMode = $('#sc-pb-dm').val();
            var columns = $('#sc-pb-columns').val();
            var rows = $('#sc-pb-rows').val();
            var hc = $('#sc-pb-hc').val();
            var separator = $('#sc-pb-separator').val();

            if (rows > 0) {
                if (hc >= 1 && hc <= columns) {
                    var sc = '[pb display_mode="' + displayMode + '" columns="' + columns + '" hl_column="' + hc + '" separator="' + separator + '"]';
                    for (var c = 0; c < columns; c++) {
                        sc += '\n[pb_column title="TITLE_COL_' + c + '" price="$20" unit="month" order_text="ORDER_TEXT" order_url="ORDER_URL"]\n';
                        for (var r = 0; r < rows; r++) {
                            if (r > 0) {
                                sc += separator;
                            }
                            sc += 'COL_' + c + '_ROW_' + r;
                        }
                        sc += '\n[/pb_column]';
                    }
                    sc += '\n[/pb]';
                    ShortCodeUtil.addToEditor(sc);
                } else {
                    alert('The highlighted column must be between 1 and ' + columns + '.');
                }
            } else {
                alert('The number of rows must be greater that zero.');
            }

        }
        return false;
    });

    //---------------------------------------------- PRICING TABLE -----------------------------------------------------

    $(document).on('click', '#sc-pt-form-submit', function () {
        if ($('#sc-pt-form').valid()) {
            var columns = $('#sc-pt-columns').val();
            var rows = $('#sc-pt-rows').val();
            var hc = $('#sc-pt-hc').val();
            var separator = $('#sc-pt-separator').val();

            if (columns > 0 && rows > 0) {
                if (hc >= 1 && hc <= columns) {
                    var sc = '[pricing_table highlighted_column="' + hc + '" separator="' + separator + '"]\n';

                    for (var c = 0; c < columns; c++) {
                        sc += '[pricing_table_header price="PRICE_(e.g. $20)" unit="UNIT_MEASURE_(e.g. month)"]TITLE_COL_' + c + '[/pricing_table_header]\n';
                    }

                    for (c = 0; c < columns; c++) {
                        sc += '[pricing_table_footer order_text="ORDER_TEXT" order_url="ORDER_URL"][/pricing_table_footer]\n';
                    }

                    for (var r = 0; r < rows; r++) {
                        sc += '[pricing_table_row title="ROW_TITLE_(e.g. Payment Integration)"]\n';
                        for (c = 0; c < columns; c++) {
                            if (c > 0) {
                                sc += separator;
                            }
                            sc += 'ROW_' + r + '_COL_' + c;
                        }
                        sc += '\n[/pricing_table_row]\n';
                    }

                    sc += '[/pricing_table]';
                    ShortCodeUtil.addToEditor(sc);
                } else {
                    alert('The highlighted column must be between 1 and ' + columns + '.');
                }
            } else {
                alert('The number of columns and the number of rows must be greater that zero.');
            }

        }
        return false;
    });

});