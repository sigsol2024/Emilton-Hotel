<?php
/**
 * Edit Room Page
 */

$pageTitle = 'Edit Room';
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/header.php';

$roomId = intval($_GET['id'] ?? 0);
if (!$roomId) {
    redirect(ADMIN_URL . 'pages/rooms/list.php');
}

try {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
    $stmt->execute([$roomId]);
    $room = $stmt->fetch();

    if (!$room) {
        redirect(ADMIN_URL . 'pages/rooms/list.php');
    }

    // Decode JSON fields
    $room['gallery_images'] = json_decode($room['gallery_images'] ?? '[]', true);
    $room['features'] = json_decode($room['features'] ?? '[]', true);
    $room['amenities'] = json_decode($room['amenities'] ?? '[]', true);
    $room['tags'] = json_decode($room['tags'] ?? '[]', true);
    $room['included_items'] = json_decode($room['included_items'] ?? '[]', true);
    $room['good_to_know'] = json_decode($room['good_to_know'] ?? '{}', true);
} catch (PDOException $e) {
    error_log("Edit room error: " . $e->getMessage());
    redirect(ADMIN_URL . 'pages/rooms/list.php');
}

$csrfToken = generateCSRFToken();
?>

<div class="card">
    <div class="card-header">
        <h2>Edit Room: <?= sanitize($room['title']) ?></h2>
    </div>

    <form id="roomForm" method="POST" style="padding: 20px;">
        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="title">Room Title *</label>
                <input type="text" id="title" name="title" class="form-control" value="<?= sanitize($room['title']) ?>" required data-slug-source="slug">
            </div>
            <div class="form-group">
                <label for="slug">Slug *</label>
                <input type="text" id="slug" name="slug" class="form-control" value="<?= sanitize($room['slug']) ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="price">Price per Night *</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" value="<?= $room['price'] ?>" required>
            </div>
            <div class="form-group">
                <label for="room_type">Room Type</label>
                <input type="text" id="room_type" name="room_type" class="form-control" value="<?= sanitize($room['room_type']) ?>">
            </div>
            <div class="form-group">
                <label for="max_guests">Max Guests</label>
                <input type="number" id="max_guests" name="max_guests" class="form-control" min="1" value="<?= $room['max_guests'] ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_description" class="form-control" rows="3"><?= sanitize($room['short_description']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="description">Full Description</label>
            <textarea id="description" name="description" class="form-control" rows="6"><?= sanitize($room['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Main Image</label>
            <div style="margin-bottom: 10px;">
                <button type="button" class="btn btn-outline" onclick="openMediaModal('main_image', 'main_image_preview')">
                    <i class="fas fa-image"></i> Select Image
                </button>
            </div>
            <input type="hidden" id="main_image" name="main_image" value="<?= sanitize($room['main_image']) ?>">
            <div id="main_image_preview" class="image-preview" style="margin-top: 10px; <?= $room['main_image'] ? 'display: block;' : 'display: none;' ?>">
                <?php if (!empty($room['main_image'])): ?>
                    <?php $existingImageUrl = SITE_URL . ltrim($room['main_image'], '/'); ?>
                    <img id="main_image_img"
                         src="<?= $existingImageUrl ?>"
                         style="max-width: 300px; max-height: 300px; border-radius: 4px; display: block;"
                         onerror="this.style.display='none';">
                <?php else: ?>
                    <img id="main_image_img" src="" style="max-width: 300px; max-height: 300px; border-radius: 4px; display: block;">
                <?php endif; ?>
            </div>
            <p class="form-help">Select an image from the media library or upload a new one</p>
        </div>

        <!-- Gallery Images -->
        <div class="form-group" style="margin-top: 20px;">
            <label>Room Gallery Images</label>
            <p class="form-help">Add multiple images for the room gallery (used on the details page). The Main Image is separate.</p>
            <div style="margin-bottom: 10px;">
                <button type="button" class="btn btn-outline" onclick="openMediaModal('gallery_images_json', 'gallery_images_preview', true)">
                    <i class="fas fa-images"></i> Add Gallery Image
                </button>
            </div>
            <input type="hidden" id="gallery_images_json" name="gallery_images_json" value="<?= htmlspecialchars(json_encode($room['gallery_images'] ?? []), ENT_QUOTES, 'UTF-8') ?>">
            <div id="gallery_images_preview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px;"></div>
        </div>

        <!-- Features Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Features</h3>
            <div id="features-container">
                <?php if (!empty($room['features']) && is_array($room['features'])): ?>
                    <?php foreach ($room['features'] as $feature): ?>
                        <div class="form-row" style="margin-bottom: 10px;">
                            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                                <input type="text" name="features[]" class="form-control" value="<?= sanitize(is_array($feature) ? ($feature['title'] ?? '') : $feature) ?>" placeholder="Feature name">
                            </div>
                            <div class="form-group" style="width: auto; margin-bottom: 0;">
                                <button type="button" class="btn btn-outline btn-sm" onclick="removeFeature(this)">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-outline btn-sm" onclick="addFeature()" style="margin-top: 10px;">Add Feature</button>
        </div>

        <!-- Amenities Section (Enhanced) -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Amenities</h3>
            <p class="form-help" style="margin-bottom: 15px;">Add amenities with icon, title, and optional description</p>
            <div id="amenities-container">
                <?php if (!empty($room['amenities']) && is_array($room['amenities'])): ?>
                    <?php foreach ($room['amenities'] as $index => $amenity): ?>
                        <?php
                            $icon = 'check_circle';
                            $title = '';
                            $description = '';
                            if (is_array($amenity)) {
                                $icon = $amenity['icon'] ?? 'check_circle';
                                $title = $amenity['title'] ?? '';
                                $description = $amenity['description'] ?? '';
                            } else {
                                $title = $amenity;
                            }
                        ?>
                        <div class="card" style="margin-bottom: 15px;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Icon (Material Symbol name)</label>
                                    <input type="text" name="amenities[<?= $index ?>][icon]" class="form-control" value="<?= sanitize($icon) ?>" placeholder="king_bed">
                                </div>
                                <div class="form-group">
                                    <label>Title *</label>
                                    <input type="text" name="amenities[<?= $index ?>][title]" class="form-control" value="<?= sanitize($title) ?>" placeholder="King Size Bed" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description (optional)</label>
                                <input type="text" name="amenities[<?= $index ?>][description]" class="form-control" value="<?= sanitize($description) ?>" placeholder="Premium linens">
                            </div>
                            <button type="button" class="btn btn-outline btn-sm" onclick="removeAmenity(this)">Remove Amenity</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-outline btn-sm" onclick="addAmenity()" style="margin-top: 10px;">Add Amenity</button>
        </div>

        <!-- Rating & Location Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Rating & Location</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="rating">Rating (Stars)</label>
                    <select id="rating" name="rating" class="form-control">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>" <?= (isset($room['rating']) ? intval($room['rating']) : 5) == $i ? 'selected' : '' ?>><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rating_score">Rating Score (e.g., 9.8)</label>
                    <input type="number" id="rating_score" name="rating_score" class="form-control" step="0.1" min="0" max="10" value="<?= isset($room['rating_score']) && $room['rating_score'] ? $room['rating_score'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="location">Location (e.g., "Ocean Wing, 5th Floor")</label>
                    <input type="text" id="location" name="location" class="form-control" value="<?= sanitize($room['location'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="size">Size (e.g., "55 m²")</label>
                    <input type="text" id="size" name="size" class="form-control" value="<?= sanitize($room['size'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- Tags Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Tags</h3>
            <div id="tags-container">
                <?php if (!empty($room['tags']) && is_array($room['tags'])): ?>
                    <?php foreach ($room['tags'] as $tag): ?>
                        <div class="form-row" style="margin-bottom: 10px;">
                            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                                <input type="text" name="tags[]" class="form-control" value="<?= sanitize($tag) ?>" placeholder="Tag name">
                            </div>
                            <div class="form-group" style="width: auto; margin-bottom: 0;">
                                <button type="button" class="btn btn-outline btn-sm" onclick="removeTag(this)">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-outline btn-sm" onclick="addTag()" style="margin-top: 10px;">Add Tag</button>
        </div>

        <!-- Included Items Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Included in Stay</h3>
            <div id="included-items-container">
                <?php if (!empty($room['included_items']) && is_array($room['included_items'])): ?>
                    <?php foreach ($room['included_items'] as $item): ?>
                        <div class="form-row" style="margin-bottom: 10px;">
                            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                                <input type="text" name="included_items[]" class="form-control" value="<?= sanitize($item) ?>" placeholder="Included item">
                            </div>
                            <div class="form-group" style="width: auto; margin-bottom: 0;">
                                <button type="button" class="btn btn-outline btn-sm" onclick="removeIncludedItem(this)">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-outline btn-sm" onclick="addIncludedItem()" style="margin-top: 10px;">Add Included Item</button>
        </div>

        <!-- Good to Know Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Good to Know</h3>
            <div class="form-group">
                <label for="check_in">Check-in Time (e.g., "15:00")</label>
                <input type="text" id="check_in" name="check_in" class="form-control" value="<?= sanitize($room['good_to_know']['check_in'] ?? '') ?>" placeholder="15:00">
            </div>
            <div class="form-group">
                <label for="check_out">Check-out Time (e.g., "12:00")</label>
                <input type="text" id="check_out" name="check_out" class="form-control" value="<?= sanitize($room['good_to_know']['check_out'] ?? '') ?>" placeholder="12:00">
            </div>
            <div class="form-group">
                <label for="pets">Pets Policy</label>
                <textarea id="pets" name="pets" class="form-control" rows="2"><?= sanitize($room['good_to_know']['pets'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- Booking Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Booking</h3>
            <div class="form-group">
                <label for="book_url">Book Now URL</label>
                <input type="url" id="book_url" name="book_url" class="form-control" value="<?= sanitize($room['book_url'] ?? '') ?>" placeholder="https://...">
                <p class="form-help">Custom URL for Book Now button. Leave empty to use default WhatsApp link.</p>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="original_price">Original Price (for discount display)</label>
                    <input type="number" id="original_price" name="original_price" class="form-control" step="0.01" min="0" value="<?= isset($room['original_price']) && $room['original_price'] ? $room['original_price'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="urgency_message">Urgency Message (optional)</label>
                    <input type="text" id="urgency_message" name="urgency_message" class="form-control" value="<?= sanitize($room['urgency_message'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label><input type="checkbox" name="is_featured" value="1" <?= $room['is_featured'] ? 'checked' : '' ?>> Featured Room</label>
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_active" value="1" <?= $room['is_active'] ? 'checked' : '' ?>> Active</label>
            </div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Update Room</button>
            <a href="<?= ADMIN_URL ?>pages/rooms/list.php" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<script>
let roomId = <?= (int)$roomId ?>;

// #region agent log
const __LOG_ENDPOINT__ = 'http://127.0.0.1:7243/ingest/a1aac6c6-ff27-4da6-a86c-6c175a5ad1ae';
function __agentLog__(hypothesisId, location, message, data) {
    try {
        fetch(__LOG_ENDPOINT__, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                sessionId: 'debug-session',
                runId: 'gallery-persist-pre',
                hypothesisId,
                location,
                message,
                data: data || {},
                timestamp: Date.now()
            })
        }).catch(() => {});
    } catch (e) {}
}
// #endregion agent log

function generateSlug(text) {
    return text
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

let slugManuallyEdited = false;
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const initialSlug = slugInput?.value || '';

    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            if (!slugManuallyEdited || slugInput.value === '' || slugInput.value === initialSlug) {
                slugInput.value = generateSlug(this.value);
            }
        });
        slugInput.addEventListener('input', function() { slugManuallyEdited = true; });
        slugInput.addEventListener('focus', function() { slugManuallyEdited = true; });
    }
});

