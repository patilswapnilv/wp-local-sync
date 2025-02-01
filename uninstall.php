<?php

// If uninstall not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Drop custom tables
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wls_environments");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}wls_backups");

// Delete options
delete_option('wls_ssh_key_path');
delete_option('wls_sftp_port');
delete_option('wls_app_password');

// Delete backup directory
$backup_dir = WP_CONTENT_DIR . '/wls-backups';
if (is_dir($backup_dir)) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($backup_dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($files as $fileinfo) {
        if ($fileinfo->isDir()) {
            rmdir($fileinfo->getRealPath());
        } else {
            unlink($fileinfo->getRealPath());
        }
    }
    rmdir($backup_dir);
} 