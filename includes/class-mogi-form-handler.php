<?php

if (!defined('ABSPATH')) {
    exit;
}

class Mogi_Form_Handler {
    /**
     * Initialize the form handler.
     */
    public function __construct() {
        add_action('init', array($this, 'handle_form_submission'));
    }

    /**
     * Handle form submission.
     */
    public function handle_form_submission() {
        if (!isset($_POST['mogi_form_nonce']) || !wp_verify_nonce($_POST['mogi_form_nonce'], 'mogi_form_submit')) {
            return;
        }

        if (!isset($_POST['form_id'])) {
            return;
        }

        // Sanitize and validate form data
        $form_data = array(
            'form_id' => intval($_POST['form_id']),
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'message' => sanitize_textarea_field($_POST['message']),
            'date' => current_time('mysql'),
            'ip' => $this->get_client_ip()
        );

        // Save submission to database
        $saved = $this->save_submission($form_data);

        if ($saved) {
            // Send email notification
            $this->send_notification($form_data);

            // Set success message
            $this->set_message('success', __('Thank you for your message. We will get back to you soon.', 'mogi-form'));
        } else {
            $this->set_message('error', __('There was an error processing your submission. Please try again.', 'mogi-form'));
        }
    }

    /**
     * Save form submission to database.
     */
    private function save_submission($data) {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'mogi_form_submissions';
        
        return $wpdb->insert($table_name, $data);
    }

    /**
     * Send email notification.
     */
    private function send_notification($data) {
        $options = get_option('mogi_form_options');
        $to = isset($options['admin_email']) ? $options['admin_email'] : get_option('admin_email');
        
        $subject = sprintf(__('New Contact Form Submission - Form #%d', 'mogi-form'), $data['form_id']);
        
        $message = sprintf(
            "Name: %s\nEmail: %s\nMessage: %s\n\nSubmitted on: %s",
            $data['name'],
            $data['email'],
            $data['message'],
            $data['date']
        );
        
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        wp_mail($to, $subject, $message, $headers);
    }

    /**
     * Get client IP address.
     */
    private function get_client_ip() {
        $ip = '';
        
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        return sanitize_text_field($ip);
    }

    /**
     * Set message in session.
     */
    private function set_message($type, $message) {
        if (!session_id()) {
            session_start();
        }
        $_SESSION['mogi_form_message'] = array(
            'type' => $type,
            'text' => $message
        );
    }
}
