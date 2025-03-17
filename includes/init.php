<?php
/**
 * MMS - Marine Management System
 * Core Initialization File
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base constants
define('MMS_ROOT_DIR', dirname(__DIR__));
define('MMS_INCLUDES_DIR', MMS_ROOT_DIR . '/includes');
define('MMS_ADMIN_DIR', MMS_ROOT_DIR . '/admin');
define('MMS_ASSETS_DIR', MMS_ROOT_DIR . '/assets');
define('MMS_UPLOADS_DIR', MMS_ROOT_DIR . '/uploads');

// Include database configuration
require_once MMS_ROOT_DIR . '/config/database.php';  // Veritabanı bağlantısı etkinleştirildi

// Include core functions
require_once MMS_INCLUDES_DIR . '/functions.php';
require_once MMS_INCLUDES_DIR . '/content-loader.php';
require_once MMS_INCLUDES_DIR . '/languages.php';

// Set default timezone
date_default_timezone_set('Europe/Istanbul');

// Error reporting (adjust for production)
if (is_development_environment()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

/**
 * Check if the current environment is development
 * 
 * @return bool
 */
function is_development_environment() {
    $dev_hosts = ['localhost', '127.0.0.1', '::1'];
    return in_array($_SERVER['SERVER_NAME'], $dev_hosts);
}

/**
 * Redirect to a specified URL
 * 
 * @param string $url The URL to redirect to
 * @return void
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Sanitize user input
 * 
 * @param string $input The input to sanitize
 * @return string Sanitized input
 */
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Check if admin is logged in
 * 
 * @return bool
 */
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Validate admin login credentials
 * 
 * @param string $username The username
 * @param string $password The password
 * @return bool
 */
