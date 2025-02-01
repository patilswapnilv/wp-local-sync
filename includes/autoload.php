<?php
namespace WPLocalSync;

spl_autoload_register(function ($class) {
    // Check if the class is in our namespace
    if (strpos($class, 'WPLocalSync\\') !== 0) {
        return;
    }

    // Remove namespace from class name
    $class_file = str_replace('WPLocalSync\\', '', $class);
    
    // Convert class name to file name
    $class_file = 'class-' . strtolower(str_replace('_', '-', $class_file)) . '.php';
    
    // Get the full path
    $file = WLS_PLUGIN_DIR . 'includes/' . $class_file;
    
    // Include the file if it exists
    if (file_exists($file)) {
        require_once $file;
    }
}); 