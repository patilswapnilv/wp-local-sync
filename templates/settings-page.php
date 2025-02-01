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
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="wls_ssh_key_path"><?php _e('SSH Key Path', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="text" id="wls_ssh_key_path" name="wls_ssh_key_path" 
                           value="<?php echo esc_attr(get_option('wls_ssh_key_path')); ?>" 
                           class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="wls_sftp_port"><?php _e('SFTP Port', 'wp-local-sync'); ?></label>
                </th>
                <td>
                    <input type="number" id="wls_sftp_port" name="wls_sftp_port" 
                           value="<?php echo esc_attr(get_option('wls_sftp_port', '22')); ?>" 
                           class="small-text">
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div> 