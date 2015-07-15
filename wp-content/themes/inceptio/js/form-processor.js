(function ($) {
    "use strict";
    $.fn.submitForm = function (userAction, successCallback, failureCallback, actionName) {
        actionName = (typeof actionName !== 'undefined') ? actionName : 'inc-process-form';
        var invoker = $(this);
        var formEl = invoker.closest("form");

        if (formEl.valid()) {
            var postParams = getFormData();

            invoker.attr('disabled', 'disabled');
            $.ajax({
                type:"POST",
                url:formEl.attr('action'),
                dataType:'html',
                data:postParams,
                success:function (html, textStatus, jqXHR) {
                    if(html && html.indexOf('redirect:') === 0){
                        html = html.replace('redirect:', '');
                        window.location = html;
                    }else{
                        invoker.removeAttr('disabled');
                        resetFormData();
                        if (typeof successCallback === 'function') {
                            successCallback(html, textStatus, jqXHR);
                        }
                    }
                },
                error:function (jqXHR, textStatus, errorThrown) {
                    invoker.removeAttr('disabled');
                    if (typeof failureCallback === 'function') {
                        failureCallback(jqXHR, textStatus, errorThrown);
                    }
                }
            });
        }

        function getFormData() {
            var postParams = {
                action: actionName,
                ua: userAction
            };
            formEl.find(':input').each(function () {
                if (this.tagName.toLowerCase() !== 'button') {
                    postParams[this.name] = this.value;
                }
            });
            return postParams;
        }

        function resetFormData() {
            formEl.find(':input').each(function () {
                var field = $(this);
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
        }

        return false;
    };

})(jQuery);