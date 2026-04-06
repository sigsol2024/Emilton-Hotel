<?php
/**
 * Add New Room Page
 */

$pageTitle = 'Add New Room';
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/header.php';

$csrfToken = generateCSRFToken();
?>

<div class="card">
    <div class="card-header">
        <h2>Add New Room</h2>
    </div>
    
    <form id="roomForm" method="POST" style="padding: 20px;">
        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label for="title">Room Title *</label>
                <input type="text" id="title" name="title" class="form-control" required data-slug-source="slug">
                <p class="form-help">The name of the room/suite</p>
            </div>
            <div class="form-group">
                <label for="slug">Slug *</label>
                <input type="text" id="slug" name="slug" class="form-control" required>
                <p class="form-help">URL-friendly version of the title</p>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="price">Price per Night *</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" required>
                <p class="form-help">Price in Naira (₦)</p>
            </div>
            <div class="form-group">
                <label for="room_type">Room Type</label>
                <input type="text" id="room_type" name="room_type" class="form-control" placeholder="e.g., 2-BR, 3-BR">
                <p class="form-help">e.g., 1-Bedroom, 2-Bedroom, 3-Bedroom</p>
            </div>
            <div class="form-group">
                <label for="max_guests">Max Guests</label>
                <input type="number" id="max_guests" name="max_guests" class="form-control" min="1">
            </div>
        </div>
        
        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_description" class="form-control" rows="3"></textarea>
            <p class="form-help">Brief description (shown in listings)</p>
        </div>
        
        <div class="form-group">
            <label for="description">Full Description</label>
            <textarea id="description" name="description" class="form-control" rows="6"></textarea>
            <p class="form-help">Detailed description of the room</p>
        </div>
        
        <div class="form-group">
            <label>Main Image</label>
            <div style="margin-bottom: 10px;">
                <button type="button" class="btn btn-outline" onclick="openMediaModal('main_image', 'main_image_preview')">
                    <i class="fas fa-image"></i> Select Image
                </button>
            </div>
            <input type="hidden" id="main_image" name="main_image">
            <div id="main_image_preview" class="image-preview" style="margin-top: 10px; display: none;">
                <img id="main_image_img" src="" style="max-width: 300px; max-height: 300px; border-radius: 4px; display: block;">
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
            <input type="hidden" id="gallery_images_json" name="gallery_images_json" value="[]">
            <div id="gallery_images_preview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px;"></div>
        </div>

        <!-- Features Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Features</h3>
            <div id="features-container"></div>
            <button type="button" class="btn btn-outline btn-sm" onclick="addFeature()" style="margin-top: 10px;">Add Feature</button>
        </div>

        <!-- Amenities Section (Enhanced) -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Amenities</h3>
            <p class="form-help" style="margin-bottom: 15px;">Add amenities with icon, title, and optional description</p>
            <div id="amenities-container"></div>
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
                        <option value="<?= $i ?>" <?= $i == 5 ? 'selected' : '' ?>><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rating_score">Rating Score (e.g., 9.8)</label>
                    <input type="number" id="rating_score" name="rating_score" class="form-control" step="0.1" min="0" max="10">
                </div>
                <div class="form-group">
                    <label for="location">Location (e.g., "Ocean Wing, 5th Floor")</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="Ocean Wing, 5th Floor">
                </div>
                <div class="form-group">
                    <label for="size">Size (e.g., "55 m²")</label>
                    <input type="text" id="size" name="size" class="form-control" placeholder="55 m²">
                </div>
            </div>
        </div>

        <!-- Tags Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Tags</h3>
            <div id="tags-container"></div>
            <button type="button" class="btn btn-outline btn-sm" onclick="addTag()" style="margin-top: 10px;">Add Tag</button>
        </div>

        <!-- Included Items Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Included in Stay</h3>
            <div id="included-items-container"></div>
            <button type="button" class="btn btn-outline btn-sm" onclick="addIncludedItem()" style="margin-top: 10px;">Add Included Item</button>
        </div>

        <!-- Good to Know Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Good to Know</h3>
            <div class="form-group">
                <label for="check_in">Check-in Time (e.g., "15:00")</label>
                <input type="text" id="check_in" name="check_in" class="form-control" placeholder="15:00">
            </div>
            <div class="form-group">
                <label for="check_out">Check-out Time (e.g., "12:00")</label>
                <input type="text" id="check_out" name="check_out" class="form-control" placeholder="12:00">
            </div>
            <div class="form-group">
                <label for="pets">Pets Policy</label>
                <textarea id="pets" name="pets" class="form-control" rows="2" placeholder="Pets are not allowed."></textarea>
            </div>
        </div>

        <!-- Booking Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <h3 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">Booking</h3>
            <div class="form-group">
                <label for="book_url">Book Now URL</label>
                <input type="url" id="book_url" name="book_url" class="form-control" placeholder="https://...">
                <p class="form-help">Custom URL for Book Now button. Leave empty to use default WhatsApp link.</p>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="original_price">Original Price (for discount display)</label>
                    <input type="number" id="original_price" name="original_price" class="form-control" step="0.01" min="0">
                    <p class="form-help">Set if you want to show a discounted price</p>
                </div>
                <div class="form-group">
                    <label for="urgency_message">Urgency Message (optional)</label>
                    <input type="text" id="urgency_message" name="urgency_message" class="form-control" placeholder="High demand! Only 2 rooms left.">
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_featured" value="1"> Featured Room
                </label>
                <p class="form-help">Show this room in featured sections</p>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" checked> Active
                </label>
                <p class="form-help">Make this room visible on the website</p>
            </div>
        </div>
        
        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Save Room</button>
            <a href="<?= ADMIN_URL ?>pages/rooms/list.php" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<script>
