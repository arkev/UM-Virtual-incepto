/* ---------------------------------------------------------------------- */
/* Style Switcher
 /* ---------------------------------------------------------------------- */
(function ($) {

    $.fn.styleSwitcher = function () {

        var settings = {};
        var ns = $.fn.styleSwitcher;
        var isMobile = Modernizr.touch;
        var status = 'closed';

        var optionName = {
            layout:'layout',
            color:'color',
            wideBgPattern:'wideBgPattern',
            widePTPattern:'widePTPattern',
            boxedBgPattern:'boxedBgPattern'
        };

        var defaultOptions = {
            layout:'wide',
            color:'green',
            wideBgPattern:'none',
            widePTPattern:'wide-pt-1',
            boxedBgPattern:'boxed-bg-1'
        };

        function getOption(option) {
            if (option === optionName.layout) {
                if(isMobile){
                    return 'wide';
                }else{
                    var href = window.location.href;
                    if (href.indexOf("boxed") >= 0) {
                        return 'boxed';
                    }
                }
            }
            var val = settings[option];
            return val ? val : defaultOptions[option];
        }

        function setOption(option, value) {
            settings[option] = value;
        }

        var layout;

        var wideOptionsDiv = '<div id="ss-wide-options">' +
            '<h3>Predefined Colors</h3>' +
            '<ul id="ss-wide-predefined-colors" class="ss-colors ss-thumbs' + (isMobile ? ' ss-thumbs-mobile' : '') + '">' +
            '<li><a id="ss-wide-default-color" href="#" data-color="green" class="green active" title="Green"></a></li>' +
            '<li><a href="#" data-color="retro-green" class="retro-green" title="Retro Green"></a></li>' +
            '<li><a href="#" data-color="teal" class="teal" title="Teal"></a></li>' +
            '<li><a href="#" data-color="orange" class="orange" title="Orange"></a></li>' +
            '<li><a href="#" data-color="yellow" class="yellow" title="Yellow"></a></li>' +
            '<li><a href="#" data-color="blue" class="blue" title="Blue"></a></li>' +
            '<li><a href="#" data-color="indigo" class="indigo" title="Indigo"></a></li>' +
            '<li><a href="#" data-color="red" class="red" title="Red"></a></li>' +
            '<li><a href="#" data-color="purple" class="purple" title="Purple"></a></li>' +
            '<li><a href="#" data-color="pink" class="pink" title="Pink"></a></li>' +
            '</ul>' +

            '<h3>Background Patterns</h3>' +
            '<ul id="ss-wide-bg-patterns" class="ss-bg-patterns ss-thumbs' + (isMobile ? ' ss-thumbs-mobile' : '') + '">' +
            '<li><a id="ss-wide-default-bg-pattern" href="#" data-bgp="none" class="none active"></a></li>' +
            '<li><a href="#" data-bgp="wide-bg-1" class="wide-bg-1"></a></li>' +
            '<li><a href="#" data-bgp="wide-bg-2" class="wide-bg-2"></a></li>' +
            '<li><a href="#" data-bgp="wide-bg-3" class="wide-bg-3"></a></li>' +
            '<li><a href="#" data-bgp="wide-bg-4" class="wide-bg-4"></a></li>' +
            '<li><a href="#" data-bgp="wide-bg-5" class="wide-bg-5"></a></li>' +
            '<li><a href="#" data-bgp="wide-bg-6" class="wide-bg-6"></a></li>' +
            '</ul>'+
            '</div>';

        var boxedOptionsDiv = '<div id="ss-boxed-options" style="display: none">' +
            '<h3>Predefined Colors</h3>' +
            '<ul id="ss-boxed-predefined-colors" class="ss-colors ss-thumbs' + (isMobile ? ' ss-thumbs-mobile' : '') + '">' +
            '<li><a id="ss-boxed-default-color" href="#" data-color="green" class="green active" title="Green"></a></li>' +
            '<li><a href="#" data-color="retro-green" class="retro-green" title="Retro Green"></a></li>' +
            '<li><a href="#" data-color="teal" class="teal" title="Teal"></a></li>' +
            '<li><a href="#" data-color="orange" class="orange" title="Orange"></a></li>' +
            '<li><a href="#" data-color="yellow" class="yellow" title="Yellow"></a></li>' +
            '<li><a href="#" data-color="blue" class="blue" title="Blue"></a></li>' +
            '<li><a href="#" data-color="indigo" class="indigo" title="Indigo"></a></li>' +
            '<li><a href="#" data-color="red" class="red" title="Red"></a></li>' +
            '<li><a href="#" data-color="purple" class="purple" title="Purple"></a></li>' +
            '<li><a href="#" data-color="pink" class="pink" title="Pink"></a></li>' +
            '</ul>';

        if (!isMobile) {
            boxedOptionsDiv += '<h3>Background Patterns</h3>' +
                '<ul id="ss-boxed-bg-patterns" class="ss-bg-patterns ss-thumbs' + (isMobile ? ' ss-thumbs-mobile' : '') + '">' +
                '<li><a id="ss-boxed-default-bg-pattern" href="#" data-bgp="boxed-bg-1" class="boxed-bg-1"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-2" class="boxed-bg-2"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-3" class="boxed-bg-3"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-4" class="boxed-bg-4"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-5" class="boxed-bg-5"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-6" class="boxed-bg-6"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-7" class="boxed-bg-7"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-8" class="boxed-bg-8"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-9" class="boxed-bg-9"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-10" class="boxed-bg-10"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-11" class="boxed-bg-11"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-12" class="boxed-bg-12"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-13" class="boxed-bg-13"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-14" class="boxed-bg-14"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-15" class="boxed-bg-15"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-16" class="boxed-bg-16"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-17" class="boxed-bg-17"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-18" class="boxed-bg-18"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-19" class="boxed-bg-19"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-20" class="boxed-bg-20"></a></li>' +
                '<li><a href="#" data-bgp="boxed-bg-21" class="boxed-bg-21"></a></li>' +
                '</ul>';
        }
        boxedOptionsDiv += '</div>';

        var layoutSwitcher = '<div>' +
            '<h3>Layout Styles</h3>' +
            '<div id="ss-layout-switcher">' +
            '<a id="ss-layout-wide" class="button" href="#">Wide</a>' +
            '<a id="ss-layout-boxed" class="button" href="#">Boxed</a>' +
            '</div>' +
            '</div>';

        function loadStyleSwitcher() {
            var optionsPanel = isMobile ? wideOptionsDiv : (wideOptionsDiv + boxedOptionsDiv);
            $('<div id="style-switcher" style="left: -195px">' +
                '<h2>Style Switcher <a href="#"></a></h2>' +
                '<div id="ss-options">' +
                optionsPanel +
                (isMobile ? '' : layoutSwitcher) +
                '</div>' +
                '<div id="ss-reset"><a href="#" class="button">Reset</a></div>' +
                '</div>').appendTo('body');
            initListeners();
        }

        function applySettings(doApplyLayout) {
            var layout = getOption(optionName.layout);
            if(doApplyLayout){
                applyLayout(layout === 'wide' ? 'boxed' : 'wide', layout);
            }
            applyColor(getOption(optionName.color));
            if (!isMobile) {
                applyBgPattern(getOption(optionName[layout + 'BgPattern']));
            }
        }

        function initListeners() {

            // Style Switcher
            $('#style-switcher h2 a').click(function (e) {
                e.preventDefault();
                var div = $('#style-switcher');
                if (status === 'closed') {
                    status = 'opening';
                    div.animate({
                        left:'0px'
                    }, 100, function () {
                        status = 'opened';
                    });
                } else if (status === 'opened') {
                    status = 'closing';
                    div.animate({
                        left:'-195px'
                    }, 100, function () {
                        status = 'closed';
                    });
                }
            });

            if (!isMobile) {
                $('#ss-layout-wide').bind('click', function () {
                    setOption(optionName.layout, 'wide');
                    var href = window.location.href;
                    href = href.replace('#','');
                    if (href.indexOf('?') >= 0) {
                        href = href.substring(0, href.indexOf('?'));
                    }
                    window.location.href = href+'?ly=wide';
                });

                $('#ss-layout-boxed').bind('click', function () {
                    setOption(optionName.layout, 'boxed');
                    var href = window.location.href;
                    href = href.replace('#','');
                    if (href.indexOf('?') >= 0) {
                        href = href.substring(0, href.indexOf('?'));
                    }
                    window.location.href = href+'?ly=boxed';
                });

            }

//Bg Pattern Switcher
            $('.ss-bg-patterns li a').click(function (e) {
                e.preventDefault();
                var bgp = $(this).data('bgp');
                applyBgPattern(bgp);
                setOption(optionName[layout + 'BgPattern'], bgp);
                setOption(optionName[layout + 'BgType'], 'pattern');
                return false;
            });

            // Color Switcher
            $(".ss-colors li a").click(function (e) {
                e.preventDefault();
                var color = $(this).data('color');
                applyColor(color);
                setOption(optionName['color'], color);
                return false;
            });

            $('#ss-reset a').click(function (e) {
                reset();
            });
        }

        function applyLayout(oldLayout, newLayout) {
            if (layout === newLayout) {
                return;
            }
            layout = newLayout;
            if (!isMobile) {
                $('#ss-' + oldLayout + '-options').hide();
                $('#ss-' + newLayout + '-options').show();

//                var body = $('body');
//                body.removeClass('wide').removeClass('boxed').addClass(newLayout);
                if (newLayout === 'wide') {
                    $('#ss-layout-boxed').removeClass('active');
                    $('#ss-layout-wide').addClass('active');
                } else {
                    $('#ss-layout-wide').removeClass('active');
                    $('#ss-layout-boxed').addClass('active');
                }
            }
        }

        function applyColor(color) {
            $('#ss-' + layout + '-predefined-colors > li > a').each(function () {
                var $this = $(this);
                if ($this.hasClass(color)) {
                    if (!$this.hasClass('active')) {
                        $this.addClass('active');
                    }
                } else {
                    $this.removeClass('active');
                }
            });
            $("#color-style-css").attr("href", "http://www.ixtendo.com/themes/inceptio-wp/wp-content/themes/inceptio/css/colors/" + color + ".css");
        }

        function applyBgPattern(bgPattern) {
            $('#ss-' + layout + '-bg-patterns > li > a').each(function () {
                var $this = $(this);
                if ($this.hasClass(bgPattern)) {
                    if (bgPattern === 'none') {
                        $('body').css('backgroundImage', 'none');
                    }else{
                        $('body').css('backgroundImage', $this.css('backgroundImage'));
                    }
                    if (!$this.hasClass('active')) {
                        $this.addClass('active');
                    }
                } else {
                    $this.removeClass('active');
                }
            });
        }

        function reset() {
            resetColor();
            if (!isMobile) {
                resetBgPattern();
            }
        }

        function resetColor() {
            var defaultColor = defaultOptions.color;
            setOption(optionName.color, defaultColor);
            $('#' + layout + '-predefined-colors').find('.active').removeClass('active');
            $('#' + layout + '-default-color').addClass('active');
            $("#color-style-css").attr("href", "http://www.ixtendo.com/themes/inceptio-wp/wp-content/themes/inceptio/css/colors/" + defaultColor + ".css");
        }

        function resetBgPattern() {
            setOption(optionName.wideBgPattern, defaultOptions.wideBgPattern);
            setOption(optionName.boxedBgPattern, defaultOptions.boxedBgPattern);
            applyBgPattern(defaultOptions[layout + 'BgPattern']);
        }

        ns.loadStyleSwitcher = function () {
            loadStyleSwitcher();
            return ns;
        };

        ns.applySettings = function () {
            applySettings(true);
            return ns;
        };

        return ns;

    };


})(jQuery);