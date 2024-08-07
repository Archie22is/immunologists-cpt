<?php
/**
 * Immunologists - Manage FAIS Immunologists
 *
 * @package   Immunologists
 * @author    Immunologists Team
 * @copyright 2024 Konclude (Pty) Ltd
 * @license   ??
 *
 *  
 * Plugin Name:     Immunologists
 * Description:     A custom must-use plugin for FAIS Immunologists with custom fields and search capabilities.
 * Author:          Konclude (Archie Makuwa)
 * Author URI:      https://www.konclu.de
 * Version:         1.0.0
 * 
 */


// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}


// Register Custom Post Type
function immunologists_cpt() {
    $labels = array(
        'name'                  => _x('Immunologists', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Immunologist', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Immunologists', 'text_domain'),
        'name_admin_bar'        => __('Immunologist', 'text_domain'),
        'archives'              => __('Immunologist Archives', 'text_domain'),
        'attributes'            => __('Immunologist Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent Immunologist:', 'text_domain'),
        'all_items'             => __('All Immunologists', 'text_domain'),
        'add_new_item'          => __('Add New Immunologist', 'text_domain'),
        'add_new'               => __('Add New', 'text_domain'),
        'new_item'              => __('New Immunologist', 'text_domain'),
        'edit_item'             => __('Edit Immunologist', 'text_domain'),
        'update_item'           => __('Update Immunologist', 'text_domain'),
        'view_item'             => __('View Immunologist', 'text_domain'),
        'view_items'            => __('View Immunologists', 'text_domain'),
        'search_items'          => __('Search Immunologist', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Profile Picture', 'text_domain'),
        'set_featured_image'    => __('Set profile picture', 'text_domain'),
        'remove_featured_image' => __('Remove profile picture', 'text_domain'),
        'use_featured_image'    => __('Use as profile picture', 'text_domain'),
        'insert_into_item'      => __('Insert into immunologist', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this immunologist', 'text_domain'),
        'items_list'            => __('Immunologists list', 'text_domain'),
        'items_list_navigation' => __('Immunologists list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter immunologists list', 'text_domain'),
    );
    $args = array(
        'label'                 => __('Immunologist', 'text_domain'),
        'description'           => __('Post Type for Immunologists', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'revisions'),
        'rewrite'               => array('slug' => 'immunologists'),
        'taxonomies'            => array('area_of_research'),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-users',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type('immunologist', $args);
}
add_action('init', 'immunologists_cpt', 0);


// Register Custom Taxonomy
function immunologists_taxonomy() {
    $labels = array(
        'name'                       => _x('Areas of Research', 'Taxonomy General Name', 'text_domain'),
        'singular_name'              => _x('Area of Research', 'Taxonomy Singular Name', 'text_domain'),
        'menu_name'                  => __('Areas of Research', 'text_domain'),
        'all_items'                  => __('All Areas of Research', 'text_domain'),
        'parent_item'                => __('Parent Area of Research', 'text_domain'),
        'parent_item_colon'          => __('Parent Area of Research:', 'text_domain'),
        'new_item_name'              => __('New Area of Research Name', 'text_domain'),
        'add_new_item'               => __('Add New Area of Research', 'text_domain'),
        'edit_item'                  => __('Edit Area of Research', 'text_domain'),
        'update_item'                => __('Update Area of Research', 'text_domain'),
        'view_item'                  => __('View Area of Research', 'text_domain'),
        'separate_items_with_commas' => __('Separate areas of research with commas', 'text_domain'),
        'add_or_remove_items'        => __('Add or remove areas of research', 'text_domain'),
        'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
        'popular_items'              => __('Popular Areas of Research', 'text_domain'),
        'search_items'               => __('Search Areas of Research', 'text_domain'),
        'not_found'                  => __('Not Found', 'text_domain'),
        'no_terms'                   => __('No areas of research', 'text_domain'),
        'items_list'                 => __('Areas of Research list', 'text_domain'),
        'items_list_navigation'      => __('Areas of Research list navigation', 'text_domain'),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy('area_of_research', array('immunologist'), $args);
}
add_action('init', 'immunologists_taxonomy', 0);


// Check if ACF is Active and Register Custom Fields
function immunologists_register_acf_fields() {
    if (class_exists('ACF')) {
        acf_add_local_field_group(array(
            'key' => 'group_immunologist_details',
            'title' => __('Immunologist Details', 'text_domain'),
            'fields' => array(
                array(
                    'key' => 'field_profile_image',
                    'label' => __('Profile Image or Logo', 'text_domain'),
                    'name' => 'profile_image',
                    'type' => 'image',
                    //'required' => 1,
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_job_title',
                    'label' => __('Job Title', 'text_domain'),
                    'name' => 'job_title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_location',
                    'label' => __('Location', 'text_domain'),
                    'name' => 'location',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_country',
                    'label' => __('Country', 'text_domain'),
                    'name' => 'country',
                    'type' => 'select',
                    'choices' => array(
                        '' => __('Select country', 'text_domain'), // Default undetectable option
                        'Afghanistan' => __('Afghanistan', 'text_domain'),
                        'Albania' => __('Albania', 'text_domain'),
                        'Algeria' => __('Algeria', 'text_domain'),
                        'Andorra' => __('Andorra', 'text_domain'),
                        'Angola' => __('Angola', 'text_domain'),
                        'Antigua and Barbuda' => __('Antigua and Barbuda', 'text_domain'),
                        'Argentina' => __('Argentina', 'text_domain'),
                        'Armenia' => __('Armenia', 'text_domain'),
                        'Australia' => __('Australia', 'text_domain'),
                        'Austria' => __('Austria', 'text_domain'),
                        'Azerbaijan' => __('Azerbaijan', 'text_domain'),
                        'Bahamas' => __('Bahamas', 'text_domain'),
                        'Bahrain' => __('Bahrain', 'text_domain'),
                        'Bangladesh' => __('Bangladesh', 'text_domain'),
                        'Barbados' => __('Barbados', 'text_domain'),
                        'Belarus' => __('Belarus', 'text_domain'),
                        'Belgium' => __('Belgium', 'text_domain'),
                        'Belize' => __('Belize', 'text_domain'),
                        'Benin' => __('Benin', 'text_domain'),
                        'Bhutan' => __('Bhutan', 'text_domain'),
                        'Bolivia' => __('Bolivia', 'text_domain'),
                        'Bosnia and Herzegovina' => __('Bosnia and Herzegovina', 'text_domain'),
                        'Botswana' => __('Botswana', 'text_domain'),
                        'Brazil' => __('Brazil', 'text_domain'),
                        'Brunei Darussalam' => __('Brunei Darussalam', 'text_domain'),
                        'Bulgaria' => __('Bulgaria', 'text_domain'),
                        'Burkina Faso' => __('Burkina Faso', 'text_domain'),
                        'Burundi' => __('Burundi', 'text_domain'),
                        'Cambodia' => __('Cambodia', 'text_domain'),
                        'Cameroon' => __('Cameroon', 'text_domain'),
                        'Canada' => __('Canada', 'text_domain'),
                        'Cape Verde' => __('Cape Verde', 'text_domain'),
                        'Central African Republic' => __('Central African Republic', 'text_domain'),
                        'Chad' => __('Chad', 'text_domain'),
                        'Chile' => __('Chile', 'text_domain'),
                        'China' => __('China', 'text_domain'),
                        'Colombia' => __('Colombia', 'text_domain'),
                        'Comoros' => __('Comoros', 'text_domain'),
                        'Congo' => __('Congo', 'text_domain'),
                        'Congo, Democratic Republic of the' => __('Congo, Democratic Republic of the', 'text_domain'),
                        'Costa Rica' => __('Costa Rica', 'text_domain'),
                        'Croatia' => __('Croatia', 'text_domain'),
                        'Cuba' => __('Cuba', 'text_domain'),
                        'Cyprus' => __('Cyprus', 'text_domain'),
                        'Czech Republic' => __('Czech Republic', 'text_domain'),
                        'Denmark' => __('Denmark', 'text_domain'),
                        'Djibouti' => __('Djibouti', 'text_domain'),
                        'Dominica' => __('Dominica', 'text_domain'),
                        'Dominican Republic' => __('Dominican Republic', 'text_domain'),
                        'Ecuador' => __('Ecuador', 'text_domain'),
                        'Egypt' => __('Egypt', 'text_domain'),
                        'El Salvador' => __('El Salvador', 'text_domain'),
                        'Equatorial Guinea' => __('Equatorial Guinea', 'text_domain'),
                        'Eritrea' => __('Eritrea', 'text_domain'),
                        'Estonia' => __('Estonia', 'text_domain'),
                        'Ethiopia' => __('Ethiopia', 'text_domain'),
                        'Falkland Islands' => __('Falkland Islands', 'text_domain'),
                        'Faroe Islands' => __('Faroe Islands', 'text_domain'),
                        'Fiji' => __('Fiji', 'text_domain'),
                        'Finland' => __('Finland', 'text_domain'),
                        'France' => __('France', 'text_domain'),
                        'French Guiana' => __('French Guiana', 'text_domain'),
                        'French Polynesia' => __('French Polynesia', 'text_domain'),
                        'Gabon' => __('Gabon', 'text_domain'),
                        'Gambia' => __('Gambia', 'text_domain'),
                        'Georgia' => __('Georgia', 'text_domain'),
                        'Germany' => __('Germany', 'text_domain'),
                        'Ghana' => __('Ghana', 'text_domain'),
                        'Gibraltar' => __('Gibraltar', 'text_domain'),
                        'Greece' => __('Greece', 'text_domain'),
                        'Greenland' => __('Greenland', 'text_domain'),
                        'Grenada' => __('Grenada', 'text_domain'),
                        'Guam' => __('Guam', 'text_domain'),
                        'Guatemala' => __('Guatemala', 'text_domain'),
                        'Guinea' => __('Guinea', 'text_domain'),
                        'Guinea-Bissau' => __('Guinea-Bissau', 'text_domain'),
                        'Guyana' => __('Guyana', 'text_domain'),
                        'Haiti' => __('Haiti', 'text_domain'),
                        'Honduras' => __('Honduras', 'text_domain'),
                        'Hong Kong' => __('Hong Kong', 'text_domain'),
                        'Hungary' => __('Hungary', 'text_domain'),
                        'Iceland' => __('Iceland', 'text_domain'),
                        'India' => __('India', 'text_domain'),
                        'Indonesia' => __('Indonesia', 'text_domain'),
                        'Iran' => __('Iran', 'text_domain'),
                        'Iraq' => __('Iraq', 'text_domain'),
                        'Ireland' => __('Ireland', 'text_domain'),
                        'Israel' => __('Israel', 'text_domain'),
                        'Italy' => __('Italy', 'text_domain'),
                        'Jamaica' => __('Jamaica', 'text_domain'),
                        'Japan' => __('Japan', 'text_domain'),
                        'Jordan' => __('Jordan', 'text_domain'),
                        'Kazakhstan' => __('Kazakhstan', 'text_domain'),
                        'Kenya' => __('Kenya', 'text_domain'),
                        'Kiribati' => __('Kiribati', 'text_domain'),
                        'Korea' => __('Korea', 'text_domain'),
                        'Kuwait' => __('Kuwait', 'text_domain'),
                        'Kyrgyzstan' => __('Kyrgyzstan', 'text_domain'),
                        'Lao' => __('Lao', 'text_domain'),
                        'Latvia' => __('Latvia', 'text_domain'),
                        'Lebanon' => __('Lebanon', 'text_domain'),
                        'Lesotho' => __('Lesotho', 'text_domain'),
                        'Liberia' => __('Liberia', 'text_domain'),
                        'Libya' => __('Libya', 'text_domain'),
                        'Liechtenstein' => __('Liechtenstein', 'text_domain'),
                        'Lithuania' => __('Lithuania', 'text_domain'),
                        'Luxembourg' => __('Luxembourg', 'text_domain'),
                        'Macao' => __('Macao', 'text_domain'),
                        'Madagascar' => __('Madagascar', 'text_domain'),
                        'Malawi' => __('Malawi', 'text_domain'),
                        'Malaysia' => __('Malaysia', 'text_domain'),
                        'Maldives' => __('Maldives', 'text_domain'),
                        'Mali' => __('Mali', 'text_domain'),
                        'Malta' => __('Malta', 'text_domain'),
                        'Marshall Islands' => __('Marshall Islands', 'text_domain'),
                        'Mauritania' => __('Mauritania', 'text_domain'),
                        'Mauritius' => __('Mauritius', 'text_domain'),
                        'Mexico' => __('Mexico', 'text_domain'),
                        'Micronesia' => __('Micronesia', 'text_domain'),
                        'Moldova' => __('Moldova', 'text_domain'),
                        'Monaco' => __('Monaco', 'text_domain'),
                        'Mongolia' => __('Mongolia', 'text_domain'),
                        'Montenegro' => __('Montenegro', 'text_domain'),
                        'Morocco' => __('Morocco', 'text_domain'),
                        'Mozambique' => __('Mozambique', 'text_domain'),
                        'Myanmar' => __('Myanmar', 'text_domain'),
                        'Namibia' => __('Namibia', 'text_domain'),
                        'Nauru' => __('Nauru', 'text_domain'),
                        'Nepal' => __('Nepal', 'text_domain'),
                        'Netherlands' => __('Netherlands', 'text_domain'),
                        'New Caledonia' => __('New Caledonia', 'text_domain'),
                        'New Zealand' => __('New Zealand', 'text_domain'),
                        'Nicaragua' => __('Nicaragua', 'text_domain'),
                        'Niger' => __('Niger', 'text_domain'),
                        'Nigeria' => __('Nigeria', 'text_domain'),
                        'Niue' => __('Niue', 'text_domain'),
                        'Norfolk Island' => __('Norfolk Island', 'text_domain'),
                        'Northern Mariana Islands' => __('Northern Mariana Islands', 'text_domain'),
                        'Norway' => __('Norway', 'text_domain'),
                        'Oman' => __('Oman', 'text_domain'),
                        'Pakistan' => __('Pakistan', 'text_domain'),
                        'Palau' => __('Palau', 'text_domain'),
                        'Panama' => __('Panama', 'text_domain'),
                        'Papua New Guinea' => __('Papua New Guinea', 'text_domain'),
                        'Paraguay' => __('Paraguay', 'text_domain'),
                        'Peru' => __('Peru', 'text_domain'),
                        'Philippines' => __('Philippines', 'text_domain'),
                        'Pitcairn' => __('Pitcairn', 'text_domain'),
                        'Poland' => __('Poland', 'text_domain'),
                        'Portugal' => __('Portugal', 'text_domain'),
                        'Puerto Rico' => __('Puerto Rico', 'text_domain'),
                        'Qatar' => __('Qatar', 'text_domain'),
                        'Réunion' => __('Réunion', 'text_domain'),
                        'Romania' => __('Romania', 'text_domain'),
                        'Russia' => __('Russia', 'text_domain'),
                        'Rwanda' => __('Rwanda', 'text_domain'),
                        'Saint Barthélemy' => __('Saint Barthélemy', 'text_domain'),
                        'Saint Helena' => __('Saint Helena', 'text_domain'),
                        'Saint Kitts and Nevis' => __('Saint Kitts and Nevis', 'text_domain'),
                        'Saint Lucia' => __('Saint Lucia', 'text_domain'),
                        'Saint Martin' => __('Saint Martin', 'text_domain'),
                        'Saint Pierre and Miquelon' => __('Saint Pierre and Miquelon', 'text_domain'),
                        'Saint Vincent and the Grenadines' => __('Saint Vincent and the Grenadines', 'text_domain'),
                        'Samoa' => __('Samoa', 'text_domain'),
                        'San Marino' => __('San Marino', 'text_domain'),
                        'Saudi Arabia' => __('Saudi Arabia', 'text_domain'),
                        'Senegal' => __('Senegal', 'text_domain'),
                        'Serbia' => __('Serbia', 'text_domain'),
                        'Seychelles' => __('Seychelles', 'text_domain'),
                        'Sierra Leone' => __('Sierra Leone', 'text_domain'),
                        'Singapore' => __('Singapore', 'text_domain'),
                        'Sint Maarten' => __('Sint Maarten', 'text_domain'),
                        'Slovakia' => __('Slovakia', 'text_domain'),
                        'Slovenia' => __('Slovenia', 'text_domain'),
                        'Solomon Islands' => __('Solomon Islands', 'text_domain'),
                        'Somalia' => __('Somalia', 'text_domain'),
                        'South Africa' => __('South Africa', 'text_domain'),
                        'South Georgia and the South Sandwich Islands' => __('South Georgia and the South Sandwich Islands', 'text_domain'),
                        'South Sudan' => __('South Sudan', 'text_domain'),
                        'Spain' => __('Spain', 'text_domain'),
                        'Sri Lanka' => __('Sri Lanka', 'text_domain'),
                        'Sudan' => __('Sudan', 'text_domain'),
                        'Suriname' => __('Suriname', 'text_domain'),
                        'Swaziland' => __('Swaziland', 'text_domain'),
                        'Sweden' => __('Sweden', 'text_domain'),
                        'Switzerland' => __('Switzerland', 'text_domain'),
                        'Syria' => __('Syria', 'text_domain'),
                        'Taiwan' => __('Taiwan', 'text_domain'),
                        'Tajikistan' => __('Tajikistan', 'text_domain'),
                        'Tanzania' => __('Tanzania', 'text_domain'),
                        'Thailand' => __('Thailand', 'text_domain'),
                        'Timor-Leste' => __('Timor-Leste', 'text_domain'),
                        'Togo' => __('Togo', 'text_domain'),
                        'Tokelau' => __('Tokelau', 'text_domain'),
                        'Tonga' => __('Tonga', 'text_domain'),
                        'Trinidad and Tobago' => __('Trinidad and Tobago', 'text_domain'),
                        'Tunisia' => __('Tunisia', 'text_domain'),
                        'Turkey' => __('Turkey', 'text_domain'),
                        'Turkmenistan' => __('Turkmenistan', 'text_domain'),
                        'Turks and Caicos Islands' => __('Turks and Caicos Islands', 'text_domain'),
                        'Tuvalu' => __('Tuvalu', 'text_domain'),
                        'Uganda' => __('Uganda', 'text_domain'),
                        'Ukraine' => __('Ukraine', 'text_domain'),
                        'United Arab Emirates' => __('United Arab Emirates', 'text_domain'),
                        'United Kingdom' => __('United Kingdom', 'text_domain'),
                        'United States' => __('United States', 'text_domain'),
                        'United States Minor Outlying Islands' => __('United States Minor Outlying Islands', 'text_domain'),
                        'Uruguay' => __('Uruguay', 'text_domain'),
                        'Uzbekistan' => __('Uzbekistan', 'text_domain'),
                        'Vanuatu' => __('Vanuatu', 'text_domain'),
                        'Vatican City' => __('Vatican City', 'text_domain'),
                        'Venezuela' => __('Venezuela', 'text_domain'),
                        'Vietnam' => __('Vietnam', 'text_domain'),
                        'Virgin Islands, British' => __('Virgin Islands, British', 'text_domain'),
                        'Virgin Islands, U.S.' => __('Virgin Islands, U.S.', 'text_domain'),
                        'Wallis and Futuna' => __('Wallis and Futuna', 'text_domain'),
                        'Western Sahara' => __('Western Sahara', 'text_domain'),
                        'Yemen' => __('Yemen', 'text_domain'),
                        'Zambia' => __('Zambia', 'text_domain'),
                        'Zimbabwe' => __('Zimbabwe', 'text_domain')
                    ),
                    'default_value' => array(
                        0 => 'Afghanistan',
                    ),
                    'return_format' => 'value',
                    'multiple' => 0,
                ),
                /*
                array(
                    'key' => 'field_email',
                    'label' => __('Email OLD', 'text_domain'),
                    'name' => 'email',
                    'type' => 'email',
                ),
                */
                array(
                    'key' => 'field_email_address',
                    'label' => __('Email Address', 'text_domain'),
                    'name' => 'email_address',
                    'type' => 'email',
                ),
                array(
                    'key' => 'field_research_interest',
                    'label' => __('Research Interest Description', 'text_domain'),
                    'name' => 'research_interest',
                    'type' => 'textarea',
                ),
                array(
                    'key' => 'field_institute',
                    'label' => __('Institute', 'text_domain'),
                    'name' => 'institute',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_website',
                    'label' => __('Website', 'text_domain'),
                    'name' => 'website',
                    'type' => 'url',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'immunologist',
                    ),
                ),
            ),
        ));
    }
}
add_action('acf/init', 'immunologists_register_acf_fields');


// Require additional files 
require_once ( plugin_dir_path( __FILE__ ) . 'includes/settings-menu.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'includes/form-handler.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'includes/country-column.php' );


// Enqueue Custom CSS and JS
function immunologists_enqueue_styles_scripts() {
    wp_enqueue_script('jquery-ui-autocomplete');
    wp_enqueue_style('jquery-ui-style', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    
    wp_enqueue_style('immunologists-style', plugin_dir_url(__FILE__) . '/css/style.css');
    wp_enqueue_script('immunologists-script', plugin_dir_url(__FILE__) . '/js/script.js', array('jquery'), null, true);
    
    wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);

    // Localize script for AJAX
    wp_localize_script('immunologists-script', 'immunologists_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('immunologists_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'immunologists_enqueue_styles_scripts');


// AJAX Handler for Search
function immunologists_ajax_search() {
    check_ajax_referer('immunologists_nonce', 'nonce');

    // Base arguments to fetch all posts
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $posts_per_page = 10; // Adjust the number of posts per page as needed

    $args = array(
        'post_type'      => 'immunologist',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
    );

    // Initialize tax_query and meta_query
    $tax_query = array('relation' => 'AND');
    $meta_query = array('relation' => 'AND');

    // Debug: Log received data
    //error_log('Received data: ' . print_r($_POST, true));

    // Apply taxonomy filter if criteria are provided
    if (!empty($_POST['field'])) {
        $tax_query[] = array(
            'taxonomy' => 'area_of_research',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['field']),
        );
    }

    if (!empty($_POST['location'])) {
        $meta_query[] = array(
            'key'     => 'location',
            'value'   => sanitize_text_field($_POST['location']),
            'compare' => 'LIKE',
        );
    }

    if (!empty($_POST['country'])) {
        $meta_query[] = array(
            'key'     => 'country',
            'value'   => sanitize_text_field($_POST['country']),
            'compare' => 'LIKE',
        );
    }

    if (!empty($_POST['s'])) {
        $args['s'] = sanitize_text_field($_POST['s']);
    }

    // Apply tax_query if it contains more than just the default 'AND'
    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    // Apply meta_query if it contains more than just the default 'AND'
    if (count($meta_query) > 1) {
        $args['meta_query'] = $meta_query;
    }

    // Debug: Log the constructed query arguments
    //error_log('Query arguments: ' . print_r($args, true));

    // Execute the query
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="immunologist-profile">';
        echo '<div class="immunologist-results immunologist-heading">';
        echo '<div><h3>Name</h3></div>';
        echo '<div><h3>Occupation</h3></div>';
        echo '<div><h3>Profile</h3></div>';
        echo '</div>';

        while ($query->have_posts()) {
            $query->the_post();

            $profile_name = get_the_title();
            $profile_image = get_field('profile_image');

            echo '<div class="immunologist-results immunologist-results-items">';
            echo '<div class="immunologist-profile-main">';
            if ($profile_image) {
                echo '<div class="item-logo">';
                echo '<img src="' . esc_url($profile_image) . '" alt="' . $profile_name . ' logo" />';
                echo '</div>';
            } else {
                echo '<div class="item-logo">';
                echo '<img src="' . get_site_url() . '/wp-content/uploads/2023/12/fais-federation.jpg" alt="Fais Logo" />';
                echo '</div>';
            }
            echo '<p>' . get_the_title() . '</p>';
            echo '</div>';
            echo '<div>';
            echo '<p>' . get_field('research_interest') . '</p>';
            echo '</div>';
            echo '<div>';
            echo '<p><a href="' . get_the_permalink() . '">View Profile</a></p>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';

        // Pagination
        $total_pages = $query->max_num_pages;
        if ($total_pages > 1) {
            echo '<div class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="#" class="page-numbers" data-page="' . $i . '">' . $i . '</a>';
            }
            echo '</div>';
        }
    } else {
        echo '<div class="no-results">';
        echo '<p>' . __('No Immunologists found', 'text_domain') . '</p>';
        echo '</div>';
    }

    wp_die();
}
add_action('wp_ajax_immunologists_search', 'immunologists_ajax_search');
add_action('wp_ajax_nopriv_immunologists_search', 'immunologists_ajax_search');


// Add this function to retrieve unique countries with listings:
function get_unique_immunologist_countries() {
    $unique_countries = array();
    $args = array(
        'post_type'      => 'immunologist',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        foreach ($query->posts as $post_id) {
            $country = get_post_meta($post_id, 'country', true);
            if ($country && !in_array($country, $unique_countries)) {
                $unique_countries[] = $country;
            }
        }
    }
    wp_reset_postdata();
    return $unique_countries;
}


// Shortcode for Search Form
function immunologists_search_form_shortcode() {
    $unique_countries = get_unique_immunologist_countries();
    $research_terms = get_terms(array(
        'taxonomy' => 'area_of_research',
        'hide_empty' => false,
    ));

    ob_start();
    ?>
    <div class="immunologists-section">

        <!-- Form Heading -->
        <div class="immunologists-preheader">
            <div class="wrapper_">
                <h1>Search Our Database</h1>
            </div>
        </div>

        <!-- Form -->
        <div id="immunologists-search">
            <div class="wrapper">
                <div class="immunologists-search-heading">
                    <h2>Who are you looking for?</h2>
                </div>
                <form id="immunologists-search-form">
                    <div class="form-column">
                        <label for="search-name"><?php _e('Name', 'text_domain'); ?></label><br>
                        <input type="search" id="search-name" name="s" size="30" placeholder="Name">
                    </div>
                    
                    <div class="form-column">
                        <label for="search-field"><?php _e('Area of Research', 'text_domain'); ?></label><br>
                        <select id="search-field" name="field">
                            <option value=""><?php _e('Select Area of Research', 'text_domain'); ?></option>
                            <?php
                            foreach ($research_terms as $term) {
                                echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-column">
                        <label for="search-location"><?php _e('Location', 'text_domain'); ?></label><br>
                        <input type="text" id="search-location" name="location" size="30" placeholder="Location/City">
                    </div>

                    <div class="form-column">
                        <label for="search-country"><?php _e('Country', 'text_domain'); ?></label><br>
                        <select id="search-country" name="country">
                            <option value=""><?php _e('Select a Country', 'text_domain'); ?></option>
                            <?php
                            foreach ($unique_countries as $country) {
                                echo '<option value="' . esc_attr($country) . '">' . esc_html($country) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-column">
                        <input type="button" id="immunologists-search-button" value="<?php esc_attr_e('Search', 'text_domain'); ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <div id="immunologists-search-results"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('immunologists_search_form', 'immunologists_search_form_shortcode');


// Add Country column in admin to show immunologists countries 



// Add class to body where the page/post contained the shortcode above 
function add_body_class_if_shortcode($classes) {
    
    // Check if we are on a singular page or post
    if (is_singular()) {
        global $post;

        // Replace 'your_shortcode' with the actual shortcode you want to check for
        if (has_shortcode($post->post_content, 'immunologists_search_form')) {
            $classes[] = 'immunologists-list-page';
        }
    }
    return $classes;

}
add_filter('body_class', 'add_body_class_if_shortcode');


// Create the Templates for Overriding
function immunologists_search_template($template) {
    if (is_search() && get_query_var('post_type') == 'immunologist') {
        $new_template = plugin_dir_path(__FILE__) . 'templates/search-immunologists.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'immunologists_search_template');

function immunologists_single_template($template) {
    if (is_singular('immunologist')) {
        $new_template = plugin_dir_path(__FILE__) . 'templates/single-immunologist.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'immunologists_single_template');