// Gallery images state + helpers
let galleryImages = <?= json_encode(array_values($room['gallery_images'] ?? [])) ?>;

function syncGalleryImages() {
    const input = document.getElementById('gallery_images_json');
    if (input) {
        const cleanArray = Array.isArray(galleryImages) ? galleryImages.filter(path => path && String(path).trim().length > 0) : [];
        input.value = JSON.stringify(cleanArray);
        console.log('Synced gallery images to hidden input:', cleanArray.length, 'images');
    }
}

function renderGalleryImages() {
    console.log('renderGalleryImages() called. galleryImages:', galleryImages);
    const container = document.getElementById('gallery_images_preview');
    if (!container) {
        console.warn('gallery_images_preview container not found!');
        return;
    }
    container.innerHTML = '';
    galleryImages.forEach((path, idx) => {
        if (!path) return;
        const wrap = document.createElement('div');
        wrap.className = 'gallery-thumb';
        wrap.style.cssText = 'position:relative;border:1px solid var(--border-color);border-radius:6px;overflow:hidden;background:var(--bg-color);';
        wrap.innerHTML = `
            <img src="<?= SITE_URL ?>${String(path).replace(/^\/+/, '')}" alt="Gallery image" style="width:100%;height:90px;object-fit:cover;display:block;">
            <div style="display:flex;gap:6px;padding:8px;justify-content:space-between;align-items:center;">
                <button type="button" class="btn btn-sm btn-outline" title="Move left">←</button>
                <button type="button" class="btn btn-sm btn-outline" title="Move right">→</button>
                <button type="button" class="btn btn-sm btn-danger" title="Remove">✕</button>
            </div>
        `;
        const btns = wrap.querySelectorAll('button');
        btns[0].addEventListener('click', () => moveGalleryImage(idx, -1));
        btns[1].addEventListener('click', () => moveGalleryImage(idx, 1));
        btns[2].addEventListener('click', () => removeGalleryImage(idx));
        container.appendChild(wrap);
    });
    console.log('Rendered', galleryImages.length, 'images in preview');
    syncGalleryImages();
}

