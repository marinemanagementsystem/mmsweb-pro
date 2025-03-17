<?php
/**
 * MMS - Marine Management System
 * Admin Functions
 */

/**
 * Upload logo file
 * 
 * @param array $file The uploaded file data ($_FILES['site_logo'])
 * @return array Result with success status and message
 */
function upload_logo($file) {
    // Define allowed file types
    $allowed_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml'];
    $max_size = 2 * 1024 * 1024; // 2MB
    
    // Check file type
    if (!in_array($file['type'], $allowed_types)) {
        return [
            'success' => false,
            'message' => 'Invalid file type. Only PNG, JPG, and SVG files are allowed.'
        ];
    }
    
    // Check file size
    if ($file['size'] > $max_size) {
        return [
            'success' => false,
            'message' => 'File is too large. Maximum size is 2MB.'
        ];
    }
    
    // Determine destination path
    $upload_dir = MMS_ASSETS_DIR . '/images/';
    $upload_file = $upload_dir . 'logo.png'; // We'll convert and save as PNG for consistency
    
    // Create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Handle different file types
    switch ($file['type']) {
        case 'image/png':
            // For PNG, just move the file
            if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                return [
                    'success' => false,
                    'message' => 'Failed to upload file. Please check directory permissions.'
                ];
            }
            break;
            
        case 'image/jpeg':
        case 'image/jpg':
            // For JPG, convert to PNG
            $image = imagecreatefromjpeg($file['tmp_name']);
            if (!$image) {
                return [
                    'success' => false,
                    'message' => 'Failed to process JPEG image.'
                ];
            }
            
            // Save as PNG
            if (!imagepng($image, $upload_file)) {
                return [
                    'success' => false,
                    'message' => 'Failed to save image. Please check directory permissions.'
                ];
            }
            
            imagedestroy($image);
            break;
            
        case 'image/svg+xml':
            // For SVG, just move the file but rename to .svg
            $svg_file = $upload_dir . 'logo.svg';
            if (!move_uploaded_file($file['tmp_name'], $svg_file)) {
                return [
                    'success' => false,
                    'message' => 'Failed to upload SVG file. Please check directory permissions.'
                ];
            }
            
            // Create a PNG version as well for compatibility
            // In a real implementation, you'd use a library like Imagick to convert SVG to PNG
            // For this example, we'll just copy an existing PNG if available
            if (file_exists($upload_file)) {
                copy($upload_file, $upload_file . '.bak');
            }
            break;
    }
    
    // Update settings if needed
    $settings = [
        'logo_updated_at' => date('Y-m-d H:i:s')
    ];
    update_settings($settings);
    
    return [
        'success' => true,
        'message' => 'Logo uploaded successfully!'
    ];
}

/**
 * Get all settings from database
 * 
 * @return array Settings as key-value pairs
 */
function get_all_settings() {
    global $db;
    
    // In a real implementation, this would fetch from the database
    // For this example, we'll return hardcoded settings
    
    return [
        'site_title' => 'Marine Management System (MMS)',
        'site_description' => 'Innovative ERP solutions for the shipbuilding industry.',
        'contact_email' => 'info@marinemanagementsystem.com',
        'contact_phone' => '+90 507 574 2666',
        'address' => 'Bilişim Vadisi - Kocaeli',
        'social_instagram' => 'https://www.instagram.com/marinemanagementsystem/',
        'social_facebook' => 'https://www.facebook.com/profile.php?id=61560348505866',
        'social_linkedin' => 'https://www.linkedin.com/company/mms-erp',
        'social_whatsapp' => 'https://wa.me/+905075742666',
        'smtp_host' => 'smtp.example.com',
        'smtp_port' => '587',
        'smtp_user' => 'user@example.com',
        'smtp_pass' => 'password',
        'mail_from_name' => 'Marine Management System',
        'mail_from_email' => 'no-reply@marinemanagementsystem.com',
        'admin_notification_email' => 'admin@marinemanagementsystem.com',
        'meta_keywords' => 'Marine Management System, MMS, ERP, Shipbuilding, Ship Repair, Yacht Building, Maritime ERP, Tersane, Gemi İnşa',
        'google_analytics_id' => '',
        'google_tag_manager_id' => '',
        'enable_social_meta' => 1,
        'logo_updated_at' => '2024-03-01 12:00:00'
    ];
}

