<?php
/*
Plugin Name: WP Local Sync
Description: Facilitates secure local development environment synchronization
Version: 1.0.0
Author: Your Name
*/

class WPLocalSync {
    private $namespace = 'wp-local-sync/v1';

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        
        // Schedule backup cleanup
        if (!wp_next_scheduled('wls_cleanup_backups')) {
            wp_schedule_event(time(), 'daily', 'wls_cleanup_backups');
        }
        add_action('wls_cleanup_backups', [$this, 'cleanup_backups']);
    }

    public function register_routes() {
        register_rest_route($this->namespace, '/verify', [
            'methods' => 'POST',
            'callback' => [$this, 'verify_connection'],
            'permission_callback' => [$this, 'check_auth'],
        ]);

        register_rest_route($this->namespace, '/backup', [
            'methods' => 'POST',
            'callback' => [$this, 'create_backup'],
            'permission_callback' => [$this, 'check_auth'],
        ]);

        register_rest_route($this->namespace, '/restore', [
            'methods' => 'POST',
            'callback' => [$this, 'restore_backup'],
            'permission_callback' => [$this, 'check_auth'],
        ]);
    }

    public function check_auth($request) {
        $auth_header = $request->get_header('X-WP-Local-Auth');
        return $this->verify_application_password($auth_header);
    }

    private function verify_application_password($auth_header) {
        if (empty($auth_header)) {
            return false;
        }

        $auth_parts = explode(' ', $auth_header);
        if (count($auth_parts) !== 2 || strtolower($auth_parts[0]) !== 'basic') {
            return false;
        }

        $credentials = base64_decode($auth_parts[1]);
        list($username, $password) = explode(':', $credentials);

        return wp_authenticate_application_password(null, $username, $password);
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'wp-local-sync') === false) {
            return;
        }

        wp_enqueue_style(
            'wp-local-sync-admin',
            WLS_PLUGIN_URL . 'assets/css/admin.css',
            [],
            WLS_VERSION
        );

        wp_enqueue_script(
            'wp-local-sync-admin',
            WLS_PLUGIN_URL . 'assets/js/admin.js',
            ['jquery'],
            WLS_VERSION,
            true
        );

        wp_localize_script('wp-local-sync-admin', 'wpLocalSync', [
            'nonce' => wp_create_nonce('wp_rest'),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'restUrl' => rest_url('wp-local-sync/v1/')
        ]);
    }

    public function cleanup_backups() {
        $backup_manager = new WLS_Backup_Manager();
        $backup_manager->cleanup_old_backups();
    }
}

new WPLocalSync(); a