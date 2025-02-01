#!/bin/bash

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "Composer is not installed. Please install Composer first."
    echo "Visit https://getcomposer.org/download/ for installation instructions."
    exit 1
fi

# Install Composer dependencies
composer install --no-dev

# Set proper permissions
chmod 755 .
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

echo "Installation completed successfully!" 