/**
 * Update settings in database
 * 
 * @param array $settings Settings to update
 * @return bool Success status
 */
function update_settings($settings) {
    global $db;
    
    // In a real implementation, this would update the database
    // For this example, we'll log the settings and return true
    
    error_log('Settings update: ' . json_encode($settings));
    
    return true;
}

/**
 * Get admin menu items
 * 
 * @return array Admin menu items with URL, icon, and label
 */
function get_admin_menu_items() {
    return [
        [
            'url' => 'dashboard.php',
            'icon' => 'fas fa-tachometer-alt',
            'label' => 'Dashboard'
        ],
        [
            'url' => 'content-editor.php',
            'icon' => 'fas fa-edit',
            'label' => 'Content Management'
        ],
        [
            'url' => 'demo-requests.php',
            'icon' => 'fas fa-tasks',
            'label' => 'Demo Requests',
            'submenu' => [
                [
                    'url' => 'demo-requests.php',
                    'label' => 'All Requests'
                ],
                [
                    'url' => 'demo-requests.php?status=pending',
                    'label' => 'Pending'
                ],
                [
                    'url' => 'demo-requests.php?status=contacted',
                    'label' => 'Contacted'
                ],
                [
                    'url' => 'demo-requests.php?status=completed',
                    'label' => 'Completed'
                ]
            ]
        ],
        [
            'url' => 'contact-messages.php',
            'icon' => 'fas fa-envelope',
            'label' => 'Contact Messages',
            'submenu' => [
                [
                    'url' => 'contact-messages.php',
                    'label' => 'All Messages'
                ],
                [
                    'url' => 'contact-messages.php?status=unread',
                    'label' => 'Unread'
                ],
                [
                    'url' => 'contact-messages.php?status=read',
                    'label' => 'Read'
                ],
                [
                    'url' => 'contact-messages.php?status=replied',
                    'label' => 'Replied'
                ]
            ]
        ],
        [
            'url' => 'settings.php',
            'icon' => 'fas fa-cog',
            'label' => 'Site Settings'
        ],
        [
            'url' => 'users.php',
            'icon' => 'fas fa-users',
            'label' => 'User Management'
        ]
    ];
}

/**
 * Check if user has permission for a specific action
 * 
 * @param string $action The action to check permission for
 * @return bool Whether user has permission
 */
function has_permission($action) {
    // In a real implementation, this would check user roles and permissions
    // For this example, we'll assume admin has all permissions
    
    if (!is_admin_logged_in()) {
        return false;
    }
    
    // Define available permissions
    $permissions = [
        'manage_content' => true,
        'manage_demo_requests' => true,
        'manage_messages' => true,
        'manage_settings' => true,
        'manage_users' => true,
        'view_statistics' => true
    ];
    
    return isset($permissions[$action]) && $permissions[$action];
}

/**
 * Log admin action
 * 
 * @param string $action The action performed
 * @param string $description Description of the action
 * @param int $user_id The user ID who performed the action (optional)
 * @return bool Success status
 */
