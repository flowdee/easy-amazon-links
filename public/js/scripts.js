jQuery(document).ready(function(a) {
    function b() {
        var a = "https://ipinfo.io/json/";
        jQuery.ajax({
            url: a,
            dataType: "json"
        }, "jsonp").always(function(a) {}).done(function(a) {
            console.log("Primary geo-response: " + a.ip + " - " + a.country), j = a.country, 
            "undefined" == typeof j && (j = ""), d();
        }).fail(function(a) {
            console.log("Primary Geolocation failed, trying second service"), c();
        });
    }
    function c() {
        var a = "https://freegeoip.net/json/";
        jQuery.ajax({
            url: a,
            dataType: "json"
        }, "jsonp").always(function(a) {}).done(function(a) {
            console.log("Secondary geo-response: " + a.ip + " - " + a.country), j = a.country_code, 
            "undefined" == typeof j && (j = ""), d();
        }).fail(function(a) {
            console.log("Secondary Geolocation service failed too.");
        });
    }
    function d() {
        return console.log("userCountry Response: " + j), j = j.toLowerCase(), console.log("userCountry Response (lc): " + j), 
        g.hasOwnProperty(j) ? (k = g[j], k === i ? (console.log("same country!"), !1) : (console.log("different country!"), 
        h.hasOwnProperty(k) ? (l = h[k], console.log("new tracking id: " + l), void e()) : (console.log("local tracking ID NOT available!"), 
        !1))) : (console.log("localizedStore is NOT available!"), !1);
    }
    function e() {
        return null === l ? void console.log("targetTrackingId is null") : (console.log("start updating links"), 
        console.log("updateLinks > targetStore: " + k), console.log("updateLinks > targetTrackingId: " + l), 
        void a('a[data-eal-link="true"]').each(function(b) {
            var c = a(this).attr("href");
            console.log("Handling url: " + c);
            var d = a(this).data("eal-search");
            d && (c = "https://www.amazon." + k + "/s/?field-keywords=" + encodeURIComponent(d), 
            c = c + "&tag=" + l, console.log("New url: " + c));
        }));
    }
    if ("undefined" != typeof eal_geotargeting_settings && "undefined" != typeof eal_geotargeting_localized_stores && "undefined" != typeof eal_geotargeting_tracking_ids) {
        var f = eal_geotargeting_settings, g = eal_geotargeting_localized_stores, h = eal_geotargeting_tracking_ids;
        console.log(f), console.log(g), console.log(h);
        var i = f.store, j = "", k = "", l = "";
        b();
    }
}), jQuery(document).ready(function(a) {});