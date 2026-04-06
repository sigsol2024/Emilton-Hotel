<?php
/**
 * Rooms Page Editor - Complete match to provided design
 */

$pageTitle = 'Rooms Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all rooms page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'rooms' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Rooms page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="roomsPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Hero Section -->
    <div class="card">
        <div class="card-header">
            <h2>Hero Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="page_title">Hero Title</label>
                <input type="text" id="page_title" name="page_title" value="<?= sanitize($sectionsArray['page_title'] ?? 'Accommodations') ?>">
                <p class="form-help">Main title displayed in the hero section (e.g., "Accommodations")</p>
            </div>
            
            <div class="form-group">
                <label for="page_subtitle">Hero Subtitle</label>
                <textarea id="page_subtitle" name="page_subtitle" rows="2"><?= sanitize($sectionsArray['page_subtitle'] ?? 'Designed for tranquility and style. Choose the space that fits your journey.') ?></textarea>
                <p class="form-help">Subtitle displayed below the hero title</p>
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
                <p class="form-help">Background image for the hero section</p>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Section -->
    <div class="card">
        <div class="card-header">
            <h2>Sidebar - Map Widget</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label>Map Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('map_image', 'map_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="map_image" name="map_image" value="<?= sanitize($sectionsArray['map_image'] ?? '') ?>">
                <div id="map_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['map_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['map_image'])): ?>
                        <img id="map_img_img" src="<?= SITE_URL . ltrim($sectionsArray['map_image'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Map widget image shown in the sidebar</p>
            </div>
        </div>
    </div>
    
    <!-- Results Section -->
    <div class="card">
        <div class="card-header">
            <h2>Results Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="results_count">Results Count Text</label>
                <input type="text" id="results_count" name="results_count" value="<?= sanitize($sectionsArray['results_count'] ?? 'properties found') ?>">
                <p class="form-help">Text that appears after the number of rooms (e.g., "properties found")</p>
            </div>
            
            <p class="form-help">Note: Rooms are loaded dynamically from the Rooms management section. The actual room count will be calculated automatically.</p>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Rooms Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
// Handle media modal selection
window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const targetInputId = mediaModalState.targetInputId;
    
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
    
    if (targetInputId === 'map_image') {
        const input = document.getElementById('map_image');
        const preview = document.getElementById('map_img_preview');
        const previewImg = document.getElementById('map_img_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="map_img_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
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
document.getElementById('roomsPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all section data
    const sectionKeys = [
        'page_title', 'page_subtitle', 'hero_background',
        'map_image', 'results_count'
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
                page: 'rooms',
                section_key: key,
                content_type: key.includes('image') ? 'image' : 'text',
                content: sections[key]
            })
        }).then(response => response.json());
    });
    
    Promise.all(promises).then(results => {
        const allSuccess = results.every(r => r.success);
        if (allSuccess) {
            showToast('Rooms page content saved successfully', 'success');
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
