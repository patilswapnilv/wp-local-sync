<?php

class WLS_Rate_Limiter {
    private $option_prefix = 'wls_rate_limit_';
    private $max_requests = 5;
    private $time_window = 300; // 5 minutes

    public function check_rate_limit($key) {
        $requests = get_transient($this->option_prefix . $key);
        
        if (false === $requests) {
            set_transient($this->option_prefix . $key, 1, $this->time_window);
            return true;
        }

        if ($requests >= $this->max_requests) {
            return new WP_Error(
                'rate_limit_exceeded',
                sprintf('Rate limit exceeded. Please wait %d minutes.', $this->time_window / 60)
            );
        }

        set_transient($this->option_prefix . $key, $requests + 1, $this->time_window);
        return true;
    }
} 