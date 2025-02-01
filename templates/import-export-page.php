<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Import / Export', 'wp-local-sync'); ?></h1>
    
    <div class="wls-import-section">
        <h2><?php _e('Import', 'wp-local-sync'); ?></h2>
        <p class="description">
            <?php _e('Import a Jetpack backup, a full-site backup in another format, or a .sql database file.', 'wp-local-sync'); ?>
            <a href="#" class="wls-learn-more"><?php _e('Learn more', 'wp-local-sync'); ?></a>
        </p>
        
        <div class="wls-upload-zone" id="wls-upload-zone">
            <div class="wls-upload-content">
                <span class="dashicons dashicons-upload"></span>
                <p><?php _e('Drag a file here, or click to select a file', 'wp-local-sync'); ?></p>
            </div>
            <input type="file" id="wls-file-input" style="display: none;">
        </div>
    </div>

    <div class="wls-export-section">
        <h2><?php _e('Export', 'wp-local-sync'); ?></h2>
        <p class="description"><?php _e('Export your entire site or only the database.', 'wp-local-sync'); ?></p>
        
        <div class="wls-export-buttons">
            <button type="button" class="button button-primary" id="wls-export-site">
                <?php _e('Export entire site', 'wp-local-sync'); ?>
            </button>
            
            <button type="button" class="button button-secondary" id="wls-export-db">
                <?php _e('Export database', 'wp-local-sync'); ?>
            </button>
        </div>
    </div>
</div> 