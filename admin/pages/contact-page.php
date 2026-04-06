<?php
/**
 * Contact Page Editor
 */

$pageTitle = 'Contact Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all contact page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'contact' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Contact page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="contactPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Page Header -->
    <div class="card">
        <div class="card-header">
            <h2>Page Header</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="hero_title">Page Title</label>
                <input type="text" id="hero_title" name="hero_title" value="<?= sanitize($sectionsArray['hero_title'] ?? '') ?>">
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
    
    <!-- Contact Information -->
    <div class="card">
        <div class="card-header">
            <h2>Contact Information</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="hero_subtitle">Hero Subtitle</label>
                <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?= sanitize($sectionsArray['hero_subtitle'] ?? '') ?>">
                <p class="form-help">Short line under the page title</p>
            </div>

            <div class="form-group">
                <label for="contact_intro_title">Contact Intro Title</label>
                <input type="text" id="contact_intro_title" name="contact_intro_title" value="<?= sanitize($sectionsArray['contact_intro_title'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="contact_intro_text">Contact Intro Text</label>
                <textarea id="contact_intro_text" name="contact_intro_text" rows="2"><?= sanitize($sectionsArray['contact_intro_text'] ?? '') ?></textarea>
            </div>

            <hr style="margin: 20px 0; border-color: var(--border-color);">
            <h3 style="margin-bottom: 15px; font-size: 18px;">Hotel Information Card</h3>
            <p class="form-help" style="margin-bottom: 15px;">These fields control the information displayed in the Hotel Information card on the contact page.</p>

            <div class="form-group">
                <label for="contact_hotel_name">Hotel Name</label>
                <input type="text" id="contact_hotel_name" name="contact_hotel_name" value="<?= sanitize($sectionsArray['contact_hotel_name'] ?? '') ?>">
                <p class="form-help">Hotel name displayed in the Hotel Information card</p>
            </div>

            <div class="form-group">
                <label for="contact_address">Address</label>
                <textarea id="contact_address" name="contact_address" rows="2"><?= sanitize($sectionsArray['contact_address'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="contact_phone">Phone</label>
                <input type="text" id="contact_phone" name="contact_phone" value="<?= sanitize($sectionsArray['contact_phone'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="contact_email">Email</label>
                <input type="email" id="contact_email" name="contact_email" value="<?= sanitize($sectionsArray['contact_email'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="contact_front_desk">Front Desk Hours</label>
                <input type="text" id="contact_front_desk" name="contact_front_desk" value="<?= sanitize($sectionsArray['contact_front_desk'] ?? '24 Hours / 7 Days') ?>">
                <p class="form-help">Front desk operating hours (e.g., "24 Hours / 7 Days")</p>
            </div>

            <hr style="margin: 20px 0; border-color: var(--border-color);">
            <h3 style="margin-bottom: 15px; font-size: 18px;">Form Content</h3>

            <div class="form-group">
                <label for="form_title">Form Title</label>
                <input type="text" id="form_title" name="form_title" value="<?= sanitize($sectionsArray['form_title'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="form_subtitle">Form Subtitle</label>
                <input type="text" id="form_subtitle" name="form_subtitle" value="<?= sanitize($sectionsArray['form_subtitle'] ?? '') ?>">
            </div>

            <hr style="margin: 20px 0; border-color: var(--border-color);">
            <h3 style="margin-bottom: 15px; font-size: 18px;">Map</h3>

            <div class="form-group">
                <label for="map_address">Map Address</label>
                <input type="text" id="map_address" name="map_address" value="<?= sanitize($sectionsArray['map_address'] ?? '') ?>">
                <p class="form-help">Used to generate the Google Map via API. Example: "Emilton Hotel, Ajao Estate, Lagos"</p>
            </div>

            <div class="form-group">
                <label for="map_embed_url">Custom Map Embed URL (optional)</label>
                <input type="text" id="map_embed_url" name="map_embed_url" value="<?= sanitize($sectionsArray['map_embed_url'] ?? '') ?>">
                <p class="form-help">Optional: paste a full embed URL. If provided, it overrides the generated map from the address.</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Contact Page</button>
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
document.getElementById('contactPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all form fields
    const fields = [
        'hero_title', 'hero_background',
        'hero_subtitle', 'contact_intro_title', 'contact_intro_text',
        'contact_address', 'contact_phone', 'contact_email',
        'contact_hotel_name', 'contact_front_desk',
        'form_title', 'form_subtitle',
        'map_address', 'map_embed_url'
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
                page: 'contact',
                section_key: key,
                content_type: key.includes('image') || key.includes('background') ? 'image' : 'text',
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
                showToast('Contact page content saved successfully', 'success');
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