// Auto-generate slug from title
function generateSlug(text) {
    return text
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '') // Remove special characters
        .replace(/[\s_-]+/g, '-') // Replace spaces, underscores, and multiple hyphens with single hyphen
        .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
}

// Track if slug was manually edited
let slugManuallyEdited = false;

document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput) {
        // Auto-generate slug when title changes (only if slug is empty or wasn't manually edited)
        titleInput.addEventListener('input', function() {
            if (!slugManuallyEdited || slugInput.value === '') {
                slugInput.value = generateSlug(this.value);
            }
        });
        
        // Track manual slug edits
        slugInput.addEventListener('input', function() {
            slugManuallyEdited = true;
        });
        
        // Track if slug field is focused (user might be editing it)
        slugInput.addEventListener('focus', function() {
            slugManuallyEdited = true;
        });
    }
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
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="main_image_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 300px; max-height: 300px; border-radius: 4px; display: block;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }

    // Handle gallery images (supports multiple selection)
    if (targetInputId === 'gallery_images_json') {
        const list = mediaModalState.allowMultiple
            ? (mediaModalState.selectedMediaMultiple || [])
            : (mediaModalState.selectedMedia ? [mediaModalState.selectedMedia] : []);

        const paths = list.map(item => item.path || item.file_path).filter(Boolean);
        console.log('Gallery override: allowMultiple=', mediaModalState.allowMultiple, 'selectedCount=', list.length, 'paths=', paths);
        
        if (paths.length) {
            // merge + de-dupe
            paths.forEach(p => {
                const cleanPath = String(p).trim();
                if (cleanPath && !galleryImages.includes(cleanPath)) {
                    galleryImages.push(cleanPath);
                }
            });
            renderGalleryImages();
        }
        
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast(paths.length > 1 ? `${paths.length} images added` : 'Gallery image added', 'success');
        }
        return true;
    }
    
    return false;
};

// Media modal integration - the openMediaModal function is provided by media-library.js

// Gallery images state + helpers
let galleryImages = [];

function syncGalleryImages() {
    const input = document.getElementById('gallery_images_json');
    if (input) {
        const cleanArray = Array.isArray(galleryImages) ? galleryImages.filter(path => path && String(path).trim().length > 0) : [];
        input.value = JSON.stringify(cleanArray);
        console.log('Synced gallery images to hidden input:', cleanArray.length, 'images');
    }
}

