<?php
namespace WPLocalSync\Tests;

use WLS_Environment_Manager;

class EnvironmentManagerTest extends TestCase {
    private $environment_manager;

    public function setUp(): void {
        parent::setUp();
        $this->environment_manager = new WLS_Environment_Manager();
    }

    public function test_add_environment() {
        $data = [
            'name' => 'Test Environment',
            'host' => 'test.example.com',
            'ssh_user' => 'testuser',
            'sftp_port' => 22
        ];

        $result = $this->environment_manager->add_environment($data);
        $this->assertTrue($result);

        global $wpdb;
        $environment = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}wls_environments WHERE name = 'Test Environment'");
        
        $this->assertNotNull($environment);
        $this->assertEquals($data['host'], $environment->host);
    }

    public function test_add_environment_validation() {
        $data = [
            'name' => '', // Invalid empty name
            'host' => 'test.example.com'
        ];

        $result = $this->environment_manager->add_environment($data);
        $this->assertInstanceOf(\WP_Error::class, $result);
        $this->assertEquals('invalid_input', $result->get_error_code());
    }
} 