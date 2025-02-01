<?php

class WLS_Environment_Manager {
    private $validator;
    private $rate_limiter;

    public function __construct() {
        $this->validator = new WLS_Input_Validator();
        $this->rate_limiter = new WLS_Rate_Limiter();
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

            // Add environment
            return parent::add_environment($data);
        } catch (\Exception $e) {
            $this->error_handler->log_error('Failed to add environment', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return new \WP_Error('environment_error', $e->getMessage());
        }
    }
} 