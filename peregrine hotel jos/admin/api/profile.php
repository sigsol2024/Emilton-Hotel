<?php
/**
 * Profile API Endpoint
 * Handle email and password updates
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
    exit;
}

try {
    // Verify CSRF token
    $headers = getAllHeaders();
    $csrfToken = $headers['X-CSRF-Token'] ?? '';
    if (!verifyCSRFToken($csrfToken)) {
        jsonResponse(['success' => false, 'message' => 'Invalid security token'], 403);
        exit;
    }
    
    // Get current user ID
    $userId = getCurrentUserId();
    if (!$userId) {
        jsonResponse(['success' => false, 'message' => 'User not authenticated'], 401);
        exit;
    }
    
    // Get request data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Validate JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        jsonResponse(['success' => false, 'message' => 'Invalid JSON data'], 400);
        exit;
    }
    
    if (!isset($data['action'])) {
        jsonResponse(['success' => false, 'message' => 'Action is required'], 400);
        exit;
    }
    
    $action = $data['action'];
    
    switch ($action) {
        case 'update_email':
            // Update email address
            if (!isset($data['email']) || empty(trim($data['email']))) {
                jsonResponse(['success' => false, 'message' => 'Email is required'], 400);
                exit;
            }
            
            $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
            if (!$email) {
                jsonResponse(['success' => false, 'message' => 'Invalid email address'], 400);
                exit;
            }
            
            // Check if email is already taken by another user
            $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $userId]);
            if ($stmt->fetch()) {
                jsonResponse(['success' => false, 'message' => 'Email address is already in use'], 400);
                exit;
            }
            
            // Update email
            $stmt = $pdo->prepare("UPDATE admin_users SET email = ? WHERE id = ?");
            $stmt->execute([$email, $userId]);
            
            // Update session
            $_SESSION['admin_email'] = $email;
            
            jsonResponse([
                'success' => true,
                'message' => 'Email address updated successfully',
                'email' => $email
            ]);
            break;
            
        case 'change_password':
            // Change password
            if (!isset($data['current_password']) || empty($data['current_password'])) {
                jsonResponse(['success' => false, 'message' => 'Current password is required'], 400);
                exit;
            }
            
            if (!isset($data['new_password']) || empty($data['new_password'])) {
                jsonResponse(['success' => false, 'message' => 'New password is required'], 400);
                exit;
            }
            
            $currentPassword = $data['current_password'];
            $newPassword = $data['new_password'];
            
            // Validate new password length
            if (strlen($newPassword) < 8) {
                jsonResponse(['success' => false, 'message' => 'New password must be at least 8 characters long'], 400);
                exit;
            }
            
            // Get current user's password hash
            $stmt = $pdo->prepare("SELECT password_hash FROM admin_users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();
            
            if (!$user) {
                jsonResponse(['success' => false, 'message' => 'User not found'], 404);
                exit;
            }
            
            // Verify current password
            if (!password_verify($currentPassword, $user['password_hash'])) {
                jsonResponse(['success' => false, 'message' => 'Current password is incorrect'], 400);
                exit;
            }
            
            // Check if new password is same as current password
            if (password_verify($newPassword, $user['password_hash'])) {
                jsonResponse(['success' => false, 'message' => 'New password must be different from current password'], 400);
                exit;
            }
            
            // Hash new password
            $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
            
            // Update password
            $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
            $stmt->execute([$newPasswordHash, $userId]);
            
            jsonResponse([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);
            break;
            
        default:
            jsonResponse(['success' => false, 'message' => 'Invalid action'], 400);
            break;
    }
} catch(PDOException $e) {
    error_log("Profile API error: " . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'Database error occurred'], 500);
}
