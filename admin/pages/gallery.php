<?php
/**
 * Gallery Page Editor
 * Edit hero section and gallery images
 */

$pageTitle = 'Gallery Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all gallery page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'gallery' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Gallery page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

// Parse gallery images (stored as JSON)
$galleryImages = [];
if (!empty($sectionsArray['gallery_images'])) {
    $decoded = json_decode($sectionsArray['gallery_images'], true);
    if (is_array($decoded)) {
        $galleryImages = $decoded;
    }
}

$csrfToken = generateCSRFToken();
?>

<form id="galleryPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Hero Section -->
    <div class="card">
        <div class="card-header">
            <h2>Hero Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="hero_subtitle">Hero Subtitle</label>
                <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?= sanitize($sectionsArray['hero_subtitle'] ?? 'Visual Journey') ?>">
                <p class="form-help">Small text above the main title (e.g., "Visual Journey")</p>
            </div>
            
            <div class="form-group">
                <label for="hero_title">Hero Title</label>
                <input type="text" id="hero_title" name="hero_title" value="<?= sanitize($sectionsArray['hero_title'] ?? 'Our Gallery') ?>">
                <p class="form-help">Main gallery page title</p>
            </div>
            
            <div class="form-group">
                <label for="hero_description">Hero Description</label>
                <textarea id="hero_description" name="hero_description" rows="3"><?= sanitize($sectionsArray['hero_description'] ?? '') ?></textarea>
                <p class="form-help">Description text below the title</p>
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
                    <?php if (!empty($sectionsArray['hero_background'])): ?>
                        <img id="hero_bg_img" src="<?= SITE_URL . ltrim($sectionsArray['hero_background'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Select an image from the media library or upload a new one</p>
            </div>
        </div>
    </div>
    
    <!-- Gallery Images -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Gallery Images</h2>
            <button type="button" class="btn btn-primary" onclick="openMediaModal('gallery_image_new', 'gallery_image_preview_new')">
                <i class="fas fa-plus"></i> Add Images
            </button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="gallery_images_json" name="gallery_images" value="<?= htmlspecialchars(json_encode($galleryImages), ENT_QUOTES, 'UTF-8') ?>">
            
            <div id="galleryImagesContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                <?php if (empty($galleryImages)): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted);">
                        <i class="fas fa-images" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                        <p>No gallery images yet. Click "Add Image" to get started.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($galleryImages as $index => $image): 
                        $imagePath = is_array($image) ? ($image['path'] ?? '') : $image;
                        $imageTitle = is_array($image) ? ($image['title'] ?? '') : '';
                        $imageCategory = is_array($image) ? ($image['category'] ?? 'all') : 'all';
                    ?>
                        <div class="gallery-image-item" data-image-index="<?= $index ?>" style="position: relative; border: 1px solid var(--border-color); border-radius: 4px; overflow: hidden; background: white;">
                            <div style="position: relative; padding-top: 100%; background: #f0f0f0;">
                                <img src="<?= SITE_URL . ltrim($imagePath, '/') ?>" 
                                     alt="Gallery image <?= $index + 1 ?>"
                                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;\'><i class=\'fas fa-image\' style=\'font-size: 32px; color: var(--text-muted);\'></i></div>';">
                            </div>
                            <div style="padding: 10px;">
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <label style="font-size: 12px; margin-bottom: 4px;">Title</label>
                                    <input type="text" class="gallery-image-title" data-index="<?= $index ?>" value="<?= htmlspecialchars($imageTitle, ENT_QUOTES, 'UTF-8') ?>" 
                                           style="width: 100%; padding: 4px 8px; font-size: 12px; border: 1px solid var(--border-color); border-radius: 4px;"
                                           onchange="updateGalleryImageData(<?= $index ?>, 'title', this.value)">
                                </div>
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <label style="font-size: 12px; margin-bottom: 4px;">Category</label>
                                    <select class="gallery-image-category" data-index="<?= $index ?>" 
                                            style="width: 100%; padding: 4px 8px; font-size: 12px; border: 1px solid var(--border-color); border-radius: 4px;"
                                            onchange="updateGalleryImageData(<?= $index ?>, 'category', this.value)">
                                        <option value="all" <?= $imageCategory === 'all' ? 'selected' : '' ?>>All</option>
                                        <option value="rooms" <?= $imageCategory === 'rooms' ? 'selected' : '' ?>>Rooms & Suites</option>
                                        <option value="dining" <?= $imageCategory === 'dining' ? 'selected' : '' ?>>Dining</option>
                                        <option value="wellness" <?= $imageCategory === 'wellness' ? 'selected' : '' ?>>Wellness</option>
                                        <option value="experiences" <?= $imageCategory === 'experiences' ? 'selected' : '' ?>>Experiences</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger" style="width: 100%;" onclick="removeGalleryImage(<?= $index ?>)">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Hidden input for new image selection -->
    <input type="hidden" id="gallery_image_new" name="gallery_image_new" value="">
    <div id="gallery_image_preview_new" style="display: none;"></div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Gallery Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
