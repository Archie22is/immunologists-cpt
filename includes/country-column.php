<?php 
/**
 * Create columns and display selected country in a column in the dashboard
 * @author Archie M
 * 
 */

// Add custom columns to the immunologist post type list
function add_immunologist_custom_columns($columns) {
    $new_columns = array();

    // Adding columns before 'date' column
    foreach ($columns as $key => $title) {
        if ($key === 'date') {
            $new_columns['country'] = __('Country', 'text_domain');
        }
        $new_columns[$key] = $title;
    }

    return $new_columns;
}
add_filter('manage_immunologist_posts_columns', 'add_immunologist_custom_columns');

// Populate custom columns with data
function populate_immunologist_custom_columns($column, $post_id) {
    if ('country' === $column) {
        $country = get_post_meta($post_id, 'country', true);
        echo esc_html($country);
    }
}
add_action('manage_immunologist_posts_custom_column', 'populate_immunologist_custom_columns', 10, 2);

// Make the custom columns sortable
function set_custom_columns_sortable($columns) {
    $columns['country'] = 'country';
    return $columns;
}
add_filter('manage_edit-immunologist_sortable_columns', 'set_custom_columns_sortable');

// Modify the query for sorting custom columns
function custom_orderby_country($query) {
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');
    if ('country' === $orderby) {
        $query->set('meta_key', 'country');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'custom_orderby_country');

