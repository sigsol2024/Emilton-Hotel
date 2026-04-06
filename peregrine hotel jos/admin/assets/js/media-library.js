/**
 * Media Library Modal JavaScript
 * Handles media selection modal functionality
 */

// Modal state
let mediaModalState = {
    targetInputId: null,
    targetPreviewId: null,
    selectedMedia: null,
    selectedMediaMultiple: [], // Array for multiple selection
    allowMultiple: false, // Flag to enable multiple selection
    currentPage: 1,
    currentSearch: ''
};

// Initialize modal when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Close modal handlers
    const closeBtn = document.getElementById('closeMediaModal');
    const cancelBtn = document.getElementById('cancelMediaSelection');
    const modal = document.getElementById('mediaLibraryModal');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeMediaModal);
    }
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeMediaModal);
    }
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeMediaModal();
            }
        });
    }
    
    // Tab switching
    const tabs = document.querySelectorAll('.media-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            switchMediaTab(tabName);
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('mediaSearchInput');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                mediaModalState.currentSearch = e.target.value;
                mediaModalState.currentPage = 1;
                loadMediaLibrary();
            }, 500);
        });
    }
    
    // Upload form
    const uploadForm = document.getElementById('mediaUploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            uploadNewMedia();
        });
    }
    
    // Insert button
    const insertBtn = document.getElementById('insertMediaBtn');
    if (insertBtn) {
        insertBtn.addEventListener('click', function() {
            insertSelectedMedia();
        });
    }
});

/**
 * Determine if a field should allow multiple selection
 * Only specific fields like gallery images should allow multiple
 */
function shouldAllowMultipleSelection(targetInputId) {
    // Fields that should allow multiple selection
    const multipleFields = [
        'gallery_image_new',
        'room_gallery_images',
        'gallery_images'
    ];
    
    // Check if the input ID matches any multiple field pattern
    return multipleFields.some(field => targetInputId.includes(field) || targetInputId === field);
}

/**
 * Open media modal
 * @param {string} targetInputId - ID of hidden input to store selected image path
 * @param {string} targetPreviewId - ID of preview container to show selected image
 * @param {boolean} allowMultiple - Allow multiple image selection (optional, auto-detected if not provided)
 */
function openMediaModal(targetInputId, targetPreviewId, allowMultiple = null) {
    mediaModalState.targetInputId = targetInputId;
    mediaModalState.targetPreviewId = targetPreviewId;
    mediaModalState.selectedMedia = null;
    mediaModalState.selectedMediaMultiple = [];
    
    // Auto-detect if allowMultiple is not explicitly provided
    if (allowMultiple === null) {
        mediaModalState.allowMultiple = shouldAllowMultipleSelection(targetInputId);
    } else {
        mediaModalState.allowMultiple = allowMultiple;
    }
    
    const modal = document.getElementById('mediaLibraryModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Switch to library tab and load media
        switchMediaTab('library');
        loadMediaLibrary();
        updateInsertButton();
    }
}

/**
 * Close media modal
 */
function closeMediaModal() {
    const modal = document.getElementById('mediaLibraryModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        mediaModalState.selectedMedia = null;
        mediaModalState.selectedMediaMultiple = [];
        updateInsertButton();
    }
}

/**
 * Switch between tabs
 */
function switchMediaTab(tabName) {
    // Update tab buttons
    document.querySelectorAll('.media-tab').forEach(tab => {
        if (tab.getAttribute('data-tab') === tabName) {
            tab.classList.add('active');
            tab.style.borderBottomColor = '#0073aa';
            tab.style.color = '#0073aa';
        } else {
            tab.classList.remove('active');
            tab.style.borderBottomColor = 'transparent';
            tab.style.color = '#666';
        }
    });
    
    // Update tab content
    document.querySelectorAll('.media-tab-content').forEach(content => {
        content.classList.remove('active');
        content.style.display = 'none';
    });
    
    if (tabName === 'library') {
        document.getElementById('mediaLibraryTab').classList.add('active');
        document.getElementById('mediaLibraryTab').style.display = 'block';
        loadMediaLibrary();
    } else if (tabName === 'upload') {
        document.getElementById('mediaUploadTab').classList.add('active');
        document.getElementById('mediaUploadTab').style.display = 'block';
    }
}