// Gallery images array - normalize to always use object format
let galleryImages = <?= json_encode(array_map(function($img) {
    if (is_array($img)) {
        return $img;
    }
    return ['path' => $img, 'title' => '', 'category' => 'all'];
}, $galleryImages)) ?>;

// Override insertSelectedMedia to handle gallery images
window.insertSelectedMediaOverride = function() {
    const targetInputId = mediaModalState.targetInputId;
    
    // Handle hero background (single selection)
    if (targetInputId === 'hero_background') {
        const selected = mediaModalState.selectedMedia;
        if (!selected) return false;
        
        const input = document.getElementById('hero_background');
        const preview = document.getElementById('hero_bg_preview');
        const previewImg = document.getElementById('hero_bg_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="hero_bg_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // If this is for gallery image (supports multiple selection)
    if (targetInputId === 'gallery_image_new') {
        const selected = mediaModalState.allowMultiple 
            ? mediaModalState.selectedMediaMultiple 
            : (mediaModalState.selectedMedia ? [mediaModalState.selectedMedia] : []);
        
        if (selected.length === 0) return false;
        
        let addedCount = 0;
        let skippedCount = 0;
        
        selected.forEach(item => {
            // Check if image already exists
            const exists = galleryImages.some(img => {
                const path = typeof img === 'string' ? img : img.path;
                return path === item.path;
            });
            
            if (!exists) {
                // Add to gallery images array as object
                galleryImages.push({
                    path: item.path,
                    title: '',
                    category: 'all'
                });
                addedCount++;
            } else {
                skippedCount++;
            }
        });
        
        if (addedCount > 0) {
            updateGalleryImagesDisplay();
            updateGalleryImagesJSON();
        }
        
        closeMediaModal();
        if (typeof showToast === 'function') {
            if (skippedCount > 0) {
                showToast(`${addedCount} image(s) added, ${skippedCount} already in gallery`, 'warning');
            } else {
                showToast(`${addedCount} image(s) added to gallery`, 'success');
            }
        }
        return true; // Return true to indicate we handled it, don't call default behavior
    }
    
    // Return false to let default behavior handle it
    return false;
};

// Update gallery images display
function updateGalleryImagesDisplay() {
    const container = document.getElementById('galleryImagesContainer');
    if (!container) return;
    
    if (galleryImages.length === 0) {
        container.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted);"><i class="fas fa-images" style="font-size: 48px; margin-bottom: 15px; display: block;"></i><p>No gallery images yet. Click "Add Image" to get started.</p></div>';
        return;
    }
    
    let html = '';
    galleryImages.forEach((image, index) => {
        const imagePath = typeof image === 'string' ? image : (image.path || '');
        const imageTitle = typeof image === 'object' ? (image.title || '') : '';
        const imageCategory = typeof image === 'object' ? (image.category || 'all') : 'all';
        const imageUrl = '<?= SITE_URL ?>' + imagePath.replace(/^\//, '');
        html += `
            <div class="gallery-image-item" data-image-index="${index}" style="position: relative; border: 1px solid var(--border-color); border-radius: 4px; overflow: hidden; background: white;">
                <div style="position: relative; padding-top: 100%; background: #f0f0f0;">
                    <img src="${imageUrl}" 
                         alt="Gallery image ${index + 1}"
                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                         onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\\'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;\\'><i class=\\'fas fa-image\\' style=\\'font-size: 32px; color: var(--text-muted);\\'></i></div>';">
                </div>
                <div style="padding: 10px;">
                    <div class="form-group" style="margin-bottom: 8px;">
                        <label style="font-size: 12px; margin-bottom: 4px;">Title</label>
                        <input type="text" class="gallery-image-title" data-index="${index}" value="${(imageTitle || '').replace(/"/g, '&quot;')}" 
                               style="width: 100%; padding: 4px 8px; font-size: 12px; border: 1px solid var(--border-color); border-radius: 4px;"
                               onchange="updateGalleryImageData(${index}, 'title', this.value)">
                    </div>
                    <div class="form-group" style="margin-bottom: 8px;">
                        <label style="font-size: 12px; margin-bottom: 4px;">Category</label>
                        <select class="gallery-image-category" data-index="${index}" 
                                style="width: 100%; padding: 4px 8px; font-size: 12px; border: 1px solid var(--border-color); border-radius: 4px;"
                                onchange="updateGalleryImageData(${index}, 'category', this.value)">
                            <option value="all" ${imageCategory === 'all' ? 'selected' : ''}>All</option>
                            <option value="rooms" ${imageCategory === 'rooms' ? 'selected' : ''}>Rooms & Suites</option>
                            <option value="dining" ${imageCategory === 'dining' ? 'selected' : ''}>Dining</option>
                            <option value="wellness" ${imageCategory === 'wellness' ? 'selected' : ''}>Wellness</option>
                            <option value="experiences" ${imageCategory === 'experiences' ? 'selected' : ''}>Experiences</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" style="width: 100%;" onclick="removeGalleryImage(${index})">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// Update individual image data (title or category)
function updateGalleryImageData(index, field, value) {
    if (galleryImages[index]) {
        // Ensure it's an object
        if (typeof galleryImages[index] === 'string') {
            galleryImages[index] = {
                path: galleryImages[index],
                title: '',
                category: 'all'
            };
        }
        galleryImages[index][field] = value;
        updateGalleryImagesJSON();
    }
}

// Update hidden JSON input
function updateGalleryImagesJSON() {
    const jsonInput = document.getElementById('gallery_images_json');
    if (jsonInput) {
        jsonInput.value = JSON.stringify(galleryImages);
    }
}

// Remove gallery image
function removeGalleryImage(index) {
    if (confirm('Are you sure you want to remove this image from the gallery?')) {
        galleryImages.splice(index, 1);
        updateGalleryImagesDisplay();
        updateGalleryImagesJSON();
        if (typeof showToast === 'function') {
            showToast('Image removed from gallery', 'success');
        }
    }
}

// Form submission
document.getElementById('galleryPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Hero fields
    if (formData.has('hero_subtitle')) {
        sections['hero_subtitle'] = formData.get('hero_subtitle');
    }
    if (formData.has('hero_title')) {
        sections['hero_title'] = formData.get('hero_title');
    }
    if (formData.has('hero_description')) {
        sections['hero_description'] = formData.get('hero_description');
    }
    
    // Hero background
    if (formData.has('hero_background')) {
        sections['hero_background'] = formData.get('hero_background');
    }
    
    // Gallery images (already in JSON format)
    if (formData.has('gallery_images')) {
        sections['gallery_images'] = formData.get('gallery_images');
    }
    
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
                page: 'gallery',
                section_key: key,
                content_type: key === 'gallery_images' ? 'json' : (key.includes('image') || key.includes('background') ? 'image' : 'html'),
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
                showToast('Gallery page content saved successfully', 'success');
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

