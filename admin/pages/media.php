<?php
/**
 * Media Library Page
 * Browse and manage uploaded media files
 */

$pageTitle = 'Media Library';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$page = max(1, intval($_GET['page'] ?? 1));
$search = sanitize($_GET['search'] ?? '');
$perPage = 20;
$offset = ($page - 1) * $perPage;

$where = [];
$params = [];

if ($search) {
    $where[] = "(original_name LIKE ? OR filename LIKE ?)";
    $searchTerm = "%{$search}%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

try {
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
    $mediaFiles = $stmt->fetchAll();
    
    $totalPages = ceil($total / $perPage);
} catch(PDOException $e) {
    error_log("Media library error: " . $e->getMessage());
    $mediaFiles = [];
    $total = 0;
    $totalPages = 0;
}
?>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Media Library</h2>
        <button class="btn btn-primary" onclick="document.getElementById('uploadModal').style.display='block'">
            <i class="fas fa-upload"></i> Upload Media
        </button>
    </div>
    
    <div style="padding: 20px; border-bottom: 1px solid var(--border-color);">
        <form method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search media..." value="<?= $search ?>" style="flex: 1;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Search
            </button>
            <?php if ($search): ?>
                <a href="<?= ADMIN_URL ?>pages/media.php" class="btn btn-outline">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    
    <?php if (empty($mediaFiles)): ?>
        <div style="padding: 40px; text-align: center; color: var(--text-muted);">
            <i class="fas fa-images" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
            <p>No media files found.</p>
            <?php if (!$search): ?>
                <button class="btn btn-primary mt-20" onclick="document.getElementById('uploadModal').style.display='block'">
                    Upload Your First Media File
                </button>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; padding: 20px;">
            <?php foreach ($mediaFiles as $media): ?>
                <div class="media-item" style="border: 1px solid var(--border-color); border-radius: 4px; overflow: hidden;">
                    <div style="position: relative; padding-top: 100%; background: var(--bg-color);">
                        <?php if (strpos($media['file_type'], 'image/') === 0): ?>
                            <img src="<?= SITE_URL . $media['file_path'] ?>" 
                                 alt="<?= sanitize($media['original_name']) ?>"
                                 style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                <i class="fas fa-file" style="font-size: 48px; color: var(--text-muted);"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div style="padding: 10px;">
                        <p style="font-size: 12px; margin-bottom: 5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?= sanitize($media['original_name']) ?>
                        </p>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 10px;">
                            <?= formatFileSize($media['file_size']) ?>
                        </p>
                        <div style="display: flex; gap: 5px;">
                            <button onclick="copyToClipboard('<?= SITE_URL . $media['file_path'] ?>')" 
                                    class="btn btn-sm btn-outline" style="flex: 1;">
                                <i class="fas fa-copy"></i>
                            </button>
                            <button onclick="deleteMedia(<?= $media['id'] ?>)" 
                                    class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($totalPages > 1): ?>
            <div style="padding: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                <p style="color: var(--text-muted);">Page <?= $page ?> of <?= $totalPages ?></p>
                <div style="display: flex; gap: 10px;">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" class="btn btn-sm btn-outline">Previous</a>
                    <?php endif; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" class="btn btn-sm btn-outline">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Upload Modal -->
<div id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 8px; max-width: 500px; width: 90%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Upload Media</h2>
            <button onclick="document.getElementById('uploadModal').style.display='none'" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="form-group">
                <label>Select Files</label>
                <input type="file" name="files[]" id="fileInput" required accept="image/jpeg,image/jpg,image/png,image/webp" multiple>
                <p style="margin-top: 5px; color: #666; font-size: 12px;">Supported formats: JPEG, PNG, WebP. You can select multiple files.</p>
            </div>
            
            <div id="previewArea" style="display: none; margin-bottom: 20px;">
                <div id="previewGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; max-height: 400px; overflow-y: auto;"></div>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('uploadModal').style.display='none'" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('fileInput').addEventListener('change', function(e) {
    const files = Array.from(e.target.files || []);
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    const validFiles = files.filter(file => allowedTypes.includes(file.type.toLowerCase()));
    
    if (validFiles.length === 0 && files.length > 0) {
        showToast('Please select JPEG, PNG, or WebP images only', 'error');
        e.target.value = '';
        return;
    }
    
    const previewArea = document.getElementById('previewArea');
    const previewGrid = document.getElementById('previewGrid');
    
    if (previewGrid && validFiles.length > 0) {
        previewGrid.innerHTML = '';
        validFiles.forEach((file) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.style.cssText = 'position: relative; padding-top: 100%; background: #f0f0f0; border-radius: 4px; overflow: hidden;';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;';
                    img.alt = file.name;
                    previewItem.appendChild(img);
                    previewGrid.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            }
        });
        previewArea.style.display = 'block';
    }
});

document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const fileInput = document.getElementById('fileInput');
    const files = Array.from(fileInput.files || []);
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    const validFiles = files.filter(file => allowedTypes.includes(file.type.toLowerCase()));
    
    if (validFiles.length === 0) {
        showToast('Please select JPEG, PNG, or WebP images only', 'error');
        return;
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Upload files sequentially
    let uploadedCount = 0;
    let failedCount = 0;
    
    function uploadNext(index) {
        if (index >= validFiles.length) {
            // All uploads complete
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            
            if (uploadedCount > 0) {
                const message = failedCount > 0
                    ? `${uploadedCount} file(s) uploaded successfully, ${failedCount} failed`
                    : `${uploadedCount} file(s) uploaded successfully`;
                showToast(message, failedCount > 0 ? 'warning' : 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('All uploads failed. Please try again.', 'error');
            }
            return;
        }
        
        const file = validFiles[index];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('csrf_token', csrfToken);
        
        if (index === 0) {
            submitBtn.disabled = true;
            submitBtn.textContent = `Uploading ${validFiles.length} file(s)...`;
        }
        
        fetch('<?= ADMIN_URL ?>api/media.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                uploadedCount++;
            } else {
                failedCount++;
            }
            uploadNext(index + 1);
        })
        .catch(error => {
            console.error('Upload error:', error);
            failedCount++;
            uploadNext(index + 1);
        });
    }
    
    uploadNext(0);
});

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('URL copied to clipboard', 'success');
    });
}

function deleteMedia(id) {
    if (!confirm('Are you sure you want to delete this media file?')) {
        return;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    fetch('<?= ADMIN_URL ?>api/media.php?id=' + id + '&csrf_token=' + encodeURIComponent(csrfToken), {
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

