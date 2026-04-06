<?php
/**
 * Reset Admin Password Script
 * Use this to reset or create the admin password
 * DELETE THIS FILE AFTER USE FOR SECURITY
 */

require_once __DIR__ . '/includes/config.php';

// Check if admin user exists
$stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
$stmt->execute(['admin']);
$user = $stmt->fetch();

// Password to set (change this if needed)
$newPassword = 'Admin@123';
$passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);

if ($user) {
    // Update existing admin user
    $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
    $stmt->execute([$passwordHash, 'admin']);
    echo "✓ Admin password updated successfully!<br>";
    echo "Username: admin<br>";
    echo "Password: " . htmlspecialchars($newPassword) . "<br><br>";
    echo "Please DELETE this file (reset-admin-password.php) immediately after use!";
} else {
    // Create new admin user
    $stmt = $pdo->prepare("INSERT INTO admin_users (username, email, password_hash, is_active) VALUES (?, ?, ?, ?)");
    $stmt->execute(['admin', 'admin@hotel.local', $passwordHash, 1]);
    echo "✓ Admin user created successfully!<br>";
    echo "Username: admin<br>";
    echo "Password: " . htmlspecialchars($newPassword) . "<br><br>";
    echo "Please DELETE this file (reset-admin-password.php) immediately after use!";
}

echo "<br><br><h3>Test Password Hash</h3>";
echo "Testing password verification: ";
if (password_verify($newPassword, $passwordHash)) {
    echo "✓ Password verification works!";
} else {
    echo "✗ Password verification FAILED!";
}
?>

