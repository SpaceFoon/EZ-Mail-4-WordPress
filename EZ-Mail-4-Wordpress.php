<?php
/**
 * Plugin Name: EZ-Mail-4-Wordpress
 * Description: Configure email settings to use multiple PrivateEmail.com mailboxes with a settings page for customization.
 * Version: 1.3
 * Author: SpaceFoon
 */

// Add menu item for settings page
add_action('admin_menu', 'privateemail_add_settings_page');
function privateemail_add_settings_page() {
    add_options_page(
        'PrivateEmail Settings',
        'PrivateEmail Mail Config',
        'manage_options',
        'privateemail-mail-config',
        'privateemail_settings_page'
    );
}

// Display the settings page
function privateemail_settings_page() {
    ?>
    <div class="wrap">
        <h1>PrivateEmail Mailbox Configuration</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('privateemail_mail_config_group');
            do_settings_sections('privateemail-mail-config');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action('admin_init', 'privateemail_register_settings');
function privateemail_register_settings() {
    // SMTP fields
    register_setting('privateemail_mail_config_group', 'privateemail_smtp_host');
    register_setting('privateemail_mail_config_group', 'privateemail_smtp_port');
    register_setting('privateemail_mail_config_group', 'privateemail_smtp_encryption');
    register_setting('privateemail_mail_config_group', 'privateemail_smtp_username');
    register_setting('privateemail_mail_config_group', 'privateemail_smtp_password');

    // Mailbox fields
    register_setting('privateemail_mail_config_group', 'privateemail_support_mailbox');
    register_setting('privateemail_mail_config_group', 'privateemail_forum_mailbox');
    register_setting('privateemail_mail_config_group', 'privateemail_accounts_mailbox');
    register_setting('privateemail_mail_config_group', 'privateemail_admin_mailbox');
    register_setting('privateemail_mail_config_group', 'privateemail_default_mailbox');

    add_settings_section('privateemail_mail_config_section', 'SMTP Settings', null, 'privateemail-mail-config');

    // SMTP settings fields
    add_settings_field('smtp_host', 'SMTP Host', 'privateemail_smtp_host_callback', 'privateemail-mail-config', 'privateemail_mail_config_section');
    add_settings_field('smtp_port', 'SMTP Port', 'privateemail_smtp_port_callback', 'privateemail-mail-config', 'privateemail_mail_config_section');
    add_settings_field('smtp_encryption', 'SMTP Encryption (tls/ssl)', 'privateemail_smtp_encryption_callback', 'privateemail-mail-config', 'privateemail_mail_config_section');
    add_settings_field('smtp_username', 'SMTP Username', 'privateemail_smtp_username_callback', 'privateemail-mail-config', 'privateemail_mail_config_section');
    add_settings_field('smtp_password', 'SMTP Password', 'privateemail_smtp_password_callback', 'privateemail-mail-config', 'privateemail_mail_config_section');

    // Mailbox settings fields
    add_settings_section('privateemail_mailboxes_section', 'Mailbox Assignment', null, 'privateemail-mail-config');
    add_settings_field('support_mailbox', 'Support Mailbox (WooCommerce Orders)', 'privateemail_support_mailbox_callback', 'privateemail-mail-config', 'privateemail_mailboxes_section');
    add_settings_field('forum_mailbox', 'Forum Mailbox (BuddyPress Notifications)', 'privateemail_forum_mailbox_callback', 'privateemail-mail-config', 'privateemail_mailboxes_section');
    add_settings_field('accounts_mailbox', 'Accounts Mailbox (Account-related Emails)', 'privateemail_accounts_mailbox_callback', 'privateemail-mail-config', 'privateemail_mailboxes_section');
    add_settings_field('admin_mailbox', 'Admin Mailbox (Admin-related Emails)', 'privateemail_admin_mailbox_callback', 'privateemail-mail-config', 'privateemail_mailboxes_section');
    add_settings_field('default_mailbox', 'Default Mailbox (General Emails)', 'privateemail_default_mailbox_callback', 'privateemail-mail-config', 'privateemail_mailboxes_section');
}

// Callbacks for settings fields
function privateemail_smtp_host_callback() {
    echo '<input type="text" name="privateemail_smtp_host" value="' . esc_attr(get_option('privateemail_smtp_host', 'mail.privateemail.com')) . '" />';
}
function privateemail_smtp_port_callback() {
    echo '<input type="text" name="privateemail_smtp_port" value="' . esc_attr(get_option('privateemail_smtp_port', '587')) . '" />';
}
function privateemail_smtp_encryption_callback() {
    echo '<input type="text" name="privateemail_smtp_encryption" value="' . esc_attr(get_option('privateemail_smtp_encryption', 'tls')) . '" />';
}
function privateemail_smtp_username_callback() {
    echo '<input type="text" name="privateemail_smtp_username" value="' . esc_attr(get_option('privateemail_smtp_username')) . '" />';
}
function privateemail_smtp_password_callback() {
    echo '<input type="password" name="privateemail_smtp_password" value="' . esc_attr(get_option('privateemail_smtp_password')) . '" />';
}

function privateemail_support_mailbox_callback() {
    echo '<input type="text" name="privateemail_support_mailbox" value="' . esc_attr(get_option('privateemail_support_mailbox', 'support@yourdomain.com')) . '" />';
}
function privateemail_forum_mailbox_callback() {
    echo '<input type="text" name="privateemail_forum_mailbox" value="' . esc_attr(get_option('privateemail_forum_mailbox', 'forum@yourdomain.com')) . '" />';
}
function privateemail_accounts_mailbox_callback() {
    echo '<input type="text" name="privateemail_accounts_mailbox" value="' . esc_attr(get_option('privateemail_accounts_mailbox', 'accounts@yourdomain.com')) . '" />';
}
function privateemail_admin_mailbox_callback() {
    echo '<input type="text" name="privateemail_admin_mailbox" value="' . esc_attr(get_option('privateemail_admin_mailbox', 'admin@yourdomain.com')) . '" />';
}
function privateemail_default_mailbox_callback() {
    echo '<input type="text" name="privateemail_default_mailbox" value="' . esc_attr(get_option('privateemail_default_mailbox', 'your-name@yourdomain.com')) . '" />';
}

// Hook into PHPMailer
add_action('phpmailer_init', 'set_privateemail_smtp');
function set_privateemail_smtp($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = get_option('privateemail_smtp_host', 'mail.privateemail.com');
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = get_option('privateemail_smtp_port', '587');
    $phpmailer->Username = get_option('privateemail_smtp_username');
    $phpmailer->Password = get_option('privateemail_smtp_password');
    $phpmailer->SMTPSecure = get_option('privateemail_smtp_encryption', 'tls');

    // Switch based on subject/context
    if (strpos($phpmailer->Subject, 'Order') !== false) {
        $phpmailer->From = get_option('privateemail_support_mailbox', 'support@yourdomain.com');
        $phpmailer->FromName = 'Support Team';
        $phpmailer->addReplyTo(get_option('privateemail_support_mailbox', 'support@yourdomain.com'));
    } elseif (strpos($phpmailer->Subject, 'New Message') !== false) {
        $phpmailer->From = get_option('privateemail_forum_mailbox', 'forum@yourdomain.com');
        $phpmailer->FromName = 'Forum Notifications';
        $phpmailer->addReplyTo(get_option('privateemail_forum_mailbox', 'forum@yourdomain.com'));
    } elseif (strpos($phpmailer->Subject, 'New Account') !== false) {
        $phpmailer->From = get_option('privateemail_accounts_mailbox', 'accounts@yourdomain.com');
        $phpmailer->FromName = 'Accounts Team';
        $phpmailer->addReplyTo(get_option('privateemail_accounts_mailbox', 'accounts@yourdomain.com'));
    } elseif (strpos($phpmailer->Subject, 'Admin') !== false) {
        $phpmailer->From = get_option('privateemail_admin_mailbox', 'admin@yourdomain.com');
        $phpmailer->FromName = 'Admin';
        $phpmailer->addReplyTo(get_option('privateemail_admin_mailbox', 'admin@yourdomain.com'));
    } else {
        $phpmailer->From = get_option('privateemail_default_mailbox', 'your-name@yourdomain.com');
        $phpmailer->FromName = 'Your Name';
        $phpmailer->addReplyTo(get_option('privateemail_default_mailbox', 'your-name@yourdomain.com'));
    }

    $phpmailer->isHTML(true);
}
?>
