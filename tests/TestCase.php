<?php
namespace WPLocalSync\Tests;

class TestCase extends \WP_UnitTestCase {
    protected $plugin;

    public function setUp(): void {
        parent::setUp();
        $this->plugin = new \WPLocalSync();
    }

    public function tearDown(): void {
        parent::tearDown();
    }
} 