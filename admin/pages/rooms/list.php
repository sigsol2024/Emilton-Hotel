<?php
/**
 * Rooms List Page
 * Display all rooms with filters and actions
 */

$pageTitle = 'Rooms';
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/header.php';

$page = max(1, intval($_GET['page'] ?? 1));
$status = $_GET['status'] ?? '';
$featured = $_GET['featured'] ?? '';
$perPage = 20;
$offset = ($page - 1) * $perPage;

$where = [];
$params = [];

if ($status !== '') {
    $where[] = "is_active = ?";
    $params[] = intval($status);
}

if ($featured !== '') {
    $where[] = "is_featured = ?";
    $params[] = intval($featured);
}

$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

try {
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM rooms {$whereClause}");
    $countStmt->execute($params);
    $total = $countStmt->fetchColumn();
    
    $stmt = $pdo->prepare("SELECT * FROM rooms {$whereClause} ORDER BY display_order ASC, created_at DESC LIMIT ? OFFSET ?");
    $params[] = $perPage;
    $params[] = $offset;
    $stmt->execute($params);
    $rooms = $stmt->fetchAll();
    
    $totalPages = ceil($total / $perPage);
} catch(PDOException $e) {
    error_log("Rooms list error: " . $e->getMessage());
    $rooms = [];
    $total = 0;
    $totalPages = 0;
}
?>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Rooms</h2>
        <a href="<?= ADMIN_URL ?>pages/rooms/add.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Room
        </a>
    </div>
    
    <div style="padding: 20px; border-bottom: 1px solid var(--border-color);">
        <form method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <select name="status" style="padding: 8px;">
                <option value="">All Status</option>
                <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Inactive</option>
            </select>
            <select name="featured" style="padding: 8px;">
                <option value="">All Rooms</option>
                <option value="1" <?= $featured === '1' ? 'selected' : '' ?>>Featured Only</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
            <?php if ($status !== '' || $featured !== ''): ?>
                <a href="<?= ADMIN_URL ?>pages/rooms/list.php" class="btn btn-outline">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    
    <?php if (empty($rooms)): ?>
        <div style="padding: 40px; text-align: center; color: var(--text-muted);">
            <i class="fas fa-bed" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
            <p>No rooms found.</p>
            <a href="<?= ADMIN_URL ?>pages/rooms/add.php" class="btn btn-primary mt-20">Add Your First Room</a>
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td>
                                <?php if (!empty($room['main_image'])): 
                                    $imagePath = trim($room['main_image']);
                                    // Ensure path doesn't start with / to avoid double slashes
                                    $imagePath = ltrim($imagePath, '/');
                                    $fullImageUrl = SITE_URL . $imagePath;
                                ?>
                                    <img src="<?= htmlspecialchars($fullImageUrl, ENT_QUOTES, 'UTF-8') ?>" 
                                         alt="<?= sanitize($room['title']) ?>"
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; background: var(--bg-color);"
                                         onload="console.log('Image loaded:', '<?= htmlspecialchars($fullImageUrl, ENT_QUOTES, 'UTF-8') ?>');"
                                         onerror="console.error('Image failed to load:', '<?= htmlspecialchars($fullImageUrl, ENT_QUOTES, 'UTF-8') ?>'); this.onerror=null; this.parentElement.innerHTML='<div style=\'width: 60px; height: 60px; background: var(--bg-color); border-radius: 4px; display: flex; align-items: center; justify-content: center;\'><i class=\'fas fa-image\' style=\'color: var(--text-muted);\'></i></div>';">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; background: var(--bg-color); border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-bed" style="color: var(--text-muted);"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= sanitize($room['title']) ?></strong><br>
                                <small style="color: var(--text-muted);"><?= sanitize($room['slug']) ?></small>
                            </td>
                            <td><?= sanitize($room['room_type']) ?: '-' ?></td>
                            <td>₦<?= number_format($room['price'], 2) ?></td>
                            <td>
                                <?php if ($room['is_active']): ?>
                                    <span style="color: var(--success-color);"><i class="fas fa-check-circle"></i> Active</span>
                                <?php else: ?>
                                    <span style="color: var(--text-muted);"><i class="fas fa-times-circle"></i> Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($room['is_featured']): ?>
                                    <span style="color: var(--warning-color);"><i class="fas fa-star"></i> Featured</span>
                                <?php else: ?>
                                    <span style="color: var(--text-muted);">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?= ADMIN_URL ?>pages/rooms/edit.php?id=<?= $room['id'] ?>" 
                                       class="btn btn-sm btn-outline" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteRoom(<?= $room['id'] ?>)" 
                                            class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($totalPages > 1): ?>
            <div style="padding: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <p style="color: var(--text-muted);">Page <?= $page ?> of <?= $totalPages ?> (<?= $total ?> total)</p>
                <div style="display: flex; gap: 10px;">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?><?= $status !== '' ? '&status=' . $status : '' ?><?= $featured !== '' ? '&featured=' . $featured : '' ?>" 
                           class="btn btn-sm btn-outline">Previous</a>
                    <?php endif; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?><?= $status !== '' ? '&status=' . $status : '' ?><?= $featured !== '' ? '&featured=' . $featured : '' ?>" 
                           class="btn btn-sm btn-outline">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
function deleteRoom(id) {
    if (!confirm('Are you sure you want to delete this room? This action cannot be undone.')) {
        return;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    fetch('<?= ADMIN_URL ?>api/rooms.php?id=' + id + '&csrf_token=' + encodeURIComponent(csrfToken), {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Delete error:', error);
        showToast('An error occurred while deleting the room.', 'error');
    });
}
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

