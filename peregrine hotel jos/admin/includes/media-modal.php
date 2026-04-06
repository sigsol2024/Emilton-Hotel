<?php
/**
 * Media Library Modal
 * Reusable modal for selecting/uploading images
 * This file is included in footer.php and available on all admin pages
 */
?>

<!-- Media Library Modal -->
<div id="mediaLibraryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.85); z-index: 10000; overflow-y: auto;">
    <div class="media-modal-container" style="background: white; margin: 20px auto; max-width: 1200px; min-height: calc(100vh - 40px); border-radius: 8px; display: flex; flex-direction: column;">
        <!-- Modal Header -->
        <div class="media-modal-header" style="padding: 20px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 600;">Select or Upload Media</h2>
            <button type="button" id="closeMediaModal" style="background: none; border: none; font-size: 28px; cursor: pointer; color: #666; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 4px;" 
                    onmouseover="this.style.backgroundColor='#f0f0f0'" 
                    onmouseout="this.style.backgroundColor='transparent'">&times;</button>
        </div>
        
        <!-- Modal Tabs -->
        <div class="media-modal-tabs" style="border-bottom: 1px solid #ddd; padding: 0 20px; flex-shrink: 0;">
            <button type="button" class="media-tab active" data-tab="library" style="background: none; border: none; padding: 15px 20px; cursor: pointer; font-size: 14px; font-weight: 500; color: #666; border-bottom: 2px solid transparent; margin-bottom: -1px;">
                Media Library
            </button>
            <button type="button" class="media-tab" data-tab="upload" style="background: none; border: none; padding: 15px 20px; cursor: pointer; font-size: 14px; font-weight: 500; color: #666; border-bottom: 2px solid transparent; margin-bottom: -1px;">
                Upload New
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="media-modal-body" style="flex: 1; padding: 20px; overflow-y: auto;">
            <!-- Media Library Tab Content -->
            <div id="mediaLibraryTab" class="media-tab-content active">
                <!-- Search Bar -->
                <div style="margin-bottom: 20px;">
                    <input type="text" id="mediaSearchInput" placeholder="Search media..." 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                </div>
                
                <!-- Media Grid -->
                <div id="mediaGridContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; min-height: 200px;">
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 32px; margin-bottom: 10px;"></i>
                        <p>Loading media...</p>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div id="mediaPagination" style="margin-top: 20px; display: none; justify-content: center; gap: 10px;">
                    <!-- Pagination buttons will be inserted here by JavaScript -->
                </div>
            </div>
            
            <!-- Upload Tab Content -->
            <div id="mediaUploadTab" class="media-tab-content" style="display: none;">
                <form id="mediaUploadForm" enctype="multipart/form-data" style="max-width: 500px; margin: 0 auto;">
                    <div style="border: 2px dashed #ddd; border-radius: 8px; padding: 40px; text-align: center; margin-bottom: 20px; background: #fafafa;">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #999; margin-bottom: 15px;"></i>
                        <p style="margin: 0 0 15px 0; color: #666;">Drag and drop images here, or</p>
                        <label for="mediaFileInput" style="display: inline-block; padding: 10px 20px; background: #0073aa; color: white; border-radius: 4px; cursor: pointer; font-weight: 500;">
                            Select Files
                        </label>
                        <input type="file" id="mediaFileInput" name="files[]" accept="image/jpeg,image/jpg,image/png,image/webp" multiple required 
                               style="display: none;" onchange="handleMediaFileSelect(event)">
                        <p id="selectedFilesInfo" style="margin: 15px 0 0 0; color: #333; font-weight: 500; display: none;"></p>
                        <p style="margin: 10px 0 0 0; color: #999; font-size: 12px;">Supported formats: JPEG, PNG, WebP</p>
                    </div>
                    
                    <div id="uploadPreviewArea" style="display: none; margin-bottom: 20px;">
                        <div id="uploadPreviewGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; max-height: 400px; overflow-y: auto;"></div>
                    </div>
                    
                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" onclick="switchMediaTab('library')" class="btn btn-outline">Cancel</button>
                        <button type="submit" id="uploadSubmitBtn" class="btn btn-primary" disabled>Upload</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="media-modal-footer" style="padding: 20px; border-top: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
            <div id="selectedCount" style="color: #666; font-size: 14px; display: none;">
                <span id="selectedCountText">0</span> selected
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="button" id="cancelMediaSelection" class="btn btn-outline">Cancel</button>
                <button type="button" id="insertMediaBtn" class="btn btn-primary" style="display: none;">Insert Selected (<span id="insertCount">0</span>)</button>
            </div>
        </div>
    </div>
</div>