function addGalleryImage(path) {
    if (!path) return;
    const clean = String(path).trim();
    if (!clean) return;
    if (!galleryImages.includes(clean)) {
        galleryImages.push(clean);
        console.log('Added gallery image:', clean, 'Total:', galleryImages.length);
    }
    renderGalleryImages();
}

function removeGalleryImage(index) {
    galleryImages = galleryImages.filter((_, i) => i !== index);
    renderGalleryImages();
}

function moveGalleryImage(index, delta) {
    const next = index + delta;
    if (next < 0 || next >= galleryImages.length) return;
    const tmp = galleryImages[index];
    galleryImages[index] = galleryImages[next];
    galleryImages[next] = tmp;
    renderGalleryImages();
}

document.addEventListener('DOMContentLoaded', function () {
    // Rehydrate galleryImages from hidden input on page load
    const input = document.getElementById('gallery_images_json');
    if (input && input.value) {
        try {
            const parsed = JSON.parse(input.value);
            if (Array.isArray(parsed)) {
                galleryImages = parsed.filter(path => path && String(path).trim().length > 0);
                console.log('Rehydrated galleryImages from hidden input on page load:', galleryImages.length, 'images');
            }
        } catch (e) {
            console.error('Error parsing gallery_images_json on page load:', e);
        }
    }
    renderGalleryImages();
});

