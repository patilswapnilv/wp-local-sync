<?php

namespace WPLocalSync;

class WLS_Error_Handler {
    private static $instance = null;
    private $errors = [];
    private $log_file;

    private function __construct() {
        $this->log_file = WP_CONTENT_DIR . '/wls-logs/error.log';
        $this->ensure_log_directory();
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function ensure_log_directory() {
        $log_dir = dirname($this->log_file);
        if (!file_exists($log_dir)) {
            wp_mkdir_p($log_dir);
            file_put_contents($log_dir . '/.htaccess', 'deny from all');
        }
    }

    public function log_error($message, $context = [], $severity = 'error') {
        $timestamp = current_time('mysql');
        $log_entry = sprintf(
            "[%s] %s: %s %s\n",
            $timestamp,
            strtoupper($severity),
            $message,
            !empty($context) ? json_encode($context) : ''
        );

        error_log($log_entry, 3, $this->log_file);

        if ($severity === 'error') {
            $this->errors[] = $message;
        }
    }

    public function get_errors() {
        return $this->errors;
    }

    public function has_errors() {
        return !empty($this->errors);
    }
} 