<?php
/**
 * MMS - Marine Management System
 * Settings Page
 */

// Initialize the application
require_once '../includes/init.php';

// Check if user is logged in
if (!is_admin_logged_in()) {
    redirect('index.php');
}

// Handle form submission
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_general_settings'])) {
        // Update general settings
        $settings = [
            'site_title' => sanitize_input($_POST['site_title']),
            'site_description' => sanitize_input($_POST['site_description']),
            'contact_email' => sanitize_input($_POST['contact_email']),
            'contact_phone' => sanitize_input($_POST['contact_phone']),
            'address' => sanitize_input($_POST['address']),
            'social_instagram' => sanitize_input($_POST['social_instagram']),
            'social_facebook' => sanitize_input($_POST['social_facebook']),
            'social_linkedin' => sanitize_input($_POST['social_linkedin']),
            'social_whatsapp' => sanitize_input($_POST['social_whatsapp'])
        ];
        
        if (update_settings($settings)) {
            $message = 'General settings updated successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error updating settings. Please try again.';
            $message_type = 'error';
        }
    } elseif (isset($_POST['update_email_settings'])) {
        // Update email settings
        $settings = [
            'smtp_host' => sanitize_input($_POST['smtp_host']),
            'smtp_port' => sanitize_input($_POST['smtp_port']),
            'smtp_user' => sanitize_input($_POST['smtp_user']),
            'smtp_pass' => sanitize_input($_POST['smtp_pass']),
            'mail_from_name' => sanitize_input($_POST['mail_from_name']),
            'mail_from_email' => sanitize_input($_POST['mail_from_email']),
            'admin_notification_email' => sanitize_input($_POST['admin_notification_email'])
        ];
        
        if (update_settings($settings)) {
            $message = 'Email settings updated successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error updating email settings. Please try again.';
            $message_type = 'error';
        }
    } elseif (isset($_POST['update_seo_settings'])) {
        // Update SEO settings
        $settings = [
            'meta_keywords' => sanitize_input($_POST['meta_keywords']),
            'google_analytics_id' => sanitize_input($_POST['google_analytics_id']),
            'google_tag_manager_id' => sanitize_input($_POST['google_tag_manager_id']),
            'enable_social_meta' => isset($_POST['enable_social_meta']) ? 1 : 0
        ];
        
        if (update_settings($settings)) {
            $message = 'SEO settings updated successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error updating SEO settings. Please try again.';
            $message_type = 'error';
        }
    } elseif (isset($_POST['update_logo'])) {
        // Handle logo upload
        if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
            $logo_result = upload_logo($_FILES['site_logo']);
            
            if ($logo_result['success']) {
                $message = 'Logo updated successfully!';
                $message_type = 'success';
            } else {
                $message = 'Error updating logo: ' . $logo_result['message'];
                $message_type = 'error';
            }
        } else {
            $message = 'Please select a logo file to upload.';
            $message_type = 'error';
        }
    }
}

// Get current settings
$settings = get_all_settings();

// Include header
include_once 'includes/header.php';
?>

