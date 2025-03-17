<?php
/**
 * MMS - Marine Management System
 * General Helper Functions
 */

/**
 * Escape HTML for safe output
 * 
 * @param string $text The text to escape
 * @return string Escaped text
 */
function html_escape($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Format date/time
 * 
 * @param string $datetime The date/time string to format
 * @param string $format The format to use (default: 'Y-m-d H:i:s')
 * @return string Formatted date/time
 */
function format_datetime($datetime, $format = 'Y-m-d H:i:s') {
    if (empty($datetime)) {
        return '';
    }
    
    $dt = new DateTime($datetime);
    return $dt->format($format);
}

/**
 * Format date
 * 
 * @param string $date The date string to format
 * @param string $format The format to use (default: 'Y-m-d')
 * @return string Formatted date
 */
function format_date($date, $format = 'Y-m-d') {
    if (empty($date)) {
        return '';
    }
    
    $dt = new DateTime($date);
    return $dt->format($format);
}

/**
 * Format time
 * 
 * @param string $time The time string to format
 * @param string $format The format to use (default: 'H:i:s')
 * @return string Formatted time
 */
function format_time($time, $format = 'H:i:s') {
    if (empty($time)) {
        return '';
    }
    
    $dt = new DateTime($time);
    return $dt->format($format);
}

/**
 * Format time ago (e.g., "5 minutes ago")
 * 
 * @param string $datetime The date/time string to format
 * @param bool $full Whether to show the full format or abbreviated
 * @return string Time ago
 */
function time_ago($datetime, $full = false) {
    if (empty($datetime)) {
        return '';
    }
    
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    
    // Manuel hafta hesaplaması
    $weeks = floor($diff->d / 7);
    $days_remaining = $diff->d % 7;
    
    $string = [];
    
    if ($diff->y > 0) {
        $string['y'] = $diff->y . ' year' . ($diff->y > 1 ? 's' : '');
    }
    
    if ($diff->m > 0) {
        $string['m'] = $diff->m . ' month' . ($diff->m > 1 ? 's' : '');
    }
    
    if ($weeks > 0) {
        $string['w'] = $weeks . ' week' . ($weeks > 1 ? 's' : '');
    }
    
    if ($days_remaining > 0) {
        $string['d'] = $days_remaining . ' day' . ($days_remaining > 1 ? 's' : '');
    }
    
    if ($diff->h > 0) {
        $string['h'] = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
    }
    
    if ($diff->i > 0) {
        $string['i'] = $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
    }
    
    if ($diff->s > 0) {
        $string['s'] = $diff->s . ' second' . ($diff->s > 1 ? 's' : '');
    }
    
    if (!$full) {
        $string = array_slice($string, 0, 1);
    }
    
    if ($string) {
        return implode(', ', $string) . ' ago';
    }
    
    return 'just now';
}

/**
 * Truncate text to a specific length
 * 
 * @param string $text The text to truncate
 * @param int $length Maximum length
 * @param string $suffix Suffix to append if truncated (default: '...')
 * @return string Truncated text
 */
function truncate_text($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    return substr($text, 0, $length) . $suffix;
}

/**
 * Create slug from a string
 * 
 * @param string $text The text to create a slug from
 * @return string Slug
 */
function create_slug($text) {
    // Replace non letter or digit by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
    // Transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    
    // Trim
    $text = trim($text, '-');
    
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    
    // Lowercase
    $text = strtolower($text);
    
    if (empty($text)) {
        return 'n-a';
    }
    
    return $text;
}

/**
 * Format file size in human-readable form
 * 
 * @param int $bytes Size in bytes
 * @param int $precision Decimal precision (default: 2)
 * @return string Formatted size
 */
function format_file_size($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= pow(1024, $pow);
    
    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * Get file extension
 * 
 * @param string $filename The filename
 * @return string File extension
 */
function get_file_extension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Check if file extension is allowed
 * 
 * @param string $filename The filename
 * @param array $allowed_extensions Array of allowed extensions
 * @return bool Whether the extension is allowed
 */
function is_allowed_extension($filename, $allowed_extensions) {
    $ext = get_file_extension($filename);
    return in_array($ext, $allowed_extensions);
}

/**
 * Generate random string
 * 
 * @param int $length Length of the string (default: 10)
 * @param string $keyspace Characters to use (default: alphanumeric)
 * @return string Random string
 */
function random_string($length = 10, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    
    return $str;
}

/**
 * Validate email address
 * 
 * @param string $email The email address to validate
 * @return bool Whether the email is valid
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate URL
 * 
 * @param string $url The URL to validate
 * @return bool Whether the URL is valid
 */
function is_valid_url($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Validate phone number
 * 
 * @param string $phone The phone number to validate
 * @return bool Whether the phone number is valid
 */
function is_valid_phone($phone) {
    // Remove common formatting characters
    $phone = preg_replace('/[^\d+]/', '', $phone);
    
    // Basic validation - must have at least 10 digits
    return preg_match('/^\+?[\d]{10,15}$/', $phone);
}

/**
 * Send email
 * 
 * @param string $to Recipient email
 * @param string $subject Email subject
 * @param string $message Email message (can be HTML)
 * @param array $options Additional options (from_name, from_email, reply_to, cc, bcc, attachments)
 * @return bool Whether the email was sent successfully
 */
function send_email($to, $subject, $message, $options = []) {
    // In a real implementation, this would use PHPMailer or similar library
    // For this example, we'll just log the email and return true
    
    $log_data = [
        'to' => $to,
        'subject' => $subject,
        'message' => $message,
        'options' => $options,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    error_log('Email sent: ' . json_encode($log_data));
    
    return true;
}

/**
 * Get language from URL or default
 * 
 * @return string Language code
 */
function get_current_language() {
    // Check URL parameter
    if (isset($_GET['lang']) && in_array($_GET['lang'], array_keys(get_available_languages()))) {
        return $_GET['lang'];
    }
    
    // Check session
    if (isset($_SESSION['language']) && in_array($_SESSION['language'], array_keys(get_available_languages()))) {
        return $_SESSION['language'];
    }
    
    // Default to Turkish
    return 'tr';
}

/**
 * Format money amount
 * 
 * @param float $amount The amount to format
 * @param string $currency Currency code (default: 'USD')
 * @param string $locale Locale for formatting (default: 'en_US')
 * @return string Formatted money amount
 */
function format_money($amount, $currency = 'USD', $locale = 'en_US') {
    $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
    return $formatter->formatCurrency($amount, $currency);
}

/**
 * Format number
 * 
 * @param float $number The number to format
 * @param int $decimals Number of decimal places (default: 0)
 * @param string $locale Locale for formatting (default: 'en_US')
 * @return string Formatted number
 */
function format_number($number, $decimals = 0, $locale = 'en_US') {
    $formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
    $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);
    return $formatter->format($number);
}

/**
 * Format percentage
 * 
 * @param float $number The number to format as percentage
 * @param int $decimals Number of decimal places (default: 0)
 * @param string $locale Locale for formatting (default: 'en_US')
 * @return string Formatted percentage
 */
function format_percentage($number, $decimals = 0, $locale = 'en_US') {
    $formatter = new NumberFormatter($locale, NumberFormatter::PERCENT);
    $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);
    return $formatter->format($number / 100);
}

/**
 * Get client IP address
 * 
 * @return string IP address
 */
function get_client_ip() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    return $ip;
}

/**
 * Get browser and OS information
 * 
 * @return array Browser and OS information
 */
function get_browser_info() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = 'Unknown';
    $platform = 'Unknown';
    
    // Detect platform
    if (preg_match('/linux/i', $user_agent)) {
        $platform = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
        $platform = 'macOS';
    } elseif (preg_match('/windows|win32/i', $user_agent)) {
        $platform = 'Windows';
    } elseif (preg_match('/android/i', $user_agent)) {
        $platform = 'Android';
    } elseif (preg_match('/iphone/i', $user_agent)) {
        $platform = 'iPhone';
    } elseif (preg_match('/ipad/i', $user_agent)) {
        $platform = 'iPad';
    }
    
    // Detect browser
    if (preg_match('/MSIE/i', $user_agent) || preg_match('/Trident/i', $user_agent)) {
        $browser = 'Internet Explorer';
    } elseif (preg_match('/Firefox/i', $user_agent)) {
        $browser = 'Firefox';
    } elseif (preg_match('/Chrome/i', $user_agent) && !preg_match('/Edge/i', $user_agent)) {
        $browser = 'Chrome';
    } elseif (preg_match('/Safari/i', $user_agent) && !preg_match('/Chrome/i', $user_agent)) {
        $browser = 'Safari';
    } elseif (preg_match('/Edge/i', $user_agent)) {
        $browser = 'Microsoft Edge';
    } elseif (preg_match('/Opera/i', $user_agent)) {
        $browser = 'Opera';
    }
    
    return [
        'browser' => $browser,
        'platform' => $platform,
        'user_agent' => $user_agent
    ];
}

