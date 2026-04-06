<?php
/**
 * About Page Editor
 */

$pageTitle = 'About Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all about page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'about' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("About page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="aboutPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Page Header -->
    <div class="card">
        <div class="card-header">
            <h2>Page Header</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="page_header_title">Page Title</label>
                <input type="text" id="page_header_title" name="page_header_title" value="<?= sanitize($sectionsArray['page_header_title'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label>Header Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('page_header_image', 'header_bg_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="page_header_image" name="page_header_image" value="<?= sanitize($sectionsArray['page_header_image'] ?? '') ?>">
                <div id="header_bg_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['page_header_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['page_header_image'])): ?>
                        <img id="header_bg_img" src="<?= SITE_URL . ltrim($sectionsArray['page_header_image'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Select an image from the media library or upload a new one</p>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="card">
        <div class="card-header">
            <h2>Main Content</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="main_title">Main Title</label>
                <textarea id="main_title" name="main_title" rows="2"><?= sanitize($sectionsArray['main_title'] ?? '') ?></textarea>
                <p class="form-help">HTML allowed</p>
            </div>
            
            <div class="form-group">
                <label for="main_description">Main Description</label>
                <textarea id="main_description" name="main_description" rows="4"><?= sanitize($sectionsArray['main_description'] ?? '') ?></textarea>
                <p class="form-help">HTML allowed</p>
            </div>
        </div>
    </div>
    
    <!-- Counter Section -->
    <div class="card">
        <div class="card-header">
            <h2>Counter Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-row">
                <div class="form-group">
                    <label for="counter_1_percentage">Counter 1 Percentage</label>
                    <input type="text" id="counter_1_percentage" name="counter_1_percentage" value="<?= sanitize($sectionsArray['counter_1_percentage'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="counter_1_title">Counter 1 Title</label>
                    <input type="text" id="counter_1_title" name="counter_1_title" value="<?= sanitize($sectionsArray['counter_1_title'] ?? '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="counter_2_percentage">Counter 2 Percentage</label>
                    <input type="text" id="counter_2_percentage" name="counter_2_percentage" value="<?= sanitize($sectionsArray['counter_2_percentage'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="counter_2_title">Counter 2 Title</label>
                    <input type="text" id="counter_2_title" name="counter_2_title" value="<?= sanitize($sectionsArray['counter_2_title'] ?? '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="counter_3_percentage">Counter 3 Percentage</label>
                    <input type="text" id="counter_3_percentage" name="counter_3_percentage" value="<?= sanitize($sectionsArray['counter_3_percentage'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="counter_3_title">Counter 3 Title</label>
                    <input type="text" id="counter_3_title" name="counter_3_title" value="<?= sanitize($sectionsArray['counter_3_title'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Why Choose Us Section -->
    <div class="card">
        <div class="card-header">
            <h2>Why Choose Us Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="why_choose_subtitle">Subtitle</label>
                <input type="text" id="why_choose_subtitle" name="why_choose_subtitle" value="<?= sanitize($sectionsArray['why_choose_subtitle'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="why_choose_title">Title</label>
                <input type="text" id="why_choose_title" name="why_choose_title" value="<?= sanitize($sectionsArray['why_choose_title'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="why_choose_description">Description</label>
                <textarea id="why_choose_description" name="why_choose_description" rows="3"><?= sanitize($sectionsArray['why_choose_description'] ?? '') ?></textarea>
                <p class="form-help">HTML allowed</p>
            </div>
            
            <div class="form-group">
                <label>Video Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('video_background', 'video_bg_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="video_background" name="video_background" value="<?= sanitize($sectionsArray['video_background'] ?? '') ?>">
                <div id="video_bg_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['video_background']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['video_background'])): ?>
                        <img id="video_bg_img" src="<?= SITE_URL . ltrim($sectionsArray['video_background'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php else: ?>
                        <img id="video_bg_img" src="" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Select an image from the media library or upload a new one</p>
            </div>
        </div>
    </div>
    
    <!-- Awards Section -->
    <div class="card">
        <div class="card-header">
            <h2>Awards Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="awards_subtitle">Subtitle</label>
                <input type="text" id="awards_subtitle" name="awards_subtitle" value="<?= sanitize($sectionsArray['awards_subtitle'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="awards_title">Title</label>
                <input type="text" id="awards_title" name="awards_title" value="<?= sanitize($sectionsArray['awards_title'] ?? '') ?>">
            </div>
            
            <hr style="margin: 20px 0; border-color: var(--border-color);">
            <h3 style="margin-bottom: 15px; font-size: 18px;">Award Items</h3>
            
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Award 1</h4>
                <div class="form-group">
                    <label for="award_title_1">Award 1 Title</label>
                    <input type="text" id="award_title_1" name="award_title_1" value="<?= sanitize($sectionsArray['award_title_1'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Award 1 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('award_image_1', 'award_image_1_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="award_image_1" name="award_image_1" value="<?= sanitize($sectionsArray['award_image_1'] ?? '') ?>">
                    <div id="award_image_1_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['award_image_1']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['award_image_1'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['award_image_1'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                    <p class="form-help">Select an image from the media library or upload a new one</p>
                </div>
            </div>
            
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Award 2</h4>
                <div class="form-group">
                    <label for="award_title_2">Award 2 Title</label>
                    <input type="text" id="award_title_2" name="award_title_2" value="<?= sanitize($sectionsArray['award_title_2'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Award 2 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('award_image_2', 'award_image_2_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="award_image_2" name="award_image_2" value="<?= sanitize($sectionsArray['award_image_2'] ?? '') ?>">
                    <div id="award_image_2_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['award_image_2']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['award_image_2'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['award_image_2'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                    <p class="form-help">Select an image from the media library or upload a new one</p>
                </div>
            </div>
            
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Award 3</h4>
                <div class="form-group">
                    <label for="award_title_3">Award 3 Title</label>
                    <input type="text" id="award_title_3" name="award_title_3" value="<?= sanitize($sectionsArray['award_title_3'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Award 3 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('award_image_3', 'award_image_3_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="award_image_3" name="award_image_3" value="<?= sanitize($sectionsArray['award_image_3'] ?? '') ?>">
                    <div id="award_image_3_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['award_image_3']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['award_image_3'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['award_image_3'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                    <p class="form-help">Select an image from the media library or upload a new one</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Testimonial Section -->
    <div class="card">
        <div class="card-header">
            <h2>Testimonial Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label>Testimonial Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('testimonial_background', 'testimonial_bg_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="testimonial_background" name="testimonial_background" value="<?= sanitize($sectionsArray['testimonial_background'] ?? '') ?>">
                <div id="testimonial_bg_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['testimonial_background']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['testimonial_background'])): ?>
                        <img id="testimonial_bg_img" src="<?= SITE_URL . ltrim($sectionsArray['testimonial_background'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php else: ?>
                        <img id="testimonial_bg_img" src="" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Select an image from the media library or upload a new one</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save About Page Content</button>
        <a href="<?= ADMIN_URL ?>pages/testimonials.php" class="btn btn-outline">Manage Testimonials</a>
    </div>
</form>

<script>
// Handle media modal selection
window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const targetInputId = mediaModalState.targetInputId;
    
    // Handle page header image
    if (targetInputId === 'page_header_image') {
        const input = document.getElementById('page_header_image');
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
    
    // Handle video background
    if (targetInputId === 'video_background') {
        const input = document.getElementById('video_background');
        const preview = document.getElementById('video_bg_preview');
        const previewImg = document.getElementById('video_bg_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="video_bg_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle award images
    if (targetInputId === 'award_image_1' || targetInputId === 'award_image_2' || targetInputId === 'award_image_3') {
        const input = document.getElementById(targetInputId);
        const preview = document.getElementById(targetInputId + '_preview');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            const existingImg = preview.querySelector('img');
            if (existingImg) {
                existingImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 300px; max-height: 200px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle testimonial background
    if (targetInputId === 'testimonial_background') {
        const input = document.getElementById('testimonial_background');
        const preview = document.getElementById('testimonial_bg_preview');
        const previewImg = document.getElementById('testimonial_bg_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="testimonial_bg_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
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

// Media modal integration - the openMediaModal function is provided by media-library.js

document.getElementById('aboutPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    const sectionKeys = [
        'page_header_title', 'page_header_image',
        'main_title', 'main_description',
        'counter_1_percentage', 'counter_1_title',
        'counter_2_percentage', 'counter_2_title',
        'counter_3_percentage', 'counter_3_title',
        'why_choose_subtitle', 'why_choose_title', 'why_choose_description', 'video_background',
        'awards_subtitle', 'awards_title',
        'award_title_1', 'award_image_1', 'award_title_2', 'award_image_2', 'award_title_3', 'award_image_3',
        'testimonial_background'
    ];
    
    sectionKeys.forEach(key => {
        if (formData.has(key)) {
            sections[key] = formData.get(key);
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
                page: 'about',
                section_key: key,
                content_type: key.includes('image') ? 'image' : 'text',
                content: sections[key]
            })
        }).then(response => response.json());
    });
    
    Promise.all(promises).then(results => {
        const allSuccess = results.every(r => r.success);
        if (allSuccess) {
            showToast('About page content saved successfully', 'success');
        } else {
            showToast('Some sections failed to save', 'warning');
        }
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

