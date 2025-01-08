<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <h2 class="nav-tab-wrapper">
        <a href="?page=mogi-form&tab=forms" class="nav-tab <?php echo !isset($_GET['tab']) || $_GET['tab'] === 'forms' ? 'nav-tab-active' : ''; ?>">
            <?php _e('Forms', 'mogi-form'); ?>
        </a>
        <a href="?page=mogi-form&tab=settings" class="nav-tab <?php echo isset($_GET['tab']) && $_GET['tab'] === 'settings' ? 'nav-tab-active' : ''; ?>">
            <?php _e('Settings', 'mogi-form'); ?>
        </a>
    </h2>

    <div class="tab-content">
        <?php
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'forms';
        
        switch ($tab) {
            case 'settings':
                ?>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('mogi_form_settings');
                    do_settings_sections('mogi_form_settings');
                    submit_button();
                    ?>
                </form>
                <?php
                break;
                
            default: // 'forms' tab
                ?>
                <div class="forms-list">
                    <div class="tablenav top">
                        <div class="alignleft actions">
                            <a href="?page=mogi-form&action=new" class="button button-primary">
                                <?php _e('Add New Form', 'mogi-form'); ?>
                            </a>
                        </div>
                    </div>

                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th><?php _e('Form Name', 'mogi-form'); ?></th>
                                <th><?php _e('Shortcode', 'mogi-form'); ?></th>
                                <th><?php _e('Submissions', 'mogi-form'); ?></th>
                                <th><?php _e('Actions', 'mogi-form'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // List forms here
                            $forms_dir = MOGI_FORM_PLUGIN_DIR . 'forms/';
                            if (is_dir($forms_dir)) {
                                $forms = glob($forms_dir . 'form-*.php');
                                if (!empty($forms)) {
                                    foreach ($forms as $form) {
                                        $form_id = str_replace(array('form-', '.php'), '', basename($form));
                                        ?>
                                        <tr>
                                            <td>Form #<?php echo esc_html($form_id); ?></td>
                                            <td>
                                                <code>[contactform id="<?php echo esc_attr($form_id); ?>"]</code>
                                                <button class="button button-small copy-shortcode" data-shortcode='[contactform id="<?php echo esc_attr($form_id); ?>"]'>
                                                    <?php _e('Copy', 'mogi-form'); ?>
                                                </button>
                                            </td>
                                            <td>
                                                <a href="?page=mogi-form&view=submissions&form_id=<?php echo esc_attr($form_id); ?>">
                                                    <?php
                                                    global $wpdb;
                                                    $count = $wpdb->get_var($wpdb->prepare(
                                                        "SELECT COUNT(*) FROM {$wpdb->prefix}mogi_form_submissions WHERE form_id = %d",
                                                        $form_id
                                                    ));
                                                    echo esc_html($count);
                                                    ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="?page=mogi-form&action=edit&form_id=<?php echo esc_attr($form_id); ?>" class="button button-small">
                                                    <?php _e('Edit', 'mogi-form'); ?>
                                                </a>
                                                <a href="?page=mogi-form&action=duplicate&form_id=<?php echo esc_attr($form_id); ?>" class="button button-small">
                                                    <?php _e('Duplicate', 'mogi-form'); ?>
                                                </a>
                                                <a href="?page=mogi-form&action=delete&form_id=<?php echo esc_attr($form_id); ?>" class="button button-small" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this form?', 'mogi-form'); ?>')">
                                                    <?php _e('Delete', 'mogi-form'); ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="4"><?php _e('No forms found.', 'mogi-form'); ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                break;
        }
        ?>
    </div>
</div>
