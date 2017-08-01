jQuery(document).ready(function ($) {

    if (typeof eal_geotargeting_settings !== 'undefined' && typeof eal_geotargeting_localized_stores !== 'undefined' && typeof eal_geotargeting_tracking_ids !== 'undefined') {

        // Setup
        var settings = eal_geotargeting_settings;
        var localizedStores = eal_geotargeting_localized_stores;
        var trackingIds = eal_geotargeting_tracking_ids;

        console.log(settings);
        console.log(localizedStores);
        console.log(trackingIds);

        var store = settings.store;
        var visitorCountry = '';
        var targetStore = '';
        var targetTrackingId = '';

        var EALCookies = Cookies.noConflict(); // https://github.com/js-cookie/js-cookie
        var geotargetingCookie = EALCookies.get('eal-geotargeting');

        console.log('geotargetingCookie: ' + geotargetingCookie);

        if ( geotargetingCookie !== undefined ) {
            console.log('cookie set');
            visitorCountry = geotargetingCookie;
            handleGeotargeting();
        } else {
            console.log('cookie NOT set');
            getVisitorCountry();
        }
    }

    /**
     * Get visitor country
     */
    function getVisitorCountry() {

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
                visitorCountry = response.country;
                if (typeof visitorCountry === 'undefined') {
                    visitorCountry = '';
                } else {
                    setGeotargetingCookie( visitorCountry );
                }

                handleGeotargeting();
            })
            .fail(function(response) {
                console.log("Primary Geolocation failed, trying second service");
                getVisitorCountryFallback(); // If unsuccessful, try second service
            });

    }

    /**
     * Get visitor country (fallback)
     */
    function getVisitorCountryFallback() {

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
                visitorCountry = response.country_code;
                if (typeof visitorCountry === 'undefined') {
                    visitorCountry = '';
                } else {
                    setGeotargetingCookie( visitorCountry );
                }
                handleGeotargeting();
            })
            .fail(function(response) {
                console.log("Secondary Geolocation service failed too.");
            });
    }

    /**
     * Handle geotargeting
     */
    function handleGeotargeting() {

        console.log('userCountry Response: ' + visitorCountry);
        visitorCountry = visitorCountry.toLowerCase();
        console.log('userCountry Response (lc): ' + visitorCountry);

        if ( ! localizedStores.hasOwnProperty(visitorCountry) ) {
            console.log('localizedStore is NOT available!');
            return false;
        }

        targetStore = localizedStores[visitorCountry];

        // Debug target country
        //storeTarget = 'fr';

        if ( targetStore === store ) {
            console.log('same country!');
            return false;
        }

        console.log('different country!');

        if ( ! trackingIds.hasOwnProperty(targetStore) ) {
            console.log('local tracking ID NOT available!');
            return false;
        }

        targetTrackingId = trackingIds[targetStore];

        console.log('new tracking id: ' + targetTrackingId);

        updateLinks();
    }

    /**
     * Update Amazon links
     */
    function updateLinks() {

        if ( targetTrackingId === null ) {
            console.log('targetTrackingId is null');
            return;
        }

        console.log('start updating links');
        console.log('updateLinks > targetStore: ' + targetStore);
        console.log('updateLinks > targetTrackingId: ' + targetTrackingId);

        $('a[data-eal-link="true"]').each(function( el ) {

            var url = $(this).attr('href');

            console.log('Handling url: ' + url);

            var search = $(this).data('eal-search');

            if ( ! search )
                return;

            url = 'https://www.amazon.' + targetStore + '/s/?field-keywords=' + encodeURIComponent( search );

            url = url + '&tag=' + targetTrackingId;

            console.log('New url: ' + url);
        });
    }

    function setGeotargetingCookie( countryCode ) {

        if ( countryCode )
            EALCookies.set('eal-geotargeting', countryCode );
    }

});