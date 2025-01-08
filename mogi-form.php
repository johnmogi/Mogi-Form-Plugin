<?php
/**
 * Plugin Name: Mogi Form
 * Plugin URI: https://example.com/mogi-form
 * Description: A powerful and flexible contact form plugin with Google Sheets integration
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Text Domain: mogi-form
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('MOGI_FORM_VERSION', '1.0.0');
define('MOGI_FORM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MOGI_FORM_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once MOGI_FORM_PLUGIN_DIR . 'includes/class-mogi-form.php';

// Initialize the plugin
function mogi_form_init() {
    $plugin = new Mogi_Form();
    $plugin->init();
}
add_action('plugins_loaded', 'mogi_form_init');
