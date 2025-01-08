<?php

if (!defined('ABSPATH')) {
    exit;
}

class Mogi_Form_Admin {
    /**
     * Initialize the admin class.
     */
    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Register plugin settings.
     */
    public function register_settings() {
        register_setting('mogi_form_settings', 'mogi_form_options');

        // Add settings sections
        add_settings_section(
            'mogi_form_general',
            __('General Settings', 'mogi-form'),
            array($this, 'render_general_section'),
            'mogi_form_settings'
        );

        // Add settings fields
        add_settings_field(
            'email_notifications',
            __('Email Notifications', 'mogi-form'),
            array($this, 'render_email_field'),
            'mogi_form_settings',
            'mogi_form_general'
        );
    }

    /**
     * Render general settings section.
     */
    public function render_general_section() {
        echo '<p>' . __('Configure general settings for your contact forms.', 'mogi-form') . '</p>';
    }

    /**
     * Render email settings field.
     */
    public function render_email_field() {
        $options = get_option('mogi_form_options');
        $email = isset($options['admin_email']) ? $options['admin_email'] : get_option('admin_email');
        ?>
        <input type="email" name="mogi_form_options[admin_email]" value="<?php echo esc_attr($email); ?>" class="regular-text">
        <p class="description"><?php _e('Email address for form notifications', 'mogi-form'); ?></p>
        <?php
    }

    /**
     * Create a new form template.
     */
    public function create_form_template($form_id) {
        $template_content = $this->get_default_form_template($form_id);
        $form_path = MOGI_FORM_PLUGIN_DIR . 'forms/form-' . $form_id . '.php';
        
        return file_put_contents($form_path, $template_content);
    }

    /**
     * Get default form template content.
     */
    private function get_default_form_template($form_id) {
        ob_start();
        ?>
<div class="mogi-form" id="mogi-form-<?php echo esc_attr($form_id); ?>">
    <form method="post" action="">
        <?php wp_nonce_field('mogi_form_submit', 'mogi_form_nonce'); ?>
        <input type="hidden" name="form_id" value="<?php echo esc_attr($form_id); ?>">
        
        <div class="form-group">
            <label for="name"><?php _e('Name', 'mogi-form'); ?></label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="email"><?php _e('Email', 'mogi-form'); ?></label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="message"><?php _e('Message', 'mogi-form'); ?></label>
            <textarea name="message" id="message" rows="5" required></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="submit-button">
                <?php _e('Send Message', 'mogi-form'); ?>
            </button>
        </div>
    </form>
</div>
        <?php
        return ob_get_clean();
    }
}
