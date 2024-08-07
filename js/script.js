/**
 * Custom JS for Immunologists Plugin
 * @author Archie M
 * 
 * 
 */

jQuery(document).ready(function($) {
    function loadImmunologists(paged = 1) {
        var data = {
            action: 'immunologists_search',
            nonce: immunologists_ajax.nonce,
            s: $('#search-name').val(),
            field: $('#search-field').val(),
            location: $('#search-location').val(),
            country: $('#search-country').val(),
            paged: paged
        };

        $.post(immunologists_ajax.ajax_url, data, function(response) {
            $('#immunologists-search-results').html(response);

            // Bind pagination links
            $('.page-numbers').on('click', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadImmunologists(page);
            });
        });
    }

    $('#immunologists-search-button').on('click', function(e) {
        e.preventDefault();
        loadImmunologists();
    });

    // Initial load
    loadImmunologists();
    
});
