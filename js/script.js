/**
 * Custom JS for Immunologists Plugin
 * @author Archie M
 * 
 * 
 */

jQuery(document).ready(function($) {

    // Dynamic search results
    $('#immunologists-search-button').on('click', function() {
        var search_data = {
            action: 'immunologists_search',
            nonce: immunologists_ajax.nonce,
            s: $('#search-name').val(),
            location: $('#search-location').val(),
            field: $('#search-field').val()
        };

        $.ajax({
            url: immunologists_ajax.ajax_url,
            type: 'POST',
            data: search_data,
            beforeSend: function() {
                $('#immunologists-search-results').html('<p>Loading...</p>');
            },
            success: function(response) {
                $('#immunologists-search-results').html(response);
            }
        });
    });


    // Debug
    console.log("Immunologists loaded...");

});