// Handle media modal selection
window.insertSelectedMediaOverride = function() {
    const targetInputId = mediaModalState.targetInputId;
    
    // Handle main image (single selection only)
    if (targetInputId === 'main_image') {
        const selected = mediaModalState.selectedMedia;
        if (!selected) return false;
        
        const input = document.getElementById('main_image');
        const preview = document.getElementById('main_image_preview');
        const previewImg = document.getElementById('main_image_img');
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
        }
        closeMediaModal();
        if (typeof showToast === 'function') showToast('Image selected', 'success');
        return true;
    }

    // Handle gallery images (supports multiple selection)
    if (targetInputId === 'gallery_images_json') {
        console.log('=== GALLERY OVERRIDE CALLED ===');
        console.log('mediaModalState:', mediaModalState);
        console.log('allowMultiple:', mediaModalState.allowMultiple);
        console.log('selectedMedia:', mediaModalState.selectedMedia);
        console.log('selectedMediaMultiple:', mediaModalState.selectedMediaMultiple);
        
        const list = mediaModalState.allowMultiple
            ? (mediaModalState.selectedMediaMultiple || [])
            : (mediaModalState.selectedMedia ? [mediaModalState.selectedMedia] : []);

        console.log('list extracted:', list);
        const paths = list.map(item => item.path || item.file_path).filter(Boolean);
        console.log('paths extracted:', paths);
        console.log('galleryImages BEFORE adding:', galleryImages);
        
        if (paths.length) {
            // merge + de-dupe
            paths.forEach(p => {
                const cleanPath = String(p).trim();
                console.log('Processing path:', cleanPath, 'already in array?', galleryImages.includes(cleanPath));
                if (cleanPath && !galleryImages.includes(cleanPath)) {
                    galleryImages.push(cleanPath);
                    console.log('Added path to galleryImages. New length:', galleryImages.length);
                }
            });
            console.log('galleryImages AFTER adding:', galleryImages);
            renderGalleryImages();
            console.log('After renderGalleryImages(), galleryImages:', galleryImages);
        } else {
            console.warn('No paths to add! list.length=', list.length, 'paths.length=', paths.length);
        }
        
        __agentLog__('H1', 'admin/pages/rooms/edit.php:override', 'Gallery insertSelectedMediaOverride fired', {
            allowMultiple: !!mediaModalState.allowMultiple,
            selectedCount: list.length,
            pathsCount: paths.length,
            galleryImagesCountAfter: Array.isArray(galleryImages) ? galleryImages.length : null,
            targetInputId
        });
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast(paths.length > 1 ? `${paths.length} images added` : 'Gallery image added', 'success');
        }
        console.log('=== END GALLERY OVERRIDE ===');
        return true;
    }

    return false;
};

