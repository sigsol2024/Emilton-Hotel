<?php
/**
 * Admin Dashboard
 * Main dashboard with statistics and quick actions
 */

$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';

// Get statistics
try {
    $roomsCount = $pdo->query("SELECT COUNT(*) FROM rooms WHERE is_active = 1")->fetchColumn();
    $totalRooms = $pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
    $featuredRooms = $pdo->query("SELECT COUNT(*) FROM rooms WHERE is_featured = 1 AND is_active = 1")->fetchColumn();
    $testimonialsCount = $pdo->query("SELECT COUNT(*) FROM testimonials WHERE is_active = 1")->fetchColumn();
    $mediaCount = $pdo->query("SELECT COUNT(*) FROM media")->fetchColumn();
    
    // Recent rooms
    $recentRooms = $pdo->query("SELECT id, title, created_at FROM rooms ORDER BY created_at DESC LIMIT 5")->fetchAll();
} catch(PDOException $e) {
    error_log("Dashboard error: " . $e->getMessage());
    $roomsCount = 0;
    $totalRooms = 0;
    $featuredRooms = 0;
    $testimonialsCount = 0;
    $mediaCount = 0;
    $recentRooms = [];
}
?>

<div class="dashboard-stats">
    <div class="stat-card">
        <h3>Active Rooms</h3>
        <p class="stat-number"><?= $roomsCount ?></p>
        <p class="text-muted">of <?= $totalRooms ?> total</p>
    </div>
    <div class="stat-card">
        <h3>Featured Rooms</h3>
        <p class="stat-number"><?= $featuredRooms ?></p>
    </div>
    <div class="stat-card">
        <h3>Active Testimonials</h3>
        <p class="stat-number"><?= $testimonialsCount ?></p>
    </div>
    <div class="stat-card">
        <h3>Media Files</h3>
        <p class="stat-number"><?= $mediaCount ?></p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Quick Actions</h2>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <a href="<?= ADMIN_URL ?>pages/rooms/add.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Room
        </a>
        <a href="<?= ADMIN_URL ?>pages/testimonials.php" class="btn btn-outline">
            <i class="fas fa-comments"></i> Manage Testimonials
        </a>
        <a href="<?= ADMIN_URL ?>pages/media.php" class="btn btn-outline">
            <i class="fas fa-folder"></i> Media Library
        </a>
        <a href="<?= ADMIN_URL ?>pages/settings.php" class="btn btn-outline">
            <i class="fas fa-cog"></i> Site Settings
        </a>
    </div>
</div>

<?php if (!empty($recentRooms)): ?>
<div class="card">
    <div class="card-header">
        <h2>Recent Rooms</h2>
    </div>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentRooms as $room): ?>
                <tr>
                    <td><?= sanitize($room['title']) ?></td>
                    <td><?= date('M d, Y', strtotime($room['created_at'])) ?></td>
                    <td>
                        <a href="<?= ADMIN_URL ?>pages/rooms/edit.php?id=<?= $room['id'] ?>" class="btn btn-sm btn-outline">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div style="padding: 15px; text-align: right;">
        <a href="<?= ADMIN_URL ?>pages/rooms/list.php" class="btn btn-sm">View All Rooms</a>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