/**
 * Load media library from API
 */
function loadMediaLibrary() {
    const gridContainer = document.getElementById('mediaGridContainer');
    if (!gridContainer) return;
    
    gridContainer.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;"><i class="fas fa-spinner fa-spin" style="font-size: 32px; margin-bottom: 10px;"></i><p>Loading media...</p></div>';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const params = new URLSearchParams({
        page: mediaModalState.currentPage,
        per_page: 20
    });
    
    if (mediaModalState.currentSearch) {
        params.append('search', mediaModalState.currentSearch);
    }
    
    const adminUrl = typeof ADMIN_URL !== 'undefined' ? ADMIN_URL : window.ADMIN_URL || '';
    fetch(adminUrl + 'api/media.php?' + params.toString(), {
        method: 'GET',
        headers: {
            'X-CSRF-Token': csrfToken
        },
        credentials: 'include'
    })
    .then(response => {
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
    })
    .then(data => {
        if (data.success && data.media) {
            renderMediaGrid(data.media);
            renderPagination(data.pagination);
        } else {
            gridContainer.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;"><p>No media files found.</p></div>';
        }
    })
    .catch(error => {
        console.error('Error loading media:', error);
        gridContainer.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #d63638;"><p>Error loading media. Please try again.</p></div>';
    });
}

/**
 * Render media grid
 */
function renderMediaGrid(mediaItems) {
    const gridContainer = document.getElementById('mediaGridContainer');
    if (!gridContainer) return;
    
    if (!mediaItems || mediaItems.length === 0) {
        gridContainer.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;"><p>No media files found.</p></div>';
        return;
    }
    
    let html = '';
    mediaItems.forEach(media => {
        const mediaId = parseInt(media.id);
        const isSelected = mediaModalState.allowMultiple 
            ? mediaModalState.selectedMediaMultiple.some(m => parseInt(m.id) === mediaId)
            : (mediaModalState.selectedMedia && parseInt(mediaModalState.selectedMedia.id) === mediaId);
        const isImage = media.file_type && media.file_type.startsWith('image/');
        const borderColor = isSelected ? '#0073aa' : '#ddd';
        const borderWidth = isSelected ? '3px' : '2px';
        
        // Escape JavaScript string delimiters for onclick handler
        const escapedPath = escapeHtml(media.file_path).replace(/'/g, "\\'").replace(/"/g, '\\"');
        const escapedUrl = escapeHtml(media.url).replace(/'/g, "\\'").replace(/"/g, '\\"');
        
        html += `
            <div class="media-grid-item" data-media-id="${media.id}" data-media-path="${escapeHtml(media.file_path)}" data-media-url="${escapeHtml(media.url)}" 
                 style="border: ${borderWidth} solid ${borderColor}; border-radius: 4px; overflow: hidden; cursor: pointer; background: white; position: relative;"
                 onclick="selectMediaItem(${media.id}, '${escapedPath}', '${escapedUrl}')">
                ${isImage ? `
                    <div style="position: relative; padding-top: 100%; background: #f0f0f0;">
                        <img src="${escapeHtml(media.url)}" alt="${escapeHtml(media.original_name)}" 
                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                        ${isSelected ? '<div class="media-selection-checkmark" style="position: absolute; top: 5px; right: 5px; background: #0073aa; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 14px; z-index: 10;"><i class="fas fa-check"></i></div>' : ''}
                    </div>
                ` : `
                    <div style="padding: 40px 20px; text-align: center; background: #f0f0f0;">
                        <i class="fas fa-file" style="font-size: 32px; color: #999;"></i>
                    </div>
                `}
                <div style="padding: 8px; font-size: 12px; color: #666; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="${escapeHtml(media.original_name)}">
                    ${escapeHtml(media.original_name)}
                </div>
            </div>
        `;
    });
    
    gridContainer.innerHTML = html;
    
    // Update button after rendering
    updateInsertButton();
}

/**
 * Render pagination
 */
