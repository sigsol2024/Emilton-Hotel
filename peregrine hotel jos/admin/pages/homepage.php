<?php
/**
 * Homepage Editor - Complete match to provided design
 */

$pageTitle = 'Homepage Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all homepage sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'index' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Homepage editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="homepageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Hero Section -->
    <div class="card">
        <div class="card-header">
            <h2>Hero Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="hero_title">Hero Title</label>
                <input type="text" id="hero_title" name="hero_title" value="<?= sanitize($sectionsArray['hero_title'] ?? 'A New Standard of Coastal Luxury') ?>">
            </div>
            
            <div class="form-group">
                <label for="hero_subtitle">Hero Subtitle</label>
                <textarea id="hero_subtitle" name="hero_subtitle" rows="2"><?= sanitize($sectionsArray['hero_subtitle'] ?? 'Stay in Comfort.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="hero_description">Hero Description</label>
                <textarea id="hero_description" name="hero_description" rows="2"><?= sanitize($sectionsArray['hero_description'] ?? 'A sanctuary of modern luxury in the heart of Rayfield.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Hero Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('hero_background', 'hero_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="hero_background" name="hero_background" value="<?= sanitize($sectionsArray['hero_background'] ?? '') ?>">
                <div id="hero_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['hero_background']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['hero_background'])): 
                        $heroImgSrc = $sectionsArray['hero_background'];
                        if (strpos($heroImgSrc, 'http://') === 0 || strpos($heroImgSrc, 'https://') === 0) {
                            $heroImgUrl = $heroImgSrc;
                        } else {
                            $heroImgUrl = SITE_URL . ltrim($heroImgSrc, '/');
                        }
                    ?>
                        <img id="hero_img_img" src="<?= htmlspecialchars($heroImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">This image will be used as the background, or as a cover image if a YouTube video is set.</p>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>YouTube Video (Optional)</h3>
            <p class="form-help" style="margin-bottom: 15px; color: #666;">If a YouTube video URL is provided, it will play as the hero background. The Hero Background Image above will serve as a cover/thumbnail before the video plays.</p>
            
            <div class="form-group">
                <label for="hero_youtube_url">YouTube Video URL</label>
                <input type="text" id="hero_youtube_url" name="hero_youtube_url" value="<?= sanitize($sectionsArray['hero_youtube_url'] ?? '') ?>" placeholder="https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID">
                <p class="form-help">Enter the full YouTube URL. If provided, the video will play as the hero background.</p>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="hero_youtube_start">Video Start Time (seconds)</label>
                    <input type="number" id="hero_youtube_start" name="hero_youtube_start" value="<?= sanitize($sectionsArray['hero_youtube_start'] ?? '0') ?>" min="0" placeholder="0">
                    <p class="form-help">Video will start playing at this time (in seconds). Leave as 0 to start from beginning.</p>
                </div>
                <div class="form-group">
                    <label for="hero_youtube_end">Video End Time (seconds)</label>
                    <input type="number" id="hero_youtube_end" name="hero_youtube_end" value="<?= sanitize($sectionsArray['hero_youtube_end'] ?? '') ?>" min="0" placeholder="Leave empty for full video">
                    <p class="form-help">Video will stop at this time (in seconds). Leave empty to play the full video.</p>
                </div>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>Mobile YouTube Video (Optional - Portrait Orientation)</h3>
            <p class="form-help" style="margin-bottom: 15px; color: #666;">If provided, this video will be displayed on mobile devices instead of the desktop video. Use a portrait-oriented video for better mobile viewing.</p>
            
            <div class="form-group">
                <label for="hero_youtube_mobile_url">Mobile YouTube Video URL</label>
                <input type="text" id="hero_youtube_mobile_url" name="hero_youtube_mobile_url" value="<?= sanitize($sectionsArray['hero_youtube_mobile_url'] ?? '') ?>" placeholder="https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID">
                <p class="form-help">Enter the full YouTube URL for mobile devices. If provided, this will replace the desktop video on mobile screens.</p>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="hero_youtube_mobile_start">Mobile Video Start Time (seconds)</label>
                    <input type="number" id="hero_youtube_mobile_start" name="hero_youtube_mobile_start" value="<?= sanitize($sectionsArray['hero_youtube_mobile_start'] ?? '0') ?>" min="0" placeholder="0">
                    <p class="form-help">Video will start playing at this time (in seconds). Leave as 0 to start from beginning.</p>
                </div>
                <div class="form-group">
                    <label for="hero_youtube_mobile_end">Mobile Video End Time (seconds)</label>
                    <input type="number" id="hero_youtube_mobile_end" name="hero_youtube_mobile_end" value="<?= sanitize($sectionsArray['hero_youtube_mobile_end'] ?? '') ?>" min="0" placeholder="Leave empty for full video">
                    <p class="form-help">Video will stop at this time (in seconds). Leave empty to play the full video.</p>
                </div>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>Hero CTA Buttons</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="hero_cta_text">Primary Button Text</label>
                    <input type="text" id="hero_cta_text" name="hero_cta_text" value="<?= sanitize($sectionsArray['hero_cta_text'] ?? 'Book Your Stay') ?>">
                </div>
                <div class="form-group">
                    <label for="hero_cta_link">Primary Button Link</label>
                    <input type="text" id="hero_cta_link" name="hero_cta_link" value="<?= sanitize($sectionsArray['hero_cta_link'] ?? 'rooms_&_suites.php') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="hero_cta2_text">Secondary Button Text</label>
                    <input type="text" id="hero_cta2_text" name="hero_cta2_text" value="<?= sanitize($sectionsArray['hero_cta2_text'] ?? 'Explore Our Rooms') ?>">
                </div>
                <div class="form-group">
                    <label for="hero_cta2_link">Secondary Button Link</label>
                    <input type="text" id="hero_cta2_link" name="hero_cta2_link" value="<?= sanitize($sectionsArray['hero_cta2_link'] ?? 'rooms_&_suites.php') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search Widget Section -->
    <div class="card">
        <div class="card-header">
            <h2>Search Widget Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="search_location">Search Location</label>
                <input type="text" id="search_location" name="search_location" value="<?= sanitize($sectionsArray['search_location'] ?? 'The Azure Estate, Malibu') ?>">
            </div>
            
            <div class="form-group">
                <label for="search_dates">Search Dates</label>
                <input type="text" id="search_dates" name="search_dates" value="<?= sanitize($sectionsArray['search_dates'] ?? 'Fri 24 Oct — Sun 26 Oct') ?>">
            </div>
            
            <div class="form-group">
                <label for="search_guests">Search Guests</label>
                <input type="text" id="search_guests" name="search_guests" value="<?= sanitize($sectionsArray['search_guests'] ?? '2 adults · 0 children · 1 room') ?>">
            </div>
        </div>
    </div>
    
    <!-- About Section -->
    <div class="card">
        <div class="card-header">
            <h2>About Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="about_label">Label (Small text above title)</label>
                <input type="text" id="about_label" name="about_label" value="<?= sanitize($sectionsArray['about_label'] ?? 'Boulevard Hotel Group') ?>">
            </div>
            
            <div class="form-group">
                <label for="about_title">Title</label>
                <input type="text" id="about_title" name="about_title" value="<?= sanitize($sectionsArray['about_title'] ?? 'A Refined Stay in the Heart of Rayfield') ?>">
            </div>
            
            <div class="form-group">
                <label for="about_description_1">Description 1</label>
                <textarea id="about_description_1" name="about_description_1" rows="3"><?= sanitize($sectionsArray['about_description_1'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="about_description_2">Description 2</label>
                <textarea id="about_description_2" name="about_description_2" rows="3"><?= sanitize($sectionsArray['about_description_2'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>About Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('about_image', 'about_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="about_image" name="about_image" value="<?= sanitize($sectionsArray['about_image'] ?? '') ?>">
                <div id="about_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['about_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['about_image'])): 
                        $aboutImgSrc = $sectionsArray['about_image'];
                        if (strpos($aboutImgSrc, 'http://') === 0 || strpos($aboutImgSrc, 'https://') === 0) {
                            $aboutImgUrl = $aboutImgSrc;
                        } else {
                            $aboutImgUrl = SITE_URL . ltrim($aboutImgSrc, '/');
                        }
                    ?>
                        <img id="about_img_img" src="<?= htmlspecialchars($aboutImgUrl, ENT_QUOTES, 'UTF-8') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>About CTA Button</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="about_cta_text">Button Text</label>
                    <input type="text" id="about_cta_text" name="about_cta_text" value="<?= sanitize($sectionsArray['about_cta_text'] ?? 'Learn More About Us') ?>">
                </div>
                <div class="form-group">
                    <label for="about_cta_link">Button Link</label>
                    <input type="text" id="about_cta_link" name="about_cta_link" value="<?= sanitize($sectionsArray['about_cta_link'] ?? 'about_us.php') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Accommodations Section -->
    <div class="card">
        <div class="card-header">
            <h2>Accommodations Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="rooms_title">Title</label>
                <input type="text" id="rooms_title" name="rooms_title" value="<?= sanitize($sectionsArray['rooms_title'] ?? 'Accommodations') ?>">
            </div>
            
            <div class="form-group">
                <label for="rooms_subtitle">Subtitle</label>
                <textarea id="rooms_subtitle" name="rooms_subtitle" rows="2"><?= sanitize($sectionsArray['rooms_subtitle'] ?? 'Designed for tranquility and style. Choose the space that fits your journey.') ?></textarea>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>Rooms CTA Button</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="rooms_cta_text">Button Text</label>
                    <input type="text" id="rooms_cta_text" name="rooms_cta_text" value="<?= sanitize($sectionsArray['rooms_cta_text'] ?? 'View All Rooms') ?>">
                </div>
                <div class="form-group">
                    <label for="rooms_cta_link">Button Link</label>
                    <input type="text" id="rooms_cta_link" name="rooms_cta_link" value="<?= sanitize($sectionsArray['rooms_cta_link'] ?? 'rooms_&_suites.php') ?>">
                </div>
            </div>
            
            <p class="form-help">Note: Rooms are loaded dynamically from the Rooms management section. Mark rooms as "Featured" to display them here.</p>
        </div>
    </div>
    
    <!-- Amenities Section -->
    <div class="card">
        <div class="card-header">
            <h2>Amenities Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="amenities_title">Title</label>
                <input type="text" id="amenities_title" name="amenities_title" value="<?= sanitize($sectionsArray['amenities_title'] ?? 'Premium Amenities') ?>">
            </div>
            
            <div class="form-group">
                <label for="amenities_description">Description</label>
                <textarea id="amenities_description" name="amenities_description" rows="2"><?= sanitize($sectionsArray['amenities_description'] ?? 'We have curated every aspect of your stay to ensure maximum comfort and convenience.') ?></textarea>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>Amenities CTA Button</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="amenities_cta_text">Button Text</label>
                    <input type="text" id="amenities_cta_text" name="amenities_cta_text" value="<?= sanitize($sectionsArray['amenities_cta_text'] ?? 'View All Amenities') ?>">
                </div>
                <div class="form-group">
                    <label for="amenities_cta_link">Button Link</label>
                    <input type="text" id="amenities_cta_link" name="amenities_cta_link" value="<?= sanitize($sectionsArray['amenities_cta_link'] ?? 'amenities.php') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Final CTA Section -->
    <div class="card">
        <div class="card-header">
            <h2>Final CTA Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="cta_title">Title</label>
                <input type="text" id="cta_title" name="cta_title" value="<?= sanitize($sectionsArray['cta_title'] ?? 'Your Perfect Stay in Jos Awaits') ?>">
            </div>
            
            <div class="form-group">
                <label for="cta_description">Description</label>
                <textarea id="cta_description" name="cta_description" rows="2"><?= sanitize($sectionsArray['cta_description'] ?? 'Experience the perfect blend of luxury, comfort, and Nigerian hospitality. Book directly with us for the best rates.') ?></textarea>
            </div>
            
            <hr style="margin: 20px 0;">
            <h3>CTA Button</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="cta_button_text">Button Text</label>
                    <input type="text" id="cta_button_text" name="cta_button_text" value="<?= sanitize($sectionsArray['cta_button_text'] ?? 'Book Your Stay') ?>">
                </div>
                <div class="form-group">
                    <label for="cta_button_link">Button Link</label>
                    <input type="text" id="cta_button_link" name="cta_button_link" value="<?= sanitize($sectionsArray['cta_button_link'] ?? 'rooms_&_suites.php') ?>">
                </div>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Homepage Content</button>
    </div>
</form>

<script>
// Handle media modal selection
window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const targetInputId = mediaModalState.targetInputId;
    
    // Handle hero background image
    if (targetInputId === 'hero_background') {
        const input = document.getElementById('hero_background');
        const preview = document.getElementById('hero_img_preview');
        const previewImg = document.getElementById('hero_img_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                const imgPath = selected.path;
                previewImg.src = (imgPath.startsWith('http://') || imgPath.startsWith('https://')) 
                    ? imgPath 
                    : '<?= SITE_URL ?>' + imgPath.replace(/^\//, '');
            } else {
                const imgPath = selected.path;
                const imgUrl = (imgPath.startsWith('http://') || imgPath.startsWith('https://')) 
                    ? imgPath 
                    : '<?= SITE_URL ?>' + imgPath.replace(/^\//, '');
                preview.innerHTML = '<img id="hero_img_img" src="' + imgUrl + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle about image
    if (targetInputId === 'about_image') {
        const input = document.getElementById('about_image');
        const preview = document.getElementById('about_img_preview');
        const previewImg = document.getElementById('about_img_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                const imgPath = selected.path;
                previewImg.src = (imgPath.startsWith('http://') || imgPath.startsWith('https://')) 
                    ? imgPath 
                    : '<?= SITE_URL ?>' + imgPath.replace(/^\//, '');
            } else {
                const imgPath = selected.path;
                const imgUrl = (imgPath.startsWith('http://') || imgPath.startsWith('https://')) 
                    ? imgPath 
                    : '<?= SITE_URL ?>' + imgPath.replace(/^\//, '');
                preview.innerHTML = '<img id="about_img_img" src="' + imgUrl + '" style="max-width: 500px; max-height: 300px;">';
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
document.getElementById('homepageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all section data
    const sectionKeys = [
        'hero_title', 'hero_subtitle', 'hero_description', 'hero_background',
        'hero_youtube_url', 'hero_youtube_start', 'hero_youtube_end',
        'hero_youtube_mobile_url', 'hero_youtube_mobile_start', 'hero_youtube_mobile_end',
        'hero_cta_text', 'hero_cta_link', 'hero_cta2_text', 'hero_cta2_link',
        'search_location', 'search_dates', 'search_guests',
        'about_label', 'about_title', 'about_description_1', 'about_description_2', 'about_image',
        'about_cta_text', 'about_cta_link',
        'rooms_title', 'rooms_subtitle', 'rooms_cta_text', 'rooms_cta_link',
        'amenities_title', 'amenities_description', 'amenities_cta_text', 'amenities_cta_link',
        'cta_title', 'cta_description', 'cta_button_text', 'cta_button_link'
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
                page: 'index',
                section_key: key,
                content_type: key.includes('image') ? 'image' : 'text',
                content: sections[key]
            })
        }).then(response => response.json());
    });
    
    Promise.all(promises).then(results => {
        const allSuccess = results.every(r => r.success);
        if (allSuccess) {
            showToast('Homepage content saved successfully', 'success');
        } else {
            showToast('Some sections failed to save', 'warning');
        }
    })
    .catch(error => {
        showToast('An error occurred', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
