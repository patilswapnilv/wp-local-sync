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
  - ZIP (`php-zip`)
  - OpenSSL (`php-openssl`)
  - JSON (`php-json`)
  - PDO (`php-pdo`)
  - MySQLi (`php-mysqli`)

## 🔧 Quick Start Guide

1. **Download and Install**
   ```bash
   cd wp-content/plugins/
   git clone https://github.com/yourusername/wp-local-sync.git
   cd wp-local-sync
   ```

2. **Install Dependencies**
   ```bash
   composer install --no-dev
   ```

3. **Set Permissions**
   ```bash
   chmod 755 .
   find . -type f -exec chmod 644 {} \;
   find . -type d -exec chmod 755 {} \;
   ```

4. **Activate Plugin**
   - Go to WordPress Admin → Plugins
   - Find "WP Local Sync"
   - Click "Activate"

5. **Initial Configuration**
   - Go to WordPress Admin → WP Local Sync
   - Add your first environment
   - Configure backup settings

## ⚙️ Configuration

### Environment Setup
1. Navigate to: WordPress Admin → WP Local Sync → Add Environment
2. Required fields:
   - Environment Name (e.g., "Local", "Staging")
   - Host (e.g., "staging.example.com")
   - SSH User
   - SSH Key Path or Password

Example configuration:
```php
[
'name' => 'Staging',
'host' => 'staging.example.com',
'ssh_user' => 'deploy',
'ssh_key_path' => '/home/user/.ssh/id_rsa',
'sftp_port' => 22,
'is_current' => false
]
```


### Backup Settings
- Maximum backup size: 500MB (configurable)
- Backup retention: 30 days
- Maximum backups: 10 per environment

## 📝 API Usage

### Authentication
All API requests require WordPress authentication. Use Application Passwords:
1. Go to WordPress Admin → Users → Profile
2. Scroll to Application Passwords
3. Generate new password for "WP Local Sync"

### API Endpoints

#### List Environments
```http
GET /wp-json/wp-local-sync/v1/environments
Authorization: Basic base64(username:app_password)
```

Response:

```json
[
    { "id": 1, "name": "Local", "host": "localhost", "ssh_user": "root", "ssh_key_path": null, "sftp_port": 22, "is_current": true }
]
```

#### Create Backup
```http
POST /wp-json/wp-local-sync/v1/backups
Authorization: Basic base64(username:app_password)
Content-Type: application/json
```

Request body:
```json
{
    "environment_id": 1,
    "backup_type": "full"
}
```
Response:
```json
{
"success": true,
"backup_id": 123,
"filename": "backup-2024-03-22-123456.zip"
}

```

## 🔍 Debugging

1. Enable debug mode in wp-config.php:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('WLS_DEBUG', true);
   ```

2. Check logs:
   - WordPress debug log: `/wp-content/debug.log`
   - Plugin error log: `/wp-content/wls-logs/error.log`

## 📦 Directory Structure
```
wp-local-sync/
├── assets/
│ ├── css/
│ │ └── admin.css
│ └── js/
│ └── admin.js
├── includes/
│ ├── class-environment-manager.php
│ ├── class-backup-manager.php
│ ├── class-error-handler.php
│ ├── class-rate-limiter.php
│ └── class-input-validator.php
├── templates/
│ └── admin-page.php
├── tests/
│ ├── TestCase.php
│ ├── EnvironmentManagerTest.php
│ └── BackupManagerTest.php
├── vendor/
├── composer.json
├── install.sh
├── README.md
└── wp-local-sync.php
```

## 🔄 Version History

### [0.1.0] - 2024-03-22
- Initial beta release
- Basic environment management
- Backup functionality
- SFTP/SSH transfer
- Rate limiting
- Error logging

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

### Development Setup
1. Clone repository
2. Install all dependencies:
   ```bash
   composer install
   ```
3. Run tests:
   ```bash
   composer test
   ```

## 📞 Support

1. Check [Documentation](https://github.com/yourusername/wp-local-sync/wiki)
2. Search [Issues](https://github.com/yourusername/wp-local-sync/issues)
3. Create new issue with:
   - WordPress version
   - PHP version
   - Error logs
   - Steps to reproduce

## 📝 License

This project is licensed under the GPL v2 or later - see the [LICENSE](LICENSE) file for details

## 🙏 Acknowledgments

* WordPress Plugin Development Team
* Contributors & Testers
* Open Source Community
