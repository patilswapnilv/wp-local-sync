<?php
/*
Plugin Name: WP Local Sync
Description: Facilitates secure local development environment synchronization
Version: 1.0.0
Author: Your Name
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WLS_VERSION', '1.0.0');
define('WLS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WLS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Check for Composer autoloader
if (!file_exists(WLS_PLUGIN_DIR . 'vendor/autoload.php')) {
    add_action('admin_notices', function() {
        ?>
        <div class="notice notice-error">
            <p><?php _e('WP Local Sync requires Composer dependencies to be installed. Please run "composer install" in the plugin directory.', 'wp-local-sync'); ?></p>
        </div>
        <?php
    });
    return;
}

// Load dependencies
require_once WLS_PLUGIN_DIR . 'vendor/autoload.php';
require_once WLS_PLUGIN_DIR . 'includes/class-environment-manager.php';
require_once WLS_PLUGIN_DIR . 'includes/class-backup-manager.php';
require_once WLS_PLUGIN_DIR . 'includes/class-error-handler.php';
require_once WLS_PLUGIN_DIR . 'includes/class-rate-limiter.php';
require_once WLS_PLUGIN_DIR . 'includes/class-input-validator.php';

class WPLocalSync {
    private $namespace = 'wp-local-sync/v1';

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
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
}

new WPLocalSync();