<?php
/**
 * Upload Diagnostic Script
 * Check upload directory permissions and configuration
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

requireLogin();

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Diagnostic</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .info { color: blue; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 4px; }
        code { background: #f5f5f5; padding: 2px 4px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>Upload Diagnostic</h1>
    
    <?php
    echo "<h2>Runtime Context</h2>";
    echo "<p><strong>REQUEST_URI:</strong> <code>" . htmlspecialchars($_SERVER['REQUEST_URI'] ?? '', ENT_QUOTES, 'UTF-8') . "</code></p>";
    echo "<p><strong>SCRIPT_NAME:</strong> <code>" . htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? '', ENT_QUOTES, 'UTF-8') . "</code></p>";
    echo "<p><strong>DOCUMENT_ROOT:</strong> <code>" . htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? '', ENT_QUOTES, 'UTF-8') . "</code></p>";
    echo "<p><strong>__DIR__ (this file):</strong> <code>" . htmlspecialchars(__DIR__, ENT_QUOTES, 'UTF-8') . "</code></p>";

    echo "<h2>Configuration</h2>";
    echo "<p><strong>BASE_PATH:</strong> <code>" . (defined('BASE_PATH') ? htmlspecialchars(BASE_PATH, ENT_QUOTES, 'UTF-8') : 'NOT DEFINED') . "</code></p>";
    echo "<p><strong>ADMIN_PATH:</strong> <code>" . (defined('ADMIN_PATH') ? htmlspecialchars(ADMIN_PATH, ENT_QUOTES, 'UTF-8') : 'NOT DEFINED') . "</code></p>";
    echo "<p><strong>SITE_PATH:</strong> <code>" . (defined('SITE_PATH') ? htmlspecialchars(SITE_PATH, ENT_QUOTES, 'UTF-8') : 'NOT DEFINED') . "</code></p>";
    echo "<p><strong>BASE_URL:</strong> <code>" . (defined('BASE_URL') ? htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') : 'NOT DEFINED') . "</code></p>";
    echo "<p><strong>SITE_URL:</strong> <code>" . (defined('SITE_URL') ? htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8') : 'NOT DEFINED') . "</code></p>";
    echo "<p><strong>ADMIN_URL:</strong> <code>" . (defined('ADMIN_URL') ? htmlspecialchars(ADMIN_URL, ENT_QUOTES, 'UTF-8') : 'NOT DEFINED') . "</code></p>";
    echo "<p><strong>UPLOAD_DIR:</strong> " . UPLOAD_DIR . "</p>";
    echo "<p><strong>UPLOAD_URL:</strong> " . UPLOAD_URL . "</p>";

    // Also show what the *expected* upload dirs would be if project root is 2 levels up from /admin/includes
    $expectedProjectRoot = realpath(__DIR__ . '/..'); // __DIR__ = /admin; one up is project root (expected)
    $expectedRootUploads = $expectedProjectRoot ? ($expectedProjectRoot . '/assets/uploads/') : '';
    $expectedAdminUploads = realpath(__DIR__) ? (realpath(__DIR__) . '/assets/uploads/') : '';

    echo "<h2>Upload Directory Candidates</h2>";
    echo "<p class='info'><strong>Expected project root (from /admin):</strong> <code>" . htmlspecialchars($expectedProjectRoot ?: 'Could not resolve', ENT_QUOTES, 'UTF-8') . "</code></p>";
    echo "<p><strong>Expected ROOT uploads:</strong> <code>" . htmlspecialchars($expectedRootUploads ?: 'N/A', ENT_QUOTES, 'UTF-8') . "</code></p>";
    echo "<p><strong>Expected ADMIN uploads:</strong> <code>" . htmlspecialchars($expectedAdminUploads ?: 'N/A', ENT_QUOTES, 'UTF-8') . "</code></p>";

    $candidates = [
        'UPLOAD_DIR (current constant)' => UPLOAD_DIR,
        'Expected ROOT uploads' => $expectedRootUploads,
        'Expected ADMIN uploads' => $expectedAdminUploads,
    ];

    foreach ($candidates as $label => $path) {
        if (!$path) continue;
        $exists = file_exists($path);
        $writable = $exists ? is_writable($path) : false;
        $readable = $exists ? is_readable($path) : false;
        $perms = $exists ? substr(sprintf('%o', fileperms($path)), -4) : '----';
        echo "<div style='margin:10px 0; padding:10px; border:1px solid #ddd; border-radius:6px;'>";
        echo "<p><strong>{$label}:</strong> <code>" . htmlspecialchars($path, ENT_QUOTES, 'UTF-8') . "</code></p>";
        echo $exists ? "<p class='success'>✓ Exists</p>" : "<p class='error'>✗ Does NOT exist</p>";
        if ($exists) {
            echo "<p><strong>Permissions:</strong> <code>{$perms}</code> | Readable: <code>" . ($readable ? 'yes' : 'no') . "</code> | Writable: <code>" . ($writable ? 'yes' : 'no') . "</code></p>";
        }
        echo "</div>";
    }
    
    echo "<h2>Directory Status</h2>";
    
    // Check if base upload directory exists
    if (file_exists(UPLOAD_DIR)) {
        echo "<p class='success'>✓ Upload directory exists</p>";
        
        // Check permissions
        $perms = substr(sprintf('%o', fileperms(UPLOAD_DIR)), -4);
        echo "<p><strong>Permissions:</strong> " . $perms . "</p>";
        
        if (is_readable(UPLOAD_DIR)) {
            echo "<p class='success'>✓ Directory is readable</p>";
        } else {
            echo "<p class='error'>✗ Directory is NOT readable</p>";
        }
        
        if (is_writable(UPLOAD_DIR)) {
            echo "<p class='success'>✓ Directory is writable</p>";
        } else {
            echo "<p class='error'>✗ Directory is NOT writable</p>";
        }
        
        $realPath = realpath(UPLOAD_DIR);
        echo "<p><strong>Real path:</strong> " . ($realPath ? $realPath : 'Could not resolve') . "</p>";
        
    } else {
        echo "<p class='error'>✗ Upload directory does NOT exist</p>";
        echo "<p class='info'>Attempting to create directory...</p>";
        
        if (mkdir(UPLOAD_DIR, 0755, true)) {
            echo "<p class='success'>✓ Directory created successfully</p>";
        } else {
            echo "<p class='error'>✗ Failed to create directory</p>";
            $error = error_get_last();
            if ($error) {
                echo "<p class='error'>Error: " . $error['message'] . "</p>";
            }
        }
    }
    
    echo "<h2>PHP Upload Settings</h2>";
    echo "<p><strong>upload_max_filesize:</strong> " . ini_get('upload_max_filesize') . "</p>";
    echo "<p><strong>post_max_size:</strong> " . ini_get('post_max_size') . "</p>";
    echo "<p><strong>MAX_FILE_SIZE (config):</strong> " . (MAX_FILE_SIZE / 1024 / 1024) . " MB</p>";
    echo "<p><strong>file_uploads:</strong> " . (ini_get('file_uploads') ? 'Enabled' : 'Disabled') . "</p>";
    echo "<p><strong>upload_tmp_dir:</strong> " . (ini_get('upload_tmp_dir') ?: 'Default system temp') . "</p>";
    
    echo "<h2>Test Write</h2>";
    $testFile = UPLOAD_DIR . 'test_write_' . time() . '.txt';
    if (file_put_contents($testFile, 'test')) {
        echo "<p class='success'>✓ Successfully wrote test file: " . basename($testFile) . "</p>";
        if (unlink($testFile)) {
            echo "<p class='success'>✓ Successfully deleted test file</p>";
        } else {
            echo "<p class='warning'>⚠ Could not delete test file (not critical)</p>";
        }
    } else {
        echo "<p class='error'>✗ Failed to write test file</p>";
        $error = error_get_last();
        if ($error) {
            echo "<p class='error'>Error: " . $error['message'] . "</p>";
        }
    }
    
    echo "<h2>CSRF Token</h2>";
    $csrfToken = generateCSRFToken();
    echo "<p><strong>CSRF Token:</strong> " . substr($csrfToken, 0, 20) . "...</p>";
    echo "<p><strong>Session CSRF Token:</strong> " . (isset($_SESSION['csrf_token']) ? substr($_SESSION['csrf_token'], 0, 20) . "..." : 'Not set') . "</p>";
    
    echo "<h2>File Upload Test</h2>";
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
        echo "<h3>Upload Test Results</h3>";
        $file = $_FILES['test_file'];
        echo "<pre>";
        print_r($file);
        echo "</pre>";
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            echo "<p class='success'>✓ File uploaded successfully (PHP level)</p>";
            
            require_once __DIR__ . '/includes/functions.php';
            $result = uploadImage($file);
            
            if ($result['success']) {
                echo "<p class='success'>✓ File processed successfully by uploadImage()</p>";
                echo "<p><strong>Path:</strong> " . $result['path'] . "</p>";
                echo "<p><strong>Full Path:</strong> " . $result['full_path'] . "</p>";

                // Try to build URL the same way the API does and test HTTP headers
                $publicUrl = (defined('SITE_URL') ? rtrim(SITE_URL, '/') : '') . '/' . ltrim($result['path'], '/');
                echo "<p><strong>Public URL (SITE_URL + path):</strong> <code>" . htmlspecialchars($publicUrl, ENT_QUOTES, 'UTF-8') . "</code></p>";
                $headers = @get_headers($publicUrl);
                if ($headers && isset($headers[0])) {
                    echo "<p><strong>HTTP check:</strong> <code>" . htmlspecialchars($headers[0], ENT_QUOTES, 'UTF-8') . "</code></p>";
                } else {
                    echo "<p class='warning'>⚠ Could not fetch HTTP headers for URL (server may block get_headers)</p>";
                }
                
                // Clean up test file
                if (file_exists($result['full_path'])) {
                    @unlink($result['full_path']);
                }
            } else {
                echo "<p class='error'>✗ uploadImage() failed</p>";
                echo "<p class='error'>Errors: " . implode(', ', $result['errors']) . "</p>";
            }
        } else {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE in form',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
            ];
            echo "<p class='error'>✗ Upload error: " . ($errorMessages[$file['error']] ?? 'Unknown error') . "</p>";
        }
    } else {
        echo '<form method="POST" enctype="multipart/form-data">';
        echo '<p><input type="file" name="test_file" accept="image/*" required></p>';
        echo '<p><button type="submit">Test Upload</button></p>';
        echo '</form>';
    }
    ?>
    
    <hr>
    <p><a href="<?= ADMIN_URL ?>">Back to Admin</a></p>
</body>
</html>

