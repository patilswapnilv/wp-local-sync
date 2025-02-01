<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Environments', 'wp-local-sync'); ?></h1>
    
    <a href="#" class="page-title-action add-environment">
        <?php _e('Add New Environment', 'wp-local-sync'); ?>
    </a>
    
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('Name', 'wp-local-sync'); ?></th>
                <th><?php _e('Host', 'wp-local-sync'); ?></th>
                <th><?php _e('Status', 'wp-local-sync'); ?></th>
                <th><?php _e('Actions', 'wp-local-sync'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($environments)): ?>
                <?php foreach ($environments as $env): ?>
                    <tr>
                        <td><?php echo esc_html($env->name); ?></td>
                        <td><?php echo esc_html($env->host); ?></td>
                        <td><?php echo $env->is_current ? __('Current', 'wp-local-sync') : ''; ?></td>
                        <td>
                            <a href="#" class="edit-env" data-id="<?php echo esc_attr($env->id); ?>">
                                <?php _e('Edit', 'wp-local-sync'); ?>
                            </a>
                            |
                            <a href="#" class="delete-env" data-id="<?php echo esc_attr($env->id); ?>">
                                <?php _e('Delete', 'wp-local-sync'); ?>
                            </a>
                            |
                            <a href="#" class="clone-env" data-id="<?php echo esc_attr($env->id); ?>">
                                <?php _e('Clone', 'wp-local-sync'); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4"><?php _e('No environments found.', 'wp-local-sync'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> 