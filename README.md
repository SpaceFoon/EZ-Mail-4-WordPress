# EZ-Mail-4-WordPress

A powerful WordPress plugin for configuring multiple PrivateEmail mailboxes with intelligent email routing based on content type.

## Features

- **SMTP Configuration**
  - Easy setup with PrivateEmail.com mail servers
  - Secure credential management
  - TLS/SSL encryption support
  - Configurable ports and authentication

- **Multi-Mailbox Management**
  - Support mailbox for order communications
  - Forum notifications mailbox
  - Account management mailbox
  - Administrative communications mailbox
  - Default mailbox for general emails

- **Intelligent Email Routing**
  - Automatic sender selection based on email content
  - Order emails route through support mailbox
  - Forum notifications use dedicated forum email
  - Account-related emails use accounts mailbox
  - Admin communications use admin mailbox
  - All other emails default to general mailbox

## Installation

1. Download the plugin ZIP file
2. Go to WordPress admin panel > Plugins > Add New
3. Click "Upload Plugin" and select the downloaded ZIP
4. Click "Install Now"
5. After installation, click "Activate"

## Configuration

1. Navigate to Settings > PrivateEmail Mail Config
2. Configure SMTP Settings:
   - Host: mail.privateemail.com (default)
   - Port: 587 (default)
   - Encryption: TLS (default)
   - Username: Your PrivateEmail username
   - Password: Your PrivateEmail password

3. Configure Mailboxes:
   - Support: support@yourdomain.com
   - Forum: forum@yourdomain.com
   - Accounts: accounts@yourdomain.com
   - Admin: admin@yourdomain.com
   - Default: your-name@yourdomain.com

## Usage

Once configured, the plugin automatically handles email routing based on content:

- WooCommerce order emails → Support mailbox
- BuddyPress notifications → Forum mailbox
- Account-related emails → Accounts mailbox
- Administrative emails → Admin mailbox
- General communications → Default mailbox

No additional configuration needed - emails are automatically routed based on their subject line and content.

## Requirements

- WordPress 5.0 or higher
- PHP 7.2 or higher
- PrivateEmail.com email account

## Support

For issues, questions, or feature requests, please open an issue on our GitHub repository.

## License

This plugin is licensed under the GPL v2 or later.

```
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
