<?php
/**
 * Simple test file to debug connection issues
 * Delete this file after fixing the issue
 */

// Enable error reporting first
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load config FIRST before any output
try {
    require_once __DIR__ . '/includes/config.php';
} catch (Exception $e) {
    die("Config Error: " . $e->getMessage() . "<br>File: " . $e->getFile() . "<br>Line: " . $e->getLine());
}

// Now output HTML
echo "<h2>PHP Test</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "PDO Available: " . (extension_loaded('pdo') ? 'Yes' : 'No') . "<br>";
echo "PDO MySQL Available: " . (extension_loaded('pdo_mysql') ? 'Yes' : 'No') . "<br><br>";

echo "<h2>Config Loaded</h2>";
try {
    echo "✓ Config loaded successfully!<br>";
    echo "DB_HOST: " . DB_HOST . "<br>";
    echo "DB_USER: " . DB_USER . "<br>";
    echo "DB_NAME: " . DB_NAME . "<br><br>";
    
    echo "<h2>Database Connection Test</h2>";
    if (isset($pdo)) {
        echo "✓ PDO object created!<br>";
        
        // Test connection
        $stmt = $pdo->query("SELECT 1");
        if ($stmt) {
            echo "✓ Database connection successful!<br>";
            
            // Test if tables exist
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "Tables found: " . count($tables) . "<br>";
            if (count($tables) > 0) {
                echo "Table names: " . implode(', ', $tables) . "<br>";
            }
        }
    } else {
        echo "✗ PDO object not created!<br>";
    }
} catch (Exception $e) {
    echo "<div style='color:red;'>";
    echo "✗ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
    echo "</div>";
}

echo "<br><br><h2>File Checks</h2>";
$files = [
    'admin/includes/config.php',
    'admin/includes/auth.php',
    'admin/includes/functions.php',
    'admin/index.php',
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . str_replace('admin/', '', $file);
    if (file_exists($path)) {
        echo "✓ $file exists<br>";
    } else {
        echo "✗ $file MISSING<br>";
    }
}

echo "<br><br><h2>Session Test</h2>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "✓ Session is active<br>";
} else {
    echo "✗ Session is not active<br>";
}
?>