// Tag management
function addTag() {
    const container = document.getElementById('tags-container');
    const div = document.createElement('div');
    div.className = 'form-row';
    div.style.cssText = 'margin-bottom: 10px;';
    div.innerHTML = `
        <div class="form-group" style="flex: 1; margin-bottom: 0;">
            <input type="text" name="tags[]" class="form-control" value="" placeholder="Tag name">
        </div>
        <div class="form-group" style="width: auto; margin-bottom: 0;">
            <button type="button" class="btn btn-outline btn-sm" onclick="removeTag(this)">Remove</button>
        </div>
    `;
    container.appendChild(div);
}
function removeTag(btn) { btn.closest('.form-row').remove(); }

// Features management
function addFeature() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.className = 'form-row';
    div.style.cssText = 'margin-bottom: 10px;';
    div.innerHTML = `
        <div class="form-group" style="flex: 1; margin-bottom: 0;">
            <input type="text" name="features[]" class="form-control" value="" placeholder="Feature name">
        </div>
        <div class="form-group" style="width: auto; margin-bottom: 0;">
            <button type="button" class="btn btn-outline btn-sm" onclick="removeFeature(this)">Remove</button>
        </div>
    `;
    container.appendChild(div);
}
function removeFeature(btn) { btn.closest('.form-row').remove(); }