/**
 * Log message to file
 * 
 * @param string $message The message to log
 * @param string $level Log level (info, warning, error, debug)
 * @param string $file Log file name (default: 'app.log')
 * @return bool Whether the message was logged successfully
 */
function log_message($message, $level = 'info', $file = 'app.log') {
    $log_dir = MMS_ROOT_DIR . '/logs';
    
    // Create log directory if it doesn't exist
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $log_file = $log_dir . '/' . $file;
    $timestamp = date('Y-m-d H:i:s');
    $level = strtoupper($level);
    
    $log_entry = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
    
    return file_put_contents($log_file, $log_entry, FILE_APPEND) !== false;
}

/**
 * Get file contents from URL
 * 
 * @param string $url The URL to get contents from
 * @param array $options Additional options (timeout, user_agent, etc.)
 * @return string|bool The file contents or false on failure
 */
function get_url_contents($url, $options = []) {
    $context_options = [
        'http' => [
            'timeout' => $options['timeout'] ?? 30,
            'user_agent' => $options['user_agent'] ?? 'MMS/1.0',
            'follow_location' => 1,
            'max_redirects' => 5
        ]
    ];
    
    if (isset($options['headers']) && is_array($options['headers'])) {
        $headers = '';
        foreach ($options['headers'] as $header => $value) {
            $headers .= "{$header}: {$value}\r\n";
        }
        $context_options['http']['header'] = $headers;
    }
    
    $context = stream_context_create($context_options);
    
    return @file_get_contents($url, false, $context);
}