function renderPagination(pagination) {
    const paginationContainer = document.getElementById('mediaPagination');
    if (!paginationContainer || !pagination || pagination.pages <= 1) {
        if (paginationContainer) paginationContainer.style.display = 'none';
        return;
    }
    
    paginationContainer.style.display = 'flex';
    
    let html = '';
    
    // Previous button
    if (pagination.page > 1) {
        html += `<button type="button" onclick="goToMediaPage(${pagination.page - 1})" class="btn btn-sm btn-outline">Previous</button>`;
    }
    
    // Page numbers
    for (let i = 1; i <= pagination.pages; i++) {
        if (i === 1 || i === pagination.pages || (i >= pagination.page - 2 && i <= pagination.page + 2)) {
            html += `<button type="button" onclick="goToMediaPage(${i})" class="btn btn-sm ${i === pagination.page ? 'btn-primary' : 'btn-outline'}" style="min-width: 40px;">${i}</button>`;
        } else if (i === pagination.page - 3 || i === pagination.page + 3) {
            html += '<span style="padding: 8px;">...</span>';
        }
    }
    
    // Next button
    if (pagination.page < pagination.pages) {
        html += `<button type="button" onclick="goToMediaPage(${pagination.page + 1})" class="btn btn-sm btn-outline">Next</button>`;
    }
    
    paginationContainer.innerHTML = html;
}

/**
 * Go to specific page
 */
