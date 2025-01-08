<?php

if (!defined('ABSPATH')) {
    exit;
}

class Mogi_Form {
    /**
     * Plugin instance.
     *
     * @var Mogi_Form
     */
    private static $instance = null;

    /**
     * Initialize the plugin.
     */
    public function init() {
        $this->init_hooks();
        $this->load_dependencies();
    }

    /**
     * Initialize WordPress hooks.
     */
    private function init_hooks() {
        // Admin hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        
        // Frontend hooks
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('contactform', array($this, 'render_contact_form'));
    }

    /**
     * Load required dependencies.
     */
    private function load_dependencies() {
        // Admin
        require_once MOGI_FORM_PLUGIN_DIR . 'admin/class-mogi-form-admin.php';
        
        // Form handling
        require_once MOGI_FORM_PLUGIN_DIR . 'includes/class-mogi-form-handler.php';
    }

    /**
     * Add admin menu items.
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Mogi Form', 'mogi-form'),
            __('Mogi Form', 'mogi-form'),
            'manage_options',
            'mogi-form',
            array($this, 'render_admin_page'),
            'dashicons-feedback',
            30
        );
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function admin_enqueue_scripts($hook) {
        if (strpos($hook, 'mogi-form') === false) {
            return;
        }

        wp_enqueue_style('mogi-form-admin', MOGI_FORM_PLUGIN_URL . 'assets/css/admin.css', array(), MOGI_FORM_VERSION);
        wp_enqueue_script('mogi-form-admin', MOGI_FORM_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), MOGI_FORM_VERSION, true);
    }

    /**
     * Enqueue frontend scripts and styles.
     */
    public function enqueue_scripts() {
        wp_enqueue_style('mogi-form', MOGI_FORM_PLUGIN_URL . 'assets/css/form.css', array(), MOGI_FORM_VERSION);
        wp_enqueue_script('mogi-form', MOGI_FORM_PLUGIN_URL . 'assets/js/form.js', array('jquery'), MOGI_FORM_VERSION, true);
    }

    /**
     * Render the contact form shortcode.
     */
    public function render_contact_form($atts) {
        $atts = shortcode_atts(array(
            'id' => '1',
            'style' => 'default'
        ), $atts, 'contactform');

        // Load and return form template
        $form_path = MOGI_FORM_PLUGIN_DIR . 'forms/form-' . $atts['id'] . '.php';
        if (file_exists($form_path)) {
            ob_start();
            include $form_path;
            return ob_get_clean();
        }

        return '<p>' . __('Form not found.', 'mogi-form') . '</p>';
    }

    /**
     * Render the admin page.
     */
    public function render_admin_page() {
        include MOGI_FORM_PLUGIN_DIR . 'admin/views/admin-page.php';
    }

    /**
     * Get plugin instance.
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
