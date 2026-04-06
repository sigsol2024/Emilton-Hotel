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
    
    <!-- Hero Section -->
    <div class="card">
        <div class="card-header">
            <h2>Hero Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="page_subtitle">Page Subtitle</label>
                <input type="text" id="page_subtitle" name="page_subtitle" value="<?= sanitize($sectionsArray['page_subtitle'] ?? 'About Peregrine Hotel') ?>">
            </div>
            
            <div class="form-group">
                <label for="hero_title">Hero Title</label>
                <input type="text" id="hero_title" name="hero_title" value="<?= sanitize($sectionsArray['hero_title'] ?? 'The Essence of') ?>">
            </div>
            
            <div class="form-group">
                <label for="hero_title_italic">Hero Title (Italic Part)</label>
                <input type="text" id="hero_title_italic" name="hero_title_italic" value="<?= sanitize($sectionsArray['hero_title_italic'] ?? 'Rayfield Luxury') ?>">
            </div>
            
            <div class="form-group">
                <label>Hero Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('hero_background', 'hero_background_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="hero_background" name="hero_background" value="<?= sanitize($sectionsArray['hero_background'] ?? '') ?>">
                <div id="hero_background_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['hero_background']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['hero_background'])): 
                        $heroImgSrc = $sectionsArray['hero_background'];
                        if (strpos($heroImgSrc, 'http://') === 0 || strpos($heroImgSrc, 'https://') === 0) {
                            $heroImgUrl = $heroImgSrc;
                        } else {
                            $heroImgUrl = SITE_URL . ltrim($heroImgSrc, '/');
                        }
                    ?>
                        <img id="hero_background_img" src="<?= htmlspecialchars($heroImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>Video Button</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="video_button_text">Button Text</label>
                    <input type="text" id="video_button_text" name="video_button_text" value="<?= sanitize($sectionsArray['video_button_text'] ?? 'Play Experience Video') ?>">
                </div>
                <div class="form-group">
                    <label for="video_button_url">Button URL</label>
                    <input type="text" id="video_button_url" name="video_button_url" value="<?= sanitize($sectionsArray['video_button_url'] ?? '#') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Intro Quote Section -->
    <div class="card">
        <div class="card-header">
            <h2>Intro Quote Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="intro_quote">Quote Text</label>
                <textarea id="intro_quote" name="intro_quote" rows="3"><?= sanitize($sectionsArray['intro_quote'] ?? '') ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Story Section -->
    <div class="card">
        <div class="card-header">
            <h2>Story Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="story_label">Label</label>
                <input type="text" id="story_label" name="story_label" value="<?= sanitize($sectionsArray['story_label'] ?? 'Our Origins') ?>">
            </div>
            
            <div class="form-group">
                <label for="story_title">Title</label>
                <input type="text" id="story_title" name="story_title" value="<?= sanitize($sectionsArray['story_title'] ?? 'A Legacy of Hospitality') ?>">
            </div>
            
            <div class="form-group">
                <label for="story_description_1">Description 1</label>
                <textarea id="story_description_1" name="story_description_1" rows="3"><?= sanitize($sectionsArray['story_description_1'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="story_description_2">Description 2</label>
                <textarea id="story_description_2" name="story_description_2" rows="3"><?= sanitize($sectionsArray['story_description_2'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Story Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('story_image', 'story_image_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="story_image" name="story_image" value="<?= sanitize($sectionsArray['story_image'] ?? '') ?>">
                <div id="story_image_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['story_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['story_image'])): 
                        $storyImgSrc = $sectionsArray['story_image'];
                        if (strpos($storyImgSrc, 'http://') === 0 || strpos($storyImgSrc, 'https://') === 0) {
                            $storyImgUrl = $storyImgSrc;
                        } else {
                            $storyImgUrl = SITE_URL . ltrim($storyImgSrc, '/');
                        }
                    ?>
                        <img id="story_image_img" src="<?= htmlspecialchars($storyImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Boulevard Connection Section -->
    <div class="card">
        <div class="card-header">
            <h2>Boulevard Connection Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="boulevard_label">Label</label>
                <input type="text" id="boulevard_label" name="boulevard_label" value="<?= sanitize($sectionsArray['boulevard_label'] ?? 'Boulevard Group') ?>">
            </div>
            
            <div class="form-group">
                <label for="boulevard_title">Title</label>
                <input type="text" id="boulevard_title" name="boulevard_title" value="<?= sanitize($sectionsArray['boulevard_title'] ?? 'Boulevard Connection') ?>">
            </div>
            
            <div class="form-group">
                <label for="boulevard_description">Description</label>
                <textarea id="boulevard_description" name="boulevard_description" rows="3"><?= sanitize($sectionsArray['boulevard_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Boulevard Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('boulevard_image', 'boulevard_image_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="boulevard_image" name="boulevard_image" value="<?= sanitize($sectionsArray['boulevard_image'] ?? '') ?>">
                <div id="boulevard_image_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['boulevard_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['boulevard_image'])): 
                        $boulevardImgSrc = $sectionsArray['boulevard_image'];
                        if (strpos($boulevardImgSrc, 'http://') === 0 || strpos($boulevardImgSrc, 'https://') === 0) {
                            $boulevardImgUrl = $boulevardImgSrc;
                        } else {
                            $boulevardImgUrl = SITE_URL . ltrim($boulevardImgSrc, '/');
                        }
                    ?>
                        <img id="boulevard_image_img" src="<?= htmlspecialchars($boulevardImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Location Section -->
    <div class="card">
        <div class="card-header">
            <h2>Location Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="location_title">Title</label>
                <input type="text" id="location_title" name="location_title" value="<?= sanitize($sectionsArray['location_title'] ?? 'In the Heart of Rayfield') ?>">
            </div>
            
            <div class="form-group">
                <label for="location_description">Description</label>
                <textarea id="location_description" name="location_description" rows="3"><?= sanitize($sectionsArray['location_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="map_address">Map Address</label>
                <textarea id="map_address" name="map_address" rows="2"><?= sanitize($sectionsArray['map_address'] ?? '') ?></textarea>
                <p class="form-help">The address used to display the Google Map. If left empty, it will use the address from Site Settings (Footer Address). Example: "12 Rayfield Avenue, Jos, Plateau State, Nigeria"</p>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>Directions Button</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="location_directions_text">Button Text</label>
                    <input type="text" id="location_directions_text" name="location_directions_text" value="<?= sanitize($sectionsArray['location_directions_text'] ?? 'Get Directions') ?>">
                </div>
                <div class="form-group">
                    <label for="location_directions_link">Button Link</label>
                    <input type="text" id="location_directions_link" name="location_directions_link" value="<?= sanitize($sectionsArray['location_directions_link'] ?? 'contact_us.php') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gallery Section -->
    <div class="card">
        <div class="card-header">
            <h2>Gallery Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="gallery_title">Title</label>
                <input type="text" id="gallery_title" name="gallery_title" value="<?= sanitize($sectionsArray['gallery_title'] ?? 'Designed for Tranquility') ?>">
            </div>
            
            <div class="form-group">
                <label for="gallery_subtitle">Subtitle</label>
                <input type="text" id="gallery_subtitle" name="gallery_subtitle" value="<?= sanitize($sectionsArray['gallery_subtitle'] ?? 'A glimpse into our aesthetic.') ?>">
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>Gallery Images (3 images)</h3>
            <?php for ($i = 1; $i <= 3; $i++): ?>
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 15px;">
                <h4>Gallery Image <?= $i ?></h4>
                <div class="form-group">
                    <label>Image <?= $i ?></label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('gallery_image_<?= $i ?>', 'gallery_<?= $i ?>_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="gallery_image_<?= $i ?>" name="gallery_image_<?= $i ?>" value="<?= sanitize($sectionsArray['gallery_image_' . $i] ?? '') ?>">
                    <div id="gallery_<?= $i ?>_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['gallery_image_' . $i]) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['gallery_image_' . $i])): 
                            $galleryImgSrc = $sectionsArray['gallery_image_' . $i];
                            if (strpos($galleryImgSrc, 'http://') === 0 || strpos($galleryImgSrc, 'https://') === 0) {
                                $galleryImgUrl = $galleryImgSrc;
                            } else {
                                $galleryImgUrl = SITE_URL . ltrim($galleryImgSrc, '/');
                            }
                        ?>
                            <img src="<?= htmlspecialchars($galleryImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save About Page Content</button>
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
            if (imgUrl.startsWith('http://') || imgUrl.startsWith('https://')) {
                // Already a full URL
            } else {
                imgUrl = '<?= SITE_URL ?>' + imgUrl.replace(/^\//, '');
            }
            
            if (previewImg) {
                previewImg.src = imgUrl;
            } else {
                preview.innerHTML = '<img id="' + imgId + '" src="' + imgUrl + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle main image
    if (targetInputId === 'main_image') {
        return updateImagePreview('main_image', 'main_image_preview', 'main_image_img');
    }
    
    // Handle philosophy image
    if (targetInputId === 'philosophy_image') {
        return updateImagePreview('philosophy_image', 'philosophy_image_preview', 'philosophy_image_img');
    }
    
    return false;
};

// Form submission
document.getElementById('aboutPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    const sectionKeys = [
        'page_subtitle', 'hero_title', 'hero_title_italic', 'hero_background',
        'video_button_text', 'video_button_url',
        'intro_quote',
        'story_label', 'story_title', 'story_description_1', 'story_description_2', 'story_image',
        'boulevard_label', 'boulevard_title', 'boulevard_description', 'boulevard_image',
        'location_title', 'location_description', 'map_address',
        'location_directions_text', 'location_directions_link',
        'gallery_title', 'gallery_subtitle',
        'gallery_image_1', 'gallery_image_2', 'gallery_image_3'
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
            if (typeof showToast === 'function') {
                showToast('About page content saved successfully', 'success');
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
