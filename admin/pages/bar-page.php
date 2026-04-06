<?php
/**
 * Bar Page Editor
 */

$pageTitle = 'Bar Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all bar page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'bar' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Bar page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="barPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Hero Section -->
    <div class="card">
        <div class="card-header">
            <h2>Hero Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="hero_subtitle">Hero Subtitle</label>
                <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?= sanitize($sectionsArray['hero_subtitle'] ?? 'Bar & Lounge') ?>">
                <p class="form-help">Small text above main title</p>
            </div>
            
            <div class="form-group">
                <label for="hero_title">Hero Title</label>
                <input type="text" id="hero_title" name="hero_title" value="<?= sanitize($sectionsArray['hero_title'] ?? 'Emilton Bar & Lounge') ?>">
            </div>
            
            <div class="form-group">
                <label for="hero_intro">Hero Intro Text</label>
                <textarea id="hero_intro" name="hero_intro" rows="4"><?= sanitize($sectionsArray['hero_intro'] ?? 'Welcome to Emilton Bar & Lounge, a sophisticated relaxation space designed for guests who appreciate premium drinks, stylish surroundings, and a calm social atmosphere. Whether you\'re unwinding after a long day, hosting a casual meeting, or enjoying an evening out, Emilton Bar offers the perfect setting.') ?></textarea>
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
    
    <!-- Section 1: Premium Drinks Experience -->
    <div class="card">
        <div class="card-header">
            <h2>Section 1: Premium Drinks Experience</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="drinks_title">Title</label>
                <input type="text" id="drinks_title" name="drinks_title" value="<?= sanitize($sectionsArray['drinks_title'] ?? 'Carefully Curated Beverages') ?>">
            </div>
            
            <div class="form-group">
                <label for="drinks_description">Description</label>
                <textarea id="drinks_description" name="drinks_description" rows="4"><?= sanitize($sectionsArray['drinks_description'] ?? 'At Emilton Bar, we offer an impressive selection of beverages crafted to suit refined tastes. From expertly mixed cocktails to premium spirits and fine wines, every drink is served with attention to quality and presentation.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Drinks Section Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('drinks_image', 'drinks_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="drinks_image" name="drinks_image" value="<?= sanitize($sectionsArray['drinks_image'] ?? '') ?>">
                <div id="drinks_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['drinks_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['drinks_image'])): ?>
                        <img id="drinks_img" src="<?= SITE_URL . ltrim($sectionsArray['drinks_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="drinks_bullet_label">Bullet List Label</label>
                <input type="text" id="drinks_bullet_label" name="drinks_bullet_label" value="<?= sanitize($sectionsArray['drinks_bullet_label'] ?? 'What we offer:') ?>">
                <p class="form-help">Text that appears above the bullet list (e.g., "What we offer:")</p>
            </div>
            
            <div class="form-group">
                <label for="drinks_bullet_1">Bullet Point 1</label>
                <input type="text" id="drinks_bullet_1" name="drinks_bullet_1" value="<?= sanitize($sectionsArray['drinks_bullet_1'] ?? 'Signature cocktails') ?>">
            </div>
            
            <div class="form-group">
                <label for="drinks_bullet_2">Bullet Point 2</label>
                <input type="text" id="drinks_bullet_2" name="drinks_bullet_2" value="<?= sanitize($sectionsArray['drinks_bullet_2'] ?? 'Premium wines & champagnes') ?>">
            </div>
            
            <div class="form-group">
                <label for="drinks_bullet_3">Bullet Point 3</label>
                <input type="text" id="drinks_bullet_3" name="drinks_bullet_3" value="<?= sanitize($sectionsArray['drinks_bullet_3'] ?? 'Top-shelf spirits') ?>">
            </div>
            
            <div class="form-group">
                <label for="drinks_bullet_4">Bullet Point 4</label>
                <input type="text" id="drinks_bullet_4" name="drinks_bullet_4" value="<?= sanitize($sectionsArray['drinks_bullet_4'] ?? 'Non-alcoholic beverages and mocktails') ?>">
            </div>
            
            <div class="form-group">
                <label for="drinks_footer">Footer Text</label>
                <textarea id="drinks_footer" name="drinks_footer" rows="2"><?= sanitize($sectionsArray['drinks_footer'] ?? 'Each drink is prepared by skilled bartenders to ensure consistency, balance, and satisfaction.') ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Section 2: Ambience & Atmosphere -->
    <div class="card">
        <div class="card-header">
            <h2>Section 2: Ambience & Atmosphere</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="ambience_title">Title</label>
                <input type="text" id="ambience_title" name="ambience_title" value="<?= sanitize($sectionsArray['ambience_title'] ?? 'Relaxed, Stylish & Inviting') ?>">
            </div>
            
            <div class="form-group">
                <label for="ambience_description">Description</label>
                <textarea id="ambience_description" name="ambience_description" rows="5"><?= sanitize($sectionsArray['ambience_description'] ?? 'The Emilton Bar & Lounge features a warm and relaxed atmosphere enhanced by tasteful lighting, modern décor, and comfortable seating. Designed to encourage conversation and relaxation, the space is ideal for both quiet evenings and social moments. Whether you prefer a calm corner or a lively setting, our bar provides the right mood for every occasion.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Ambience Section Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('ambience_image', 'ambience_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="ambience_image" name="ambience_image" value="<?= sanitize($sectionsArray['ambience_image'] ?? '') ?>">
                <div id="ambience_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['ambience_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['ambience_image'])): ?>
                        <img id="ambience_img" src="<?= SITE_URL . ltrim($sectionsArray['ambience_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Section 3: Interior Design & Seating -->
    <div class="card">
        <div class="card-header">
            <h2>Section 3: Interior Design & Seating</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="interior_title">Title</label>
                <input type="text" id="interior_title" name="interior_title" value="<?= sanitize($sectionsArray['interior_title'] ?? 'Contemporary Bar Interior') ?>">
            </div>
            
            <div class="form-group">
                <label for="interior_description">Description</label>
                <textarea id="interior_description" name="interior_description" rows="5"><?= sanitize($sectionsArray['interior_description'] ?? 'Our bar interior reflects modern luxury, combining sleek finishes with elegant design elements. The thoughtfully arranged seating ensures comfort and privacy, making it suitable for individuals, couples, and small groups. The layout balances style and function, allowing guests to enjoy their drinks in a refined yet welcoming environment.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Interior Section Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('interior_image', 'interior_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="interior_image" name="interior_image" value="<?= sanitize($sectionsArray['interior_image'] ?? '') ?>">
                <div id="interior_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['interior_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['interior_image'])): ?>
                        <img id="interior_img" src="<?= SITE_URL . ltrim($sectionsArray['interior_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Why Choose Section -->
    <div class="card">
        <div class="card-header">
            <h2>Why Choose Section (4 Cards)</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="why_choose_title">Section Title</label>
                <input type="text" id="why_choose_title" name="why_choose_title" value="<?= sanitize($sectionsArray['why_choose_title'] ?? 'Why Choose Emilton Bar & Lounge') ?>">
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 1</h3>
            <div class="form-group">
                <label for="why_choose_card_1_icon">Icon Name (Material Symbols)</label>
                <input type="text" id="why_choose_card_1_icon" name="why_choose_card_1_icon" value="<?= sanitize($sectionsArray['why_choose_card_1_icon'] ?? 'local_bar') ?>" placeholder="e.g., local_bar">
            </div>
            <div class="form-group">
                <label for="why_choose_card_1_title">Title</label>
                <input type="text" id="why_choose_card_1_title" name="why_choose_card_1_title" value="<?= sanitize($sectionsArray['why_choose_card_1_title'] ?? 'Premium drinks and cocktails') ?>">
            </div>
            <div class="form-group">
                <label for="why_choose_card_1_description">Description</label>
                <textarea id="why_choose_card_1_description" name="why_choose_card_1_description" rows="2"><?= sanitize($sectionsArray['why_choose_card_1_description'] ?? 'Expertly crafted beverages using quality ingredients') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 2</h3>
            <div class="form-group">
                <label for="why_choose_card_2_icon">Icon Name</label>
                <input type="text" id="why_choose_card_2_icon" name="why_choose_card_2_icon" value="<?= sanitize($sectionsArray['why_choose_card_2_icon'] ?? 'spa') ?>">
            </div>
            <div class="form-group">
                <label for="why_choose_card_2_title">Title</label>
                <input type="text" id="why_choose_card_2_title" name="why_choose_card_2_title" value="<?= sanitize($sectionsArray['why_choose_card_2_title'] ?? 'Elegant and relaxed environment') ?>">
            </div>
            <div class="form-group">
                <label for="why_choose_card_2_description">Description</label>
                <textarea id="why_choose_card_2_description" name="why_choose_card_2_description" rows="2"><?= sanitize($sectionsArray['why_choose_card_2_description'] ?? 'Tasteful décor and comfortable seating') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 3</h3>
            <div class="form-group">
                <label for="why_choose_card_3_icon">Icon Name</label>
                <input type="text" id="why_choose_card_3_icon" name="why_choose_card_3_icon" value="<?= sanitize($sectionsArray['why_choose_card_3_icon'] ?? 'room_service') ?>">
            </div>
            <div class="form-group">
                <label for="why_choose_card_3_title">Title</label>
                <input type="text" id="why_choose_card_3_title" name="why_choose_card_3_title" value="<?= sanitize($sectionsArray['why_choose_card_3_title'] ?? 'Professional and friendly service') ?>">
            </div>
            <div class="form-group">
                <label for="why_choose_card_3_description">Description</label>
                <textarea id="why_choose_card_3_description" name="why_choose_card_3_description" rows="2"><?= sanitize($sectionsArray['why_choose_card_3_description'] ?? 'Attentive staff ensuring your comfort') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 4</h3>
            <div class="form-group">
                <label for="why_choose_card_4_icon">Icon Name</label>
                <input type="text" id="why_choose_card_4_icon" name="why_choose_card_4_icon" value="<?= sanitize($sectionsArray['why_choose_card_4_icon'] ?? 'location_on') ?>">
            </div>
            <div class="form-group">
                <label for="why_choose_card_4_title">Title</label>
                <input type="text" id="why_choose_card_4_title" name="why_choose_card_4_title" value="<?= sanitize($sectionsArray['why_choose_card_4_title'] ?? 'Conveniently located within Emilton Hotel & Suites') ?>">
            </div>
            <div class="form-group">
                <label for="why_choose_card_4_description">Description</label>
                <textarea id="why_choose_card_4_description" name="why_choose_card_4_description" rows="2"><?= sanitize($sectionsArray['why_choose_card_4_description'] ?? 'Perfect for leisure, meetings, and evening relaxation') ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Closing CTA Section -->
    <div class="card">
        <div class="card-header">
            <h2>Closing CTA Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="cta_title">CTA Title</label>
                <input type="text" id="cta_title" name="cta_title" value="<?= sanitize($sectionsArray['cta_title'] ?? 'Unwind in Style') ?>">
            </div>
            
            <div class="form-group">
                <label for="cta_description">CTA Description</label>
                <textarea id="cta_description" name="cta_description" rows="3"><?= sanitize($sectionsArray['cta_description'] ?? 'Step into Emilton Bar & Lounge and enjoy premium drinks, refined ambience, and exceptional service—all designed to elevate your evening experience.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="cta_tagline">CTA Tagline</label>
                <input type="text" id="cta_tagline" name="cta_tagline" value="<?= sanitize($sectionsArray['cta_tagline'] ?? 'Relax. Sip. Enjoy.') ?>">
            </div>
            
            <div class="form-group">
                <label>CTA Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('cta_background', 'cta_bg_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="cta_background" name="cta_background" value="<?= sanitize($sectionsArray['cta_background'] ?? '') ?>">
                <div id="cta_bg_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['cta_background']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['cta_background'])): ?>
                        <img id="cta_bg_img" src="<?= SITE_URL . ltrim($sectionsArray['cta_background'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Optional: Background image for the CTA section. If not set, white background will be used.</p>
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
        <button type="submit" class="btn btn-primary">Save Bar Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
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
    
    // Hero background
    if (targetInputId === 'hero_background') {
        handleImageSelection('hero_background', 'hero_bg_preview', 'hero_bg_img');
        return true;
    }
    
    // Drinks image
    if (targetInputId === 'drinks_image') {
        handleImageSelection('drinks_image', 'drinks_img_preview', 'drinks_img');
        return true;
    }
    
    // Ambience image
    if (targetInputId === 'ambience_image') {
        handleImageSelection('ambience_image', 'ambience_img_preview', 'ambience_img');
        return true;
    }
    
    // Interior image
    if (targetInputId === 'interior_image') {
        handleImageSelection('interior_image', 'interior_img_preview', 'interior_img');
        return true;
    }
    
    // CTA background
    if (targetInputId === 'cta_background') {
        const input = document.getElementById('cta_background');
        const preview = document.getElementById('cta_bg_preview');
        const selected = mediaModalState.selectedMedia;
        if (input && preview && selected) {
            input.value = selected.path;
            preview.style.display = 'block';
            const existingImg = document.getElementById('cta_bg_img');
            if (existingImg) {
                existingImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="cta_bg_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
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
document.getElementById('barPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all form fields
    const fields = [
        'hero_subtitle', 'hero_title', 'hero_intro', 'hero_background',
        'drinks_title', 'drinks_description', 'drinks_image', 'drinks_bullet_label', 'drinks_bullet_1', 'drinks_bullet_2', 'drinks_bullet_3', 'drinks_bullet_4', 'drinks_footer',
        'ambience_title', 'ambience_description', 'ambience_image',
        'interior_title', 'interior_description', 'interior_image',
        'why_choose_title',
        'why_choose_card_1_icon', 'why_choose_card_1_title', 'why_choose_card_1_description',
        'why_choose_card_2_icon', 'why_choose_card_2_title', 'why_choose_card_2_description',
        'why_choose_card_3_icon', 'why_choose_card_3_title', 'why_choose_card_3_description',
        'why_choose_card_4_icon', 'why_choose_card_4_title', 'why_choose_card_4_description',
        'cta_title', 'cta_description', 'cta_tagline', 'cta_background',
        'feature_image'
    ];
    
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
                page: 'bar',
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
                showToast('Bar page content saved successfully', 'success');
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