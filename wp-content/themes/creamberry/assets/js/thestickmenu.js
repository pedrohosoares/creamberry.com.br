!(function (x) {
    (x.fn.theiaStickySidebar = function (i) {
        var t, e;
        function o(i, t) {
            return (
                !0 === i.initialized ||
                (!(x("body").width() < i.minWidth) &&
                    ((function (m, i) {
                        (m.initialized = !0),
                            0 === x("#theia-sticky-sidebar-stylesheet-" + m.namespace).length &&
                                x("head").append(x('<style id="theia-sticky-sidebar-stylesheet-' + m.namespace + '">.theiaStickySidebar:after {content: ""; display: table; clear: both;}</style>'));
                        i.each(function () {
                            var e,
                                i = {};
                            (i.sidebar = x(this)),
                                (i.options = m || {}),
                                (i.container = x(i.options.containerSelector)),
                                0 == i.container.length && (i.container = i.sidebar.parent()),
                                i.sidebar.parents().css("-webkit-transform", "none"),
                                i.sidebar.css({ position: i.options.defaultPosition, overflow: "visible", "-webkit-box-sizing": "border-box", "-moz-box-sizing": "border-box", "box-sizing": "border-box" }),
                                (i.stickySidebar = i.sidebar.find(".theiaStickySidebar")),
                                0 == i.stickySidebar.length &&
                                    ((e = /(?:text|application)\/(?:x-)?(?:javascript|ecmascript)/i),
                                    i.sidebar
                                        .find("script")
                                        .filter(function (i, t) {
                                            return 0 === t.type.length || t.type.match(e);
                                        })
                                        .remove(),
                                    (i.stickySidebar = x("<div>").addClass("theiaStickySidebar").append(i.sidebar.children())),
                                    i.sidebar.append(i.stickySidebar)),
                                (i.marginBottom = parseInt(i.sidebar.css("margin-bottom"))),
                                (i.paddingTop = parseInt(i.sidebar.css("padding-top"))),
                                (i.paddingBottom = parseInt(i.sidebar.css("padding-bottom")));
                            var t,
                                o,
                                a,
                                n = i.stickySidebar.offset().top,
                                s = i.stickySidebar.outerHeight();
                            function u() {
                                (i.fixedScrollTop = 0), i.sidebar.css({ "min-height": "1px" }), i.stickySidebar.css({ position: "static", width: "", transform: "none" });
                            }
                            i.stickySidebar.css("padding-top", 1),
                                i.stickySidebar.css("padding-bottom", 1),
                                (n -= i.stickySidebar.offset().top),
                                (s = i.stickySidebar.outerHeight() - s - n),
                                0 == n ? (i.stickySidebar.css("padding-top", 0), (i.stickySidebarPaddingTop = 0)) : (i.stickySidebarPaddingTop = 1),
                                0 == s ? (i.stickySidebar.css("padding-bottom", 0), (i.stickySidebarPaddingBottom = 0)) : (i.stickySidebarPaddingBottom = 1),
                                (i.previousScrollTop = null),
                                (i.fixedScrollTop = 0),
                                u(),
                                (i.onScroll = function (i) {
                                    if (i.stickySidebar.is(":visible"))
                                        if (x("body").width() < i.options.minWidth) u();
                                        else {
                                            if (i.options.disableOnResponsiveLayouts) if (i.sidebar.outerWidth("none" == i.sidebar.css("float")) + 50 > i.container.width()) return void u();
                                            var t,
                                                e,
                                                o,
                                                a,
                                                n,
                                                s,
                                                d,
                                                r,
                                                c,
                                                p,
                                                b,
                                                l,
                                                h,
                                                g,
                                                f,
                                                S = x(document).scrollTop(),
                                                y = "static";
                                            S >= i.sidebar.offset().top + (i.paddingTop - i.options.additionalMarginTop) &&
                                                ((t = i.paddingTop + m.additionalMarginTop),
                                                (e = i.paddingBottom + i.marginBottom + m.additionalMarginBottom),
                                                (o = i.sidebar.offset().top),
                                                (a =
                                                    i.sidebar.offset().top +
                                                    ((l = i.container),
                                                    (h = l.height()),
                                                    l.children().each(function () {
                                                        h = Math.max(h, x(this).height());
                                                    }),
                                                    h)),
                                                (n = 0 + m.additionalMarginTop),
                                                (s = i.stickySidebar.outerHeight() + t + e < x(window).height() ? n + i.stickySidebar.outerHeight() : x(window).height() - i.marginBottom - i.paddingBottom - m.additionalMarginBottom),
                                                (d = o - S + i.paddingTop),
                                                (r = a - S - i.paddingBottom - i.marginBottom),
                                                (c = i.stickySidebar.offset().top - S),
                                                (p = i.previousScrollTop - S),
                                                "fixed" == i.stickySidebar.css("position") && "modern" == i.options.sidebarBehavior && (c += p),
                                                "stick-to-top" == i.options.sidebarBehavior && (c = m.additionalMarginTop),
                                                "stick-to-bottom" == i.options.sidebarBehavior && (c = s - i.stickySidebar.outerHeight()),
                                                (c = 0 < p ? Math.min(c, n) : Math.max(c, s - i.stickySidebar.outerHeight())),
                                                (c = Math.max(c, d)),
                                                (c = Math.min(c, r - i.stickySidebar.outerHeight())),
                                                (y =
                                                    ((b = i.container.height() == i.stickySidebar.outerHeight()) || c != n) && (b || c != s - i.stickySidebar.outerHeight())
                                                        ? S + c - i.sidebar.offset().top - i.paddingTop <= m.additionalMarginTop
                                                            ? "static"
                                                            : "absolute"
                                                        : "fixed")),
                                                "fixed" == y
                                                    ? ((g = x(document).scrollLeft()),
                                                      i.stickySidebar.css({
                                                          position: "fixed",
                                                          width: k(i.stickySidebar) + "px",
                                                          transform: "translateY(" + c + "px)",
                                                          left: i.sidebar.offset().left + parseInt(i.sidebar.css("padding-left")) - g + "px",
                                                          top: "0px",
                                                      }))
                                                    : "absolute" == y
                                                    ? ((f = {}),
                                                      "absolute" != i.stickySidebar.css("position") &&
                                                          ((f.position = "absolute"), (f.transform = "translateY(" + (S + c - i.sidebar.offset().top - i.stickySidebarPaddingTop - i.stickySidebarPaddingBottom) + "px)"), (f.top = "0px")),
                                                      (f.width = k(i.stickySidebar) + "px"),
                                                      (f.left = ""),
                                                      i.stickySidebar.css(f))
                                                    : "static" == y && u(),
                                                "static" != y && 1 == i.options.updateSidebarHeight && i.sidebar.css({ "min-height": i.stickySidebar.outerHeight() + i.stickySidebar.offset().top - i.sidebar.offset().top + i.paddingBottom }),
                                                (i.previousScrollTop = S);
                                        }
                                }),
                                i.onScroll(i),
                                x(document).on(
                                    "scroll." + i.options.namespace,
                                    ((t = i),
                                    function () {
                                        t.onScroll(t);
                                    })
                                ),
                                x(window).on(
                                    "resize." + i.options.namespace,
                                    ((o = i),
                                    function () {
                                        o.stickySidebar.css({ position: "static" }), o.onScroll(o);
                                    })
                                ),
                                "undefined" != typeof ResizeSensor &&
                                    new ResizeSensor(
                                        i.stickySidebar[0],
                                        ((a = i),
                                        function () {
                                            a.onScroll(a);
                                        })
                                    );
                        });
                    })(i, t),
                    !0))
            );
        }
        function k(i) {
            var t;
            try {
                t = i[0].getBoundingClientRect().width;
            } catch (i) {}
            return void 0 === t && (t = i.width()), t;
        }
        return (
            ((i = x.extend(
                { containerSelector: "", additionalMarginTop: 0, additionalMarginBottom: 0, updateSidebarHeight: !0, minWidth: 0, disableOnResponsiveLayouts: !0, sidebarBehavior: "modern", defaultPosition: "relative", namespace: "TSS" },
                i
            )).additionalMarginTop = parseInt(i.additionalMarginTop) || 0),
            (i.additionalMarginBottom = parseInt(i.additionalMarginBottom) || 0),
            o((t = i), (e = this)) ||
                (console.log("TSS: Body width smaller than options.minWidth. Init is delayed."),
                x(document).on(
                    "scroll." + t.namespace,
                    (function (t, e) {
                        return function (i) {
                            o(t, e) && x(this).unbind(i);
                        };
                    })(t, e)
                ),
                x(window).on(
                    "resize." + t.namespace,
                    (function (t, e) {
                        return function (i) {
                            o(t, e) && x(this).unbind(i);
                        };
                    })(t, e)
                )),
            this
        );
    }),
        jQuery(document).ready(function () {
            jQuery(".sliderBar").theiaStickySidebar({ additionalMarginTop: 143 });
        });
})(jQuery);