<!-- Main Content -->
<div class="admin-content">
    <div class="content-header">
        <h1 class="page-title">Site Settings</h1>
        
        <div class="content-actions">
            <a href="dashboard.php" class="outline-btn">
                <i class="fas fa-arrow-left btn-icon"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
    
    <?php if (!empty($message)): ?>
    <div class="alert <?php echo $message_type; ?>">
        <i class="fas fa-<?php echo $message_type === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
        <?php echo $message; ?>
        <button class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php endif; ?>
    
    <div class="settings-container">
        <div class="settings-sidebar">
            <ul class="settings-nav">
                <li><a href="#general-settings" class="active">General Settings</a></li>
                <li><a href="#email-settings">Email Settings</a></li>
                <li><a href="#logo-settings">Logo & Branding</a></li>
                <li><a href="#seo-settings">SEO Settings</a></li>
                <li><a href="#security-settings">Security</a></li>
                <li><a href="#backup-settings">Backup & Restore</a></li>
            </ul>
        </div>
        
        <div class="settings-content">
            <!-- General Settings -->
            <div id="general-settings" class="settings-section active">
                <h2 class="settings-title">General Settings</h2>
                
                <form action="" method="post" data-validate>
                    <div class="settings-group">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="site_title">Site Title</label>
                                <input type="text" id="site_title" name="site_title" value="<?php echo $settings['site_title'] ?? 'Marine Management System'; ?>" required>
                                <small>The title of your website, displayed in browser tabs and search results.</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="site_description">Site Description</label>
                                <textarea id="site_description" name="site_description" rows="3"><?php echo $settings['site_description'] ?? 'Innovative ERP solutions for the shipbuilding industry.'; ?></textarea>
                                <small>A brief description of your website, used for SEO and meta tags.</small>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_email">Contact Email</label>
                                <input type="email" id="contact_email" name="contact_email" value="<?php echo $settings['contact_email'] ?? 'info@marinemanagementsystem.com'; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_phone">Contact Phone</label>
                                <input type="text" id="contact_phone" name="contact_phone" value="<?php echo $settings['contact_phone'] ?? '+90 507 574 2666'; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="2"><?php echo $settings['address'] ?? 'Bilişim Vadisi - Kocaeli'; ?></textarea>
                        </div>
                        
                        <h3 class="settings-subtitle">Social Media Links</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="social_instagram">Instagram</label>
                                <input type="text" id="social_instagram" name="social_instagram" value="<?php echo $settings['social_instagram'] ?? 'https://www.instagram.com/marinemanagementsystem/'; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="social_linkedin">LinkedIn</label>
                                <input type="text" id="social_linkedin" name="social_linkedin" value="<?php echo $settings['social_linkedin'] ?? 'https://www.linkedin.com/company/mms-erp'; ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="social_facebook">Facebook</label>
                                <input type="text" id="social_facebook" name="social_facebook" value="<?php echo $settings['social_facebook'] ?? 'https://www.facebook.com/profile.php?id=61560348505866'; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="social_whatsapp">WhatsApp</label>
                                <input type="text" id="social_whatsapp" name="social_whatsapp" value="<?php echo $settings['social_whatsapp'] ?? 'https://wa.me/+905075742666'; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="update_general_settings" class="primary-btn">
                            <i class="fas fa-save btn-icon"></i>
                            Save General Settings
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Email Settings -->
            <div id="email-settings" class="settings-section">
                <h2 class="settings-title">Email Settings</h2>
                
                <form action="" method="post" data-validate>
                    <div class="settings-group">
                        <h3 class="settings-subtitle">SMTP Configuration</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="smtp_host">SMTP Host</label>
                                <input type="text" id="smtp_host" name="smtp_host" value="<?php echo $settings['smtp_host'] ?? 'smtp.example.com'; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtp_port">SMTP Port</label>
                                <input type="text" id="smtp_port" name="smtp_port" value="<?php echo $settings['smtp_port'] ?? '587'; ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="smtp_user">SMTP Username</label>
                                <input type="text" id="smtp_user" name="smtp_user" value="<?php echo $settings['smtp_user'] ?? ''; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtp_pass">SMTP Password</label>
                                <input type="password" id="smtp_pass" name="smtp_pass" value="<?php echo $settings['smtp_pass'] ?? ''; ?>">
                            </div>
                        </div>
                        
                        <h3 class="settings-subtitle">Email Identities</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="mail_from_name">From Name</label>
                                <input type="text" id="mail_from_name" name="mail_from_name" value="<?php echo $settings['mail_from_name'] ?? 'Marine Management System'; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="mail_from_email">From Email</label>
                                <input type="email" id="mail_from_email" name="mail_from_email" value="<?php echo $settings['mail_from_email'] ?? 'no-reply@marinemanagementsystem.com'; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="admin_notification_email">Admin Notification Email</label>
                            <input type="email" id="admin_notification_email" name="admin_notification_email" value="<?php echo $settings['admin_notification_email'] ?? 'admin@marinemanagementsystem.com'; ?>">
                            <small>Email where admin notifications will be sent (demo requests, contact forms, etc.)</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="button" class="outline-btn" onclick="testEmailSettings()">
                                <i class="fas fa-paper-plane btn-icon"></i>
                                Test Email Settings
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="update_email_settings" class="primary-btn">
                            <i class="fas fa-save btn-icon"></i>
                            Save Email Settings
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Logo Settings -->
            <div id="logo-settings" class="settings-section">
                <h2 class="settings-title">Logo & Branding</h2>
                
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="settings-group">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Current Logo</label>
                                <div class="current-logo">
                                    <img src="../assets/images/logo.png" alt="Current Logo">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="site_logo">Upload New Logo</label>
                                <div class="file-upload">
                                    <input type="file" id="site_logo" name="site_logo" accept="image/png, image/jpeg, image/svg+xml">
                                    <label for="site_logo" class="upload-btn">
                                        <i class="fas fa-upload"></i>
                                        Choose File
                                    </label>
                                    <span class="file-name">No file chosen</span>
                                </div>
                                <small>Recommended size: 200x80px. Supported formats: PNG, JPG, SVG.</small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Preview</label>
                            <div class="logo-preview">
                                <div class="preview-light">
                                    <h4>Light Background</h4>
                                    <div class="preview-box light">
                                        <img src="../assets/images/logo.png" alt="Logo Preview" id="logoPreviewLight">
                                    </div>
                                </div>
                                
                                <div class="preview-dark">
                                    <h4>Dark Background</h4>
                                    <div class="preview-box dark">
                                        <img src="../assets/images/logo.png" alt="Logo Preview" id="logoPreviewDark">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="update_logo" class="primary-btn">
                            <i class="fas fa-save btn-icon"></i>
                            Save Logo
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- SEO Settings -->
            <div id="seo-settings" class="settings-section">
                <h2 class="settings-title">SEO Settings</h2>
                
                <form action="" method="post" data-validate>
                    <div class="settings-group">
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <textarea id="meta_keywords" name="meta_keywords" rows="3"><?php echo $settings['meta_keywords'] ?? 'Marine Management System, MMS, ERP, Shipbuilding, Ship Repair, Yacht Building, Maritime ERP, Tersane, Gemi İnşa'; ?></textarea>
                            <small>Comma-separated keywords for SEO (less important nowadays but still used by some search engines).</small>
                        </div>
                        
                        <h3 class="settings-subtitle">Analytics Integration</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="google_analytics_id">Google Analytics ID</label>
                                <input type="text" id="google_analytics_id" name="google_analytics_id" value="<?php echo $settings['google_analytics_id'] ?? ''; ?>" placeholder="UA-XXXXXXXX-X or G-XXXXXXXXXX">
                            </div>
                            
                            <div class="form-group">
                                <label for="google_tag_manager_id">Google Tag Manager ID</label>
                                <input type="text" id="google_tag_manager_id" name="google_tag_manager_id" value="<?php echo $settings['google_tag_manager_id'] ?? ''; ?>" placeholder="GTM-XXXXXXX">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="enable_social_meta" name="enable_social_meta" <?php echo (isset($settings['enable_social_meta']) && $settings['enable_social_meta']) ? 'checked' : ''; ?>>
                                <label for="enable_social_meta">Enable Social Media Meta Tags</label>
                            </div>
                            <small>Add Open Graph and Twitter Card meta tags for better social media sharing appearance.</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="update_seo_settings" class="primary-btn">
                            <i class="fas fa-save btn-icon"></i>
                            Save SEO Settings
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Security Settings -->
            <div id="security-settings" class="settings-section">
                <h2 class="settings-title">Security Settings</h2>
                
                <div class="settings-group">
                    <h3 class="settings-subtitle">Admin Password</h3>
                    
                    <form action="" method="post" id="password-form" data-validate>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password" required>
                                <small>Use at least 8 characters with a mix of letters, numbers, and symbols.</small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" name="update_password" class="primary-btn">
                                <i class="fas fa-key btn-icon"></i>
                                Change Password
                            </button>
                        </div>
                    </form>
                    
                    <h3 class="settings-subtitle">Security Options</h3>
                    
                    <form action="" method="post" id="security-form">
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="enable_2fa" name="enable_2fa">
                                <label for="enable_2fa">Enable Two-Factor Authentication</label>
                            </div>
                            <small>Add an extra layer of security by requiring a verification code when logging in.</small>
                        </div>
                        
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="enable_login_notifications" name="enable_login_notifications" checked>
                                <label for="enable_login_notifications">Email Notifications for Login Attempts</label>
                            </div>
                            <small>Receive email notifications for successful and failed login attempts.</small>
                        </div>
                        
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="enable_ip_restriction" name="enable_ip_restriction">
                                <label for="enable_ip_restriction">Restrict Admin Access by IP</label>
                            </div>
                            <small>Limit admin login attempts to specific IP addresses.</small>
                        </div>
                        
                        <div class="form-group ip-restriction-settings" style="display: none;">
                            <label for="allowed_ips">Allowed IP Addresses</label>
                            <textarea id="allowed_ips" name="allowed_ips" rows="3" placeholder="One IP address per line"></textarea>
                            <small>Enter one IP address per line. Your current IP: <?php echo $_SERVER['REMOTE_ADDR']; ?></small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" name="update_security_settings" class="primary-btn">
                                <i class="fas fa-shield-alt btn-icon"></i>
                                Save Security Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Backup & Restore -->
            <div id="backup-settings" class="settings-section">
                <h2 class="settings-title">Backup & Restore</h2>
                
                <div class="settings-group">
                    <h3 class="settings-subtitle">Create Backup</h3>
                    
                    <p>Create a backup of your website's database and content. You can download the backup file for safekeeping.</p>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="backup_database" name="backup_database" checked>
                            <label for="backup_database">Include Database</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="backup_files" name="backup_files" checked>
                            <label for="backup_files">Include Files</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="button" class="primary-btn" onclick="createBackup()">
                            <i class="fas fa-download btn-icon"></i>
                            Create Backup
                        </button>
                    </div>
                    
                    <h3 class="settings-subtitle">Restore from Backup</h3>
                    
                    <p>Restore your website from a previously created backup file. This will overwrite your current data.</p>
                    
                    <div class="form-group">
                        <div class="file-upload">
                            <input type="file" id="restore_file" name="restore_file" accept=".zip">
                            <label for="restore_file" class="upload-btn">
                                <i class="fas fa-upload"></i>
                                Choose Backup File
                            </label>
                            <span class="file-name">No file chosen</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="button" class="danger-btn" onclick="confirmRestore()">
                            <i class="fas fa-undo-alt btn-icon"></i>
                            Restore from Backup
                        </button>
                    </div>
                    
                    <h3 class="settings-subtitle">Previous Backups</h3>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Backup Date</th>
                                    <th>File Size</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mar 15, 2025 09:45 AM</td>
                                    <td>8.2 MB</td>
                                    <td>Full Backup</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#" class="action-btn view-btn" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="#" class="action-btn edit-btn" title="Restore">
                                                <i class="fas fa-undo-alt"></i>
                                            </a>
                                            <a href="#" class="action-btn delete-btn" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Feb 28, 2025 02:30 PM</td>
                                    <td>7.9 MB</td>
                                    <td>Full Backup</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#" class="action-btn view-btn" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="#" class="action-btn edit-btn" title="Restore">
                                                <i class="fas fa-undo-alt"></i>
                                            </a>
                                            <a href="#" class="action-btn delete-btn" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Restore Confirmation Modal -->
