# WP Local Sync

A WordPress plugin that facilitates secure local development environment synchronization with staging and production environments.

## 🚀 Features

- Environment Management (Local, Staging, Production)
- Secure SFTP/SSH File Transfer
- Database Backup and Restoration
- File System Backup with Rotation
- Environment-specific Configuration
- Secure Authentication using WordPress Application Passwords
- Progress Tracking for Long Operations
- Rate Limiting for Large Operations
- Detailed Error Logging and Monitoring

## 📋 Requirements

- PHP 7.4 or higher
- WordPress 5.6 or higher
- SSH/SFTP access to remote environments
- MySQL/MariaDB database
- PHP Extensions:
  - ZIP
  - OpenSSL
  - JSON
  - PDO
  - MySQLi

## 🔧 Installation

### Prerequisites
1. Ensure your server meets all requirements
2. Install Composer (https://getcomposer.org)
3. WordPress admin access

### Installation Methods

#### Method 1: Automatic Installation
1. Download the latest release
2. Upload to `/wp-content/plugins/`
3. Navigate to plugin directory:
   ```bash
   cd wp-content/plugins/wp-local-sync
   ```
4. Run installation script:
   ```bash
   chmod +x install.sh
   ./install.sh
   ```
5. Activate through WordPress admin

#### Method 2: Manual Installation
1. Clone the repository:
   ```bash
   cd wp-content/plugins
   git clone [repository-url] wp-local-sync
   cd wp-local-sync
   ```
2. Install dependencies:
   ```bash
   composer install --no-dev
   ```
3. Set permissions:
   ```bash
   chmod 755 .
   find . -type f -exec chmod 644 {} \;
   find . -type d -exec chmod 755 {} \;
   ```
4. Activate through WordPress admin

#### Method 3: Composer Installation
```bash
composer require wp-local-sync/wp-local-sync
```

## ⚙️ Configuration

### Initial Setup
1. Navigate to WordPress Admin → WP Local Sync
2. Configure environment settings:
   - SSH/SFTP credentials
   - Application passwords
   - Backup settings
   - Rate limiting options

### Environment Configuration
```php
// Example environment configuration
[
    'name' => 'Staging',
    'host' => 'staging.example.com',
    'ssh_user' => 'deploy',
    'ssh_key_path' => '/path/to/private/key',
    'sftp_port' => 22,
    'is_current' => false
]
```

## 🔒 Security

- Encrypted password storage
- SSH key authentication support
- WordPress application passwords integration
- Rate limiting protection
- Secure file permissions
- Protected backup directories
- Sanitized inputs and validated data

## 🛠️ Development

### Setup Development Environment
1. Clone repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Run tests:
   ```bash
   composer test
   ```

### Running Tests
```bash
# Run all tests
composer test

# Run with coverage report
composer test-coverage

# Run specific test file
./vendor/bin/phpunit tests/EnvironmentManagerTest.php
```

## 📝 API Documentation

### REST API Endpoints

#### Get Environments
```http
GET /wp-json/wp-local-sync/v1/environments
```

#### Add Environment
```http
POST /wp-json/wp-local-sync/v1/environments
```

#### Create Backup
```http
POST /wp-json/wp-local-sync/v1/backup
```

#### Transfer Backup
```http
POST /wp-json/wp-local-sync/v1/backups/transfer/{backup_id}
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

### Coding Standards
- Follow WordPress Coding Standards
- Run PHPCS before committing
- Include tests for new features
- Update documentation

## 📄 Error Handling

Errors are logged to `/wp-content/wls-logs/error.log`

Example log format:
```log
[2024-03-21 10:15:30] ERROR: Failed to connect to SFTP server {"host":"example.com","error":"Connection refused"}
```

## 🔍 Debugging

Enable debug mode in wp-config.php:
```php
define('WLS_DEBUG', true);
```

## 📦 Directory Structure

```
wp-local-sync/
├── assets/
│   ├── css/
│   └── js/
├── includes/
│   ├── class-environment-manager.php
│   ├── class-backup-manager.php
│   ├── class-error-handler.php
│   ├── class-rate-limiter.php
│   └── class-input-validator.php
├── templates/
│   └── admin-page.php
├── tests/
├── vendor/
├── composer.json
├── install.sh
├── README.md
└── wp-local-sync.php
```

## 📝 License

This project is licensed under the GPL v2 or later - see the [LICENSE](LICENSE) file for details

## 👥 Authors

* **Your Name** - *Initial work* - [YourGithub](https://github.com/yourusername)

## 🙏 Acknowledgments

* WordPress Plugin Development Team
* Contributors & Testers
* Open Source Community

## 📞 Support

1. Check [Documentation](https://your-docs-url.com)
2. Search [Issues](https://github.com/your-repo/wp-local-sync/issues)
3. Create new issue if needed

## 🔄 Changelog

### [1.0.0] - 2024-03-21
- Initial release
- Environment management
- Backup functionality
- SFTP/SSH transfer
- Rate limiting
- Error logging

### [1.1.0] - 2024-03-22
- Added backup rotation
- Improved error handling
- Enhanced security features
- Added rate limiting
- Input validation improvements

## 🗺️ Roadmap

- [ ] Multi-site support
- [ ] Database search and replace
- [ ] Automated deployment workflows
- [ ] Cloud storage integration
- [ ] CLI commands