function log_admin_action($action, $description, $user_id = null) {
    global $db;
    
    // Get user ID if not provided
    if ($user_id === null) {
        $user_id = $_SESSION['admin_user_id'] ?? 1;
    }
    
    // Prepare log data
    $log_data = [
        'user_id' => $user_id,
        'action' => $action,
        'description' => $description,
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    // In a real implementation, this would save to the database
    // For this example, we'll log to error_log
    error_log('Admin action log: ' . json_encode($log_data));
    
    return true;
}

/**
 * Get demo requests with optional filtering
 * 
 * @param array $filters Optional filters (status, date_from, date_to, search)
 * @param int $limit Maximum number of results to return
 * @param int $offset Offset for pagination
 * @return array Demo requests and count
 */
function get_demo_requests($filters = [], $limit = 20, $offset = 0) {
    global $db;
    
    // In a real implementation, this would fetch from the database with filters
    // For this example, we'll return hardcoded demo requests
    
    $demo_requests = [
        [
            'id' => 1,
            'name' => 'Ali',
            'surname' => 'Yılmaz',
            'email' => 'ali@example.com',
            'phone' => '+90 555 123 4567',
            'message' => 'I would like to request a demo for our shipyard.',
            'status' => 'completed',
            'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
        ],
        [
            'id' => 2,
            'name' => 'Merve',
            'surname' => 'Kaya',
            'email' => 'merve@example.com',
            'phone' => '+90 555 987 6543',
            'message' => 'We need MMS for our new shipbuilding project.',
            'status' => 'contacted',
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 days'))
        ],
        [
            'id' => 3,
            'name' => 'Ahmet',
            'surname' => 'Demir',
            'email' => 'ahmet@example.com',
            'phone' => '+90 555 456 7890',
            'message' => 'Need information about MMS Yacht software.',
            'status' => 'completed',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
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
            'id' => 5,
            'name' => 'Zeynep',
            'surname' => 'Yılmaz',
            'email' => 'zeynep@example.com',
            'phone' => '+90 555 123 4567',
            'message' => 'I would like to request a demo for our shipyard.',
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
        ]
    ];
    
    // Apply filters (if this was a real implementation)
    $filtered_requests = [];
    foreach ($demo_requests as $request) {
        $include = true;
        
        // Filter by status
        if (isset($filters['status']) && !empty($filters['status']) && $request['status'] !== $filters['status']) {
            $include = false;
        }
        
        // Filter by date range
        if (isset($filters['date_from']) && !empty($filters['date_from'])) {
            $request_date = strtotime($request['created_at']);
            $filter_date = strtotime($filters['date_from']);
            if ($request_date < $filter_date) {
                $include = false;
            }
        }
        
        if (isset($filters['date_to']) && !empty($filters['date_to'])) {
            $request_date = strtotime($request['created_at']);
            $filter_date = strtotime($filters['date_to']);
            if ($request_date > $filter_date) {
                $include = false;
            }
        }
        
        // Filter by search term
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search_term = strtolower($filters['search']);
            $searchable_text = strtolower($request['name'] . ' ' . $request['surname'] . ' ' . $request['email'] . ' ' . $request['message']);
            
            if (strpos($searchable_text, $search_term) === false) {
                $include = false;
            }
        }
        
        if ($include) {
            $filtered_requests[] = $request;
        }
    }
    
    // Get total count for pagination
    $total_count = count($filtered_requests);
    
    // Apply limit and offset
    $filtered_requests = array_slice($filtered_requests, $offset, $limit);
    
    return [
        'requests' => $filtered_requests,
        'total' => $total_count
    ];
}

/**
 * Get a specific demo request by ID
 * 
 * @param int $id Request ID
 * @return array|bool Request data or false if not found
 */
