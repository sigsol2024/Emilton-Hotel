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

// Gallery images are loaded from rooms, not stored here

$csrfToken = generateCSRFToken();
?>

<form id="galleryPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Gallery Header Section -->
    <div class="card">
        <div class="card-header">
            <h2>Gallery Header</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="gallery_title">Gallery Title</label>
                <input type="text" id="gallery_title" name="gallery_title" value="<?= sanitize($sectionsArray['gallery_title'] ?? 'Experience Our Sanctuary') ?>">
                <p class="form-help">Main title displayed on the gallery page</p>
            </div>
            
            <div class="form-group">
                <label for="gallery_description">Gallery Description</label>
                <textarea id="gallery_description" name="gallery_description" rows="3"><?= sanitize($sectionsArray['gallery_description'] ?? 'Explore the luxury and comfort of our amenities through our curated gallery. From our infinity pools to our fine dining experiences.') ?></textarea>
                <p class="form-help">Description text displayed below the title</p>
            </div>
            
            <div class="form-group" style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 4px; padding: 15px; margin-top: 20px;">
                <p style="margin: 0; color: #0369a1; font-size: 14px;">
                    <strong>Note:</strong> Gallery images are automatically pulled from room images. To add images to the gallery, edit rooms in the <a href="<?= ADMIN_URL ?>pages/rooms/list.php" style="color: #0284c7; text-decoration: underline;">Rooms</a> section and add images to their galleries.
                </p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Gallery Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
// Handle media modal selection (not needed for gallery page)
window.insertSelectedMediaOverride = function() {
    return false;
};

// Form submission
document.getElementById('galleryPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Gallery header fields
    if (formData.has('gallery_title')) {
        sections['gallery_title'] = formData.get('gallery_title');
    }
    if (formData.has('gallery_description')) {
        sections['gallery_description'] = formData.get('gallery_description');
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
                content_type: 'text',
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

