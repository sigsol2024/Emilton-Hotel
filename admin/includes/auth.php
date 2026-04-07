<?php
/**
 * Authentication Functions
 * User authentication and authorization
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
        return false;
    }
    
    // Update last activity before checking timeout
    if (isset($_SESSION['last_activity'])) {
        if (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
            session_unset();
            session_destroy();
            return false;
        }
    }
    $_SESSION['last_activity'] = time();
    
    return true;
}

/**
 * Require login - redirect if not logged in (for pages) or return JSON error (for API)
 */
function requireLogin() {
    // Check if we're in an API file by checking the calling file (most reliable method)
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
    $callingFile = $backtrace[1]['file'] ?? '';
    $isApiFile = strpos($callingFile, '/api/') !== false || strpos($callingFile, '\\api\\') !== false;
    
    if (!isLoggedIn()) {
        // Check if this is an API request - check multiple indicators
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $httpAccept = $_SERVER['HTTP_ACCEPT'] ?? '';
        
        // Use backtrace to check if called from API file (most reliable)
        $isApiRequest = $isApiFile
                     || strpos($requestUri, '/api/') !== false 
                     || strpos($scriptName, '/api/') !== false
                     || strpos($requestUri, 'api/media.php') !== false
                     || strpos($scriptName, 'api/media.php') !== false
                     || (isset($httpAccept) && strpos($httpAccept, 'application/json') !== false);
        
        if ($isApiRequest) {
            // Return JSON error for API requests
            while (ob_get_level()) {
                ob_end_clean();
            }
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Authentication required. Please log in.']);
            exit;
        } else {
            // Redirect for page requests
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            redirect(ADMIN_URL . 'index.php');
        }
    }
}

/**
 * Login user
 */
function login($username, $password) {
    global $pdo;
    
    // Check rate limiting
    if (!checkLoginRateLimit($username)) {
        return ['success' => false, 'message' => 'Too many login attempts. Please try again later.'];
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? AND is_active = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            
            // Login successful
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['last_activity'] = time();
            
            // Update last login
            $stmt = $pdo->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);
            
            // Clear failed login attempts
            clearFailedLoginAttempts($username);
            
            return ['success' => true, 'user' => $user];
        } else {
            // Record failed login attempt
            recordFailedLoginAttempt($username);
            return ['success' => false, 'message' => 'Invalid username or password.'];
        }
    } catch(PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred. Please try again.'];
    }
}

/**
 * Logout user
 */
function logout() {
    session_unset();
    session_destroy();
    redirect(ADMIN_URL . 'index.php');
}

/**
 * Check login rate limiting
 */
function checkLoginRateLimit($username) {
    $key = 'login_attempts_' . md5($username);
    $windowStart = time() - LOGIN_ATTEMPT_WINDOW;
    
    // Initialize session if not started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }
    
    // Remove old attempts
    $_SESSION[$key] = array_filter($_SESSION[$key], function($timestamp) use ($windowStart) {
        return $timestamp > $windowStart;
    });
    
    // Check if exceeded limit
    if (count($_SESSION[$key]) >= MAX_LOGIN_ATTEMPTS) {
        return false;
    }
    
    return true;
}

/**
 * Record failed login attempt
 */
function recordFailedLoginAttempt($username) {
    $key = 'login_attempts_' . md5($username);
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }
    $_SESSION[$key][] = time();
}

/**
 * Clear failed login attempts
 */
function clearFailedLoginAttempts($username) {
    $key = 'login_attempts_' . md5($username);
    unset($_SESSION[$key]);
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    return $_SESSION['admin_id'] ?? null;
}

/**
 * Get current username
 */
function getCurrentUsername() {
    return $_SESSION['admin_username'] ?? null;
}