function get_demo_request($id) {
    global $db;
    
    // In a real implementation, this would fetch from the database
    // For this example, we'll return a hardcoded demo request if ID matches
    
    $demo_requests = [
        1 => [
            'id' => 1,
            'name' => 'Ali',
            'surname' => 'Yılmaz',
            'email' => 'ali@example.com',
            'phone' => '+90 555 123 4567',
            'message' => 'I would like to request a demo for our shipyard.',
            'company' => 'Istanbul Shipyard',
            'position' => 'Operations Manager',
            'status' => 'completed',
            'notes' => 'Demoed MMS NB on March 1. Client was satisfied and requested pricing.',
            'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ],
        2 => [
            'id' => 2,
            'name' => 'Merve',
            'surname' => 'Kaya',
            'email' => 'merve@example.com',
            'phone' => '+90 555 987 6543',
            'message' => 'We need MMS for our new shipbuilding project.',
            'company' => 'Kaya Marine',
            'position' => 'Project Manager',
            'status' => 'contacted',
            'notes' => 'Called on March 5. Scheduled demo for March 10.',
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 days')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        3 => [
            'id' => 3,
            'name' => 'Ahmet',
            'surname' => 'Demir',
            'email' => 'ahmet@example.com',
            'phone' => '+90 555 456 7890',
            'message' => 'Need information about MMS Yacht software.',
            'company' => 'Luxury Yachts Ltd.',
            'position' => 'CEO',
            'status' => 'completed',
            'notes' => 'Demoed MMS Yacht on March 2. Client purchased Professional package.',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        4 => [
            'id' => 4,
            'name' => 'Mehmet',
            'surname' => 'Kaya',
            'email' => 'mehmet@example.com',
            'phone' => '+90 555 987 6543',
            'message' => 'Interested in MMS for our new shipbuilding project.',
            'company' => 'Antalya Shipbuilders',
            'position' => 'IT Director',
            'status' => 'contacted',
            'notes' => 'Called on March 14. Scheduled demo for March 17.',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-12 hours'))
        ],
        5 => [
            'id' => 5,
            'name' => 'Zeynep',
            'surname' => 'Yılmaz',
            'email' => 'zeynep@example.com',
            'phone' => '+90 555 123 4567',
            'message' => 'I would like to request a demo for our shipyard.',
            'company' => 'Marmara Marine',
            'position' => 'Operations Director',
            'status' => 'pending',
            'notes' => '',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
        ]
    ];
    
    return isset($demo_requests[$id]) ? $demo_requests[$id] : false;
}

/**
 * Update demo request status and notes
 * 
 * @param int $id Request ID
 * @param array $data Update data (status, notes)
 * @return bool Success status
 */
function update_demo_request($id, $data) {
    global $db;
    
    // In a real implementation, this would update the database
    // For this example, we'll log the update and return true
    
    error_log('Demo request update: ID ' . $id . ', Data: ' . json_encode($data));
    
    return true;
}

/**
 * Get contact messages with optional filtering
 * 
 * @param array $filters Optional filters (status, date_from, date_to, search)
 * @param int $limit Maximum number of results to return
 * @param int $offset Offset for pagination
 * @return array Contact messages and count
 */
function get_contact_messages($filters = [], $limit = 20, $offset = 0) {
    global $db;
    
    // In a real implementation, this would fetch from the database with filters
    // For this example, we'll return hardcoded contact messages
    
    $contact_messages = [
        [
            'id' => 1,
            'name' => 'Kemal Öztürk',
            'email' => 'kemal@example.com',
            'phone' => '+90 555 111 2222',
            'message' => 'I would like to learn more about your MMS SRM software and how it can help our ship repair operations.',
            'status' => 'replied',
            'created_at' => date('Y-m-d H:i:s', strtotime('-6 days'))
        ],
        [
            'id' => 2,
            'name' => 'Ayşe Nur',
            'email' => 'ayse@example.com',
            'phone' => '+90 555 333 4444',
            'message' => 'Is your software compatible with our existing ERP system? We currently use SAP for our business operations.',
            'status' => 'read',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ],
        [
            'id' => 3,
            'name' => 'Burak Şahin',
            'email' => 'burak@example.com',
            'phone' => '+90 555 555 6666',
            'message' => 'What is the pricing structure for MMS Enterprise? We have a large shipyard with multiple operations.',
            'status' => 'replied',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        [
            'id' => 4,
            'name' => 'Selin Yıldız',
            'email' => 'selin@example.com',
            'phone' => '+90 555 777 8888',
            'message' => 'Do you offer training services for your software? We need to train our staff on how to use MMS effectively.',
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        [
            'id' => 5,
            'name' => 'Emre Can',
            'email' => 'emre@example.com',
            'phone' => '+90 555 999 0000',
            'message' => 'I am interested in learning more about the integration capabilities of your software with other systems.',
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
        ]
    ];
    
    // Apply filters (if this was a real implementation)
    $filtered_messages = [];
    foreach ($contact_messages as $message) {
        $include = true;
        
        // Filter by status
        if (isset($filters['status']) && !empty($filters['status']) && $message['status'] !== $filters['status']) {
            $include = false;
        }
        
        // Filter by date range
        if (isset($filters['date_from']) && !empty($filters['date_from'])) {
            $message_date = strtotime($message['created_at']);
            $filter_date = strtotime($filters['date_from']);
            if ($message_date < $filter_date) {
                $include = false;
            }
        }
        
        if (isset($filters['date_to']) && !empty($filters['date_to'])) {
            $message_date = strtotime($message['created_at']);
            $filter_date = strtotime($filters['date_to']);
            if ($message_date > $filter_date) {
                $include = false;
            }
        }
        
        // Filter by search term
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search_term = strtolower($filters['search']);
            $searchable_text = strtolower($message['name'] . ' ' . $message['email'] . ' ' . $message['message']);
            
            if (strpos($searchable_text, $search_term) === false) {
                $include = false;
            }
        }
        
        if ($include) {
            $filtered_messages[] = $message;
        }
    }
    
    // Get total count for pagination
    $total_count = count($filtered_messages);
    
    // Apply limit and offset
    $filtered_messages = array_slice($filtered_messages, $offset, $limit);
    
    return [
        'messages' => $filtered_messages,
        'total' => $total_count
    ];
}

/**
 * Get a specific contact message by ID
 * 
 * @param int $id Message ID
 * @return array|bool Message data or false if not found
 */
function get_contact_message($id) {
    global $db;
    
    // In a real implementation, this would fetch from the database
    // For this example, we'll return a hardcoded contact message if ID matches
    
    $contact_messages = [
        1 => [
            'id' => 1,
            'name' => 'Kemal Öztürk',
            'email' => 'kemal@example.com',
            'phone' => '+90 555 111 2222',
            'message' => 'I would like to learn more about your MMS SRM software and how it can help our ship repair operations.',
            'status' => 'replied',
            'reply' => 'Thank you for your interest in Marine Management System. Our MMS SRM software is specifically designed to streamline ship repair and maintenance operations. I would be happy to schedule a demo to show you how it can benefit your business. Please let me know when would be a convenient time for you.',
            'replied_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-6 days')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
        ],
        2 => [
            'id' => 2,
            'name' => 'Ayşe Nur',
            'email' => 'ayse@example.com',
            'phone' => '+90 555 333 4444',
            'message' => 'Is your software compatible with our existing ERP system? We currently use SAP for our business operations.',
            'status' => 'read',
            'reply' => '',
            'replied_at' => null,
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        3 => [
            'id' => 3,
            'name' => 'Burak Şahin',
            'email' => 'burak@example.com',
            'phone' => '+90 555 555 6666',
            'message' => 'What is the pricing structure for MMS Enterprise? We have a large shipyard with multiple operations.',
            'status' => 'replied',
            'reply' => 'Thank you for your interest in our MMS Enterprise solution. The pricing for MMS Enterprise depends on several factors, including the number of users, the specific modules you need, and the level of customization required. I would be happy to schedule a call to discuss your specific requirements and provide a tailored quote. Please let me know when would be a good time for you.',
            'replied_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        4 => [
            'id' => 4,
            'name' => 'Selin Yıldız',
            'email' => 'selin@example.com',
            'phone' => '+90 555 777 8888',
            'message' => 'Do you offer training services for your software? We need to train our staff on how to use MMS effectively.',
            'status' => 'unread',
            'reply' => '',
            'replied_at' => null,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        5 => [
            'id' => 5,
            'name' => 'Emre Can',
            'email' => 'emre@example.com',
            'phone' => '+90 555 999 0000',
            'message' => 'I am interested in learning more about the integration capabilities of your software with other systems.',
            'status' => 'unread',
            'reply' => '',
            'replied_at' => null,
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
        ]
    ];
    
    return isset($contact_messages[$id]) ? $contact_messages[$id] : false;
}

/**
 * Update contact message status and reply
 * 
 * @param int $id Message ID
 * @param array $data Update data (status, reply)
 * @return bool Success status
 */
function update_contact_message($id, $data) {
    global $db;
    
    // In a real implementation, this would update the database
    // For this example, we'll log the update and return true
    
    error_log('Contact message update: ID ' . $id . ', Data: ' . json_encode($data));
    
    return true;
}

/**
 * Get analytics data for the dashboard
 * 
 * @param string $period Period to get data for (week, month, year)
 * @return array Analytics data
 */
function get_analytics_data($period = 'week') {
    // In a real implementation, this would fetch from the database or analytics API
    // For this example, we'll return hardcoded data
    
    switch ($period) {
        case 'week':
            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'visitors' => [120, 135, 95, 150, 180, 90, 110],
                'page_views' => [320, 280, 190, 390, 420, 210, 240],
                'unique_visitors' => [80, 95, 70, 110, 130, 65, 85]
            ];
            
        case 'month':
            return [
                'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                'visitors' => [750, 850, 950, 880],
                'page_views' => [1800, 2100, 2300, 2000],
                'unique_visitors' => [550, 620, 680, 640]
            ];
            
        case 'year':
            return [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'visitors' => [3200, 3500, 4000, 3800, 4200, 4500, 4300, 4100, 4600, 4800, 5000, 5200],
                'page_views' => [7500, 8200, 9500, 9000, 10000, 11000, 10500, 9800, 11200, 11500, 12000, 12500],
                'unique_visitors' => [2400, 2600, 3000, 2900, 3100, 3400, 3200, 3000, 3500, 3700, 3900, 4100]
            ];
            
        default:
            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'visitors' => [120, 135, 95, 150, 180, 90, 110],
                'page_views' => [320, 280, 190, 390, 420, 210, 240],
                'unique_visitors' => [80, 95, 70, 110, 130, 65, 85]
            ];
    }
}
