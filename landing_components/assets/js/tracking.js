// Analytics
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-49916110-1']);
        _gaq.push(['_trackPageview']);
        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

// Google Code para etiquetas de remarketing 
        /* <![CDATA[ */
        var google_conversion_id = 957296960;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    

// Facebook Pixel Code 
        ! function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window,
            document, 'script', '//connect.facebook.net/en_US/fbevents.js');

        fbq('init', '954439487953611');
        fbq('track', "PageView");


//Tracking Code de Agile CRM
        _agile.set_account('nnrj2h9osqla66t5rf6h2ai1sr', 'umvirtual');
        _agile.track_page_view();
        _agile_execute_web_rules();