/**
 * Get domain from URL
 * 
 * @param string $url The URL to extract domain from
 * @return string The domain
 */
function get_domain_from_url($url) {
    $parts = parse_url($url);
    return isset($parts['host']) ? $parts['host'] : '';
}

/**
 * Check if current page is admin section
 * 
 * @return bool Whether current page is in admin section
 */
function is_admin() {
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    return strpos($request_uri, '/admin/') !== false;
}

/**
 * Get pagination HTML
 * 
 * @param int $total_items Total number of items
 * @param int $current_page Current page number
 * @param int $per_page Number of items per page
 * @param string $url_pattern URL pattern with :page placeholder
 * @return string Pagination HTML
 */
function get_pagination($total_items, $current_page, $per_page, $url_pattern) {
    $total_pages = ceil($total_items / $per_page);
    
    if ($total_pages <= 1) {
        return '';
    }
    
    $html = '<div class="pagination">';
    
    // Previous button
    if ($current_page > 1) {
        $prev_url = str_replace(':page', $current_page - 1, $url_pattern);
        $html .= '<a href="' . $prev_url . '" class="page-item prev">&laquo; Prev</a>';
    } else {
        $html .= '<span class="page-item prev disabled">&laquo; Prev</span>';
    }
    
    // Page numbers
    $start_page = max(1, min($current_page - 2, $total_pages - 4));
    $end_page = min($total_pages, max(5, $current_page + 2));
    
    if ($start_page > 1) {
        $html .= '<a href="' . str_replace(':page', 1, $url_pattern) . '" class="page-item">1</a>';
        if ($start_page > 2) {
            $html .= '<span class="page-item dots">...</span>';
        }
    }
    
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            $html .= '<span class="page-item active">' . $i . '</span>';
        } else {
            $html .= '<a href="' . str_replace(':page', $i, $url_pattern) . '" class="page-item">' . $i . '</a>';
        }
    }
    
    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            $html .= '<span class="page-item dots">...</span>';
        }
        $html .= '<a href="' . str_replace(':page', $total_pages, $url_pattern) . '" class="page-item">' . $total_pages . '</a>';
    }
    
    // Next button
    if ($current_page < $total_pages) {
        $next_url = str_replace(':page', $current_page + 1, $url_pattern);
        $html .= '<a href="' . $next_url . '" class="page-item next">Next &raquo;</a>';
    } else {
        $html .= '<span class="page-item next disabled">Next &raquo;</span>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Generate meta tags for SEO
 * 
 * @param array $meta Meta information (title, description, keywords, etc.)
 * @return string Meta tags HTML
 */
function generate_meta_tags($meta) {
    $html = '';
    
    // Basic meta tags
    $html .= '<meta name="description" content="' . html_escape($meta['description'] ?? '') . '">' . PHP_EOL;
    
    if (isset($meta['keywords']) && !empty($meta['keywords'])) {
        $html .= '<meta name="keywords" content="' . html_escape($meta['keywords']) . '">' . PHP_EOL;
    }
    
    // Open Graph meta tags
    if (isset($meta['og_enable']) && $meta['og_enable']) {
        $html .= '<meta property="og:title" content="' . html_escape($meta['title'] ?? '') . '">' . PHP_EOL;
        $html .= '<meta property="og:description" content="' . html_escape($meta['description'] ?? '') . '">' . PHP_EOL;
        $html .= '<meta property="og:type" content="' . ($meta['og_type'] ?? 'website') . '">' . PHP_EOL;
        $html .= '<meta property="og:url" content="' . html_escape($meta['og_url'] ?? '') . '">' . PHP_EOL;
        
        if (isset($meta['og_image']) && !empty($meta['og_image'])) {
            $html .= '<meta property="og:image" content="' . html_escape($meta['og_image']) . '">' . PHP_EOL;
        }
    }
    
    // Twitter Card meta tags
    if (isset($meta['twitter_enable']) && $meta['twitter_enable']) {
        $html .= '<meta name="twitter:card" content="' . ($meta['twitter_card'] ?? 'summary_large_image') . '">' . PHP_EOL;
        
        if (isset($meta['twitter_site']) && !empty($meta['twitter_site'])) {
            $html .= '<meta name="twitter:site" content="' . html_escape($meta['twitter_site']) . '">' . PHP_EOL;
        }
        
        $html .= '<meta name="twitter:title" content="' . html_escape($meta['title'] ?? '') . '">' . PHP_EOL;
        $html .= '<meta name="twitter:description" content="' . html_escape($meta['description'] ?? '') . '">' . PHP_EOL;
        
        if (isset($meta['twitter_image']) && !empty($meta['twitter_image'])) {
            $html .= '<meta name="twitter:image" content="' . html_escape($meta['twitter_image']) . '">' . PHP_EOL;
        }
    }
    
    // Canonical URL
    if (isset($meta['canonical']) && !empty($meta['canonical'])) {
        $html .= '<link rel="canonical" href="' . html_escape($meta['canonical']) . '">' . PHP_EOL;
    }
    
    return $html;
}

/**
 * Return HTTP status code and message
 * 
 * @param int $code HTTP status code
 * @return void
 */
function http_response_code_and_exit($code) {
    $messages = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        429 => 'Too Many Requests',
        500 => 'Internal Server Error'
    ];
    
    $message = $messages[$code] ?? 'Unknown';
    
    header("HTTP/1.1 {$code} {$message}");
    
    if ($code >= 400) {
        echo json_encode([
            'error' => [
                'code' => $code,
                'message' => $message
            ]
        ]);
    }
    
    exit;
}

