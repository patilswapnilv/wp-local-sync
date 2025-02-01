<?php
namespace WPLocalSync\Tests;

use WLS_Backup_Manager;

class BackupManagerTest extends TestCase {
    private $backup_manager;

    public function setUp(): void {
        parent::setUp();
        $this->backup_manager = new WLS_Backup_Manager();
    }

    public function test_create_backup() {
        $result = $this->backup_manager->create_backup();
        $this->assertTrue($result);

        global $wpdb;
        $backup = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}wls_backups ORDER BY id DESC LIMIT 1");
        
        $this->assertNotNull($backup);
        $this->assertFileExists(WP_CONTENT_DIR . '/wls-backups/' . $backup->filename);
    }

    public function test_transfer_backup() {
        // Create a test backup first
        $this->backup_manager->create_backup();
        
        global $wpdb;
        $backup = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}wls_backups ORDER BY id DESC LIMIT 1");
        
        // Test with invalid environment
        $result = $this->backup_manager->transfer_backup($backup->id, 999);
        $this->assertInstanceOf(\WP_Error::class, $result);
    }
} 