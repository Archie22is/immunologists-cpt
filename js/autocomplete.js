/**
 * 
 * 
 * 
 */
jQuery(document).ready(function($) {
    function loadResults() {
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
            },
            error: function(xhr, status, error) {
                console.error(status, error); // Log AJAX errors
            }
        });
    }

    // Initialize autocomplete for fields
    function initializeAutocomplete() {
        $('#search-name').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: immunologists_ajax.ajax_url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'autocomplete_search',
                        nonce: immunologists_ajax.nonce,
                        field: 'name',
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(status, error); // Log AJAX errors
                    }
                });
            }
        });

        $('#search-location').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: immunologists_ajax.ajax_url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'autocomplete_search',
                        nonce: immunologists_ajax.nonce,
                        field: 'location',
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(status, error); // Log AJAX errors
                    }
                });
            }
        });

        $('#search-field').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: immunologists_ajax.ajax_url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'autocomplete_search',
                        nonce: immunologists_ajax.nonce,
                        field: 'field',
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(status, error); // Log AJAX errors
                    }
                });
            }
        });
    }

    // Load results on page load
    loadResults();

    // Initialize autocomplete functionality
    initializeAutocomplete();

    // Bind the search button click event
    $('#immunologists-search-button').on('click', function() {
        loadResults();
    });
});
