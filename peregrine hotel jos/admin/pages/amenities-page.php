<?php
/**
 * Amenities Page Editor
 */

$pageTitle = 'Amenities Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all amenities page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'amenities' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Amenities page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="amenitiesPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Hero Section -->
    <div class="card">
        <div class="card-header">
            <h2>Hero Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="page_title">Page Title</label>
                <input type="text" id="page_title" name="page_title" value="<?= sanitize($sectionsArray['page_title'] ?? 'Hotel Amenities & Facilities') ?>">
            </div>
            
            <div class="form-group">
                <label for="page_subtitle">Page Subtitle</label>
                <textarea id="page_subtitle" name="page_subtitle" rows="2"><?= sanitize($sectionsArray['page_subtitle'] ?? 'Experience the pinnacle of relaxation and luxury at Peregrine Hotel Rayfield. Every detail is curated for your comfort.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Hero Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('hero_background', 'hero_bg_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="hero_background" name="hero_background" value="<?= sanitize($sectionsArray['hero_background'] ?? '') ?>">
                <div id="hero_bg_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['hero_background']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['hero_background'])): 
                        $heroImgSrc = $sectionsArray['hero_background'];
                        if (strpos($heroImgSrc, 'http://') === 0 || strpos($heroImgSrc, 'https://') === 0) {
                            $heroImgUrl = $heroImgSrc;
                        } else {
                            $heroImgUrl = SITE_URL . ltrim($heroImgSrc, '/');
                        }
                    ?>
                        <img id="hero_bg_img" src="<?= htmlspecialchars($heroImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Swimming Pool Section -->
    <div class="card">
        <div class="card-header">
            <h2>Swimming Pool Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="pool_label">Label</label>
                <input type="text" id="pool_label" name="pool_label" value="<?= sanitize($sectionsArray['pool_label'] ?? 'Relaxation') ?>">
            </div>
            
            <div class="form-group">
                <label for="pool_title">Title</label>
                <input type="text" id="pool_title" name="pool_title" value="<?= sanitize($sectionsArray['pool_title'] ?? 'Serene Swimming Pool') ?>">
            </div>
            
            <div class="form-group">
                <label for="pool_description">Description</label>
                <textarea id="pool_description" name="pool_description" rows="4"><?= sanitize($sectionsArray['pool_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Pool Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('pool_image', 'pool_image_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="pool_image" name="pool_image" value="<?= sanitize($sectionsArray['pool_image'] ?? '') ?>">
                <div id="pool_image_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['pool_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['pool_image'])): 
                        $poolImgSrc = $sectionsArray['pool_image'];
                        if (strpos($poolImgSrc, 'http://') === 0 || strpos($poolImgSrc, 'https://') === 0) {
                            $poolImgUrl = $poolImgSrc;
                        } else {
                            $poolImgUrl = SITE_URL . ltrim($poolImgSrc, '/');
                        }
                    ?>
                        <img id="pool_image_img" src="<?= htmlspecialchars($poolImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Restaurant Section -->
    <div class="card">
        <div class="card-header">
            <h2>Restaurant & Dining Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="restaurant_label">Label</label>
                <input type="text" id="restaurant_label" name="restaurant_label" value="<?= sanitize($sectionsArray['restaurant_label'] ?? 'Culinary') ?>">
            </div>
            
            <div class="form-group">
                <label for="restaurant_title">Title</label>
                <input type="text" id="restaurant_title" name="restaurant_title" value="<?= sanitize($sectionsArray['restaurant_title'] ?? 'Gourmet Restaurant & Dining') ?>">
            </div>
            
            <div class="form-group">
                <label for="restaurant_description">Description</label>
                <textarea id="restaurant_description" name="restaurant_description" rows="4"><?= sanitize($sectionsArray['restaurant_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Restaurant Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('restaurant_image', 'restaurant_image_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="restaurant_image" name="restaurant_image" value="<?= sanitize($sectionsArray['restaurant_image'] ?? '') ?>">
                <div id="restaurant_image_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['restaurant_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['restaurant_image'])): 
                        $restaurantImgSrc = $sectionsArray['restaurant_image'];
                        if (strpos($restaurantImgSrc, 'http://') === 0 || strpos($restaurantImgSrc, 'https://') === 0) {
                            $restaurantImgUrl = $restaurantImgSrc;
                        } else {
                            $restaurantImgUrl = SITE_URL . ltrim($restaurantImgSrc, '/');
                        }
                    ?>
                        <img id="restaurant_image_img" src="<?= htmlspecialchars($restaurantImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Leisure Spaces Section -->
    <div class="card">
        <div class="card-header">
            <h2>Leisure Spaces Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="leisure_label">Label</label>
                <input type="text" id="leisure_label" name="leisure_label" value="<?= sanitize($sectionsArray['leisure_label'] ?? 'Lifestyle') ?>">
            </div>
            
            <div class="form-group">
                <label for="leisure_title">Title</label>
                <input type="text" id="leisure_title" name="leisure_title" value="<?= sanitize($sectionsArray['leisure_title'] ?? 'Exclusive Leisure Spaces') ?>">
            </div>
            
            <div class="form-group">
                <label for="leisure_description">Description</label>
                <textarea id="leisure_description" name="leisure_description" rows="4"><?= sanitize($sectionsArray['leisure_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Leisure Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('leisure_image', 'leisure_image_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="leisure_image" name="leisure_image" value="<?= sanitize($sectionsArray['leisure_image'] ?? '') ?>">
                <div id="leisure_image_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['leisure_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['leisure_image'])): 
                        $leisureImgSrc = $sectionsArray['leisure_image'];
                        if (strpos($leisureImgSrc, 'http://') === 0 || strpos($leisureImgSrc, 'https://') === 0) {
                            $leisureImgUrl = $leisureImgSrc;
                        } else {
                            $leisureImgUrl = SITE_URL . ltrim($leisureImgSrc, '/');
                        }
                    ?>
                        <img id="leisure_image_img" src="<?= htmlspecialchars($leisureImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Amenities Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>

// Handle media modal selection
window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const targetInputId = mediaModalState.targetInputId;
    
    // Helper function to update image preview
    function updateImagePreview(inputId, previewId, imgId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const previewImg = document.getElementById(imgId);
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            let imgUrl = selected.path;
            if (!imgUrl.startsWith('http://') && !imgUrl.startsWith('https://')) {
                imgUrl = '<?= SITE_URL ?>' + imgUrl.replace(/^\//, '');
            }
            if (previewImg) {
                previewImg.src = imgUrl;
            } else {
                preview.innerHTML = '<img id="' + imgId + '" src="' + imgUrl + '" style="max-width: 500px; max-height: 300px;">';
            }
            closeMediaModal();
            if (typeof showToast === 'function') {
                showToast('Image selected', 'success');
            }
            return true;
        }
        return false;
    }
    
    // Handle hero background
    if (targetInputId === 'hero_background') {
        return updateImagePreview('hero_background', 'hero_bg_preview', 'hero_bg_img');
    }
    
    // Handle pool image
    if (targetInputId === 'pool_image') {
        return updateImagePreview('pool_image', 'pool_image_preview', 'pool_image_img');
    }
    
    // Handle restaurant image
    if (targetInputId === 'restaurant_image') {
        return updateImagePreview('restaurant_image', 'restaurant_image_preview', 'restaurant_image_img');
    }
    
    // Handle leisure image
    if (targetInputId === 'leisure_image') {
        return updateImagePreview('leisure_image', 'leisure_image_preview', 'leisure_image_img');
    }
    
    return false;
};

// Form submission
document.getElementById('amenitiesPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Hero section fields
    if (formData.has('page_title')) sections['page_title'] = formData.get('page_title');
    if (formData.has('page_subtitle')) sections['page_subtitle'] = formData.get('page_subtitle');
    if (formData.has('hero_background')) sections['hero_background'] = formData.get('hero_background');
    
    // Swimming Pool section
    if (formData.has('pool_label')) sections['pool_label'] = formData.get('pool_label');
    if (formData.has('pool_title')) sections['pool_title'] = formData.get('pool_title');
    if (formData.has('pool_description')) sections['pool_description'] = formData.get('pool_description');
    if (formData.has('pool_image')) sections['pool_image'] = formData.get('pool_image');
    
    // Restaurant section
    if (formData.has('restaurant_label')) sections['restaurant_label'] = formData.get('restaurant_label');
    if (formData.has('restaurant_title')) sections['restaurant_title'] = formData.get('restaurant_title');
    if (formData.has('restaurant_description')) sections['restaurant_description'] = formData.get('restaurant_description');
    if (formData.has('restaurant_image')) sections['restaurant_image'] = formData.get('restaurant_image');
    
    // Leisure section
    if (formData.has('leisure_label')) sections['leisure_label'] = formData.get('leisure_label');
    if (formData.has('leisure_title')) sections['leisure_title'] = formData.get('leisure_title');
    if (formData.has('leisure_description')) sections['leisure_description'] = formData.get('leisure_description');
    if (formData.has('leisure_image')) sections['leisure_image'] = formData.get('leisure_image');
    
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
                page: 'amenities',
                section_key: key,
                content_type: (key.includes('image') || key.includes('background')) ? 'image' : 'text',
                content: sections[key]
            })
        }).then(response => response.json());
    });
    
    Promise.all(promises).then(results => {
        const allSuccess = results.every(r => r.success);
        if (allSuccess) {
            if (typeof showToast === 'function') {
                showToast('Amenities page saved successfully', 'success');
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