function goToMediaPage(page) {
    mediaModalState.currentPage = page;
    loadMediaLibrary();
    document.getElementById('mediaGridContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/**
 * Select media item
 */
function selectMediaItem(mediaId, mediaPath, mediaUrl) {
    // Convert to numbers for comparison
    mediaId = parseInt(mediaId);
    
    if (mediaModalState.allowMultiple) {
        // Multiple selection mode - toggle selection
        const existingIndex = mediaModalState.selectedMediaMultiple.findIndex(m => parseInt(m.id) === mediaId);
        if (existingIndex >= 0) {
            // Deselect if already selected
            mediaModalState.selectedMediaMultiple.splice(existingIndex, 1);
        } else {
            // Add to selection
            mediaModalState.selectedMediaMultiple.push({
                id: mediaId,
                path: mediaPath,
                url: mediaUrl
            });
        }
        // Clear single selection when in multiple mode
        mediaModalState.selectedMedia = null;
    } else {
        // Single selection mode - replace previous selection
        mediaModalState.selectedMedia = {
            id: mediaId,
            path: mediaPath,
            url: mediaUrl
        };
        mediaModalState.selectedMediaMultiple = [];
    }
    
    // Update grid to show selection
    document.querySelectorAll('.media-grid-item').forEach(item => {
        const itemId = parseInt(item.getAttribute('data-media-id'));
        const isSelected = mediaModalState.allowMultiple
            ? mediaModalState.selectedMediaMultiple.some(m => parseInt(m.id) === itemId)
            : (mediaModalState.selectedMedia && parseInt(mediaModalState.selectedMedia.id) === itemId);
        
        if (isSelected) {
            item.style.borderColor = '#0073aa';
            item.style.borderWidth = '3px';
            // Add or update checkmark
            let checkmark = item.querySelector('.media-selection-checkmark');
            if (!checkmark) {
                checkmark = document.createElement('div');
                checkmark.className = 'media-selection-checkmark';
                checkmark.style.cssText = 'position: absolute; top: 5px; right: 5px; background: #0073aa; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 14px; z-index: 10;';
                checkmark.innerHTML = '<i class="fas fa-check"></i>';
                const imgContainer = item.querySelector('div[style*="position: relative"]');
                if (imgContainer) {
                    imgContainer.appendChild(checkmark);
                } else {
                    // Fallback: append to item itself
                    item.style.position = 'relative';
                    item.appendChild(checkmark);
                }
            }
        } else {
            item.style.borderColor = '#ddd';
            item.style.borderWidth = '2px';
            const checkmark = item.querySelector('.media-selection-checkmark');
            if (checkmark) checkmark.remove();
        }
    });
    
    // Always update the button and counter
    updateInsertButton();
}

/**
 * Update insert button visibility
 */
function updateInsertButton() {
    const insertBtn = document.getElementById('insertMediaBtn');
    const selectedCount = document.getElementById('selectedCount');
    const selectedCountText = document.getElementById('selectedCountText');
    const insertCount = document.getElementById('insertCount');
    
    const hasSelection = mediaModalState.allowMultiple
        ? mediaModalState.selectedMediaMultiple.length > 0
        : mediaModalState.selectedMedia !== null;
    
    const selectionCount = mediaModalState.allowMultiple
        ? mediaModalState.selectedMediaMultiple.length
        : (mediaModalState.selectedMedia ? 1 : 0);
    
    if (insertBtn) {
        if (hasSelection) {
            insertBtn.style.display = 'inline-block';
            if (insertCount) {
                insertCount.textContent = selectionCount;
            }
        } else {
            insertBtn.style.display = 'none';
        }
    }
    
    if (selectedCount && selectedCountText) {
        if (mediaModalState.allowMultiple && selectionCount > 0) {
            selectedCount.style.display = 'block';
            selectedCountText.textContent = selectionCount;
        } else {
            selectedCount.style.display = 'none';
        }
    }
}

/**
 * Insert selected media
 */
function insertSelectedMedia() {
    const selected = mediaModalState.allowMultiple 
        ? mediaModalState.selectedMediaMultiple 
        : (mediaModalState.selectedMedia ? [mediaModalState.selectedMedia] : []);
    
    if (selected.length === 0) return;
    
    // Allow override by checking window hook first
    if (window.insertSelectedMediaOverride && typeof window.insertSelectedMediaOverride === 'function') {
        const overrideResult = window.insertSelectedMediaOverride();
        // If override returns true, it handled everything, so return early
        if (overrideResult === true) {
            return;
        }
        // If override returns false or undefined, continue with default behavior
    }
    
    // For single selection, use first item
    const firstSelected = selected[0];
    
    // Update hidden input
    const targetInput = document.getElementById(mediaModalState.targetInputId);
    if (targetInput) {
        if (mediaModalState.allowMultiple && selected.length > 1) {
            // Store as JSON array for multiple
            targetInput.value = JSON.stringify(selected.map(s => s.path));
        } else {
            targetInput.value = firstSelected.path;
        }
    }
    
    // Update preview
    if (mediaModalState.targetPreviewId) {
        const previewContainer = document.getElementById(mediaModalState.targetPreviewId);
        if (previewContainer) {
            previewContainer.style.display = 'block';
            
            if (mediaModalState.allowMultiple && selected.length > 1) {
                // Show multiple previews
                previewContainer.innerHTML = '';
                selected.forEach((item, index) => {
                    const previewImg = document.createElement('img');
                    previewImg.style.cssText = 'max-width: 120px; max-height: 120px; border-radius: 4px; display: inline-block; margin: 5px; object-fit: cover;';
                    previewImg.src = item.url;
                    previewImg.alt = 'Selected image ' + (index + 1);
                    previewContainer.appendChild(previewImg);
                });
            } else {
                // Single preview
                let previewImg = previewContainer.querySelector('img');
                if (!previewImg) {
                    previewImg = document.createElement('img');
                    previewImg.style.cssText = 'max-width: 100%; max-height: 300px; border-radius: 4px; display: block;';
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(previewImg);
                }
                previewImg.src = firstSelected.url;
                previewImg.alt = 'Selected image';
            }
        }
    }
    
    closeMediaModal();
    if (typeof showToast === 'function') {
        const message = selected.length > 1 
            ? `${selected.length} images selected successfully`
            : 'Image selected successfully';
        showToast(message, 'success');
    }
}

/**
 * Handle file select for upload (multiple files)
 */
function handleMediaFileSelect(event) {
    const files = Array.from(event.target.files || []);
    if (files.length === 0) return;
    
    // Validate file types
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    const validFiles = files.filter(file => {
        return allowedTypes.includes(file.type.toLowerCase());
    });
    
    if (validFiles.length === 0) {
        if (typeof showToast === 'function') {
            showToast('Please select JPEG, PNG, or WebP images only', 'error');
        }
        event.target.value = '';
        return;
    }
    
    if (validFiles.length < files.length) {
        if (typeof showToast === 'function') {
            showToast(`${files.length - validFiles.length} file(s) were skipped. Only JPEG, PNG, and WebP are allowed.`, 'warning');
        }
    }
    
    const filesInfo = document.getElementById('selectedFilesInfo');
    const uploadPreview = document.getElementById('uploadPreviewArea');
    const previewGrid = document.getElementById('uploadPreviewGrid');
    const submitBtn = document.getElementById('uploadSubmitBtn');
    
    if (filesInfo) {
        filesInfo.textContent = `${validFiles.length} file(s) selected`;
        filesInfo.style.display = 'block';
    }
    
    if (previewGrid) {
        previewGrid.innerHTML = '';
        validFiles.forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.style.cssText = 'position: relative; padding-top: 100%; background: #f0f0f0; border-radius: 4px; overflow: hidden;';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;';
                    img.alt = file.name;
                    previewItem.appendChild(img);
                    previewGrid.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            }
        });
        if (uploadPreview) {
            uploadPreview.style.display = 'block';
        }
    }
    
    if (submitBtn) {
        submitBtn.disabled = false;
    }
}