/**
 * Generate CSRF token
 * 
 * @return string CSRF token
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 * 
 * @param string $token The token to validate
 * @return bool Whether the token is valid
 */
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Parse markdown text
 * 
 * @param string $markdown The markdown text
 * @return string Parsed HTML
 */
function parse_markdown($markdown) {
    // In a real implementation, this would use a library like Parsedown
    // For this example, we'll convert basic markdown syntax
    
    // Convert headers
    $markdown = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $markdown);
    $markdown = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $markdown);
    $markdown = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $markdown);
    
    // Convert bold and italic
    $markdown = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $markdown);
    $markdown = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $markdown);
    
    // Convert lists
    $markdown = preg_replace('/^\* (.*?)$/m', '<li>$1</li>', $markdown);
    $markdown = preg_replace('/^\- (.*?)$/m', '<li>$1</li>', $markdown);
    $markdown = preg_replace('/^\d+\. (.*?)$/m', '<li>$1</li>', $markdown);
    
    // Wrap lists
    $markdown = preg_replace('/((?:<li>.*?<\/li>)+)/s', '<ul>$1</ul>', $markdown);
    
    // Convert links
    $markdown = preg_replace('/\[(.*?)\]\((.*?)\)/s', '<a href="$2">$1</a>', $markdown);
    
    // Convert paragraphs
    $markdown = preg_replace('/^((?!<h|<ul|<li|<a).*)/m', '<p>$1</p>', $markdown);
    
    return $markdown;
}
