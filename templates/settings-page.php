<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Settings', 'wp-local-sync'); ?></h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('wp-local-sync'); ?>
        <?php do_settings_sections('wp-local-sync'); ?>
        
        <h2><?php _e('SSH/SFTP Connection Settings', 'wp-local-sync'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="wls_ssh_host"><?php _e('SSH/SFTP Host', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="text" id="wls_ssh_host" name="wls_ssh_host" 
                           value="<?php echo esc_attr(get_option('wls_ssh_host')); ?>" 
                           class="regular-text" placeholder="e.g., 65.20.82.40">
                    <p class="description"><?php _e('The SSH/SFTP host address for your server', 'wp-local-sync'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wls_ssh_port"><?php _e('SSH/SFTP Port', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="number" id="wls_ssh_port" name="wls_ssh_port" 
                           value="<?php echo esc_attr(get_option('wls_ssh_port', '22')); ?>" 
                           class="small-text" placeholder="e.g., 4138">
                    <p class="description"><?php _e('The SSH/SFTP port (default: 22)', 'wp-local-sync'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wls_ssh_username"><?php _e('SSH/SFTP Username', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="text" id="wls_ssh_username" name="wls_ssh_username" 
                           value="<?php echo esc_attr(get_option('wls_ssh_username')); ?>" 
                           class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wls_ssh_password"><?php _e('SSH/SFTP Password', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="password" id="wls_ssh_password" name="wls_ssh_password" 
                           value="<?php echo esc_attr(get_option('wls_ssh_password')); ?>" 
                           class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wls_ssh_key_path"><?php _e('SSH Key Path (Optional)', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="text" id="wls_ssh_key_path" name="wls_ssh_key_path" 
                           value="<?php echo esc_attr(get_option('wls_ssh_key_path')); ?>" 
                           class="regular-text">
                    <p class="description"><?php _e('Path to SSH private key file (if using key-based authentication)', 'wp-local-sync'); ?></p>
                </td>
            </tr>
        </table>

        <h2><?php _e('WordPress Authentication', 'wp-local-sync'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="wls_wp_username"><?php _e('WordPress Username', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="text" id="wls_wp_username" name="wls_wp_username" 
                           value="<?php echo esc_attr(get_option('wls_wp_username')); ?>" 
                           class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wls_wp_app_password"><?php _e('Application Password', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="password" id="wls_wp_app_password" name="wls_wp_app_password" 
                           value="<?php echo esc_attr(get_option('wls_wp_app_password')); ?>" 
                           class="regular-text">
                    <p class="description">
                        <?php _e('Generate an application password from WordPress admin > Users > Profile > Application Passwords', 'wp-local-sync'); ?>
                    </p>
                </td>
            </tr>
        </table>

        <h2><?php _e('Additional Settings', 'wp-local-sync'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="wls_backup_retention_days"><?php _e('Backup Retention (Days)', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="number" id="wls_backup_retention_days" name="wls_backup_retention_days" 
                           value="<?php echo esc_attr(get_option('wls_backup_retention_days', '30')); ?>" 
                           class="small-text">
                    <p class="description"><?php _e('Number of days to keep backups (default: 30)', 'wp-local-sync'); ?></p>
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div> 