/**
 * Upload new media (multiple files)
 */
function uploadNewMedia() {
    const fileInput = document.getElementById('mediaFileInput');
    const submitBtn = document.getElementById('uploadSubmitBtn');
    
    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
        if (typeof showToast === 'function') {
            showToast('Please select file(s)', 'error');
        }
        return;
    }
    
    const files = Array.from(fileInput.files);
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    const validFiles = files.filter(file => allowedTypes.includes(file.type.toLowerCase()));
    
    if (validFiles.length === 0) {
        if (typeof showToast === 'function') {
            showToast('Please select JPEG, PNG, or WebP images only', 'error');
        }
        return;
    }
    
    const originalText = submitBtn ? submitBtn.textContent : '';
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = `Uploading ${validFiles.length} file(s)...`;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const adminUrl = typeof ADMIN_URL !== 'undefined' ? ADMIN_URL : window.ADMIN_URL || '';
    
    // Upload files sequentially
    let uploadedCount = 0;
    let failedCount = 0;
    const uploadedMedia = [];
    
    function uploadNext(index) {
        if (index >= validFiles.length) {
            // All uploads complete
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
            
            if (uploadedCount > 0) {
                if (typeof showToast === 'function') {
                    const message = failedCount > 0
                        ? `${uploadedCount} file(s) uploaded successfully, ${failedCount} failed`
                        : `${uploadedCount} file(s) uploaded successfully`;
                    showToast(message, failedCount > 0 ? 'warning' : 'success');
                }
                
                // Switch to library tab and reload
                switchMediaTab('library');
                
                // Reset upload form
                document.getElementById('mediaUploadForm').reset();
                document.getElementById('selectedFilesInfo').style.display = 'none';
                document.getElementById('uploadPreviewArea').style.display = 'none';
                
                // If multiple selection is enabled, select all uploaded images
                if (mediaModalState.allowMultiple && uploadedMedia.length > 0) {
                    uploadedMedia.forEach(media => {
                        if (!mediaModalState.selectedMediaMultiple.some(m => m.id === media.id)) {
                            mediaModalState.selectedMediaMultiple.push(media);
                        }
                    });
                    updateInsertButton();
                } else if (uploadedMedia.length > 0) {
                    // Single selection - select first uploaded
                    selectMediaItem(uploadedMedia[0].id, uploadedMedia[0].path, uploadedMedia[0].url);
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast('All uploads failed. Please try again.', 'error');
                }
            }
            return;
        }
        
        const file = validFiles[index];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('csrf_token', csrfToken);
        
        fetch(adminUrl + 'api/media.php', {
            method: 'POST',
            credentials: 'include',
            body: formData
        })
        .then(response => {
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
        })
        .then(data => {
            if (data.success && data.media) {
                uploadedCount++;
                uploadedMedia.push(data.media);
            } else {
                failedCount++;
            }
            uploadNext(index + 1);
        })
        .catch(error => {
            console.error('Upload error for file:', file.name, error);
            failedCount++;
            uploadNext(index + 1);
        });
    }
    
    uploadNext(0);
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

