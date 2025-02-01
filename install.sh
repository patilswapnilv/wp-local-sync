#!/bin/bash

# Check if running with correct permissions
if [ "$EUID" -ne 0 ]; then 
    echo "Please run as root or using sudo"
    exit 1
fi

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "Composer is not installed. Please install Composer first."
    echo "Visit https://getcomposer.org/download/ for installation instructions."
    exit 1
fi

# Create necessary directories if they don't exist
mkdir -p vendor
mkdir -p includes
mkdir -p assets/css
mkdir -p assets/js

# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Set proper permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod +x install.sh

# Create wp-content directories if they don't exist
WP_CONTENT_DIR=${WP_CONTENT_DIR:-"../../../"}
mkdir -p "$WP_CONTENT_DIR/wls-backups"
mkdir -p "$WP_CONTENT_DIR/wls-logs"

# Set proper permissions for wp-content directories
chmod 755 "$WP_CONTENT_DIR/wls-backups"
chmod 755 "$WP_CONTENT_DIR/wls-logs"

echo "Installation completed successfully!"
echo "Please activate the plugin through the WordPress admin interface." 