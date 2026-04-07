<?php
/**
 * Media API Endpoint
 * Handle file uploads and media management
 */

// Start output buffering to prevent any accidental output
ob_start();

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Ensure session is active and update last activity
if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['admin_id'])) {
    $_SESSION['last_activity'] = time();
}

requireLogin();

// Clear any output that might have been generated
ob_clean();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'POST':
            // Verify CSRF token
            $csrfToken = $_POST['csrf_token'] ?? '';
            if (!verifyCSRFToken($csrfToken)) {
                error_log("Media upload CSRF token verification failed. Token provided: " . (!empty($csrfToken) ? 'yes' : 'no'));
                jsonResponse(['success' => false, 'message' => 'Invalid security token. Please refresh the page and try again.'], 403);
            }
            
            // Upload file
            if (!isset($_FILES['file'])) {
                error_log("Media upload: No file in \$_FILES array");
                jsonResponse(['success' => false, 'message' => 'No file uploaded. Please select a file.'], 400);
            }
            
            $file = $_FILES['file'];
            
            // Check for PHP upload errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive in php.ini',
                    UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive in HTML form',
                    UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                    UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                    UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
                ];
                $errorMsg = $errorMessages[$file['error']] ?? 'Unknown upload error (' . $file['error'] . ')';
                error_log("Media upload PHP error: " . $errorMsg);
                jsonResponse(['success' => false, 'message' => 'Upload error: ' . $errorMsg], 400);
            }
            
            $subdirectory = sanitize($_POST['subdirectory'] ?? '');
            
            $result = uploadImage($file, $subdirectory);
            
            if ($result['success']) {
                try {
                    // Save to database
                    $stmt = $pdo->prepare("INSERT INTO media (filename, original_name, file_path, file_type, file_size, uploaded_by) 
                                           VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $result['filename'],
                        $file['name'],
                        $result['path'],
                        $file['type'],
                        $file['size'],
                        getCurrentUserId()
                    ]);
                    
                    $mediaId = $pdo->lastInsertId();
                    
                    // Verify file exists first
                    $fullPath = $result['full_path'] ?? '';
                    $fileExists = !empty($fullPath) && file_exists($fullPath);
                    
                    if (!$fileExists) {
                        error_log("ERROR: Uploaded file does not exist at: {$fullPath}");
                        jsonResponse([
                            'success' => false,
                            'message' => 'File was uploaded but could not be verified. Please try again.'
                        ], 500);
                    }
                    
                    // Construct URL - use UPLOAD_URL constant which is already correctly defined
                    // Path stored is 'assets/uploads/filename.jpg'
                    // UPLOAD_URL is 'SITE_URL . assets/uploads/'
                    // So we can either use: SITE_URL . path OR extract filename and use UPLOAD_URL . filename
                    $imageUrl = SITE_URL . $result['path'];
                    
                    jsonResponse([
                        'success' => true,
                        'message' => 'File uploaded successfully',
                        'media' => [
                            'id' => $mediaId,
                            'path' => $result['path'],
                            'url' => $imageUrl,
                            'filename' => $result['filename']
                        ]
                    ]);
                } catch(PDOException $e) {
                    error_log("Media upload database error: " . $e->getMessage());
                    // File was uploaded but database insert failed - try to delete the file
                    if (isset($result['full_path']) && file_exists($result['full_path'])) {
                        @unlink($result['full_path']);
                    }
                    jsonResponse(['success' => false, 'message' => 'File uploaded but failed to save to database. Please try again.'], 500);
                }
            } else {
                $errorMessage = implode(', ', $result['errors']);
                error_log("Media upload validation failed: " . $errorMessage);
                jsonResponse([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
            break;
            
        case 'GET':
            // List media files
            $page = max(1, intval($_GET['page'] ?? 1));
            $perPage = 20;
            $offset = ($page - 1) * $perPage;
            
            $search = sanitize($_GET['search'] ?? '');
            
            $where = [];
            $params = [];
            
            if ($search) {
                $where[] = "(original_name LIKE ? OR filename LIKE ?)";
                $searchTerm = "%{$search}%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }
            
            $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
            
            // Get total count
            $countStmt = $pdo->prepare("SELECT COUNT(*) FROM media {$whereClause}");
            $countStmt->execute($params);
            $total = $countStmt->fetchColumn();
            
            // Get media files
            $stmt = $pdo->prepare("SELECT m.*, u.username as uploaded_by_name 
                                   FROM media m 
                                   LEFT JOIN admin_users u ON m.uploaded_by = u.id 
                                   {$whereClause}
                                   ORDER BY m.uploaded_at DESC 
                                   LIMIT ? OFFSET ?");
            $params[] = $perPage;
            $params[] = $offset;
            $stmt->execute($params);
            $media = $stmt->fetchAll();
            
            // Add full URL to each media item
            foreach ($media as &$item) {
                $item['url'] = SITE_URL . $item['file_path'];
            }
            
            jsonResponse([
                'success' => true,
                'media' => $media,
                'pagination' => [
                    'page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'pages' => ceil($total / $perPage)
                ]
            ]);
            break;
            
        case 'DELETE':
            // Verify CSRF token
            $csrfToken = $_GET['csrf_token'] ?? '';
            if (!verifyCSRFToken($csrfToken)) {
                jsonResponse(['success' => false, 'message' => 'Invalid security token'], 403);
            }
            
            // Delete media file
            $id = intval($_GET['id'] ?? 0);
            
            if (!$id) {
                jsonResponse(['success' => false, 'message' => 'Invalid media ID'], 400);
            }
            
            // Get file info
            $stmt = $pdo->prepare("SELECT file_path FROM media WHERE id = ?");
            $stmt->execute([$id]);
            $media = $stmt->fetch();
            
            if (!$media) {
                jsonResponse(['success' => false, 'message' => 'Media not found'], 404);
            }
            
            // Try to delete file from disk (returns true even if file doesn't exist)
            deleteFile($media['file_path']);
            
            // Delete from database regardless of file deletion result
            // (file may have been manually deleted already)
            try {
                $stmt = $pdo->prepare("DELETE FROM media WHERE id = ?");
                $stmt->execute([$id]);
                
                jsonResponse(['success' => true, 'message' => 'Media deleted successfully']);
            } catch(PDOException $e) {
                error_log("Failed to delete media record from database: " . $e->getMessage());
                jsonResponse(['success' => false, 'message' => 'Failed to delete media record'], 500);
            }
            break;
            
        default:
            jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
    }
} catch(PDOException $e) {
    error_log("Media API error: " . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'Database error occurred'], 500);
} catch(Exception $e) {
    error_log("Media API error: " . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'An error occurred'], 500);
}

