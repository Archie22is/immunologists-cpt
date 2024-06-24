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


// Require additional files 
//require_once plugin_dir_path( __FILE__ ) . 'includes/disable-seo.php';


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
        'has_archive'           => true,
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
                    'key' => 'field_email',
                    'label' => __('Email Address', 'text_domain'),
                    'name' => 'email',
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


// Enqueue Custom CSS and JS
function immunologists_enqueue_styles_scripts() {
    wp_enqueue_style('immunologists-style', plugin_dir_url(__FILE__) . '/css/style.css');
    wp_enqueue_script('immunologists-script', plugin_dir_url(__FILE__) . '/js/script.js', array('jquery'), null, true);

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

    $args = array(
        'post_type' => 'immunologist',
        'posts_per_page' => -1,
    );

    $meta_query = array('relation' => 'AND');

    if (!empty($_POST['field'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'area_of_research',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_POST['field']),
            ),
        );
    }

    if (!empty($_POST['location'])) {
        $meta_query[] = array(
            'key'     => 'location',
            'value'   => sanitize_text_field($_POST['location']),
            'compare' => 'LIKE',
        );
    }

    if (count($meta_query) > 1) {
        $args['meta_query'] = $meta_query;
    }

    if (!empty($_POST['s'])) {
        $args['s'] = sanitize_text_field($_POST['s']);
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) { ?>

        <div class="immunologist-profile">

            <div class="immunologist-results immunologist-heading">
                <div>
                    <h3>Name</h3>
                </div>
                <div>
                    <h3>Occupation</h3>
                </div>
                <div>
                    <h3>Profile</h3>
                </div>
            </div>
            
        
            <?php while ($query->have_posts()) { 
                $query->the_post();
                ?>

                    <div class="immunologist-results immunologist-results-items">
                        <div class="immunologist-profile-main">
                            <?php 
                                // Profile name and featured image 
                                $profile_name = get_the_title();
                                $profile_image = get_field('profile_image'); 
                            ?>
                            <?php if( $profile_image ) { ?>
                                <div class="item-logo">
                                    <img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo $profile_name ?> logo" />
                                </div>
                            <?php } else { ?>
                                <div class="item-logo">
                                    <img src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/12/fais-federation.jpg" alt="Fais Logo" />
                                </div>
                            <?php } ?>
                            <p><?php the_title(); ?></p>
                        </div>
                        <div>
                            <p><?php the_field('research_interest'); ?></p>
                        </div>
                        <div>
                            <p><a href="<?php the_permalink(); ?>">View Profile</a></p>
                        </div>    
                    </div>
                
                <?php
            } ?>

        </div>

    <?php } else { ?>

        <div class="no-results">
            <?php echo '<p>' . __('No Immunologists found', 'text_domain') . '</p>'; ?>
        </div>
    
    <?php }

    wp_die();
}
add_action('wp_ajax_immunologists_search', 'immunologists_ajax_search');
add_action('wp_ajax_nopriv_immunologists_search', 'immunologists_ajax_search');


// Shortcode for Search Form
function immunologists_search_form_shortcode() {
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
                        <input type="text" id="search-field" name="field" size="30" placeholder="Field">
                    </div>

                    <div class="form-column">
                        <label for="search-location"><?php _e('Location', 'text_domain'); ?></label><br>
                        <input type="text" id="search-location" name="location" size="30" placeholder="Location">
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
