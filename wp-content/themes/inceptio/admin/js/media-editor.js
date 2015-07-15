/*global tb_show */
/*global tb_remove */
/*global Base64 */
/*global AdminUtil */
/*global alert */

jQuery(document).ready(function ($) {
    "use strict";

    //----------------------------------------------- SLIDER MANAGER ---------------------------------------------------

    var editSlideMetaDialog = $("#page-media-add-slide-meta-dialog");
    var sliderSlides = $('#slider-manager-slides');
    var slideMetaSlideId = $('#page-media-add-slide-id');
    var slideMetaLinkId = $('#page-media-add-slide-meta-link');
    var slideMetaCaptionTitle = $('#page-media-add-slide-meta-title');
    var slideMetaCaptionContent = $('#page-media-add-slide-meta-content');

    $(".tabs").tabs();

    sliderSlides.each(function () {
        $(this).sortable();
    });

    $(document).on('click', '#slider-manager-form-save', function () {
        var slidesContent = getSliderSlidesAsJSON();
        $('#slider-manager-slides-content').val(slidesContent);
        return $('#slider-manager-form').valid();
    });

    editSlideMetaDialog.dialog({
        autoOpen:false,
        width:560,
        modal:true,
        resizable:false,
        dialogClass: 'wp-dialog',
        create:function () {
            $(document).on('click', '#page-media-add-slide-meta-form-submit', function () {
                var invokerEl = editSlideMetaDialog.data('invoker');
                if ($('#page-media-add-slide-meta-form').valid()) {
                    var imageId = slideMetaSlideId.val();
                    var imageLink = slideMetaLinkId.val();
                    var captionTitle = slideMetaCaptionTitle.val();
                    var captionContent = slideMetaCaptionContent.val();

                    invokerEl.data('id', imageId);
                    invokerEl.data('img-link', Base64.encode(imageLink));
                    invokerEl.data('caption-title', Base64.encode(captionTitle));
                    invokerEl.data('caption-content', Base64.encode(captionContent));
                }
                editSlideMetaDialog.dialog("close");
            });
            $(document).on('click', '#page-media-add-slide-meta-form-cancel', function () {
                editSlideMetaDialog.dialog("close");
            });
        }
    });

    $(document).on('click', '.upload-slide-img', function () {
        tb_show('', 'media-upload.php?type=image&post_id=0&TB_iframe=true&flash=1');
        $('iframe#TB_iframeContent').load(function () {
            $('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');
        });

        window.send_to_editor = function (html) {
            var imgId = getId(html);
            var imgSrc = getImgSrc(html);

            var element = '<li data-type="img" data-id="' + imgId + '">';
            element += '<div class="img-wrap">';
            element += '<img src="' + imgSrc + '" title="">';
            element += '<span class="type-img"></span>';
            element += '<a class="delete-slider-slide-button" href="#"></a>';
            element += '</div>';
            element += '<a class="edit-meta-slider-slide-button" href="#" title="Edit Meta">Edit Meta</a>';
            element += '</li>';
            $(element).appendTo(sliderSlides);
            tb_remove();
        };

        function getImgSrc(html) {
            var str = 'src="';
            var x1 = html.indexOf(str) + str.length;
            var x2 = html.indexOf('"', x1);
            return html.substr(x1, x2 - x1);
        }

        function getGUID(html) {
            var str = 'href="';
            var x1 = html.indexOf(str) + str.length;
            var x2 = html.indexOf('"', x1);
            return html.substr(x1, x2 - x1);
        }

        function getId(html) {
            var str = 'wp-image-';
            if (html.indexOf(str) >= 0) {
                var x1 = html.indexOf(str) + str.length;
                var x2 = html.indexOf('"', x1);
                return html.substr(x1, x2 - x1);
            } else {
                return getGUID(html);
            }
        }

        return false;
    });

    $(document).on('click', '.delete-slider-slide-button', function () {
        $(this).parent().parent().remove();
        return false;
    });

    $(document).on('click', '.edit-meta-slider-slide-button', function () {
        var dialogEl = $("#page-media-add-slide-meta-dialog");
        dialogEl.dialog("open");
        var liEl = $(this).parent();

        var id = liEl.data('id');
        var link = liEl.data('img-link');
        var captionTitle = liEl.data('caption-title');
        var captionContent = liEl.data('caption-content');

        link = link ? Base64.decode(link) : '';
        captionTitle = captionTitle ? Base64.decode(captionTitle) : '';
        captionContent = captionTitle ? Base64.decode(captionContent) : '';

        slideMetaSlideId.val(id);
        slideMetaLinkId.val(link);
        slideMetaCaptionTitle.val(captionTitle);
        slideMetaCaptionContent.val(captionContent);
        dialogEl.data('invoker', liEl);
    });

    function getSliderSlidesAsJSON() {
        var content = '[';
        var index = 0;
        sliderSlides.find('li').each(function () {
            var id = $(this).data('id');
            var type = $(this).data('type');
            var imageLink = $(this).data('img-link') ? $(this).data('img-link') : '';
            var captionTitle = $(this).data('caption-title') ? $(this).data('caption-title') : '';
            var captionContent = $(this).data('caption-content') ? $(this).data('caption-content') : '';
            if (index > 0) {
                content += ',';
            }

            content += '{"type": "' + type + '", "id": "' + id + '", "caption_title": "' +
                captionTitle + '", "caption_content": "' + captionContent + '", "img_link": "' +
                imageLink + '" }';
            index++;
        });
        content += ']';
        return content;
    }

    //------------------------------------------------- PAGE EDITOR ----------------------------------------------------

    var postTypeInput = $('#post_type');
    if (postTypeInput.length > 0) {
        var postType = postTypeInput.val();
        var sliderEditorButton = $('#slider-editor-button');
        var contactEditorButton = $('#contact-editor-button');
        var videoEditorButton = $('#video-editor-button');
        var postsOverviewSettingsEditorButton = $('#posts-overview-editor-button');
        var blogOverviewSettingsEditorButton = $('#blog-overview-editor-button');

        sliderEditorButton.on('click', function () {
            return AdminUtil.openThickBoxDialog(this, {width:450, height:250}, function () {
                var saveFormButton = $('#page-slider-editor-form-submit');
                var sliderIDInput = $('#page-slider-editor-slider-id');
                var sliderTypeSelector = $('#page-slider-editor-slider-type');
                var sliderLayoutSelector = $('#page-slider-editor-slider-layout');
                var sliderDisplayOnSelector = $('#page-slider-editor-slider-display');
                sliderTypeSelector.on('change', function () {
                    if (this.value === 'none') {
                        sliderIDInput.parent().hide();
                        if(sliderLayoutSelector.length > 0){
                            sliderLayoutSelector.parent().hide();
                        }
                        if(sliderDisplayOnSelector.length > 0){
                            sliderDisplayOnSelector.parent().hide();
                        }
                    } else {
                        sliderIDInput.parent().show();
                        if(sliderLayoutSelector.length > 0){
                            sliderLayoutSelector.parent().show();
                        }
                        if(sliderDisplayOnSelector.length > 0){
                            sliderDisplayOnSelector.parent().show();
                        }
                    }
                });
                saveFormButton.on('click', function () {
                    if ($('#page-slider-editor-form').valid()) {
                        var sliderID = '';
                        var sliderType = sliderTypeSelector.find('option:selected').val();
                        var sliderLayout = 'wide';
                        var sliderDisplayOn = 'all';
                        var postID = $('#post_ID').val();
                        var postType = $('#post_type').val();
                        if (sliderType !== 'none') {
                            sliderID = sliderIDInput.val();
                        }
                        if(sliderLayoutSelector.length > 0){
                            sliderLayout = sliderLayoutSelector.val();
                        }
                        if(sliderDisplayOnSelector.length > 0){
                            sliderDisplayOn = sliderDisplayOnSelector.val();
                        }
                        var params = {
                            'action':'inc-save-slider-settings',
                            'slider-type':sliderType,
                            'slider-id':sliderID,
                            'slider-layout':sliderLayout,
                            'slider-display-on':sliderDisplayOn,
                            'post-id':postID,
                            'post-type':postType
                        };
                        saveFormButton.attr("disabled", "disabled");
                        AdminUtil.doPost(params, 'html', function (response) {
                            saveFormButton.removeAttr("disabled");
                            updatePageMediaSettingsMeta(response);
                            tb_remove();
                        }, function (errorThrown) {
                            saveFormButton.removeAttr("disabled");
                            alert(errorThrown);
                        });
                    }
                    return false;
                });
                $('#page-slider-editor-form-cancel').on('click', function () {
                    return tb_remove();
                });
            });
        });

        if (postType === 'page') {
            var pageTemplateSelector = $('#page_template');

            if (pageTemplateSelector.length > 0) {

                var showOrHidePageSliderEditorButton = function() {
                    var selectedOption = pageTemplateSelector.find('option:selected');
                    if (selectedOption) {
                        var selectedOptionVal = selectedOption.val().toLowerCase();
                        if (selectedOptionVal.indexOf('default') >= 0 ||
                            selectedOptionVal.indexOf('fullwidth') >= 0 ||
                            selectedOptionVal.indexOf('leftsidebar') >= 0) {
                            sliderEditorButton.show();
                            contactEditorButton.hide();
                            postsOverviewSettingsEditorButton.hide();
                            blogOverviewSettingsEditorButton.hide();
                        } else if (selectedOptionVal.indexOf('contact') >= 0) {
                            sliderEditorButton.hide();
                            postsOverviewSettingsEditorButton.hide();
                            blogOverviewSettingsEditorButton.hide();
                            contactEditorButton.show();
                        }else if (selectedOptionVal.indexOf('portfolio-overview') >= 0) {
                            postsOverviewSettingsEditorButton.show();
                            blogOverviewSettingsEditorButton.hide();
                            sliderEditorButton.hide();
                            contactEditorButton.hide();
                        }else if (selectedOptionVal.indexOf('blog-overview') >= 0) {
                            blogOverviewSettingsEditorButton.show();
                            postsOverviewSettingsEditorButton.hide();
                            sliderEditorButton.hide();
                            contactEditorButton.hide();
                        } else {
                            sliderEditorButton.hide();
                            contactEditorButton.hide();
                            postsOverviewSettingsEditorButton.hide();
                            blogOverviewSettingsEditorButton.hide();
                        }
                    }
                };

                showOrHidePageSliderEditorButton();
                pageTemplateSelector.on('change', function () {
                    showOrHidePageSliderEditorButton();
                });

                contactEditorButton.on('click', function () {
                    return AdminUtil.openThickBoxDialog(this, {width:550, height:300}, function () {
                        var contactRetrievalLink = $('#page-contact-retrieval');
                        var saveFormButton = $('#page-contact-editor-form-submit');
                        var displayMapButton = $('#page-contact-editor-display');
                        var editorSettingsDiv = $('#page-contact-editor-settings');
                        var locTypeSelector = $('#page-contact-editor-localization-type');
                        var addressInput = $('#page-contact-editor-address');
                        var coordLatInput = $('#page-contact-editor-lat');
                        var coordLongInput = $('#page-contact-editor-long');
                        var mapZoomInput = $('#page-contact-editor-zoom');
                        var mapHeightInput = $('#page-contact-editor-height');

                        displayMapButton.on('change', function () {
                            if ($(this).is(':checked')) {
                                editorSettingsDiv.show();
                            } else {
                                editorSettingsDiv.hide();
                            }
                        });

                        locTypeSelector.on('change', function () {
                            if (this.value === 'address') {
                                addressInput.parent().show();
                                coordLatInput.parent().hide();
                                coordLongInput.parent().hide();
                            } else {
                                addressInput.parent().hide();
                                coordLatInput.parent().show();
                                coordLongInput.parent().show();
                            }
                        });

                        contactRetrievalLink.on('click', function(){
                            var content = $(this).data('content');
                            var editorContent = AdminUtil.getEditorContent();
                            var add = true;
                            if(editorContent && editorContent.length>0){
                                content = '\n\n------- START CONTENT -------\n'+content+'\n------- END CONTENT -------\n\n';
                            }
                            AdminUtil.addToEditor(content);
                        });

                        saveFormButton.on('click', function () {
                            if ($('#page-contact-editor-form').valid()) {
                                var display = displayMapButton.is(":checked") ? 'true' : 'false';
                                var locType = locTypeSelector.find('option:selected').val();
                                var address = Base64.encode(addressInput.val());
                                var coordLat = coordLatInput.val();
                                var coordLong = coordLongInput.val();
                                var mapZoom = mapZoomInput.val();
                                var mapHeight = mapHeightInput.val();
                                var postID = $('#post_ID').val();
                                var postType = $('#post_type').val();

                                var params = {
                                    'action':'inc-save-contact-settings',
                                    'display':display,
                                    'loc-type':locType,
                                    'address':address,
                                    'lat':coordLat,
                                    'long':coordLong,
                                    'map-zoom':mapZoom,
                                    'map-height':mapHeight,
                                    'post-id':postID,
                                    'post-type':postType
                                };
                                saveFormButton.attr("disabled", "disabled");
                                AdminUtil.doPost(params, 'html', function (response) {
                                    saveFormButton.removeAttr("disabled");
                                    updatePageMediaSettingsMeta(response);
                                    tb_remove();
                                }, function (errorThrown) {
                                    saveFormButton.removeAttr("disabled");
                                    alert(errorThrown);
                                });
                            }
                            return false;
                        });
                        $('#page-contact-editor-form-cancel').on('click', function () {
                            return tb_remove();
                        });
                    });
                });

                postsOverviewSettingsEditorButton.on('click', function(){
                    return AdminUtil.openThickBoxDialog(this, {width:550, height:400}, function () {
                        var saveFormButton = $('#posts-overview-editor-form-submit');
                        var columnsSelector = $('#posts-overview-editor-cols');
                        var termsInput = $('#posts-overview-editor-terms');
                        var filterAllSelector = $('#posts-overview-editor-filter-all');
                        var thumbClickActionSelector = $('#posts-overview-editor-tca');
                        var noOfItemsSelector = $('#posts-overview-editor-noi');
                        var termsOrderInput = $('#posts-overview-editor-terms-order');

                        saveFormButton.on('click', function () {
                            if ($('#posts-overview-editor-form').valid()) {
                                var columns = columnsSelector.val();
                                var terms = termsInput.val();
                                var termsOrder = termsOrderInput.val();
                                var filterAll = filterAllSelector.val();
                                var thumbClickAction = thumbClickActionSelector.val();
                                var noOfItems = noOfItemsSelector.val();
                                var postID = $('#post_ID').val();
                                var postType = $('#post_type').val();

                                var params = {
                                    'action':'inc-save-posts-overview-settings',
                                    'columns':columns,
                                    'terms':terms,
                                    'terms-order':termsOrder,
                                    'display-filter-all':filterAll,
                                    'thumb-click-action':thumbClickAction,
                                    'items':noOfItems,
                                    'post-id':postID,
                                    'post-type':postType
                                };
                                saveFormButton.attr("disabled", "disabled");
                                AdminUtil.doPost(params, 'html', function (response) {
                                    saveFormButton.removeAttr("disabled");
                                    updatePageMediaSettingsMeta(response);
                                    tb_remove();
                                }, function (errorThrown) {
                                    saveFormButton.removeAttr("disabled");
                                    alert(errorThrown);
                                });
                            }
                            return false;
                        });
                        $('#posts-overview-editor-form-cancel').on('click', function () {
                            return tb_remove();
                        });
                    });
                });

                blogOverviewSettingsEditorButton.on('click', function(){
                    return AdminUtil.openThickBoxDialog(this, {width:550, height:300}, function () {
                        var saveFormButton = $('#blog-overview-editor-form-submit');
                        var termsTypeInput = $('#blog-overview-editor-terms-type');
                        var termsInput = $('#blog-overview-editor-terms');
                        var termsOrderBySelector = $('#blog-overview-editor-terms-order-by');
                        var termsOrderSelector = $('#blog-overview-editor-terms-order');

                        saveFormButton.on('click', function () {
                            if ($('#blog-overview-editor-form').valid()) {
                                var termsType = termsTypeInput.val();
                                var terms = termsInput.val();
                                var termsOrderBy = termsOrderBySelector.val();
                                var termsOrder = termsOrderSelector.val();
                                var postID = $('#post_ID').val();
                                var postType = $('#post_type').val();

                                var params = {
                                    'action':'inc-save-blog-overview-settings',
                                    'terms-type':termsType,
                                    'terms':terms,
                                    'terms-order-by':termsOrderBy,
                                    'terms-order':termsOrder,
                                    'post-id':postID,
                                    'post-type':postType
                                };
                                saveFormButton.attr("disabled", "disabled");
                                AdminUtil.doPost(params, 'html', function (response) {
                                    saveFormButton.removeAttr("disabled");
                                    updatePageMediaSettingsMeta(response);
                                    tb_remove();
                                }, function (errorThrown) {
                                    saveFormButton.removeAttr("disabled");
                                    alert(errorThrown);
                                });
                            }
                            return false;
                        });
                        $('#blog-overview-editor-form-cancel').on('click', function () {
                            return tb_remove();
                        });
                    });
                });
            }
        } else {

            videoEditorButton.on('click', function () {
                return AdminUtil.openThickBoxDialog(this, {width:550, height:300}, function () {
                    var saveFormButton = $('#page-video-editor-form-submit');

                    saveFormButton.on('click', function () {
                        if ($('#page-video-editor-form').valid()) {
                            var videoID = $('#page-video-editor-video-id').val();
                            var videoContent = Base64.encode($('#page-video-editor-video-content').val());
                            var postID = $('#post_ID').val();
                            var postType = $('#post_type').val();

                            var params = {
                                'action':'inc-save-video-settings',
                                'video-id':videoID,
                                'video-content':videoContent,
                                'post-id':postID,
                                'post-type':postType
                            };
                            saveFormButton.attr("disabled", "disabled");
                            AdminUtil.doPost(params, 'html', function (response) {
                                saveFormButton.removeAttr("disabled");
                                updatePageMediaSettingsMeta(response);
                                tb_remove();
                            }, function (errorThrown) {
                                saveFormButton.removeAttr("disabled");
                                alert(errorThrown);
                            });
                        }
                        return false;
                    });
                    $('#page-video-editor-form-cancel').on('click', function () {
                        return tb_remove();
                    });
                });
            });

            var showOrHidePostPortfolioMediaEditorButton = function() {
                var postFormat = $('input[name=post_format]:checked').val();
                if (postFormat === 'gallery') {
                    sliderEditorButton.show();
                    videoEditorButton.hide();
                } else if (postFormat === 'video') {
                    sliderEditorButton.hide();
                    videoEditorButton.show();
                } else {
                    sliderEditorButton.hide();
                    videoEditorButton.hide();
                }
            };

            $('input[name=post_format]').on('click', function () {
                showOrHidePostPortfolioMediaEditorButton();
            });
            showOrHidePostPortfolioMediaEditorButton();
        }
    }

    function updatePageMediaSettingsMeta(value) {
        var name = '';
        $("input[type='text']").each(function () {
            var $this = $(this);
            if ($this.val() === 'inceptio_page_media_settings') {
                name = $this.attr('name').replace('[key]', '[value]');
            }
        });
        if (name.length > 0) {
            $("textarea").each(function () {
                var $this = $(this);
                if ($this.attr('name') === name) {
                    $this.val(value);
                }
            });
        }
    }

});
