<?php
/**
 * Hotel CMS Configuration File
 * Database connection and system constants
 */

// Start session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    // Set secure session cookie parameters (more reliable than ini_set)
    $cookieParams = [
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
    ];
    
    // session.cookie_samesite requires PHP 7.3+
    if (PHP_VERSION_ID >= 70300) {
        $cookieParams['samesite'] = 'Lax';
    }
    
    session_set_cookie_params($cookieParams);
    
    // Additional ini settings (fallback)
    @ini_set('session.use_only_cookies', 1);
    
    session_start();
    
    // Regenerate session ID periodically to prevent fixation
    if (!isset($_SESSION['created'])) {
        $_SESSION['created'] = time();
    } else if (time() - $_SESSION['created'] > 1800) {
        // Regenerate session ID every 30 minutes
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}

// Database configuration
// ============================================
// IMPORTANT: Update these with your actual database credentials
// ============================================
// 
// SETUP INSTRUCTIONS:
// 1. Create a MySQL database named 'peregrine_hotel' (or your preferred name)
// 2. Import the database schema from: config/database.sql
// 3. Import initial content from: config/database-init-content.sql
// 4. Update the credentials below:
//    - DB_HOST: Usually 'localhost' for local development
//    - DB_USER: Your MySQL username
//    - DB_PASS: Your MySQL password
//    - DB_NAME: Your database name (default: 'peregrine_hotel')
//
// Example for local development:
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_NAME', 'peregrine_hotel');
//
// Example for production:
// define('DB_HOST', 'localhost');
// define('DB_USER', 'peregrine_user');
// define('DB_PASS', 'secure_password_here');
// define('DB_NAME', 'peregrine_hotel');
// ============================================
define('DB_HOST', 'localhost');
define('DB_USER', 'sigsol_peregrine');
define('DB_PASS', 'sigsol_peregrine');
define('DB_NAME', 'sigsol_peregrine');

// Paths and URLs
// IMPORTANT:
// This file lives in /admin/includes/. The project root is TWO levels up from here.
// If BASE_PATH is wrong, uploads/logs end up under /admin/... and URLs 404.
$projectRoot = realpath(__DIR__ . '/../../');
if ($projectRoot === false) {
    // Fallback: dirname twice
    $projectRoot = dirname(dirname(__DIR__));
}
define('BASE_PATH', $projectRoot);
define('SITE_PATH', BASE_PATH);
define('ADMIN_PATH', BASE_PATH . '/admin');

// URLs - Adjust these based on your setup
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
// Validate and sanitize host to prevent host header injection
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
// Remove any port, path, or query string from host
$host = preg_replace('/[^a-zA-Z0-9.\-]/', '', parse_url($host, PHP_URL_HOST) ?: $host);
if (empty($host) || !preg_match('/^[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?)*$/', $host)) {
    $host = 'localhost';
}
$scriptPath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$adminPath = strpos($scriptPath, '/admin') !== false ? substr($scriptPath, 0, strpos($scriptPath, '/admin')) : $scriptPath;

define('BASE_URL', $protocol . $host . $adminPath . '/');
define('ADMIN_URL', BASE_URL . 'admin/');
define('SITE_URL', BASE_URL);

// File paths
define('UPLOAD_DIR', SITE_PATH . '/assets/uploads/');
define('UPLOAD_URL', SITE_URL . 'assets/uploads/');

// Security settings
define('SESSION_TIMEOUT', 1800); // 30 minutes in seconds
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_ATTEMPT_WINDOW', 900); // 15 minutes

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB in bytes
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'image/webp']);
define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);

// Create database connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch(PDOException $e) {
    // Log error
    error_log("Database connection failed: " . $e->getMessage());
    
    // For admin pages, show error and stop
    if (strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/') !== false) {
        http_response_code(500);
        die("Database connection failed. Please ensure the database '" . DB_NAME . "' exists and the credentials in admin/includes/config.php are correct.");
    }
    
    // For frontend pages, set $pdo to null so content-loader can handle gracefully
    $pdo = null;
}

// Timezone
date_default_timezone_set('Africa/Lagos'); // Nigeria timezone

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1); // Temporarily enabled for debugging - SET TO 0 IN PRODUCTION
ini_set('log_errors', 1);
ini_set('error_log', ADMIN_PATH . '/logs/error.log');

// Create logs directory if it doesn't exist
if (!file_exists(ADMIN_PATH . '/logs')) {
    mkdir(ADMIN_PATH . '/logs', 0755, true);
}

