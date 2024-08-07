<?php
/**
 * Ajax Form Handler 
 * @author Archie M
 * 
 */
function immunologists_contact_form_shortcode($atts) {
    // Get the $to email from the custom field in the current post
    $to_email = get_post_meta(get_the_ID(), 'email', true);

    ob_start();
    ?>
    <form id="immunologists-contact-form" class="immunologists-contact-form" method="post">
        <div class="form-block">
            <p>
                <input type="hidden" name="to_email" value="<?php echo esc_attr($to_email); ?>" >
            </p>
        </div>
        <div class="form-block">
            <p>
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" required placeholder="First Name/s">
            </p>
        </div>
        <div class="form-block">
            <p>
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" required placeholder="Last Name">
            </p>
        </div>
        <div class="form-block">
            <p>
                <label for="email">Email</label>
                <input type="email" name="email" required placeholder="Email address">
            </p>
        </div>
        <div class="form-block">
            <p>
                <label for="contact_number">Contact Number</label>
                <input type="tel" name="contact_number" required placeholder="Contact Number">
            </p>
        </div>
        <div class="form-block">
            <p>
                <label for="message">Message</label>
                <textarea name="message" required placeholder="Message/Comments"></textarea>
            </p>
        </div>
        <div class="form-block">
            <p>
                <div class="g-recaptcha" data-sitekey="<?php echo esc_attr(get_option('google_recaptcha_site_key')); ?>"></div>
            </p>
        </div>
        <div class="form-block">
            <p>
                <input type="submit" value="Submit">
            </p>
        </div>
    </form>
    <div id="form-message"></div>
    <script>
    jQuery(document).ready(function($) {
        $('#immunologists-contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var formData = form.serialize();
            
            $.ajax({
                type: 'POST',
                url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                data: formData + '&action=immunologists_contact_form',
                success: function(response) {
                    $('#form-message').html('<p>' + response.data.message + '</p>');
                    if (response.success) {
                        form[0].reset();
                        grecaptcha.reset(); // Reset the reCAPTCHA
                    }
                },
                error: function(response) {
                    $('#form-message').html('<p>' + response.responseJSON.data.message + '</p>');
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('immunologists_contact_form', 'immunologists_contact_form_shortcode');

function handle_immunologists_contact_form() {
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptcha_secret = get_option('google_recaptcha_secret_key');
        $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$_POST['g-recaptcha-response']}");
        $response_body = wp_remote_retrieve_body($response);
        $result = json_decode($response_body);
        if (!$result->success) {
            wp_send_json_error(['message' => 'reCAPTCHA validation failed.']);
        }
    } else {
        wp_send_json_error(['message' => 'reCAPTCHA is not set.']);
    }

    // Use the $to email passed from the form
    $to = sanitize_email($_POST['to_email']);
    if (empty($to)) {
        wp_send_json_error(['message' => 'Recipient email is missing.']);
    }

    $bcc_emails = get_option('immunologists_bcc_emails');
    $headers = array('Content-Type: text/html; charset=UTF-8');

    $headers[] = 'From: Fais Africa <no-reply@faisafrica.com>';

    $subject = 'Contact Request From FaisAfrica.com';
    $message = '<html><body>';
    $message .= '<p>Good day, you have received the following enquiry from <a href="https://www.faisafrica.com/" target="_blank">www.faisafrica.com</a>.</p>';
    $message .= '<br>';
    $message .= '<p><strong>Enquiry Details:</strong></p>';
    $message .= '<p>First Name/s: ' . sanitize_text_field($_POST['first_name']) . '</p>';
    $message .= '<p>Last Name: ' . sanitize_text_field($_POST['last_name']) . '</p>';
    $message .= '<p>Email: ' . sanitize_email($_POST['email']) . '</p>';
    $message .= '<p>Contact Number: ' . sanitize_text_field($_POST['contact_number']) . '</p>';
    $message .= '<p>Message: ' . sanitize_textarea_field($_POST['message']) . '</p>';
    $message .= '<br>';
    $message .= '<p>A copy of this enquiry has also been emailed to ' . $bcc_emails . '</p>';
    $message .= '</body></html>';

    $bcc_emails_array = [];
    if ($bcc_emails) {
        $bcc_emails_array = explode(',', $bcc_emails);
        foreach ($bcc_emails_array as $bcc_email) {
            $headers[] = 'Bcc: ' . sanitize_email($bcc_email);
        }
    }

    if (wp_mail($to, $subject, $message, $headers)) {
        // Save the email
        $saved_emails = get_option('immunologists_contact_form_emails');
        $bcc_emails_str = implode(';', $bcc_emails_array);
        $new_email = sanitize_text_field($_POST['first_name']) . ' ' . sanitize_text_field($_POST['last_name']) . ',' . sanitize_email($_POST['email']) . ',' . sanitize_textarea_field($_POST['message']) . ',' . $to . ',' . $bcc_emails_str;
        if ($saved_emails) {
            $saved_emails .= PHP_EOL . $new_email;
        } else {
            $saved_emails = $new_email;
        }
        update_option('immunologists_contact_form_emails', $saved_emails);

        wp_send_json_success(['message' => 'Your message has been sent successfully.']);
    } else {
        wp_send_json_error(['message' => 'Failed to send your message. Please try again later.']);
    }
}
add_action('wp_ajax_immunologists_contact_form', 'handle_immunologists_contact_form');
add_action('wp_ajax_nopriv_immunologists_contact_form', 'handle_immunologists_contact_form');