<div id="restore-confirm-modal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container small-modal">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Restore</h3>
            <button class="modal-close" data-dismiss="modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="confirm-icon warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h4>Warning: This will overwrite your data</h4>
            <p>You are about to restore from a backup. This will overwrite your current database and files. This action cannot be undone.</p>
            <p>Are you sure you want to continue?</p>
            <div class="button-group">
                <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                <button class="danger-btn" id="confirm-restore-btn">Yes, Restore Now</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Settings navigation
    document.addEventListener('DOMContentLoaded', function() {
        const settingsNav = document.querySelectorAll('.settings-nav a');
        const settingsSections = document.querySelectorAll('.settings-section');
        
        settingsNav.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links and sections
                settingsNav.forEach(item => item.classList.remove('active'));
                settingsSections.forEach(section => section.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Show corresponding section
                const targetSection = document.querySelector(this.getAttribute('href'));
                if (targetSection) {
                    targetSection.classList.add('active');
                }
            });
        });
        
        // File input display
        const fileInputs = document.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'No file chosen';
                const fileNameElement = this.nextElementSibling.nextElementSibling;
                
                if (fileNameElement && fileNameElement.classList.contains('file-name')) {
                    fileNameElement.textContent = fileName;
                }
                
                // If this is the logo upload, update preview
                if (this.id === 'site_logo' && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('logoPreviewLight').src = e.target.result;
                        document.getElementById('logoPreviewDark').src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
        
        // IP restriction toggle
        const enableIpRestriction = document.getElementById('enable_ip_restriction');
        const ipRestrictionSettings = document.querySelector('.ip-restriction-settings');
        
        if (enableIpRestriction && ipRestrictionSettings) {
            enableIpRestriction.addEventListener('change', function() {
                ipRestrictionSettings.style.display = this.checked ? 'block' : 'none';
            });
        }
        
        // Password validation
        const passwordForm = document.getElementById('password-form');
        
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    alert('New passwords do not match. Please try again.');
                    return false;
                }
                
                if (newPassword.length < 8) {
                    e.preventDefault();
                    alert('Password must be at least 8 characters long.');
                    return false;
                }
            });
        }
    });
    
    /**
     * Test email settings
     */
    function testEmailSettings() {
        const host = document.getElementById('smtp_host').value;
        const port = document.getElementById('smtp_port').value;
        const user = document.getElementById('smtp_user').value;
        const pass = document.getElementById('smtp_pass').value;
        
        if (!host || !port) {
            alert('Please enter SMTP host and port first.');
            return;
        }
        
        // Show sending indicator
        alert('Sending test email... This is just a simulation in the demo.');
        
        // In a real implementation, this would use AJAX to send a test email
        setTimeout(() => {
            alert('Test email sent successfully!');
        }, 2000);
    }
    
    /**
     * Create backup
     */
    function createBackup() {
        const includeDatabase = document.getElementById('backup_database').checked;
        const includeFiles = document.getElementById('backup_files').checked;
        
        if (!includeDatabase && !includeFiles) {
            alert('Please select at least one backup option.');
            return;
        }
        
        // Show backup progress
        alert('Creating backup... This is just a simulation in the demo.');
        
        // In a real implementation, this would use AJAX to create and download a backup
        setTimeout(() => {
            alert('Backup created successfully!');
            
            // Simulate download
            const link = document.createElement('a');
            link.href = '#';
            link.download = 'mms_backup_' + new Date().toISOString().slice(0, 10) + '.zip';
            link.click();
        }, 2000);
    }
    
    /**
     * Confirm restore
     */
    function confirmRestore() {
        const restoreFile = document.getElementById('restore_file').files[0];
        
        if (!restoreFile) {
            alert('Please select a backup file to restore from.');
            return;
        }
        
        // Show confirmation modal
        const modal = document.getElementById('restore-confirm-modal');
        modal.classList.add('show');
        
        // Handle confirm button
        document.getElementById('confirm-restore-btn').addEventListener('click', function() {
            // Close modal
            modal.classList.remove('show');
            
            // Show restore progress
            alert('Restoring from backup... This is just a simulation in the demo.');
            
            // In a real implementation, this would use AJAX to upload and restore from backup
            setTimeout(() => {
                alert('Restore completed successfully! The page will reload.');
                window.location.reload();
            }, 2000);
        });
    }
</script>

<?php
// Include footer
include_once 'includes/footer.php';
?>