<?php

namespace WPLocalSync;

class WLS_Environment_Manager {
    private $validator;
    private $rate_limiter;
    private $error_handler;
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'wls_environments';
        $this->validator = new WLS_Input_Validator();
        $this->rate_limiter = new WLS_Rate_Limiter();
        $this->error_handler = WLS_Error_Handler::get_instance();
        
        // Create tables if they don't exist
        $this->create_tables();
    }

    public function add_environment($data) {
        try {
            // Check rate limiting
            $rate_check = $this->rate_limiter->check_rate_limit('add_environment');
            if (is_wp_error($rate_check)) {
                return $rate_check;
            }

            // Validate input
            $validation = $this->validator->validate_environment($data);
            if (is_wp_error($validation)) {
                return $validation;
            }

            // Sanitize input
            $data = $this->validator->sanitize_environment($data);

            // Insert into database
            global $wpdb;
            $result = $wpdb->insert(
                $this->table_name,
                [
                    'name' => $data['name'],
                    'host' => $data['host'],
                    'ssh_user' => $data['ssh_user'],
                    'sftp_port' => $data['sftp_port'],
                    'ssh_key_path' => $data['ssh_key_path'],
                    'is_current' => $data['is_current'],
                    'created_at' => current_time('mysql')
                ],
                ['%s', '%s', '%s', '%d', '%s', '%d', '%s']
            );

            if ($result === false) {
                throw new \Exception('Failed to add environment to database');
            }

            return $wpdb->insert_id;
        } catch (\Exception $e) {
            $this->error_handler->log_error('Failed to add environment', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return new \WP_Error('environment_error', $e->getMessage());
        }
    }

    private function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            host varchar(255) NOT NULL,
            ssh_user varchar(100) DEFAULT NULL,
            sftp_port int(5) DEFAULT 22,
            ssh_key_path varchar(255) DEFAULT NULL,
            is_current tinyint(1) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY name (name),
            KEY host (host)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function get_environment($id) {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id)
        );
    }

    public function get_environments() {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$this->table_name} ORDER BY name ASC");
    }

    public function update_environment($id, $data) {
        try {
            // Validate input
            $validation = $this->validator->validate_environment($data);
            if (is_wp_error($validation)) {
                return $validation;
            }

            // Sanitize input
            $data = $this->validator->sanitize_environment($data);

            global $wpdb;
            $result = $wpdb->update(
                $this->table_name,
                [
                    'name' => $data['name'],
                    'host' => $data['host'],
                    'ssh_user' => $data['ssh_user'],
                    'sftp_port' => $data['sftp_port'],
                    'ssh_key_path' => $data['ssh_key_path'],
                    'is_current' => $data['is_current']
                ],
                ['id' => $id],
                ['%s', '%s', '%s', '%d', '%s', '%d'],
                ['%d']
            );

            if ($result === false) {
                throw new \Exception('Failed to update environment');
            }

            return true;
        } catch (\Exception $e) {
            $this->error_handler->log_error('Failed to update environment', [
                'error' => $e->getMessage(),
                'data' => $data,
                'id' => $id
            ]);
            return new \WP_Error('environment_error', $e->getMessage());
        }
    }

    public function delete_environment($id) {
        global $wpdb;
        return $wpdb->delete($this->table_name, ['id' => $id], ['%d']);
    }
} 