// Amenities management
let amenityIndex = <?= !empty($room['amenities']) && is_array($room['amenities']) ? count($room['amenities']) : 0 ?>;
function addAmenity() {
    const container = document.getElementById('amenities-container');
    const div = document.createElement('div');
    div.className = 'card';
    div.style.cssText = 'margin-bottom: 15px;';
    div.innerHTML = `
        <div class="form-row">
            <div class="form-group">
                <label>Icon (Material Symbol name)</label>
                <input type="text" name="amenities[${amenityIndex}][icon]" class="form-control" value="check_circle" placeholder="king_bed">
            </div>
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="amenities[${amenityIndex}][title]" class="form-control" value="" placeholder="King Size Bed" required>
            </div>
        </div>
        <div class="form-group">
            <label>Description (optional)</label>
            <input type="text" name="amenities[${amenityIndex}][description]" class="form-control" value="" placeholder="Premium linens">
        </div>
        <button type="button" class="btn btn-outline btn-sm" onclick="removeAmenity(this)">Remove Amenity</button>
    `;
    container.appendChild(div);
    amenityIndex++;
}
function removeAmenity(btn) { btn.closest('.card').remove(); }

// Included items
function addIncludedItem() {
    const container = document.getElementById('included-items-container');
    const div = document.createElement('div');
    div.className = 'form-row';
    div.style.cssText = 'margin-bottom: 10px;';
    div.innerHTML = `
        <div class="form-group" style="flex: 1; margin-bottom: 0;">
            <input type="text" name="included_items[]" class="form-control" value="" placeholder="Included item">
        </div>
        <div class="form-group" style="width: auto; margin-bottom: 0;">
            <button type="button" class="btn btn-outline btn-sm" onclick="removeIncludedItem(this)">Remove</button>
        </div>
    `;
    container.appendChild(div);
}
function removeIncludedItem(btn) { btn.closest('.form-row').remove(); }

