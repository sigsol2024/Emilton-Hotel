<?php
/**
 * Testimonials Management Page
 */

$pageTitle = 'Testimonials';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$page = max(1, intval($_GET['page'] ?? 1));
$status = $_GET['status'] ?? '';
$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);

// Handle edit/add form
if ($action === 'edit' && $id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
        $stmt->execute([$id]);
        $testimonial = $stmt->fetch();
        
        if (!$testimonial) {
            redirect(ADMIN_URL . 'pages/testimonials.php');
        }
    } catch(PDOException $e) {
        redirect(ADMIN_URL . 'pages/testimonials.php');
    }
} elseif ($action === 'add') {
    $testimonial = [
        'author_name' => '',
        'quote' => '',
        'rating' => 5,
        'is_active' => 1,
        'display_order' => 0
    ];
}

if ($action === 'list' || empty($action)) {
    // List testimonials
    $perPage = 20;
    $offset = ($page - 1) * $perPage;
    
    $where = [];
    $params = [];
    
    if ($status !== '') {
        $where[] = "is_active = ?";
        $params[] = intval($status);
    }
    
    $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
    
    try {
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM testimonials {$whereClause}");
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        
        $stmt = $pdo->prepare("SELECT * FROM testimonials {$whereClause} ORDER BY display_order ASC, created_at DESC LIMIT ? OFFSET ?");
        $params[] = $perPage;
        $params[] = $offset;
        $stmt->execute($params);
        $testimonials = $stmt->fetchAll();
        
        $totalPages = ceil($total / $perPage);
    } catch(PDOException $e) {
        $testimonials = [];
        $total = 0;
        $totalPages = 0;
    }
}

$csrfToken = generateCSRFToken();
?>

<?php if ($action === 'add' || ($action === 'edit' && isset($testimonial))): ?>
    <!-- Add/Edit Form -->
    <div class="card">
        <div class="card-header">
            <h2><?= $action === 'add' ? 'Add New Testimonial' : 'Edit Testimonial' ?></h2>
        </div>
        
        <form id="testimonialForm" style="padding: 20px;">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            
            <div class="form-group">
                <label for="author_name">Author Name *</label>
                <input type="text" id="author_name" name="author_name" value="<?= sanitize($testimonial['author_name']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="quote">Quote *</label>
                <textarea id="quote" name="quote" rows="4" required><?= sanitize($testimonial['quote']) ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select id="rating" name="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>" <?= $testimonial['rating'] == $i ? 'selected' : '' ?>><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="display_order">Display Order</label>
                    <input type="number" id="display_order" name="display_order" value="<?= $testimonial['display_order'] ?>" min="0">
                    <p class="form-help">Lower numbers appear first</p>
                </div>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" <?= $testimonial['is_active'] ? 'checked' : '' ?>> Active
                </label>
            </div>
            
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary"><?= $action === 'add' ? 'Create' : 'Update' ?> Testimonial</button>
                <a href="<?= ADMIN_URL ?>pages/testimonials.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
    
    <script>
    document.getElementById('testimonialForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = {
            author_name: formData.get('author_name'),
            quote: formData.get('quote'),
            rating: parseInt(formData.get('rating')),
            display_order: parseInt(formData.get('display_order')),
            is_active: this.querySelector('[name="is_active"]').checked ? 1 : 0
        };
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Saving...';
        
        const url = '<?= ADMIN_URL ?>api/testimonials.php<?= $action === 'edit' ? '?id=' . $id : '' ?>';
        const method = '<?= $action === 'edit' ? 'PUT' : 'POST' ?>';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => {
                    window.location.href = '<?= ADMIN_URL ?>pages/testimonials.php';
                }, 1000);
            } else {
                showToast(data.message, 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        })
        .catch(error => {
            showToast('An error occurred', 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
    </script>
    
<?php else: ?>
    <!-- List View -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Testimonials</h2>
            <a href="<?= ADMIN_URL ?>pages/testimonials.php?action=add" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Testimonial
            </a>
        </div>
        
        <div style="padding: 20px; border-bottom: 1px solid var(--border-color);">
            <form method="GET" style="display: flex; gap: 10px;">
                <select name="status" style="padding: 8px;">
                    <option value="">All Status</option>
                    <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Inactive</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <?php if ($status !== ''): ?>
                    <a href="<?= ADMIN_URL ?>pages/testimonials.php" class="btn btn-outline">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        
        <?php if (empty($testimonials)): ?>
            <div style="padding: 40px; text-align: center; color: var(--text-muted);">
                <i class="fas fa-comments" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                <p>No testimonials found.</p>
                <a href="<?= ADMIN_URL ?>pages/testimonials.php?action=add" class="btn btn-primary mt-20">Add Your First Testimonial</a>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th>Quote</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonials as $testimonial): ?>
                            <tr>
                                <td><strong><?= sanitize($testimonial['author_name']) ?></strong></td>
                                <td><?= sanitize(substr($testimonial['quote'], 0, 100)) ?><?= strlen($testimonial['quote']) > 100 ? '...' : '' ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star" style="color: <?= $i <= $testimonial['rating'] ? '#ffc107' : '#ddd' ?>;"></i>
                                    <?php endfor; ?>
                                </td>
                                <td>
                                    <?php if ($testimonial['is_active']): ?>
                                        <span style="color: var(--success-color);">Active</span>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $testimonial['display_order'] ?></td>
                                <td>
                                    <div class="table-actions">
                                        <a href="?action=edit&id=<?= $testimonial['id'] ?>" class="btn btn-sm btn-outline">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteTestimonial(<?= $testimonial['id'] ?>)" class="btn btn-sm btn-danger">
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
                    <p style="color: var(--text-muted);">Page <?= $page ?> of <?= $totalPages ?></p>
                    <div style="display: flex; gap: 10px;">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?><?= $status !== '' ? '&status=' . $status : '' ?>" class="btn btn-sm btn-outline">Previous</a>
                        <?php endif; ?>
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?><?= $status !== '' ? '&status=' . $status : '' ?>" class="btn btn-sm btn-outline">Next</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <script>
    function deleteTestimonial(id) {
        if (!confirmDelete('Are you sure you want to delete this testimonial?')) {
            return;
        }
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        fetch('<?= ADMIN_URL ?>api/testimonials.php?id=' + id + '&csrf_token=' + encodeURIComponent(csrfToken), {
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
        });
    }
    </script>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

