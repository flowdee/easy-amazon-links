jQuery(document).ready(function ($) {

    if (typeof aawp_geotargeting_settings != 'undefined' && typeof aawp_geotargeting_localized_stores != 'undefined' && typeof aawp_geotargeting_tracking_ids != 'undefined') {

        // Setup
        var settings = aawp_geotargeting_settings;
        var localizedStores = aawp_geotargeting_localized_stores;
        var trackingIds = aawp_geotargeting_tracking_ids;

        console.log(settings);
        console.log(localizedStores);
        console.log(trackingIds);

        // Quit if store is not known
        if ( ! settings.hasOwnProperty('store') ) {
            console.log('store not available!');
            return;
        }

        var urlMode = ( settings.hasOwnProperty('mode') ) ? settings.mode : 'mode';

        console.log('urlMode: ' + urlMode);

        var storeCountry = settings.store;
        var storeTarget = '';

        // Getting user country
        var userCountry = '';
        var localTrackingId = '';

        getCountry();
        //getCountryFallback();
    }

    function validateVisitorCountry() {

        console.log('userCountry Response: ' + userCountry);
        userCountry = userCountry.toLowerCase();
        console.log('userCountry Response (lc): ' + userCountry);

        if ( ! localizedStores.hasOwnProperty(userCountry) ) {
            console.log('localizedStore is NOT available!');
            return;
        }

        storeTarget = localizedStores[userCountry];

        // Debug target country
        //storeTarget = 'fr';

        if ( storeTarget == storeCountry ) {
            console.log('same country!');
            return;
        }

        // All right, let's check the tracking ids!
        validateTrackingId();
    }

    function validateTrackingId() {

        if ( ! trackingIds.hasOwnProperty(storeTarget) ) {
            console.log('local tracking ID NOT available!');
            return;
        }

        localTrackingId = trackingIds[storeTarget];

        console.log(localTrackingId);

        update_amazon_links( storeCountry, storeTarget, localTrackingId );
    }

    function getCountry() {

        var requestUrl = 'https://ipinfo.io/json/';

        //var devIP = '192.99.197.25';
        //var requestUrl = 'https://ipinfo.io/' + devIP + '/json/';

        jQuery.ajax({
            url: requestUrl,
            dataType: "json"
        }, "jsonp")
            .always(function(response) {})
            .done(function(response) {
                console.log('Primary geo-response: ' + response.ip + ' - ' + response.country);
                userCountry = response.country;
                if (typeof userCountry == 'undefined') {
                    userCountry = '';
                }
                validateVisitorCountry();
            })
            .fail(function(response) {
                console.log("Primary Geolocation failed, trying second service");
                getCountryFallback(); // If unsuccessful, try second service
            });

    }

    function getCountryFallback() {

        var requestUrl = 'https://freegeoip.net/json/';

        //var devIP = '192.99.197.25';
        //var requestUrl = 'https://freegeoip.net/json/' + devIP;

        jQuery.ajax({
            url: requestUrl,
            dataType: "json"
        }, "jsonp")
            .always(function(response) {})
            .done(function(response) {
                console.log('Secondary geo-response: ' + response.ip + ' - ' + response.country);
                userCountry = response.country_code;
                if (typeof userCountry == 'undefined') {
                    userCountry = '';
                }
                validateVisitorCountry();
            })
            .fail(function(response) {
                console.log("Secondary Geolocation service failed too.");
            });
    }

    function update_amazon_links( storeOld, storeNew, trackingId ) {

        if ( trackingId == null ) {
            console.log('trackingId is null');
            return;
        }

        $("a[href*='/amazon'], a[href*='/www.amazon'], a[href*='/amzn'], a[href*='/www.amzn']").each(function( el ) {

            var url = $(this).attr('href');

            console.log('Handling url: ' + url);

            if ( 'asin' === urlMode || url.indexOf('prime') != -1 ) {
                url = get_url_mode_asin( url, storeOld, storeNew );

            } else if ( 'title' === urlMode ) {
                url = get_url_mode_title( $(this), url, storeOld, storeNew );
            }

            //console.log(url);

            // Replacing tags
            url = replaceUrlParam(url, 'tag', trackingId);
            console.log('URL edited: ' + url);

            $(this).attr('href', url);
        });
    }

    function get_url_mode_title( linkElement, url, storeOld, storeNew ) {

        console.log('get_url_mode_title');

        //var productTitle = linkElement.closest("*:has(*[data-aawp-product-title])").children('[data-aawp-product-title]').data('aawp-product-title');
        // First: Search on element
        var productTitle = linkElement.data("aawp-product-title");

        // Second: Searching for containers
        if ( ! productTitle ) {
            productTitle = linkElement.parents().filter(function() { return $(this).data("aawp-product-title"); }).eq(0).data("aawp-product-title");
        }

        if ( productTitle ) {

            console.log('productTitle: ' + productTitle );

            // Get only first X words
            productTitle = getWords( productTitle, 5 );

            console.log('productTitle (search): ' + productTitle );

            url = 'https://www.amazon.' + storeNew + '/s/?field-keywords=' + encodeURIComponent( productTitle );
        }

        return url;
    }

    function get_url_mode_asin( url, storeOld, storeNew ) {

        console.log('get_url_mode_asin');

        var urlTypeShort = false;
        var urlTypeLong = false;

        //console.log('URL found: ' + url);
        //console.log(getDomain(url));

        if ( url.indexOf('amzn.' + storeCountry) != -1 ) {
            urlTypeShort = true;
        }

        if ( url.indexOf('amazon.' + storeCountry) != -1 ) {
            urlTypeLong = true;
        }

        if ( ! urlTypeShort && ! urlTypeLong ) {
            return;
        }

        // Return if url doesn't include the tracking tag parameter
        if ( url.indexOf('tag=') == -1 ) {
            return;
        }

        // Replacing domain endings
        if ( 'com' == storeOld && urlTypeShort ) {
            url = url.replace("amzn." + storeOld, "amazon." + storeNew + '/dp');

        } else if ( 'com' == storeNew ) {
            url = url.replace("amazon." + storeOld, "amzn." + storeNew);

        } else {
            url = url.replace("amazon." + storeOld, "amazon." + storeNew);
        }

        return url;
    }

    // Source: http://stackoverflow.com/a/20420424/3379704
    function replaceUrlParam(url, paramName, paramValue){
        if(paramValue == null)
            paramValue = '';
        var pattern = new RegExp('\\b('+paramName+'=).*?(&|$)');
        if(url.search(pattern)>=0){
            return url.replace(pattern,'$1' + paramValue + '$2');
        }
        return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue
    }

    // Source: http://www.primaryobjects.com/2012/11/19/parsing-hostname-and-domain-from-a-url-with-javascript/
    function getHostName(url) {
        var match = url.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);
        if (match != null && match.length > 2 && typeof match[2] === 'string' && match[2].length > 0) {
            return match[2];
        }
        else {
            return null;
        }
    }

    function getDomain(url) {
        var hostName = getHostName(url);
        var domain = hostName;

        if (hostName != null) {
            var parts = hostName.split('.').reverse();

            if (parts != null && parts.length > 1) {
                domain = parts[1] + '.' + parts[0];

                if (hostName.toLowerCase().indexOf('.co.uk') != -1 && parts.length > 2) {
                    domain = parts[2] + '.' + domain;
                }
            }
        }

        return domain;
    }

    function getWords(str, max) {
        return str.split(/\s+/).slice(0,max).join(" ");
    }

});