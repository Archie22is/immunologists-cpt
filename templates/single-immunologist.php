<?php
/**
 * Single Immunologist Template
 * @author Archie M
 * 
 */
get_header();

while (have_posts()) {
    the_post(); ?>

    <section class="banner inner-banner about"></section>

    <div class="wrapper">

        <section class="single-immunologist-heading">
            <h2 class="h1">Profile</h2>
        </section>
        
        <section class="single-immunologist-listing">
            <?php 
                // Get profiles vars 
                $profile_image = get_field('profile_image');
                $job_title = get_field('job_title');
                $location = get_field('location');
                $country = get_field('country');
                $immunology_email = get_field('email_address');
                $research_interest = get_field('research_interest');
                $institute = get_field('institute');
                $website = get_field('website');
            ?>
            <div class="single-immunologist-info">
                <div class="single-immunologists-title">
                    <h1><?php the_title(); ?></h1>
                </div>
                <div class="single-immunologist-image">
                    <?php if( $profile_image ) { ?>
                        <div class="item-logo">
                            <img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo $profile_name ?> logo" />
                        </div>
                    <?php } else { ?>
                        <div class="item-logo">
                            <img src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/12/fais-federation.jpg" alt="Fais Logo" />
                        </div>
                    <?php } ?>
                </div>
                <?php 
                    // Load custom contact form
                    echo do_shortcode('[immunologists_contact_form]');
                ?>
            </div>
            <div class="single-immunologist-about">
                <h3>About</h3>

                <?php if($institute) { ?>
                    <p>
                        <i class="fa fa-school " aria-hidden="true"></i> 
                        <span><?php echo $institute; ?></span>
                    </p>
                <?php } ?>

                <?php if($location || $country) { ?>
                    <p>
                        <i class="fa fa-solid fa-location-arrow" aria-hidden="true"></i> 
                        <span>
                            <?php echo $location; ?>
                            <?php if($location && $country) { ?>
                                <?php echo ", "; ?>
                            <?php } ?>
                            <?php echo $country; ?>
                        </span>
                    </p>
                <?php } ?>

                <?php if($research_interest) { ?>
                    <p>
                        <i class="fa fa-solid fa-list" aria-hidden="true"></i> 
                        <span><?php echo $research_interest; ?></span>
                    </p>
                <?php } ?>

                <?php if($immunology_email) { ?>
                    <p>
                        <i class="fa fa-solid fa-envelope" aria-hidden="true"></i> 
                        <span><a href="mailto:<?php echo $immunology_email; ?>"><?php echo $immunology_email ?></a></span>
                    </p>
                <?php } ?>

                <?php if($website) { ?>
                    <p>
                        <i class="fa fa-solid fa-globe" aria-hidden="true"></i> 
                        <?php
                            // Check if url contain protocol
                            if (!preg_match('/^https?:\/\//i', $website)) {
                                // If not, prepend 'https://'
                                $website = 'https://' . $website;
                            }
                        ?>
                        <span>
                            <a href="<?php echo $website; ?>" target="_blank"><?php echo $website ?></a>
                        </span>
                    </p>
                <?php } ?>
            </div>
        </section>

        <div class="back-to-listing-wrapper">
            <a href="https://www.faisafrica.com/immunologists/">Back to Listings</a>
        </div>
    </div>
</section>

<?php }

get_footer();