function renderGalleryImages() {
    const container = document.getElementById('gallery_images_preview');
    if (!container) return;
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
        const btnLeft = wrap.querySelectorAll('button')[0];
        const btnRight = wrap.querySelectorAll('button')[1];
        const btnRemove = wrap.querySelectorAll('button')[2];
        btnLeft.addEventListener('click', () => moveGalleryImage(idx, -1));
        btnRight.addEventListener('click', () => moveGalleryImage(idx, 1));
        btnRemove.addEventListener('click', () => removeGalleryImage(idx));
        container.appendChild(wrap);
    });
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
    renderGalleryImages();
});

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

function removeTag(btn) {
    btn.closest('.form-row').remove();
}

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

function removeFeature(btn) {
    btn.closest('.form-row').remove();
}

// Amenities management (enhanced)
let amenityIndex = 0;
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

function removeAmenity(btn) {
    btn.closest('.card').remove();
}

// Included items management
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

function removeIncludedItem(btn) {
    btn.closest('.form-row').remove();
}

// Form submission
document.getElementById('roomForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {};
    
    // Collect features
    const features = [];
    formData.getAll('features[]').forEach(feature => {
        if (feature.trim()) features.push(feature.trim());
    });
    data['features'] = features;

    // Collect gallery images
    syncGalleryImages();
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
    console.log('Submitting gallery images:', data['gallery_images'].length, 'images');
    
    // Collect amenities (enhanced format)
    const amenities = [];
    const amenityKeys = new Set();
    formData.forEach((value, key) => {
        const match = key.match(/^amenities\[(\d+)\]\[(icon|title|description)\]$/);
        if (match) {
            amenityKeys.add(match[1]);
        }
    });
    amenityKeys.forEach(index => {
        const icon = formData.get(`amenities[${index}][icon]`) || 'check_circle';
        const title = formData.get(`amenities[${index}][title]`);
        const description = formData.get(`amenities[${index}][description]`) || '';
        if (title && title.trim()) {
            amenities.push({
                icon: icon.trim(),
                title: title.trim(),
                description: description.trim()
            });
        }
    });
    data['amenities'] = amenities;
    
    // Collect tags
    const tags = [];
    formData.getAll('tags[]').forEach(tag => {
        if (tag.trim()) tags.push(tag.trim());
    });
    data['tags'] = tags;
    
    // Collect included items
    const includedItems = [];
    formData.getAll('included_items[]').forEach(item => {
        if (item.trim()) includedItems.push(item.trim());
    });
    data['included_items'] = includedItems;
    
    // Collect good to know
    data['good_to_know'] = {
        check_in: formData.get('check_in') || '',
        check_out: formData.get('check_out') || '',
        pets: formData.get('pets') || ''
    };
    
    // Collect other fields
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
    submitBtn.textContent = 'Saving...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // #region agent log
    // H3: admin UI may be sending wrong title/slug/short_description payload when creating a room
    fetch('http://127.0.0.1:7243/ingest/a1aac6c6-ff27-4da6-a86c-6c175a5ad1ae', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            sessionId: 'debug-session',
            runId: 'pre-fix',
            hypothesisId: 'H3',
            location: 'admin/pages/rooms/add.php:agentlog:submit',
            message: 'Create room submit payload (sanity)',
            data: {
                title: data.title || null,
                slug: data.slug || null,
                short_description: data.short_description || null,
                descriptionLen: (data.description || '').length,
                featuresCount: Array.isArray(data.features) ? data.features.length : null,
                amenitiesCount: Array.isArray(data.amenities) ? data.amenities.length : null,
                tagsCount: Array.isArray(data.tags) ? data.tags.length : null
            },
            timestamp: Date.now()
        })
    }).catch(() => {});
    // #endregion agent log
    fetch('<?= ADMIN_URL ?>api/rooms.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': csrfToken
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + response.statusText);
            }
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Invalid JSON response:', text);
                    throw new Error('Server returned invalid response. Please check server logs.');
                }
            });
        })
        .then(data => {
            if (data.success) {
                showToast('Room created successfully', 'success');
                setTimeout(() => {
                    window.location.href = '<?= ADMIN_URL ?>pages/rooms/edit.php?id=' + data.room_id;
                }, 1000);
            } else {
                showToast(data.message || 'Failed to create room', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Room save error:', error);
            showToast('Error: ' + error.message, 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
});
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

