jQuery(document).ready(function ($) {

    /**
     * Validating tracking id changes regarding store selection
     */
    $('*[data-eal-amazon-tracking-id-input]').keyup( function() {

        var tracking_id_store = $(this).data('eal-amazon-tracking-id-input');
        var tracking_id = $(this).val();

        var select_store_option = $( '[data-eal-select-amazon-store-option="' + tracking_id_store + '"]');

        if ( tracking_id ) {
            select_store_option.prop( 'disabled', false );
        } else {
            select_store_option.prop( 'disabled', true );
        }

    });


});