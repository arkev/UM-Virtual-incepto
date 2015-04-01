// JavaScript Document

/*global Modernizr */
/*global ddlevelsmenu */
/*global $f */

/* ---------------------------------------------------------------------- */
/* Utility Methods
 /* ---------------------------------------------------------------------- */
var Util = {

    isIOS6: function () {
        "use strict";
        if (/(iPhone|iPod|iPad)/i.test(navigator.userAgent)) {
            if (/OS [6](.*) like Mac OS X/i.test(navigator.userAgent)) {
                return true;
            }
        }
        return false;
    },

    isOpera: function () {
        "use strict";
        return jQuery.browser.name === 'opera';
    },

    isIE: function () {
        "use strict";
        return jQuery.browser.name === 'msie';
    },

    isChrome: function () {
        "use strict";
        return jQuery.browser.name === 'chrome';
    },

    closeDDLevelsMenu: function (e, target) {
        "use strict";
        var close = true;
        var subuls = ddlevelsmenu.topitems.nav;
        if (subuls) {
            jQuery.each(subuls, function (subul) {
                if (jQuery(subul.parentNode).has(target).length > 0) {
                    close = false;
                }
            });
        }
        if (close) {
            subuls = ddlevelsmenu.subuls.nav;
            if (subuls) {
                jQuery.each(subuls, function (subul) {
                    if (jQuery(subul).has(target).length > 0) {
                        close = false;
                    }
                });
            }
        }
        if (close) {
            subuls = ddlevelsmenu.subuls.nav;
            if (subuls) {
                jQuery.each(subuls, function (subul) {
                    if (subul && subul.parentNode) {
                        ddlevelsmenu.hidemenu(subul.parentNode);
                    }
                });
            }
        }
    }

};

/* ---------------------------------------------------------------------- */
/* ImagePreloader: https://github.com/farinspace/jquery.imgpreload
 /* ---------------------------------------------------------------------- */
(function ($) {
    "use strict";
    // extend jquery (because i love jQuery)
    $.imgpreload = function (imgs, settings) {
        settings = $.extend({}, $.fn.imgpreload.defaults, (settings instanceof Function) ? {
            all: settings
        } : settings);

        // use of typeof required
        // https://developer.mozilla.org/En/Core_JavaScript_1.5_Reference/Operators/Special_Operators/Instanceof_Operator#Description
        if ('string' === typeof imgs) {
            imgs = new Array(imgs);
        }

        var loaded = [];
        $.each(imgs, function (i, elem) {
            var img = new Image();
            var url = elem;
            var img_obj = img;
            if ('string' !== typeof elem) {
                url = $(elem).attr('src');
                img_obj = elem;
            }

            $(img).bind('load error', function (e) {
                loaded.push(img_obj);
                $.data(img_obj, 'loaded', ('error' !== e.type));
                if (settings.each instanceof Function) {
                    settings.each.call(img_obj);
                }
                // http://jsperf.com/length-in-a-variable
                if (loaded.length >= imgs.length && settings.all instanceof Function) {
                    settings.all.call(loaded);
                }

                $(this).unbind('load error');
            });

            img.src = url;
        });
    };

    $.fn.imgpreload = function (settings) {
        $.imgpreload(this, settings);
        return this;
    };

    $.fn.imgpreload.defaults = {
        each: null, // callback invoked when each image in a group loads
        all: null // callback invoked when when the entire group of images has loaded
    };

})(jQuery);
/* ---------------------------------------------------------------------- */
/* FlexSlider jQuery Initializer
 /* ---------------------------------------------------------------------- */
(function ($) {
    "use strict";
    $.fn.flexSliderInitializer = function (flexSliderObj) {
        var animation = flexSliderObj.animation;
        var sliderSelector = flexSliderObj.controlsContainer;
        var sliders = $(sliderSelector);
        var players;

        if (sliders.length > 0) {
            sliders.each(function () {
                var sliderElement = this;
                var sliderImages = $(sliderElement).find('img');
                if (sliderImages.length > 0) {

                    var firstImageSrc = $(sliderImages[0]).attr('src');
                    if (Util.isIE()) {
                        firstImageSrc += '?t=' + $.now();
                    }

                    $.imgpreload(firstImageSrc, function () {
                        if (Util.isIE()) {
                            $(sliderImages[0]).attr('src', firstImageSrc);
                            initSlider(sliderElement);
                        } else {
                            initSlider(sliderElement);
                        }
                    });
                }
            });
        }

        function initSlider(sliderElement) {
            var slider = $(sliderElement);
            players = slider.find('iframe');

            var sliderConfig = $.extend({}, {
                smoothHeight: (animation === 'slide'),
                pauseOnHover: true, //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                video: (animation === 'slide'),
                before: function () {
                    pausePlayers();
                }
            }, flexSliderObj);
            slider.fitVids().flexslider(sliderConfig);

            // Swipe gestures support
            if (Modernizr.touch && $().swipe) {
                var next = slider.find('a.flex-next');
                var prev = slider.find('a.flex-prev');

                var doFlexSliderSwipe = function (e, dir) {
                    if (dir.toLowerCase() === 'left') {
                        next.trigger('click');
                    }
                    if (dir.toLowerCase() === 'right') {
                        prev.trigger('click');
                    }
                };

                slider.swipe({
                    click: function (e, target) {
                        $(target).trigger('click');
                    },
                    swipeLeft: doFlexSliderSwipe,
                    swipeRight: doFlexSliderSwipe,
                    allowPageScroll: 'auto'
                });
            }
        }

        function pausePlayers() {
            try {
                if (players.length > 0 && window.$f) {
                    players.each(function () {
                        $f(this).api('pause');
                    });
                }
            } catch (e) {}
        }

    };

})(jQuery);

