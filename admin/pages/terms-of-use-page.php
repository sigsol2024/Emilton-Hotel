<?php
/**
 * Terms of Use Page Editor
 */

$pageTitle = 'Terms of Use Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all terms of use page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'terms-of-use' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Terms of use page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="termsOfUsePageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Page Header -->
    <div class="card">
        <div class="card-header">
            <h2>Page Header</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="hero_title">Page Title</label>
                <input type="text" id="hero_title" name="hero_title" value="<?= sanitize($sectionsArray['hero_title'] ?? 'Terms of Use') ?>">
                <p class="form-help">Title displayed in the page header</p>
            </div>
            
            <div class="form-group">
                <label>Header Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('hero_background', 'header_bg_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="hero_background" name="hero_background" value="<?= sanitize($sectionsArray['hero_background'] ?? '') ?>">
                <div id="header_bg_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['hero_background']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['hero_background'])): ?>
                        <img id="header_bg_img" src="<?= SITE_URL . ltrim($sectionsArray['hero_background'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Select an image from the media library or upload a new one</p>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="card">
        <div class="card-header">
            <h2>Terms of Use Content</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="main_content">Terms Content</label>
                <textarea id="main_content" name="main_content" rows="25" style="font-family: monospace; font-size: 14px;"><?= htmlspecialchars($sectionsArray['main_content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                <p class="form-help">HTML allowed. You can format the terms content using HTML tags like &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, etc.</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Terms of Use Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
// Handle media modal selection for hero background
window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const targetInputId = mediaModalState.targetInputId;
    
    if (targetInputId === 'hero_background') {
        const input = document.getElementById('hero_background');
        const preview = document.getElementById('header_bg_preview');
        const previewImg = document.getElementById('header_bg_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="header_bg_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    return false;
};

// Form submission
document.getElementById('termsOfUsePageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all form fields
    const fields = ['hero_title', 'hero_background', 'main_content'];
    fields.forEach(field => {
        if (formData.has(field)) {
            sections[field] = formData.get(field);
        }
    });
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const promises = Object.keys(sections).map(key => {
        return fetch('<?= ADMIN_URL ?>api/pages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
            body: JSON.stringify({
                page: 'terms-of-use',
                section_key: key,
                content_type: key.includes('image') || key.includes('background') ? 'image' : 'html',
                content: sections[key]
            })
        }).then(response => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Invalid JSON response:', text);
                    throw new Error('Invalid response');
                }
            });
        });
    });
    
    Promise.all(promises).then(results => {
        const allSuccess = results.every(r => r.success);
        if (allSuccess) {
            if (typeof showToast === 'function') {
                showToast('Terms of Use page content saved successfully', 'success');
            }
        } else {
            if (typeof showToast === 'function') {
                showToast('Some sections failed to save', 'warning');
            }
        }
    })
    .catch(error => {
        console.error('Save error:', error);
        if (typeof showToast === 'function') {
            showToast('An error occurred: ' + error.message, 'error');
        }
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

