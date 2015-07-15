/* ---------------------------------------------------------------------- */
/*	Browser Compatibility Check
 /* ---------------------------------------------------------------------- */

function ieExecuteAfterLoading(retryCount, maxRetryCount, callback) {
    var timer = setTimeout(function () {
        clearTimeout(timer);
        if ((jQuery && jQuery.browser) || (retryCount >= maxRetryCount)) {
            try {
                callback.call(this);
            } catch (e) {
                console.log(e);
            }
        } else {
            ieExecuteAfterLoading(++retryCount, maxRetryCount, callback);
        }
    }, 1000);
}

ieExecuteAfterLoading(0, 5, function() {
    if (jQuery && jQuery.browser) {
        var browserName = jQuery.browser.name;
        var browserVersion = jQuery.browser.versionNumber;
        if (browserName === 'msie') {
            var bResult = document.implementation.hasFeature("org.w3c.svg", "1.0");
            if (browserVersion <= 7 && !bResult) {
                var url = document.URL;
                if (url.indexOf('?') >= 0) {
                    url = url + '&unsupported=true';
                } else {
                    url = url + '?unsupported=true';
                }
                window.location.href = url;
            }
        }
    }
});