<?php
namespace WPLocalSync;

class WLS_Settings_Manager {
    public function encrypt_sensitive_data($value, $option_name) {
        $sensitive_options = [
            'wls_ssh_password',
            'wls_wp_app_password'
        ];

        if (in_array($option_name, $sensitive_options)) {
            return wp_encrypt_password($value);
        }

        return $value;
    }

    public function decrypt_sensitive_data($value, $option_name) {
        $sensitive_options = [
            'wls_ssh_password',
            'wls_wp_app_password'
        ];

        if (in_array($option_name, $sensitive_options)) {
            return $this->decrypt_value($value);
        }

        return $value;
    }

    private function decrypt_value($encrypted_value) {
        // Implement secure decryption
        return $encrypted_value;
    }
} 