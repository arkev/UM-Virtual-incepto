/*global ajaxurl */
/*global tb_show */
/*global tb_remove */
/*global confirm */
/*global alert */

var AdminUtil = {

    addToEditor:function (sc) {
        "use strict";
        if (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden()) {
            var ed = tinyMCE.activeEditor;
            ed.focus();
            if (tinyMCE.isIE) {
                ed.selection.moveToBookmark(tinyMCE.EditorManager.activeEditor.windowManager.bookmark);
            }
            ed.execCommand('mceInsertContent', false, sc);
        } else if (typeof edInsertContent === 'function') {
            edInsertContent(edCanvas, sc);
        } else {
            jQuery(edCanvas).val(jQuery(edCanvas).val() + sc);
        }
        tb_remove();
    },

    getEditorContent:function () {
        "use strict";
        try{
            if (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden()) {
                return tinyMCE.activeEditor.getContent();
            } else {
                return jQuery(edCanvas).val();
            }
        }catch (e){
            console.log(e);
            return '';
        }
    },

    doPost: function (params, type, successCallback, failureCallback) {
        "use strict";
        jQuery.ajax({type: "POST",
            url: ajaxurl,
            dataType: type,
            data: params,
            success: function (html) {
                if (typeof successCallback === 'function') {
                    successCallback(html);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (typeof failureCallback === 'function') {
                    failureCallback(errorThrown + ': ' + jqXHR.responseText);
                } else {
                    alert(errorThrown + ': ' + jqXHR.responseText);
                }
            }
        });
    },

    getFormParams: function (formSelector) {
        "use strict";
        if (jQuery(formSelector).valid()) {
            var params = {};
            jQuery(formSelector + " :input").each(function () {
                var field = jQuery(this);
                var fieldName = field.attr('name');
                params[fieldName] = field.val();
            });
            return params;
        } else {
            return false;
        }
    },

    isRequiredFieldValid: function (fieldId) {
        "use strict";
        var field = jQuery('#' + fieldId);
        if (jQuery.trim(field.val()).length > 0) {
            field.css('border-color', '');
            field.css('border', '');
            return true;
        } else {
            field.css('border-color', '#ff0000');
            field.css('border', '1px solid #ff0000');
            return false;
        }
    },

    openThickBoxDialog: function (invoker, settings, afterLoadCallback) {
        "use strict";
        var width = settings.width;//900;
        var height = settings.height;//500;
        var tbWindowWidth = width + 30;
        var tbWindowHeight = height + 30;
        var t = invoker.title;
        var a = invoker.href + '&width=' + width + '&height=' + height + '';
        var g = invoker.rel || false;
        var old_tb_init = window.tb_init;
        window.tb_init = function (domChunk) {
            old_tb_init(domChunk);
            jQuery("#TB_window").css({marginLeft: '-' + parseInt((tbWindowWidth / 2), 10) + 'px', width: tbWindowWidth + 'px', height: tbWindowHeight + 'px'});
            window.tb_init = old_tb_init;
            if (afterLoadCallback) {
                afterLoadCallback.call(jQuery(this));
            }
        };
        tb_show(t, a, g);
        invoker.blur();
        return false;
    }
};

(function ($) {
    "use strict";
    $.fn.colorRadioButtons = function () {
        var invoker = $(this);
        var refId = invoker.data('ref');
        var refField = $('#' + refId);
        var defaultSelectedValue = refField.val();
        var links = invoker.find("li > a");

        setValue(defaultSelectedValue);

        links.click(function (e) {
            e.preventDefault();
            var color = $(this).data('color');
            setValue(color);
            return false;
        });

        function setValue(value) {
            refField.val(value);
            links.removeClass('selected');
            links.each(function () {
                var color = $(this).data('color');
                if (color === value) {
                    $(this).addClass('selected');
                }
            });
        }

    };

})(jQuery);

jQuery(document).ready(function ($) {
    "use strict";
    function doAddOrUpdate(button, formSelector, refreshListSelector) {
        var formParams = AdminUtil.getFormParams(formSelector);
        if (formParams) {
            button.attr('disabled', 'disabled');
            AdminUtil.doPost(formParams, 'html', function (response) {
                tb_remove();
                $(refreshListSelector).html(response);
            }, function (errorThrown) {
                button.removeAttr('disabled');
                alert(errorThrown);
            });
        }
        return false;
    }

    function doDelete(link, refreshListSelector) {
        if (confirm("Are you sure you want to proceed?")) {
            var formParams = link.attr('href');
            AdminUtil.doPost(formParams, 'html', function (response) {
                $(refreshListSelector).html(response);
            }, function (errorThrown) {
                alert(errorThrown);
            });
        }
        return false;
    }

    //---------------------------------------------- Theme Options -----------------------------------------------------
    var themeOptionsCategories = $('#theme-settings-form').find('div.widgets-holder-wrap');
    var themeOptionsCategoriesBody = themeOptionsCategories.find('div.category-body');
    themeOptionsCategories.each(function(){
        var $this = $(this);
        var categoryBody = $this.find('div.category-body');

        $this.find('div.category-title').on('click', function(){
            if($this.hasClass('closed')){
                themeOptionsCategories.not($this).addClass('closed');
                themeOptionsCategoriesBody.not(categoryBody).hide();

                categoryBody.show();
                $this.removeClass('closed');
            }else{
                categoryBody.hide();
                $this.addClass('closed');
            }
        });

    });

    $(document).on('click', '#restore-theme-settings', function () {
        if (confirm("Are you sure you want to reset the values for these settings?")) {
            $(':input', '#theme-settings-form').each(function () {
                var tagName = this.type.toLowerCase();
                if (tagName !== 'hidden') {
                    var defaultValue = $(this).attr('data-default-value');
                    if (defaultValue !== undefined) {
                        if (tagName.indexOf('text') >= 0) {
                            $(this).val(defaultValue);
                        } else if (tagName === 'checkbox') {
                            if (defaultValue === 'on') {
                                $(this).attr('checked', 'checked');
                            } else {
                                $(this).attr('checked', '');
                            }
                        } else if (tagName.indexOf('select') >= 0) {
                            $(this).val(defaultValue);
                        }
                    }
                }
            });
            return true;
        } else {
            return false;
        }
    });

    $(document).on('click', '.upload-button', function () {
        var id = $(this).attr('id');
        var fieldId = id.substr('upload_'.length, id.length - 'upload_'.length);
        var imgId = id.replace('upload_', 'img_');

        tb_show('', 'media-upload.php?type=image&post_id=0&TB_iframe=true&flash=1');
        $('iframe#TB_iframeContent').load(function () {
            $('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');
        });

        window.send_to_editor = function (html) {
            var x1 = html.indexOf("src=\"") + 5;
            var x2 = html.indexOf("\"", x1);
            var imageURL = html.substr(x1, x2 - x1);
            $('#' + fieldId).attr('value', imageURL);
            $('#' + imgId).attr('src', imageURL);
            tb_remove();
        };

        return false;
    });

    $('.color-selector').each(function () {
        var bgEl = $(this).children('div');
        var inputEl = $(this).next('input');
        var initialColor = inputEl.attr('value');

        $(this).ColorPicker({
            color: initialColor,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex) {
                bgEl.css('backgroundColor', '#' + hex);
                inputEl.attr('value', '#' + hex);
            }
        });
    });


    $('.predefined-colors-selector').each(function () {
        var invoker = this;
        var selectEl = $(invoker).next('select');
        var bgEl = $(invoker).children('div');

        var initialColor = selectEl.val();
        $(this).ColorPicker({
            color: initialColor,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex) {
                changeBgColor(hex, true);
            }
        });

        selectEl.on('change', function () {
            changeBgColor(this.value, false);
        });

        function changeBgColor(hex, add) {
            if (hex.length > 0) {
                hex = hex.indexOf("#") < 0 ? '#' + hex : hex;
                bgEl.css('backgroundColor', hex);
            } else {
                bgEl.css('backgroundColor', '');
            }
            if (add) {
                selectEl.find("option").each(function () {
                    if (this.value === hex) {
                        add = false;
                        $(this).attr("selected", "selected");
                    } else if ($(this).data("custom-color")) {
                        add = false;
                        $(this).val(hex);
                        $(this).text(hex);
                        $(this).attr("selected", "selected");
                    }
                });
                if (add) {
                    selectEl.append('<option value="' + hex + '" selected="selected" data-custom-color="true">' + hex + '</option>');
                }
            }
        }
    });

    $('.predefined-patterns-selector').on('click', function () {
        var id = $(this).attr('id');
        var fieldId = id.substr('upload_'.length, id.length - 'upload_'.length);

        tb_show('', 'media-upload.php?type=image&amp;post_id=0&amp;TB_iframe=true&amp;flash=1');
        $('iframe#TB_iframeContent').load(function () {
            $('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');
        });

        window.send_to_editor = function (html) {
            var selectEl = $('#' + fieldId);
            var x1 = html.indexOf("src=\"") + 5;
            var x2 = html.indexOf("\"", x1);
            var imageURL = html.substr(x1, x2 - x1);

            var add = true;
            selectEl.find("> option").each(function () {
                if (this.value === imageURL) {
                    add = false;
                    $(this).attr("selected", "selected");
                }
            });
            if (add) {
                selectEl.append('<option value="' + imageURL + '" selected="selected">' + imageURL + '</option>');
            }
            tb_remove();
        };

        return false;
    });

    //--------------------------------------------- Sidebar Manager ----------------------------------------------------
    $(document).on('click', '#sbm-add-form-submit', function () {
        return doAddOrUpdate($(this), '#sbm-add-form', '#sidebar-list');
    });

    $(document).on('click', '.sbm-delete', function () {
        return doDelete($(this), '#sidebar-list');
    });

    //------------------------------------------- Flex Slider Manager --------------------------------------------------
    $(document).on('click', '#fsm-add-slider-form-submit', function () {
        return doAddOrUpdate($(this), '#fsm-add-slider-form', '#slider-list');
    });

    $(document).on('click', '.fsm-delete-slider', function () {
        return doDelete($(this), '#slider-list');
    });

    //----------------------------------------------- Font Manager -----------------------------------------------------
    $(document).on('click', '#font-manager-form-submit', function () {
        return doAddOrUpdate($(this), '#font-manager-form', '#font-list');
    });

    $(document).on('click', '.font-manager-delete', function () {
        return doDelete($(this), '#font-list');
    });

    //------------------------------------------ Import Data Manager ---------------------------------------------------

    $(document).on('click', '#import-demo-submit', function () {
        if (AdminUtil.isRequiredFieldValid('website-url') &&
            AdminUtil.isRequiredFieldValid('email-address')) {
            var button = this;
            if (confirm("Are you sure you want to install the demo content? \nThe entire database will be deleted and replaced with another one.")) {
                var params = {
                    'nonce': $('#import-demo-nonce').val(),
                    'action': $('#import-demo-action').val(),
                    'email-address': $('#email-address').val(),
                    'website-url': $('#website-url').val()
                };
                var successMessage = $('#success-message');
                var errorMessage = $('#error-message');
                var waitMessage = $('#wait-message');
                waitMessage.show();
                $(button).attr('disabled', 'disabled');
                AdminUtil.doPost(params, 'html', function () {
                    waitMessage.hide();
                    successMessage.show();
                }, function () {
                    $(button).attr('disabled', '');
                    waitMessage.hide();
                    errorMessage.show();
                });
            }
        }
        return false;
    });

});