/* ---------------------------------------------------------------------- */
/* Responsive Search
 /* ---------------------------------------------------------------------- */
(function ($) {
    "use strict";

    $.fn.responsiveSearch = function (op) {
        var rs = $.fn.responsiveSearch;
        var settings = $.extend({}, rs.defaults, op);
        var searchInput = $(this);
        var searchButton = $('#search-submit');

        installListeners();

        function setSearchInputVisible(display) {
            if (display) {
                searchInput.fadeIn(settings.animSpeed);
            } else {
                searchInput.fadeOut(settings.animSpeed);
            }
        }

        function installListeners() {
            searchButton.bind('click', function () {
                var isSearchHidden = (searchInput.css('display') === 'none');
                if (isSearchHidden) {
                    setSearchInputVisible(true);
                    return false;
                } else if ($.trim(searchInput.val()) === '') {
                    setSearchInputVisible(false);
                    return false;
                } else {
                    return true;
                }
            });
        }

        rs.hide = function (target) {
            if (target.id !== 'ix-s' && target.id !== 'search-submit') {
                var isSearchVisible = (searchInput.css('display') !== 'none');
                if (isSearchVisible) {
                    setSearchInputVisible(false);
                }
            }
        };

        return rs;

    };

    var pcc = $.fn.responsiveSearch;
    pcc.defaults = {
        animSpeed: 500
    };

})(jQuery);

// This library re-implements setTimeout, setInterval, clearTimeout, clearInterval for iOS6.
// iOS6 suffers from a bug that kills timers that are created while a page is scrolling.
// This library fixes that problem by recreating timers after scrolling finishes (with interval correction).
// This code is free to use by anyone (MIT, blabla).
// Original Author: rkorving@wizcorp.jp
if (Util.isIOS6()) {
    (function (window) {
        "use strict";
        var timeouts = {};
        var intervals = {};
        var orgSetTimeout = window.setTimeout;
        var orgSetInterval = window.setInterval;
        var orgClearTimeout = window.clearTimeout;
        var orgClearInterval = window.clearInterval;
        // To prevent errors if loaded on older IE.
        if (!window.addEventListener) {
            return false;
        }

        function createTimer(set, map, args) {
            var id, cb = args[0],
                repeat = (set === orgSetInterval);

            function callback() {
                if (cb) {
                    cb.apply(window, arguments);
                    if (!repeat) {
                        delete map[id];
                        cb = null;
                    }
                }
            }

            args[0] = callback;
            id = set.apply(window, args);
            map[id] = {
                args: args,
                created: Date.now(),
                cb: cb,
                id: id
            };
            return id;
        }

        function resetTimer(set, clear, map, virtualId) {
            var timer = map[virtualId];
            if (!timer) {
                return;
            }
            var repeat = (set === orgSetInterval);
            // cleanup
            clear(timer.id);
            // reduce the interval (arg 1 in the args array)
            if (!repeat) {
                var interval = timer.args[1];
                var reduction = Date.now() - timer.created;
                if (reduction < 0) {
                    reduction = 0;
                }
                interval -= reduction;
                if (interval < 0) {
                    interval = 0;
                }
                timer.args[1] = interval;
            }
            // recreate
            function callback() {
                if (timer.cb) {
                    timer.cb.apply(window, arguments);
                    if (!repeat) {
                        delete map[virtualId];
                        timer.cb = null;
                    }
                }
            }

            timer.args[0] = callback;
            timer.created = Date.now();
            timer.id = set.apply(window, timer.args);
        }

        window.setTimeout = function () {
            return createTimer(orgSetTimeout, timeouts, arguments);
        };
        window.setInterval = function () {
            return createTimer(orgSetInterval, intervals, arguments);
        };
        window.clearTimeout = function (id) {
            var timer = timeouts[id];
            if (timer) {
                delete timeouts[id];
                orgClearTimeout(timer.id);
            }
        };
        window.clearInterval = function (id) {
            var timer = intervals[id];
            if (timer) {
                delete intervals[id];
                orgClearInterval(timer.id);
            }
        };
        //check and add listener on the top window if loaded on frameset/iframe
        var win = window;
        while (win.location !== win.parent.location) {
            win = win.parent;
        }
        win.addEventListener('scroll', function () {
            // recreate the timers using adjusted intervals
            // we cannot know how long the scroll-freeze lasted, so we cannot take that into account
            var virtualId;
            for (virtualId in timeouts) {
                if (timeouts.hasOwnProperty(virtualId)) {
                    resetTimer(orgSetTimeout, orgClearTimeout, timeouts, virtualId);
                }
            }
            for (virtualId in intervals) {
                if (intervals.hasOwnProperty(virtualId)) {
                    resetTimer(orgSetInterval, orgClearInterval, intervals, virtualId);
                }
            }
        });
    }(window));
}

