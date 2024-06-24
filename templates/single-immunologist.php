<?php
/**
 * 
 * 
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
                        $email = get_field('email');
                        $research_interest = get_field('research_interest');
                        $institute = get_field('institute');
                        $website = get_field('website');
                    ?>
                    <div class="single-immunologist-info">
                        <div class="single-immunologists-title">
                            <h1><?php wp_title(''); ?></h1>
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
                    </div>
                    <div class="single-immunologist-about">
                        <h4>About</h4>
                        <?php if($email) { ?>
                            <p><i class="fa-solid fa-envelope"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email ?></a></p>
                        <?php } ?>

                        <?php if($institute) { ?>
                            <p><i class="fa-solid fa-location-dot"></i> <?php echo $institute; ?></p>
                        <?php } ?>

                        <?php if($research_interest) { ?>
                            <p><i class="fa-solid fa-link"></i> <?php echo $research_interest; ?></p>
                        <?php } ?>

                        <?php if($website) { ?>
                            <p><i class="fa-solid fa-globe"></i> <?php ?></p>
                        <?php } ?>
                    </div>

                </section>
            
            </div>
            
        </section>

<?php }

get_footer();
