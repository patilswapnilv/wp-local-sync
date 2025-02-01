<?php

class WLS_Input_Validator {
    public function validate_environment($data) {
        $errors = new WP_Error();

        if (empty($data['name'])) {
            $errors->add('empty_name', 'Environment name is required');
        } elseif (strlen($data['name']) > 100) {
            $errors->add('name_too_long', 'Environment name must be less than 100 characters');
        }

        if (empty($data['host'])) {
            $errors->add('empty_host', 'Host is required');
        } elseif (!filter_var($data['host'], FILTER_VALIDATE_DOMAIN)) {
            $errors->add('invalid_host', 'Invalid host name');
        }

        if (!empty($data['sftp_port'])) {
            if (!is_numeric($data['sftp_port']) || $data['sftp_port'] < 1 || $data['sftp_port'] > 65535) {
                $errors->add('invalid_port', 'Invalid SFTP port number');
            }
        }

        if (!empty($data['ssh_key_path'])) {
            if (!file_exists($data['ssh_key_path'])) {
                $errors->add('invalid_ssh_key', 'SSH key file does not exist');
            }
        }

        return $errors->has_errors() ? $errors : true;
    }

    public function sanitize_environment($data) {
        return [
            'name' => sanitize_text_field($data['name']),
            'host' => sanitize_text_field($data['host']),
            'ssh_user' => sanitize_text_field($data['ssh_user'] ?? ''),
            'sftp_port' => absint($data['sftp_port'] ?? 22),
            'ssh_key_path' => sanitize_text_field($data['ssh_key_path'] ?? ''),
            'is_current' => absint($data['is_current'] ?? 0)
        ];
    }
} 