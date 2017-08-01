!function(a) {
    var b = !1;
    if ("function" == typeof define && define.amd && (define(a), b = !0), "object" == typeof exports && (module.exports = a(), 
    b = !0), !b) {
        var c = window.Cookies, d = window.Cookies = a();
        d.noConflict = function() {
            return window.Cookies = c, d;
        };
    }
}(function() {
    function a() {
        for (var a = 0, b = {}; a < arguments.length; a++) {
            var c = arguments[a];
            for (var d in c) b[d] = c[d];
        }
        return b;
    }
    function b(c) {
        function d(b, e, f) {
            var g;
            if ("undefined" != typeof document) {
                if (arguments.length > 1) {
                    if (f = a({
                        path: "/"
                    }, d.defaults, f), "number" == typeof f.expires) {
                        var h = new Date();
                        h.setMilliseconds(h.getMilliseconds() + 864e5 * f.expires), f.expires = h;
                    }
                    f.expires = f.expires ? f.expires.toUTCString() : "";
                    try {
                        g = JSON.stringify(e), /^[\{\[]/.test(g) && (e = g);
                    } catch (i) {}
                    e = c.write ? c.write(e, b) : encodeURIComponent(String(e)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent), 
                    b = encodeURIComponent(String(b)), b = b.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent), 
                    b = b.replace(/[\(\)]/g, escape);
                    var j = "";
                    for (var k in f) f[k] && (j += "; " + k, f[k] !== !0 && (j += "=" + f[k]));
                    return document.cookie = b + "=" + e + j;
                }
                b || (g = {});
                for (var l = document.cookie ? document.cookie.split("; ") : [], m = /(%[0-9A-Z]{2})+/g, n = 0; n < l.length; n++) {
                    var o = l[n].split("="), p = o.slice(1).join("=");
                    '"' === p.charAt(0) && (p = p.slice(1, -1));
                    try {
                        var q = o[0].replace(m, decodeURIComponent);
                        if (p = c.read ? c.read(p, q) : c(p, q) || p.replace(m, decodeURIComponent), this.json) try {
                            p = JSON.parse(p);
                        } catch (i) {}
                        if (b === q) {
                            g = p;
                            break;
                        }
                        b || (g[q] = p);
                    } catch (i) {}
                }
                return g;
            }
        }
        return d.set = d, d.get = function(a) {
            return d.call(d, a);
        }, d.getJSON = function() {
            return d.apply({
                json: !0
            }, [].slice.call(arguments));
        }, d.defaults = {}, d.remove = function(b, c) {
            d(b, "", a(c, {
                expires: -1
            }));
        }, d.withConverter = b, d;
    }
    return b(function() {});
}), jQuery(document).ready(function(a) {
    function b() {
        var a = "https://ipinfo.io/json/";
        jQuery.ajax({
            url: a,
            dataType: "json"
        }, "jsonp").always(function(a) {}).done(function(a) {
            k = a.country, "undefined" == typeof k ? k = "" : f(k), d();
        }).fail(function(a) {
            c();
        });
    }
    function c() {
        var a = "https://freegeoip.net/json/";
        jQuery.ajax({
            url: a,
            dataType: "json"
        }, "jsonp").always(function(a) {}).done(function(a) {
            k = a.country_code, "undefined" == typeof k ? k = "" : f(k), d();
        }).fail(function(a) {});
    }
    function d() {
        return k = k.toLowerCase(), !!h.hasOwnProperty(k) && (l = h[k], l !== j && (!!i.hasOwnProperty(l) && (m = i[l], 
        void e())));
    }
    function e() {
        null !== m && a('a[data-eal-link="true"]').each(function(b) {
            var c = a(this).attr("href"), d = a(this).data("eal-search");
            d && (c = "https://www.amazon." + l + "/s/?field-keywords=" + encodeURIComponent(d), 
            c = c + "&tag=" + m);
        });
    }
    function f(a) {
        a && n.set("eal-geotargeting", a);
    }
    if ("undefined" != typeof eal_geotargeting_settings && "undefined" != typeof eal_geotargeting_localized_stores && "undefined" != typeof eal_geotargeting_tracking_ids) {
        var g = eal_geotargeting_settings, h = eal_geotargeting_localized_stores, i = eal_geotargeting_tracking_ids, j = g.store, k = "", l = "", m = "", n = Cookies.noConflict(), o = n.get("eal-geotargeting");
        void 0 !== o ? (k = o, d()) : b();
    }
}), jQuery(document).ready(function(a) {});