// jQuery Initialization
jQuery(document).ready(function ($) {
    "use strict";
    /* ---------------------------------------------------------------------- */
    /*	Detect Touch Device
     /* ---------------------------------------------------------------------- */

    if (Modernizr.touch) {
        $("body").addClass("no-touch");
    }

    /* ---------------------------------------------------------------------- */
    /* Fixes for Browsers
     /* ---------------------------------------------------------------------- */

    if (Util.isOpera()) {
        $('.flexslider .slides > li').each(function () {
            $(this).css('overflow', 'hidden');
        });
    }

    /* ---------------------------------------------------------------------- */
    /* jCarousel
     /* ---------------------------------------------------------------------- */

    var allCarousels = document.carouselSettings;

    function resetCarouselPosition(carousel) {
        if (carousel.data('resizing')) {
            carousel.css('left', '0');
        }
    }

    function getCarouselScrollCount() {
        var windowWidth = $(window).width();
        if (windowWidth < 480) {
            return 1;
        } else if (windowWidth < 768) {
            return 2;
        } else if (windowWidth < 960) {
            return 3;
        } else {
            return 4;
        }
    }

    function swipeCarousel(e, dir) {
        var carouselParent = $(e.currentTarget).parents().eq(2);
        if (dir.toLowerCase() === 'left') {
            carouselParent.find('.jcarousel-next').trigger('click');
        }
        if (dir.toLowerCase() === 'right') {
            carouselParent.find('.jcarousel-prev').trigger('click');
        }
    }

    function initCarousel(carouselObj, bindGestures) {
        var carouselSelector = carouselObj.selector;
        var customSettings = carouselObj.customSettings;

        var carousels = $(carouselSelector);
        if (carousels.length > 0) {
            carousels.each(function () {
                var carousel = $(this);
                var defaultSettings = {
                    scroll: 1,
                    visible: 1,
                    wrap: "last",
                    easing: "swing",
                    itemVisibleInCallback: {
                        onBeforeAnimation: resetCarouselPosition(carousel),
                        onAfterAnimation: resetCarouselPosition(carousel)
                    }
                };
                var settings = $.extend({}, defaultSettings, customSettings);
                settings.scroll = Math.min(getCarouselScrollCount(), settings.scroll);
                carousel.jcarousel(settings);
            });

            if (bindGestures && Modernizr.touch && $().swipe) {
                carousels.swipe({
                    click: function (e, target) {
                        $(target).trigger('click');
                    },
                    swipeLeft: swipeCarousel,
                    swipeRight: swipeCarousel,
                    allowPageScroll: 'auto'
                });
            }
        }
    }

    function resizeCarousel(carouselObj) {
        var carousels = $(carouselObj.selector);
        if (carousels.length > 0) {
            carousels.each(function () {
                var carousel = $(this);
                var carouselChildren = carousel.children('li');
                var carouselItemWidth = carouselChildren.first().outerWidth(true);
                var newWidth = carouselChildren.length * carouselItemWidth + 100;
                if (carousel.width() !== newWidth) {
                    carousel.css('width', newWidth).data('resizing', 'true');
                    initCarousel(carouselObj, false);
                    carousel.jcarousel('scroll', 1);
                    var timer = window.setTimeout(function () {
                        window.clearTimeout(timer);
                        carousel.data('resizing', null);
                    }, 600);
                }
            });
        }
    }

    function resizeAllCarousels() {
        if ($().jcarousel && allCarousels) {
            for (var i = 0; i < allCarousels.length; i++) {
                resizeCarousel(allCarousels[i]);
            }
        }
    }

    function initAllCarousels() {
        if ($().jcarousel && allCarousels) {
            for (var i = 0; i < allCarousels.length; i++) {
                initCarousel(allCarousels[i], true);
            }
        }
    }

    initAllCarousels();

    /* ---------------------------------------------------------------------- */
    /* Tiny Nav
     /* ---------------------------------------------------------------------- */

    if ($().tinyNav) {

        $('html').addClass('js');
        $("#navlist").tinyNav();

    }

    /* ---------------------------------------------------------------------- */
    /* Responsive Search (must be placed after Tiny Nav)
     /* ---------------------------------------------------------------------- */

    var searchInput = $('#ix-s');
    if (searchInput.length > 0) {
        var responsiveSearchInstance = searchInput.responsiveSearch();
    }

    /* ---------------------------------------------------------------------- */
    /* Responsive Video Embeds (must be called before the FlexSlider initialization)
     /* ---------------------------------------------------------------------- */

    function resizeVideoEmbed() {
        if ($().fitVids) {
            $(".entry-video").fitVids();
        }
    }

    resizeVideoEmbed();

    /* ---------------------------------------------------------------------- */
    /* Flex Slider
     /* ---------------------------------------------------------------------- */

    function initAllFlexSliders() {
        var slidersSettings = document.slidersSettings;
        if (slidersSettings && slidersSettings.length > 0 && $().flexslider) {
            for (var i = 0; i < slidersSettings.length; i++) {
                $().flexSliderInitializer(slidersSettings[i]);
            }
        }
    }

    initAllFlexSliders();

    /* ---------------------------------------------------------------------- */
    /* Lightbox
     /* ---------------------------------------------------------------------- */

    function swipeFancyBox(e, dir) {
        var buttonBox = $('#fancybox-buttons');
        var nextButton = buttonBox.find('.btnNext');
        var prevButton = buttonBox.find('.btnPrev');
        if (dir.toLowerCase() === 'left' && nextButton) {
            nextButton.trigger('click');
        }
        if (dir.toLowerCase() === 'right' && prevButton) {
            prevButton.trigger('click');
        }
    }

    function calculateLightboxIFrameSize(origWidth, origHeight) {
        var windowWidth = $(window).width();
        if (windowWidth < origWidth * 1.3) {
            var width = windowWidth * 0.75;
            var height = (width * origHeight) / origWidth;
            return {
                'width': width,
                'height': height
            };
        } else {
            return false;
        }
    }

    function lightbox() {
        if ($().fancybox) {

            /* Video in Lightbox */
            $(".lightbox-video").each(function () {
                var $this = $(this);
                var origWidth = $this.data('width') ? $this.data('width') : 800;
                var origHeight = $this.data('height') ? $this.data('height') : 450;
                $this.fancybox({
                    autoScale: false,
                    transitionIn: 'none',
                    transitionOut: 'none',
                    title: this.title,
                    width: origWidth,
                    height: origHeight,
                    type: 'iframe',
                    fitToView: false,

                    openEffect: 'fade',
                    closeEffect: 'fade',
                    nextEffect: 'fade',
                    prevEffect: 'fade',
                    arrows: !Modernizr.touch,
                    helpers: {
                        title: {
                            type: 'inside'
                        },
                        buttons: {},
                        media: {}
                    },
                    beforeShow: function () {
                        var $this = this;
                        var size = calculateLightboxIFrameSize(origWidth, origHeight);
                        if (size) {
                            $this.width = size.width;
                            $this.height = size.height;
                        }
                    },
                    onUpdate: function () {
                        var $this = this;
                        var size = calculateLightboxIFrameSize(origWidth, origHeight);
                        if (size) {
                            $this.width = size.width;
                            $this.height = size.height;
                        }
                    },
                    beforeLoad: function () {
                        this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
                    },
                    afterShow: function () {
                        if (Modernizr.touch && $().swipe) {
                            var fancyBoxOuter = $('.fancybox-wrap');
                            var isSwipeAdded = fancyBoxOuter.data('swipe') === 'true';
                            if (!isSwipeAdded) {
                                fancyBoxOuter.data('swipe', 'true');
                                fancyBoxOuter.swipe({
                                    click: function (e, target) {
                                        $(target).trigger('click');
                                    },
                                    swipeLeft: swipeFancyBox,
                                    swipeRight: swipeFancyBox,
                                    allowPageScroll: 'auto'
                                });
                            }
                        }
                    }
                });
            });

            /* Image in Lightbox */
            var lightboxImages = [];
            $(".lightbox").each(function () {
                var parent = $(this).parent();
                var add = true;
                if (parent && parent.hasClass('clone')) {
                    add = false;
                }
                if (add) {
                    lightboxImages.push(this);
                }
            });

            $(lightboxImages).fancybox({
                openEffect: 'fade',
                closeEffect: 'fade',
                nextEffect: 'fade',
                prevEffect: 'fade',
                arrows: !Modernizr.touch,
                helpers: {
                    title: {
                        type: 'inside'
                    },
                    buttons: {},
                    media: {}
                },
                beforeLoad: function () {
                    this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
                },
                afterShow: function () {
                    if (Modernizr.touch && $().swipe) {
                        var fancyBoxOuter = $('.fancybox-wrap');
                        var isSwipeAdded = fancyBoxOuter.data('swipe') === 'true';
                        if (!isSwipeAdded) {
                            fancyBoxOuter.data('swipe', 'true');
                            fancyBoxOuter.swipe({
                                click: function (e, target) {
                                    $(target).trigger('click');
                                },
                                swipeLeft: swipeFancyBox,
                                swipeRight: swipeFancyBox,
                                allowPageScroll: 'auto'
                            });
                        }
                    }
                }
            });
        }
    }

    lightbox();

    /* ---------------------------------------------------------------------- */
    /* Tooltips
     /* ---------------------------------------------------------------------- */

    if ($().tipsy) {

        $('.clients img[title], .social-links a[title], .entry-slider img[title], .inc-tooltip[title]').tipsy({
            fade: true,
            gravity: $.fn.tipsy.autoNS,
            offset: 3
        });

    }

    /* ---------------------------------------------------------------------- */
    /* Scroll to Top
     /* ---------------------------------------------------------------------- */

    if ($().UItoTop) {

        $().UItoTop({
            scrollSpeed: 400
        });

    }

    /* ---------------------------------------------------------------------- */
    /* Fix for YouTube Iframe Z-Index
     /* ---------------------------------------------------------------------- */

    $("iframe").each(function () {
        var ifr_source = $(this).attr('src');
        if (ifr_source) {
            var wmode = "wmode=transparent";
            if (ifr_source.indexOf('?') !== -1) {
                var getQString = ifr_source.split('?');
                var oldString = getQString[1];
                var newString = getQString[0];
                $(this).attr('src', newString + '?' + wmode + '&' + oldString);
            } else {
                $(this).attr('src', ifr_source + '?' + wmode);
            }
        }
    });

    /* ---------------------------------------------------------------------- */
    /* Notification Boxes
     /* ---------------------------------------------------------------------- */

    $(".notification-close-info").click(function () {
        $(this).parent().fadeOut("fast");
        return false;
    });

    $(".notification-close-success").click(function () {
        $(this).parent().fadeOut("fast");
        return false;
    });

    $(".notification-close-warning").click(function () {
        $(this).parent().fadeOut("fast");
        return false;
    });

    $(".notification-close-error").click(function () {
        $(this).parent().fadeOut("fast");
        return false;
    });

    /* ---------------------------------------------------------------------- */
    /* Tabs
     /* ---------------------------------------------------------------------- */

    if ($().tabs) {
        $(".tabs").each(function () {
            var settings = {};
            var active = $(this).data('active');
            if (active && $.isNumeric(active)) {
                settings.active = parseInt(active) - 1;
            }

            var heightStyle = $(this).data('heightStyle');
            if (heightStyle) {
                settings.heightStyle = heightStyle;
            }

            var disabled = $(this).data('disabled');
            if (disabled) {
                if ($.isNumeric(disabled)) {
                    disabled = [parseInt(disabled) - 1];
                } else {
                    disabled = $.map(disabled.split(','), function (value) {
                        return parseInt(value, 10) - 1;
                    });
                }
                settings.disabled = disabled;
            }

            $(this).tabs(settings);
        });
    }

    /* ---------------------------------------------------------------------- */
    /* Accordion & Toggle
     /* ---------------------------------------------------------------------- */

    if ($().accordion) {
        $(".toggle").each(function () {
            // for backwards compatibility
            var active = $(this).data('id');
            if (active && active === 'opened') {
                active = true;
            } else {
                active = $(this).data('active');
            }
            if (active && (active === 'true' || active === true)) {
                active = 0;
            } else {
                active = false;
            }

            var heightStyle = $(this).data('heightStyle');
            if (!heightStyle) {
                heightStyle = 'content';
            }

            var disabled = $(this).data('disabled');
            disabled = disabled && (disabled === 'true' || disabled === true);

            $(this).accordion({
                header: '.toggle-title',
                collapsible: true,
                heightStyle: heightStyle,
                disabled: disabled,
                active: active
            });
        });

        $(".accordion").each(function () {
            var heightStyle = $(this).data('heightStyle');
            if (!heightStyle) {
                heightStyle = 'content';
            }

            var active = $(this).data('active');
            if (active && $.isNumeric(active)) {
                active = parseInt(active) - 1;
            } else {
                active = false;
            }

            var disabled = $(this).data('disabled');
            disabled = disabled && (disabled === 'true' || disabled === true);

            $(this).accordion({
                header: '.accordion-title',
                collapsible: true,
                heightStyle: heightStyle,
                disabled: disabled,
                active: active
            });
        });
    }

    /* ---------------------------------------------------------------------- */
    /* Shortcodes Settings
     /* ---------------------------------------------------------------------- */

    var shortcodesSettingsUtil = {

        setSameHeightForPortfolioItems: function (selector) {
            var items = $(selector);
            if (items.length > 0) {
                var maxItemHeight = Math.max.apply(null, items.map(function () {
                    return $(this).height();
                }).get());
                items.css('minHeight', maxItemHeight + 'px');
            }
        },

        setSameHeightForIconBoxes: function () {
            var scSettings = document.incShortcodesSettings;
            if (scSettings && scSettings.sameIconBoxHeight && scSettings.sameIconBoxHeight === true) {
                var timer = window.setTimeout(function () {
                    window.clearTimeout(timer);
                    var iconBoxes = $('div.iconbox a');
                    if (iconBoxes.length > 0) {
                        var maxIconBoxesHeight = Math.max.apply(null, iconBoxes.map(function () {
                            return $(this).height();
                        }).get());
                        iconBoxes.css('minHeight', maxIconBoxesHeight + 'px');
                    }
                }, 500);
            }
        }
    };

    shortcodesSettingsUtil.setSameHeightForIconBoxes();

    /* ---------------------------------------------------------------------- */
    /* Portfolio Filter
     /* ---------------------------------------------------------------------- */

    function doIsotopeFilter(container, filter, selectedFilter) {
        var $filterLinks = filter.find('a');
        if ($().isotope) {
            var isotopeFilter = '';
            $filterLinks.each(function () {
                var selector = $(this).attr('data-filter');
                var link = window.location.href;
                var firstIndex = link.indexOf('filter=');
                if (firstIndex > 0) {
                    var id = link.substring(firstIndex + 7, link.length);
                    if ('.' + id === selector) {
                        isotopeFilter = '.' + id;
                    }
                }
            });
            if (isotopeFilter.length === 0 && selectedFilter.length > 0) {
                isotopeFilter = '.' + selectedFilter;
            }
            if (isotopeFilter.length > 0) {
                // initialize Isotope
                container.isotope({
                    itemSelector: '.entry',
                    filter: isotopeFilter
                });
                $filterLinks.each(function () {
                    var $this = $(this);
                    var selector = $this.attr('data-filter');
                    if (selector === isotopeFilter) {
                        if (!$this.hasClass('selected')) {
                            filter.find('.selected').removeClass('selected');
                            $this.addClass('selected');
                        }
                    }
                });
            }

            // filter items when filter link is clicked
            $filterLinks.click(function () {
                var $this = $(this);
                var selector = $this.attr('data-filter');
                container.isotope({
                    itemSelector: '.entry',
                    filter: selector
                });

                if (!$this.hasClass('selected')) {
                    filter.find('.selected').removeClass('selected');
                    $this.addClass('selected');
                }

                return false;
            });

        }
    }

    var postsGallerySettings = document.postsGallerySettings;
    if (postsGallerySettings && postsGallerySettings.length > 0) {
        $(postsGallerySettings).each(function () {
            var container = $(this.containerSelector);
            var filter = $(this.filterSelector);
            var selectedFilter = this.selectedFilter;

            $.imgpreload($(container).find('img'), function () {
                shortcodesSettingsUtil.setSameHeightForPortfolioItems('li.entry a.entry-meta');
                shortcodesSettingsUtil.setSameHeightForPortfolioItems('li.entry');
                doIsotopeFilter(container, filter, selectedFilter);
            });
        });
    }



    /* ---------------------------------------------------------------------- */
    /* Form Validation
     /* ---------------------------------------------------------------------- */

    if ($().validate) {
        $("#comment-form").validate();
    }

    var formSuccessNotificationTimeout = 5000; //5 seconds
    var forErrorNotificationTimeout = 10000; //10 seconds
    var formsSettings = document.formsSettings;
    if (formsSettings && formsSettings.length > 0) {
        $(formsSettings).each(function () {
            var submitButtonId = this.submitButtonId;
            var action = this.action;
            var successBoxId = this.successBoxId;
            var errorBoxId = this.errorBoxId;
            $('#' + submitButtonId).click(function () {
                $('#' + successBoxId).hide();
                $('#' + errorBoxId).hide();
                return $(this).submitForm(action, function () {
                    $('#' + successBoxId).css('display', '');
                    if (formSuccessNotificationTimeout > 0) {
                        var timer = window.setTimeout(function () {
                            window.clearTimeout(timer);
                            $('#' + successBoxId).fadeOut("slow");
                        }, formSuccessNotificationTimeout);
                    }
                }, function (jqXHR) {
                    var errorMsgElement = $('#' + errorBoxId + '-p');
                    var errorMessage = jqXHR.responseText;
                    if (!errorMessage || errorMessage.length === 0) {
                        errorMessage = errorMsgElement.data('default-msg');
                    }
                    if (errorMessage && errorMessage.length > 0) {
                        errorMsgElement.html(errorMessage);
                    }
                    $('#' + errorBoxId).css('display', '');
                    if (forErrorNotificationTimeout > 0) {
                        var timer = window.setTimeout(function () {
                            window.clearTimeout(timer);
                            $('#' + errorBoxId).fadeOut("slow");
                        }, forErrorNotificationTimeout);
                    }
                });
            });
        });
    }

    /* ---------------------------------------------------------------------- */
    /* Twitter Widget
     /* ---------------------------------------------------------------------- */

    if ($().tweet) {
        $("div.tweet").each(function () {
            try {
                var wrapper = $(this);
                var settings = {
                    username: '',
                    twitter_api_url: '',
                    join_text: false,
                    avatar_size: false, // you can activate the avatar
                    count: 3, // number of tweets
                    view_text: "view tweet on twitter",
                    seconds_ago_text: "about %d seconds ago",
                    a_minutes_ago_text: "about a minute ago",
                    minutes_ago_text: "about %d minutes ago",
                    a_hours_ago_text: "about an hour ago",
                    hours_ago_text: "about %d hours ago",
                    a_day_ago_text: "about a day ago",
                    days_ago_text: "about %d days ago",
                    template: "{avatar}{text}{join}{time}" // [string or function] template used to construct each tweet <li> - see code for available vars
                };

                var username = wrapper.data('username');
                if (typeof username !== 'undefined') {
                    settings.username = username;
                }
                var proxy = wrapper.data('proxy');
                if (typeof proxy !== 'undefined') {
                    settings.twitter_api_url = proxy;
                }
                var count = wrapper.data('count');
                if (typeof count !== 'undefined') {
                    settings.count = count;
                }

                wrapper.tweet(settings);
            } catch (e) {
                console.log(e);
            }
        });
    }

    /* ---------------------------------------------------------------------- */
    /* Flickr Widget
     /* ---------------------------------------------------------------------- */

    var flickrSettings = document.flickrSettings;
    if (flickrSettings && $().jflickrfeed) {
        $('.flickr-feed').jflickrfeed({
            limit: flickrSettings.limit,
            qstrings: {
                id: flickrSettings.id // Flickr ID (Flickr IDs can be found using this tool: http://idgettr.com/)
            },
            itemTemplate: '<li><a href="{{link}}" title="{{title}}" target="_blank"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
        });
    }

    /* ---------------------------------------------------------------------- */
    /* jQuery UI
     /* ---------------------------------------------------------------------- */
    if ($().datepicker) {
        $(".datepicker").datepicker();
    }

    if ($().slider) {
        $("div.slider,div.inc-slider").each(function () {
            var wrapper = $(this);
            var settings = {};

            var animate = wrapper.data('animate');
            if (typeof animate !== 'undefined') {
                settings.animate = animate;
            }
            var disabled = wrapper.data('disabled');
            if (typeof disabled !== 'undefined') {
                settings.disabled = disabled;
            }
            var max = wrapper.data('max');
            if (typeof max !== 'undefined') {
                settings.max = max;
            }
            var min = wrapper.data('min');
            if (typeof min !== 'undefined') {
                settings.min = min;
            }
            var orientation = wrapper.data('orientation');
            if (typeof orientation !== 'undefined') {
                settings.orientation = orientation;
            }
            var range = wrapper.data('range');
            if (typeof range !== 'undefined') {
                settings.range = range;
            }
            var step = wrapper.data('step');
            if (typeof step !== 'undefined') {
                settings.step = step;
            }
            var value = wrapper.data('value');
            if (typeof value !== 'undefined') {
                settings.value = value;
            }
            var values = wrapper.data('values');
            if (typeof values !== 'undefined') {
                settings.values = values;
            }

            wrapper.slider(settings);
        });
    }

    /* ---------------------------------------------------------------------- */
    /* Google Maps
     /* ---------------------------------------------------------------------- */

    var mapObjects = $('.map');
    if ($().gMap && mapObjects.length > 0) {
        mapObjects.each(function () {
            var lat = $(this).data('lat'); //uses data-lat attribute
            var lng = $(this).data('lng'); //uses data-lng attribute
            var addr = $(this).data('address'); //uses data-address attribute
            var zoom = $(this).data('zoom'); //uses data-zoom attribute
            var markers = {};
            if (addr) {
                markers.address = addr;
            } else {
                markers.latitude = lat;
                markers.longitude = lng;
            }

            $(this).gMap({
                markers: [markers],
                zoom: zoom
            });
        });

    }

    function resizeGoogleMap() {
        if (mapObjects.length > 0) {
            mapObjects.each(function () {
                var mapWidth = $(this).width();
                var mapHeight = Math.round(mapWidth * 0.425);
                $(this).height(mapHeight);
            });
        }
    }

    resizeGoogleMap();

    /* ---------------------------------------------------------------------- */
    /* Sticky Footer
     /* ---------------------------------------------------------------------- */

    // Set minimum height so that the footer will stay at the bottom of the window even if there isn't enough content
    function setMinHeight() {
        var body = $('body');
        var wrap = $('#wrap');
        var content = $('#content');
        content.css('min-height', $(window).outerHeight(true) - (body.outerHeight(true) - body.height()) - (wrap.outerHeight(true) - wrap.height()) - $('#header').outerHeight(true) - $('#slider-home').outerHeight(true) - $('#page-title').outerHeight(true) - (content.outerHeight(true) - content.height()) - $('#footer').outerHeight(true));
    }

    // Init
    setMinHeight();

    // Window resize
    $(window).on('resize', function () {
        var timer = window.setTimeout(function () {
            window.clearTimeout(timer);
            setMinHeight();
            resizeAllCarousels();
            resizeGoogleMap();
        }, 30);
    });


    if (Modernizr.touch) {
        $(document).on('touchstart', function (e) {
            var target = e.target;
            if (responsiveSearchInstance) {
                responsiveSearchInstance.hide(target);
            }
            Util.closeDDLevelsMenu(e, target);
            closeLanguageSwitcher(target);
        });
    } else {
        $(document).click(function (e) {
            Util.closeDDLevelsMenu(e, '');
            if (responsiveSearchInstance) {
                responsiveSearchInstance.hide(e.target);
            }
            closeLanguageSwitcher(e.target);
        });
    }

    /* ---------------------------------------------------------------------- */
    /* Language Switcher
     /* ---------------------------------------------------------------------- */

    function openLanguageSwitcher() {
        if (languageSwitcher.length > 0) {
            languageSwitcherStatus = 'opening';
            languageSwitcher.animate({
                left: '0px'
            }, 100, function () {
                languageSwitcherStatus = 'opened';
            });
        }
    }

    function closeLanguageSwitcher(target) {
        var $target = $(target);
        if (!$target.parents().hasClass("language-switcher") || $target.attr('id') === languageSwitcherThumb.attr('id')) {
            if (languageSwitcher.length > 0) {
                languageSwitcherStatus = 'closing';
                languageSwitcher.animate({
                    left: '-195px'
                }, 100, function () {
                    languageSwitcherStatus = 'closed';
                });
            }
        }
    }

    function loadLanguageSwitcher() {
        if (languageSwitcher.length > 0) {
            languageSwitcher.show();
            languageSwitcherThumb.click(function (e) {
                e.stopPropagation();
                e.preventDefault();
                if (languageSwitcherStatus === 'closed') {
                    openLanguageSwitcher();
                } else if (languageSwitcherStatus === 'opened') {
                    closeLanguageSwitcher(languageSwitcherThumb);
                }
            });
        }
    }

    var languageSwitcher = $('#inc-language-switcher');
    var languageSwitcherThumb = $('#inc-language-switcher-thumb');
    var languageSwitcherStatus = 'closed';
    loadLanguageSwitcher();

    /* ---------------------------------------------------------------------- */
    /* Style Switcher
     /* ---------------------------------------------------------------------- */

    var windowWidth = $(window).width();
    if (windowWidth > 480) {
        if ($().styleSwitcher) {
            var styleSwitcher = $().styleSwitcher();
            styleSwitcher.loadStyleSwitcher();
            styleSwitcher.applySettings();
        }
    }

});

/* ---------------------------------------------------------------------- */
/* Fecha en el footer
/* ---------------------------------------------------------------------- */
var ano = (new Date).getFullYear();

document.getElementById("fecha").innerHTML = ano;

// Iframe
iFrameResize({
    log: true,// Enable console logging
});