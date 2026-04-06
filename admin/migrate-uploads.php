<?php
/**
 * One-time migration: move uploads from /admin/assets/uploads -> /assets/uploads
 *
 * WHY: Previously BASE_PATH was wrong, so UPLOAD_DIR pointed at /admin/assets/uploads.
 * The public site serves /assets/uploads, so images 404 even though they were "uploaded".
 *
 * After running successfully, DELETE this file.
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

requireLogin();

header('Content-Type: text/html; charset=utf-8');

$fromDir = realpath(SITE_PATH . '/admin/assets/uploads');
$toDir = SITE_PATH . '/assets/uploads';

function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Upload Migration</title>
  <style>
    body{font-family:Arial,sans-serif;margin:20px}
    code{background:#f5f5f5;padding:2px 4px;border-radius:3px}
    .ok{color:green}.bad{color:#b91c1c}.warn{color:#b45309}
    pre{background:#f5f5f5;padding:10px;border-radius:6px;overflow:auto}
  </style>
</head>
<body>
  <h1>Upload Migration</h1>
  <p><strong>From:</strong> <code><?= h($fromDir ?: 'NOT FOUND') ?></code></p>
  <p><strong>To:</strong> <code><?= h($toDir) ?></code></p>

<?php
if (!$fromDir || !is_dir($fromDir)) {
    echo "<p class='warn'>Nothing to migrate: source folder not found.</p>";
    echo "<p>Remove this file: <code>admin/migrate-uploads.php</code></p>";
    exit;
}

if (!file_exists($toDir)) {
    if (!mkdir($toDir, 0755, true)) {
        echo "<p class='bad'>Failed to create destination folder. Check permissions for <code>" . h($toDir) . "</code></p>";
        exit;
    }
}

if (!is_writable($toDir)) {
    echo "<p class='bad'>Destination folder is not writable: <code>" . h($toDir) . "</code></p>";
    exit;
}

$files = glob($fromDir . '/*');
$moved = 0;
$skipped = 0;
$errors = 0;
$details = [];

foreach ($files as $src) {
    if (!is_file($src)) continue;
    $base = basename($src);
    $dst = rtrim($toDir, '/\\') . '/' . $base;

    if (file_exists($dst)) {
        $skipped++;
        $details[] = "SKIP exists: {$base}";
        continue;
    }

    // Try rename (same filesystem). If it fails, fall back to copy+unlink.
    if (@rename($src, $dst)) {
        $moved++;
        $details[] = "MOVED: {$base}";
        continue;
    }

    if (@copy($src, $dst)) {
        @unlink($src);
        $moved++;
        $details[] = "COPIED: {$base}";
        continue;
    }

    $errors++;
    $details[] = "ERROR: {$base}";
}

echo "<h2>Result</h2>";
echo "<p class='ok'>Moved/Copied: <strong>{$moved}</strong></p>";
echo "<p class='warn'>Skipped (already existed): <strong>{$skipped}</strong></p>";
echo "<p class='bad'>Errors: <strong>{$errors}</strong></p>";

echo "<h2>Details</h2>";
echo "<pre>" . h(implode("\n", $details)) . "</pre>";

echo "<h2>Next</h2>";
echo "<ol>";
echo "<li>Verify some image URLs load: <code>" . h(rtrim(SITE_URL, '/')) . "/assets/uploads/&lt;filename&gt;</code></li>";
echo "<li><strong>Delete this file</strong>: <code>admin/migrate-uploads.php</code></li>";
echo "</ol>";
?>

</body>
</html>


