<?php
/**
 * Swimming Pool Page Editor
 */

$pageTitle = 'Swimming Pool Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all swimming pool page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'swimming-pool' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Swimming pool page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="swimmingPoolPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Hero Section -->
    <div class="card">
        <div class="card-header">
            <h2>Hero Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="hero_subtitle">Hero Subtitle</label>
                <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?= sanitize($sectionsArray['hero_subtitle'] ?? 'Pool & Leisure') ?>">
                <p class="form-help">Small text above main title</p>
            </div>
            
            <div class="form-group">
                <label for="hero_title">Hero Title</label>
                <input type="text" id="hero_title" name="hero_title" value="<?= sanitize($sectionsArray['hero_title'] ?? 'Swimming Pool & Leisure') ?>">
            </div>
            
            <div class="form-group">
                <label for="hero_intro">Hero Intro Text</label>
                <textarea id="hero_intro" name="hero_intro" rows="2"><?= sanitize($sectionsArray['hero_intro'] ?? 'A serene escape designed for relaxation, refreshment, and quiet enjoyment.') ?></textarea>
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
            </div>
        </div>
    </div>
    
    <!-- Pool Experience Section (3 Cards) -->
    <div class="card">
        <div class="card-header">
            <h2>Pool Experience Section (3 Cards)</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="pool_title">Section Title</label>
                <input type="text" id="pool_title" name="pool_title" value="<?= sanitize($sectionsArray['pool_title'] ?? 'Swimming Pool & Leisure Experience') ?>">
            </div>
            <div class="form-group">
                <label for="pool_intro">Intro Text</label>
                <textarea id="pool_intro" name="pool_intro" rows="2"><?= sanitize($sectionsArray['pool_intro'] ?? 'Discover a tranquil pool area where relaxation, refreshment, and peaceful moments come together.') ?></textarea>
            </div>
            <div class="form-group">
                <label for="pool_description">Description</label>
                <textarea id="pool_description" name="pool_description" rows="3"><?= sanitize($sectionsArray['pool_description'] ?? 'At Emilton Hotel & Suites, our swimming pool offers a serene escape from the everyday. From refreshing morning swims to relaxing evening dips, every moment is designed for comfort and tranquility.') ?></textarea>
            </div>

            <hr style="margin: 30px 0;">

            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 1: Pool Experience</h3>
            <div class="form-group">
                <label>Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('pool_card_1_image', 'pool_card_1_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="pool_card_1_image" name="pool_card_1_image" value="<?= sanitize($sectionsArray['pool_card_1_image'] ?? '') ?>">
                <div id="pool_card_1_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['pool_card_1_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['pool_card_1_image'])): ?>
                        <img id="pool_card_1_img" src="<?= SITE_URL . ltrim($sectionsArray['pool_card_1_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="pool_card_1_icon">Icon Name (Material Symbols)</label>
                <input type="text" id="pool_card_1_icon" name="pool_card_1_icon" value="<?= sanitize($sectionsArray['pool_card_1_icon'] ?? 'pool') ?>" placeholder="e.g., pool">
            </div>
            <div class="form-group">
                <label for="pool_card_1_title">Title</label>
                <input type="text" id="pool_card_1_title" name="pool_card_1_title" value="<?= sanitize($sectionsArray['pool_card_1_title'] ?? 'Refreshing Pool Experience') ?>">
            </div>
            <div class="form-group">
                <label for="pool_card_1_description">Description</label>
                <textarea id="pool_card_1_description" name="pool_card_1_description" rows="3"><?= sanitize($sectionsArray['pool_card_1_description'] ?? 'Enjoy a clean, well-maintained swimming pool designed for comfort and relaxation. Whether you\'re starting your day with a refreshing dip or unwinding in the evening, our pool offers a calm and inviting environment.') ?></textarea>
            </div>

            <hr style="margin: 30px 0;">

            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 2: Poolside Ambience</h3>
            <div class="form-group">
                <label>Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('pool_card_2_image', 'pool_card_2_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="pool_card_2_image" name="pool_card_2_image" value="<?= sanitize($sectionsArray['pool_card_2_image'] ?? '') ?>">
                <div id="pool_card_2_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['pool_card_2_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['pool_card_2_image'])): ?>
                        <img id="pool_card_2_img" src="<?= SITE_URL . ltrim($sectionsArray['pool_card_2_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="pool_card_2_icon">Icon Name</label>
                <input type="text" id="pool_card_2_icon" name="pool_card_2_icon" value="<?= sanitize($sectionsArray['pool_card_2_icon'] ?? 'deck') ?>">
            </div>
            <div class="form-group">
                <label for="pool_card_2_title">Title</label>
                <input type="text" id="pool_card_2_title" name="pool_card_2_title" value="<?= sanitize($sectionsArray['pool_card_2_title'] ?? 'Calm Poolside Ambience') ?>">
            </div>
            <div class="form-group">
                <label for="pool_card_2_description">Description</label>
                <textarea id="pool_card_2_description" name="pool_card_2_description" rows="3"><?= sanitize($sectionsArray['pool_card_2_description'] ?? 'Surrounded by a peaceful atmosphere, the pool area offers a relaxing setting where guests can unwind, lounge, and enjoy quiet moments away from the city\'s pace.') ?></textarea>
            </div>

            <hr style="margin: 30px 0;">

            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 3: Comfort & Leisure</h3>
            <div class="form-group">
                <label>Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('pool_card_3_image', 'pool_card_3_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="pool_card_3_image" name="pool_card_3_image" value="<?= sanitize($sectionsArray['pool_card_3_image'] ?? '') ?>">
                <div id="pool_card_3_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['pool_card_3_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['pool_card_3_image'])): ?>
                        <img id="pool_card_3_img" src="<?= SITE_URL . ltrim($sectionsArray['pool_card_3_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="pool_card_3_icon">Icon Name</label>
                <input type="text" id="pool_card_3_icon" name="pool_card_3_icon" value="<?= sanitize($sectionsArray['pool_card_3_icon'] ?? 'chair') ?>">
            </div>
            <div class="form-group">
                <label for="pool_card_3_title">Title</label>
                <input type="text" id="pool_card_3_title" name="pool_card_3_title" value="<?= sanitize($sectionsArray['pool_card_3_title'] ?? 'Comfort & Leisure') ?>">
            </div>
            <div class="form-group">
                <label for="pool_card_3_description">Description</label>
                <textarea id="pool_card_3_description" name="pool_card_3_description" rows="3"><?= sanitize($sectionsArray['pool_card_3_description'] ?? 'Thoughtfully arranged seating and a well-designed pool layout provide comfort, privacy, and ease, making the swimming pool ideal for leisure, relaxation, and light recreation.') ?></textarea>
            </div>

            <hr style="margin: 30px 0;">
            <div class="form-group">
                <label for="pool_cta">Optional CTA (Text Under Cards)</label>
                <textarea id="pool_cta" name="pool_cta" rows="3"><?= sanitize($sectionsArray['pool_cta'] ?? 'Relax. Refresh. Recharge.

Experience calm and comfort at the Emilton Hotel & Suites swimming pool.') ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Gallery Slider Section -->
    <div class="card">
        <div class="card-header">
            <h2>Gallery Slider Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="slider_title">Slider Section Title</label>
                <input type="text" id="slider_title" name="slider_title" value="<?= sanitize($sectionsArray['slider_title'] ?? 'Pool Gallery') ?>">
                <p class="form-help">Title displayed above the slider (optional, leave empty to hide)</p>
            </div>
            
            <div class="form-group">
                <label>Slider Images</label>
                <p class="form-help">Add images to display in the slider. Desktop: 3 slides, Tablet: 2 slides, Mobile: 1 slide.</p>
                <div id="slider_images_list" style="margin-top: 15px;">
                    <?php
                    $sliderImagesJson = $sectionsArray['slider_images'] ?? '[]';
                    $sliderImages = json_decode($sliderImagesJson, true);
                    if (!is_array($sliderImages)) {
                        $sliderImages = [];
                    }
                    $sliderImageIndex = 0;
                    foreach ($sliderImages as $img): 
                        if (empty($img['url'])) continue;
                    ?>
                        <div class="slider-image-item" data-index="<?= $sliderImageIndex ?>" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                            <div style="display: flex; gap: 15px; align-items: start;">
                                <div style="flex: 0 0 150px;">
                                    <img src="<?= SITE_URL . ltrim($img['url'], '/') ?>" style="max-width: 150px; max-height: 100px; object-fit: cover; border-radius: 5px; width: 150px; height: 100px;">
                                </div>
                                <div style="flex: 1;">
                                    <input type="hidden" class="slider-image-url" value="<?= sanitize($img['url']) ?>">
                                    <input type="text" class="slider-image-alt" value="<?= sanitize($img['alt'] ?? '') ?>" placeholder="Image alt text" style="width: 100%; margin-bottom: 10px; padding: 8px;">
                                    <button type="button" class="btn btn-outline" onclick="openMediaModalForSlider('<?= $sliderImageIndex ?>')" style="margin-right: 10px;">
                                        <i class="fas fa-image"></i> Change Image
                                    </button>
                                    <button type="button" class="btn btn-outline" onclick="removeSliderImage(this)" style="background: #dc3545; color: white; border-color: #dc3545;">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php 
                        $sliderImageIndex++;
                    endforeach; 
                    ?>
                </div>
                <button type="button" class="btn btn-outline" onclick="addSliderImage()" style="margin-top: 15px;">
                    <i class="fas fa-plus"></i> Add Image
                </button>
                <input type="hidden" id="slider_images" name="slider_images" value="">
            </div>
        </div>
    </div>
    
    <!-- Feature Image Section (for Mega Menu) -->
    <div class="card">
        <div class="card-header">
            <h2>Feature Image (Mega Menu Thumbnail)</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label>Feature Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('feature_image', 'feature_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="feature_image" name="feature_image" value="<?= sanitize($sectionsArray['feature_image'] ?? '') ?>">
                <div id="feature_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['feature_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['feature_image'])): ?>
                        <img id="feature_img_img" src="<?= SITE_URL . ltrim($sectionsArray['feature_image'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Optional: Image used as thumbnail in Facility mega menu. If not set, an icon will be used instead.</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Swimming Pool Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
// Slider images management
let sliderImageCounter = <?= isset($sliderImages) && is_array($sliderImages) ? count($sliderImages) : 0 ?>;
let currentSliderImageIndex = null;

function addSliderImage() {
    const container = document.getElementById('slider_images_list');
    const index = sliderImageCounter++;
    const html = `
        <div class="slider-image-item" data-index="${index}" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
            <div style="display: flex; gap: 15px; align-items: start;">
                <div style="flex: 0 0 150px;">
                    <div style="width: 150px; height: 100px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #999;">
                        No image
                    </div>
                </div>
                <div style="flex: 1;">
                    <input type="hidden" class="slider-image-url" value="">
                    <input type="text" class="slider-image-alt" value="" placeholder="Image alt text" style="width: 100%; margin-bottom: 10px; padding: 8px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModalForSlider('${index}')" style="margin-right: 10px;">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                    <button type="button" class="btn btn-outline" onclick="removeSliderImage(this)" style="background: #dc3545; color: white; border-color: #dc3545;">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

function removeSliderImage(btn) {
    btn.closest('.slider-image-item').remove();
}

function openMediaModalForSlider(index) {
    currentSliderImageIndex = index;
    if (typeof openMediaModal === 'function') {
        openMediaModal('slider_image_' + index, 'slider_preview_' + index);
    }
}

// Handle media modal selection
function handleImageSelection(inputId, previewId, imgId) {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    if (input && preview) {
        input.value = selected.path;
        preview.style.display = 'block';
        const existingImg = document.getElementById(imgId);
        if (existingImg) {
            existingImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
        } else {
            preview.innerHTML = '<img id="' + imgId + '" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 300px; max-height: 200px;">';
        }
    }
    closeMediaModal();
    if (typeof showToast === 'function') {
        showToast('Image selected', 'success');
    }
    return true;
}

window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const targetInputId = mediaModalState.targetInputId;
    
    // Handle slider images
    if (targetInputId && targetInputId.startsWith('slider_image_')) {
        const index = currentSliderImageIndex;
        if (index !== null) {
            const item = document.querySelector(`.slider-image-item[data-index="${index}"]`);
            if (item) {
                const urlInput = item.querySelector('.slider-image-url');
                if (urlInput) {
                    urlInput.value = selected.path;
                    // Update preview
                    const previewDiv = item.querySelector('div[style*="flex: 0 0 150px"]');
                    if (previewDiv) {
                        previewDiv.innerHTML = `<img src="<?= SITE_URL ?>${selected.path.replace(/^\//, '')}" style="max-width: 150px; max-height: 100px; object-fit: cover; border-radius: 5px; width: 150px; height: 100px;">`;
                    }
                    // Update button text
                    const btn = item.querySelector('button[onclick*="openMediaModalForSlider"]');
                    if (btn) {
                        btn.innerHTML = '<i class="fas fa-image"></i> Change Image';
                    }
                }
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Hero background
    if (targetInputId === 'hero_background') {
        handleImageSelection('hero_background', 'hero_bg_preview', 'hero_bg_img');
        return true;
    }
    
    // Pool card 1 image
    if (targetInputId === 'pool_card_1_image') {
        handleImageSelection('pool_card_1_image', 'pool_card_1_img_preview', 'pool_card_1_img');
        return true;
    }
    
    // Pool card 2 image
    if (targetInputId === 'pool_card_2_image') {
        handleImageSelection('pool_card_2_image', 'pool_card_2_img_preview', 'pool_card_2_img');
        return true;
    }
    
    // Pool card 3 image
    if (targetInputId === 'pool_card_3_image') {
        handleImageSelection('pool_card_3_image', 'pool_card_3_img_preview', 'pool_card_3_img');
        return true;
    }
    
    // Feature image
    if (targetInputId === 'feature_image') {
        handleImageSelection('feature_image', 'feature_img_preview', 'feature_img_img');
        return true;
    }
    
    return false;
};

// Form submission
document.getElementById('swimmingPoolPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect slider images as JSON from DOM elements
    const sliderImages = [];
    const sliderItems = document.querySelectorAll('.slider-image-item');
    sliderItems.forEach(item => {
        const urlInput = item.querySelector('.slider-image-url');
        const altInput = item.querySelector('.slider-image-alt');
        if (urlInput && urlInput.value) {
            sliderImages.push({
                url: urlInput.value,
                alt: altInput ? altInput.value : ''
            });
        }
    });
    
    // Collect all form fields
    const fields = [
        'hero_subtitle', 'hero_title', 'hero_intro', 'hero_background',
        'pool_title', 'pool_intro', 'pool_description',
        'pool_card_1_image', 'pool_card_1_icon', 'pool_card_1_title', 'pool_card_1_description',
        'pool_card_2_image', 'pool_card_2_icon', 'pool_card_2_title', 'pool_card_2_description',
        'pool_card_3_image', 'pool_card_3_icon', 'pool_card_3_title', 'pool_card_3_description',
        'pool_cta',
        'slider_title', 'slider_images',
        'feature_image'
    ];
    
    fields.forEach(field => {
        if (field === 'slider_images') {
            sections[field] = JSON.stringify(sliderImages);
        } else if (formData.has(field)) {
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
                page: 'swimming-pool',
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
                showToast('Swimming pool page content saved successfully', 'success');
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