// Form submission
document.getElementById('roomForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = {};

    const features = [];
    formData.getAll('features[]').forEach(f => { if (String(f).trim()) features.push(String(f).trim()); });
    data['features'] = features;

    // Ensure the hidden JSON input is the single source of truth before saving
    syncGalleryImages();
    
    // DEBUG: Verify sync worked
    const afterSync = document.getElementById('gallery_images_json')?.value;
    console.log('After syncGalleryImages(), hidden input value:', afterSync);
    console.log('galleryImages array length:', galleryImages.length);
    
    let galleryFromInput = [];
    try {
        const input = document.getElementById('gallery_images_json');
        const raw = input?.value || '[]';
        const parsed = JSON.parse(raw);
        galleryFromInput = Array.isArray(parsed) ? parsed : [];
    } catch (e) {
        console.error('Error parsing gallery_images_json:', e);
        // Fallback to the JavaScript array
        galleryFromInput = Array.isArray(galleryImages) ? galleryImages : [];
    }
    // Filter out empty strings and ensure we have valid paths
    data['gallery_images'] = galleryFromInput.filter(path => path && String(path).trim().length > 0);
    __agentLog__('H2', 'admin/pages/rooms/edit.php:submit', 'Submitting room update', {
        roomId,
        galleryImagesCountVar: Array.isArray(galleryImages) ? galleryImages.length : null,
        galleryImagesJsonLen: (document.getElementById('gallery_images_json')?.value || '').length,
        galleryImagesCountPayload: Array.isArray(data.gallery_images) ? data.gallery_images.length : null
    });

    const amenities = [];
    const amenityKeys = new Set();
    formData.forEach((value, key) => {
        const match = key.match(/^amenities\[(\d+)\]\[(icon|title|description)\]$/);
        if (match) amenityKeys.add(match[1]);
    });
    amenityKeys.forEach(index => {
        const icon = formData.get(`amenities[${index}][icon]`) || 'check_circle';
        const title = formData.get(`amenities[${index}][title]`);
        const description = formData.get(`amenities[${index}][description]`) || '';
        if (title && String(title).trim()) {
            amenities.push({ icon: String(icon).trim(), title: String(title).trim(), description: String(description).trim() });
        }
    });
    data['amenities'] = amenities;

    const tags = [];
    formData.getAll('tags[]').forEach(t => { if (String(t).trim()) tags.push(String(t).trim()); });
    data['tags'] = tags;

    const includedItems = [];
    formData.getAll('included_items[]').forEach(i => { if (String(i).trim()) includedItems.push(String(i).trim()); });
    data['included_items'] = includedItems;

    data['good_to_know'] = {
        check_in: formData.get('check_in') || '',
        check_out: formData.get('check_out') || '',
        pets: formData.get('pets') || ''
    };

    formData.forEach((value, key) => {
        if (key !== 'tags[]' && key !== 'included_items[]' && key !== 'features[]' &&
            !key.match(/^amenities\[\d+\]\[/) &&
            key !== 'gallery_images_json' &&
            key !== 'check_in' && key !== 'check_out' &&
            key !== 'pets') {
            data[key] = value;
        }
    });

    data['is_featured'] = this.querySelector('[name="is_featured"]').checked ? 1 : 0;
    data['is_active'] = this.querySelector('[name="is_active"]').checked ? 1 : 0;

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Updating...';

    const csrfMeta = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const csrfHidden = document.querySelector('input[name="csrf_token"]')?.value || '';
    const csrfToken = csrfMeta || csrfHidden || '';
    __agentLog__('H1', 'admin/pages/rooms/edit.php:csrf', 'Resolved CSRF token sources', {
        hasMeta: !!document.querySelector('meta[name="csrf-token"]'),
        metaLen: csrfMeta ? String(csrfMeta).length : 0,
        hiddenLen: csrfHidden ? String(csrfHidden).length : 0,
        chosen: csrfMeta ? 'meta' : (csrfHidden ? 'hidden' : 'none')
    });
    
    // DEBUG: Log what we're about to send
    console.log('=== GALLERY IMAGES DEBUG ===');
    console.log('galleryImages array:', galleryImages);
    console.log('gallery_images_json input value:', document.getElementById('gallery_images_json')?.value);
    console.log('data.gallery_images being sent:', data.gallery_images);
    console.log('Full data object keys:', Object.keys(data));
    console.log('===========================');
    
    fetch('<?= ADMIN_URL ?>api/rooms.php?id=' + roomId, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrfToken },
        body: JSON.stringify(data)
    })
        .then(response => {
            __agentLog__('H1', 'admin/pages/rooms/edit.php:fetch', 'PUT response status', { status: response.status, ok: response.ok, statusText: response.statusText });
            if (!response.ok) throw new Error('HTTP ' + response.status + ': ' + response.statusText);
            return response.text().then(text => {
                try { return JSON.parse(text); }
                catch (e) { console.error('Invalid JSON response:', text); throw new Error('Server returned invalid response. Please check server logs.'); }
            });
        })
        .then(resp => {
            if (resp.success) {
                // Debug verification: re-fetch the room and confirm gallery_images persisted
                const sentCount = Array.isArray(data.gallery_images) ? data.gallery_images.length : 0;
                __agentLog__('H3', 'admin/pages/rooms/edit.php:put', 'PUT success response', { sentCount, resp });
                fetch('<?= ADMIN_URL ?>api/rooms.php?id=' + roomId, { method: 'GET' })
                    .then(r => r.text().then(t => { try { return JSON.parse(t); } catch { return null; } }))
                    .then(check => {
                        const stored = check?.room?.gallery_images;
                        const storedCount = Array.isArray(stored) ? stored.length : 0;
                        __agentLog__('H4', 'admin/pages/rooms/edit.php:refetch', 'Refetch after save', {
                            sentCount,
                            storedType: typeof stored,
                            storedIsArray: Array.isArray(stored),
                            storedCount,
                            rawGalleryImagesField: check?.room?.gallery_images
                        });
                        if (sentCount > 0 && storedCount === 0) {
                            showToast('Saved, but gallery images did NOT persist. Please refresh and try again.', 'error');
                            console.error('Gallery persist check failed', { sentCount, storedCount, check });
                        } else {
                            showToast('Room updated successfully', 'success');
                        }
                    })
                    .catch(err => {
                        showToast('Room updated successfully', 'success');
                        console.error('Gallery persist check error', err);
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    });
            } else {
                showToast(resp.message || 'Failed to update room', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Room update error:', error);
            showToast('Error: ' + error.message, 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
});
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

 
