<?php 
/** 
 * Settings Menu
 * @author Archie M
 * 
 * 
 */

// Add submenu page under 'Immunologists'
function immunologists_settings_submenu() {
    add_submenu_page(
        'edit.php?post_type=immunologist', // Parent slug
        'Settings',                        // Page title
        'Settings',                        // Menu title
        'manage_options',                  // Capability
        'immunologists-settings',          // Menu slug
        'immunologists_settings_page'      // Function to display the page
    );
}
add_action('admin_menu', 'immunologists_settings_submenu');

// Display the settings page
function immunologists_settings_page() {
    if (isset($_POST['clear_emails'])) {
        update_option('immunologists_contact_form_emails', '');
        echo '<div class="updated"><p>Contact form emails have been cleared.</p></div>';
    }

    if (isset($_POST['export_emails'])) {
        $emails = get_option('immunologists_contact_form_emails');
        if ($emails) {
            $emails = explode(PHP_EOL, $emails);
            $file_name = 'contact_form_emails_' . date('Y-m-d') . '.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Name', 'Email', 'Message', 'To', 'BCC']);
            foreach ($emails as $email) {
                fputcsv($output, explode(',', $email));
            }
            fclose($output);
            exit;
        } else {
            echo '<div class="error"><p>No emails to export.</p></div>';
        }
    }

    $emails = get_option('immunologists_contact_form_emails');
    $emails_list = $emails ? explode(PHP_EOL, $emails) : [];
    ?>
    <div class="wrap">
        <h1>Immunologists Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('immunologists_settings_group');
            do_settings_sections('immunologists-settings');
            submit_button();
            ?>
        </form>

        <form method="post" style="margin-top: 20px;">
            <input type="submit" name="clear_emails" class="button button-secondary" value="Clear Emails" />
            <input type="submit" name="export_emails" class="button button-secondary" value="Export Emails" />
        </form>

        <h2>Contact Form Submissions</h2>
        <?php if (!empty($emails_list)) : ?>
            <table class="widefat fixed" cellspacing="0">
                <thead>
                    <tr>
                        <th class="manage-column column-columnname" scope="col">Name</th>
                        <th class="manage-column column-columnname" scope="col">Email</th>
                        <th class="manage-column column-columnname" scope="col">Message</th>
                        <th class="manage-column column-columnname" scope="col">To</th>
                        <th class="manage-column column-columnname" scope="col">BCC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emails_list as $email) : 
                        list($name, $email_address, $message, $to, $bcc) = explode(',', $email); ?>
                        <tr>
                            <td><?php echo esc_html($name); ?></td>
                            <td><?php echo esc_html($email_address); ?></td>
                            <td><?php echo esc_html($message); ?></td>
                            <td><?php echo esc_html($to); ?></td>
                            <td><?php echo esc_html($bcc); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No contact form submissions found.</p>
        <?php endif; ?>
    </div>
    <?php
}

// Register settings, sections, and fields
function immunologists_settings_init() {
    register_setting('immunologists_settings_group', 'immunologists_bcc_emails');
    register_setting('immunologists_settings_group', 'google_recaptcha_site_key');
    register_setting('immunologists_settings_group', 'google_recaptcha_secret_key');
    register_setting('immunologists_settings_group', 'immunologists_contact_form_emails');

    add_settings_section(
        'immunologists_settings_section',
        'General Settings',
        'immunologists_settings_section_callback',
        'immunologists-settings'
    );

    add_settings_field(
        'immunologists_bcc_emails',
        'BCC Emails',
        'immunologists_bcc_emails_callback',
        'immunologists-settings',
        'immunologists_settings_section'
    );

    add_settings_field(
        'google_recaptcha_site_key',
        'Google Recaptcha Site Key',
        'google_recaptcha_site_key_callback',
        'immunologists-settings',
        'immunologists_settings_section'
    );

    add_settings_field(
        'google_recaptcha_secret_key',
        'Google Recaptcha Secret Key',
        'google_recaptcha_secret_key_callback',
        'immunologists-settings',
        'immunologists_settings_section'
    );
}
add_action('admin_init', 'immunologists_settings_init');

// Callback functions
function immunologists_settings_section_callback() {
    echo 'Configure the general settings for Immunologists.';
}

function immunologists_bcc_emails_callback() {
    $bcc_emails = get_option('immunologists_bcc_emails');
    echo '<input type="text" id="immunologists_bcc_emails" name="immunologists_bcc_emails" value="' . esc_attr($bcc_emails) . '" class="regular-text" />';
    echo '<p class="description">Enter BCC emails separated by commas.</p>';
}

function google_recaptcha_site_key_callback() {
    $site_key = get_option('google_recaptcha_site_key');
    echo '<input type="text" id="google_recaptcha_site_key" name="google_recaptcha_site_key" value="' . esc_attr($site_key) . '" class="regular-text" />';
    echo '<p class="description">Enter your Google Recaptcha site key.</p>';
}

function google_recaptcha_secret_key_callback() {
    $secret_key = get_option('google_recaptcha_secret_key');
    echo '<input type="text" id="google_recaptcha_secret_key" name="google_recaptcha_secret_key" value="' . esc_attr($secret_key) . '" class="regular-text" />';
    echo '<p class="description">Enter your Google Recaptcha secret key.</p>';
}
 