function validate_admin_login($username, $password) {
    global $db;
    
    try {
        // In a real implementation, this would check the database
        // For this example, we'll use a hardcoded admin account
        $admin_username = 'admin';
        $admin_password_hash = password_hash('admin123', PASSWORD_DEFAULT);
        
        if ($username === $admin_username && password_verify($password, $admin_password_hash)) {
            return true;
        }
        
        return false;
    } catch (Exception $e) {
        error_log('Login validation error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Get current admin user information
 * 
 * @return array User information
 */
function get_admin_user() {
    if (!is_admin_logged_in()) {
        return [];
    }
    
    // In a real implementation, this would fetch from the database
    return [
        'username' => $_SESSION['admin_username'] ?? 'admin',
        'full_name' => 'Administrator',
        'email' => 'admin@marinemanagementsystem.com',
        'role' => 'Administrator'
    ];
}

/**
 * Get the title for the current admin page
 * 
 * @return string Page title
 */
function get_page_title() {
    $current_page = basename($_SERVER['PHP_SELF']);
    
    $titles = [
        'dashboard.php' => 'Dashboard',
        'content-editor.php' => 'Content Management',
        'demo-requests.php' => 'Demo Requests',
        'demo-request.php' => 'Demo Request Details',
        'contact-messages.php' => 'Contact Messages',
        'message.php' => 'Message Details',
        'settings.php' => 'Site Settings',
        'users.php' => 'User Management',
        'profile.php' => 'My Profile'
    ];
    
    return $titles[$current_page] ?? 'Admin Panel';
}

/**
 * Get unread notifications count
 * 
 * @return int Count of unread notifications
 */
function get_unread_notifications_count() {
    // In a real implementation, this would fetch from the database
    return 3;
}

/**
 * Get recent notifications
 * 
 * @param int $limit Number of notifications to fetch
 * @return array List of notifications
 */
function get_recent_notifications($limit = 5) {
    // In a real implementation, this would fetch from the database
    return [
        [
            'id' => 1,
            'title' => 'New Demo Request',
            'message' => 'A new demo request has been submitted.',
            'icon' => 'fas fa-tasks',
            'link' => 'demo-requests.php',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
        ],
        [
            'id' => 2,
            'title' => 'New Contact Message',
            'message' => 'You have received a new contact message.',
            'icon' => 'fas fa-envelope',
            'link' => 'contact-messages.php',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
        ],
        [
            'id' => 3,
            'title' => 'System Update',
            'message' => 'System has been updated to version 1.0.1',
            'icon' => 'fas fa-sync',
            'link' => 'settings.php',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ]
    ];
}

/**
 * Get count of demo requests
 * 
 * @return int Count of demo requests
 */
function get_demo_requests_count() {
    // In a real implementation, this would fetch from the database
    return 15;
}

/**
 * Get count of contact submissions
 * 
 * @return int Count of contact submissions
 */
function get_contact_submissions_count() {
    // In a real implementation, this would fetch from the database
    return 28;
}

/**
 * Get count of site visits
 * 
 * @param string $period Period to count (today, week, month)
 * @return int Count of visits
 */
function get_visits_count($period = 'today') {
    // In a real implementation, this would fetch from the database
    $counts = [
        'today' => 85,
        'week' => 542,
        'month' => 2375
    ];
    
    return $counts[$period] ?? 0;
}

/**
 * Get recent demo requests
 * 
 * @param int $limit Number of requests to fetch
 * @return array List of demo requests
 */
function get_recent_demo_requests($limit = 5) {
    // In a real implementation, this would fetch from the database
    return [
        [
            'id' => 5,
            'name' => 'Ahmet',
            'surname' => 'Yılmaz',
            'email' => 'ahmet@example.com',
            'phone' => '+90 555 123 4567',
            'message' => 'I would like to request a demo for our shipyard.',
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
        ],
        [
            'id' => 4,
            'name' => 'Mehmet',
            'surname' => 'Kaya',
            'email' => 'mehmet@example.com',
            'phone' => '+90 555 987 6543',
            'message' => 'Interested in MMS for our new shipbuilding project.',
            'status' => 'contacted',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        [
            'id' => 3,
            'name' => 'Zeynep',
            'surname' => 'Demir',
            'email' => 'zeynep@example.com',
            'phone' => '+90 555 456 7890',
            'message' => 'Need information about MMS Yacht software.',
            'status' => 'completed',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ]
    ];
}

/**
 * Get recent contact messages
 * 
 * @param int $limit Number of messages to fetch
 * @return array List of contact messages
 */
function get_recent_contact_messages($limit = 5) {
    // In a real implementation, this would fetch from the database
    return [
        [
            'id' => 8,
            'name' => 'Ali Can',
            'email' => 'alican@example.com',
            'phone' => '+90 555 222 3333',
            'message' => 'I have a question about integration with our existing systems.',
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
        ],
        [
            'id' => 7,
            'name' => 'Ayşe Şahin',
            'email' => 'ayse@example.com',
            'phone' => '+90 555 444 5555',
            'message' => 'Please provide more information about your pricing models.',
            'status' => 'read',
            'created_at' => date('Y-m-d H:i:s', strtotime('-5 hours'))
        ],
        [
            'id' => 6,
            'name' => 'Mustafa Öztürk',
            'email' => 'mustafa@example.com',
            'phone' => '+90 555 666 7777',
            'message' => 'We are interested in implementing MMS in our shipyard.',
            'status' => 'replied',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ]
    ];
}

/**
 * Get MySQL version
 * 
 * @return string MySQL version
 */
function get_mysql_version() {
    global $db;
    
    try {
        // For demonstration purposes only
        return '8.0.28';
    } catch (Exception $e) {
        return 'Unknown';
    }
}

/**
 * Handle demo request submission
 * 
 * @param array $data Form data
 * @return bool Success status
 */
function handle_demo_request($data) {
    // In a real implementation, this would save to the database
    // and send email notifications
    
    // Log the request for demonstration purposes
    error_log('Demo request received: ' . json_encode($data));
    
    return true;
}

/**
 * Handle contact form submission
 * 
 * @param array $data Form data
 * @return bool Success status
 */
function handle_contact_form($data) {
    // In a real implementation, this would save to the database
    // and send email notifications
    
    // Log the message for demonstration purposes
    error_log('Contact form submitted: ' . json_encode($data));
    
    return true;
}
