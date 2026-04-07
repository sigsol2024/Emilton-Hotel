<?php
/**
 * Homepage Editor
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
                <textarea id="hero_title" name="hero_title" rows="2"><?= sanitize($sectionsArray['hero_title'] ?? '') ?></textarea>
                <p class="form-help">HTML allowed</p>
            </div>
            
            <div class="form-group">
                <label>Hero Background Images (Up to 5 images for auto-sliding hero)</label>
                <p class="form-help">Multiple images will create an auto-sliding hero with fade transitions and Ken Burns effect</p>
                <?php
                // Get hero background images - handle both old single image and new JSON array format
                $heroBackgroundImages = [];
                if (!empty($sectionsArray['hero_background'])) {
                    $heroBg = $sectionsArray['hero_background'];
                    // Try to decode as JSON first (new format)
                    $decoded = json_decode($heroBg, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $heroBackgroundImages = $decoded;
                    } else {
                        // Old format - single image string
                        $heroBackgroundImages = [$heroBg];
                    }
                }
                // Ensure we have up to 5 slots
                while (count($heroBackgroundImages) < 5) {
                    $heroBackgroundImages[] = '';
                }
                ?>
                <input type="hidden" id="hero_background" name="hero_background" value="<?= htmlspecialchars(json_encode(array_filter($heroBackgroundImages)), ENT_QUOTES, 'UTF-8') ?>">
                <div id="hero_images_container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="hero-image-item" data-index="<?= $i ?>" style="position: relative; border: 1px solid var(--border-color); border-radius: 4px; overflow: hidden; background: white;">
                            <div style="position: relative; padding-top: 100%; background: #f0f0f0;">
                                <?php if (!empty($heroBackgroundImages[$i])): ?>
                                    <img src="<?= SITE_URL . ltrim($heroBackgroundImages[$i], '/') ?>" 
                                         alt="Hero image <?= $i + 1 ?>"
                                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                         onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;\'><i class=\'fas fa-image\' style=\'font-size: 32px; color: var(--text-muted);\'></i></div>';">
                                <?php else: ?>
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: var(--text-muted);">
                                        <i class="fas fa-image" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                                        <span style="font-size: 12px;">Image <?= $i + 1 ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div style="padding: 10px;">
                                <button type="button" class="btn btn-sm btn-primary" style="width: 100%; margin-bottom: 5px;" onclick="selectHeroImage(<?= $i ?>)">
                                    <i class="fas fa-image"></i> <?= !empty($heroBackgroundImages[$i]) ? 'Change' : 'Select' ?>
                                </button>
                                <?php if (!empty($heroBackgroundImages[$i])): ?>
                                    <button type="button" class="btn btn-sm btn-danger" style="width: 100%;" onclick="removeHeroImage(<?= $i ?>)">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="hero_cta_text">CTA Button Text</label>
                    <input type="text" id="hero_cta_text" name="hero_cta_text" value="<?= sanitize($sectionsArray['hero_cta_text'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="hero_cta_link">CTA Button Link</label>
                    <input type="text" id="hero_cta_link" name="hero_cta_link" value="<?= sanitize($sectionsArray['hero_cta_link'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Widget (Bridge) -->
    <div class="card">
        <div class="card-header">
            <h2>Booking Widget (Bridge)</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="booking_widget_html">Widget HTML</label>
                <textarea id="booking_widget_html" name="booking_widget_html" rows="8" style="font-family: monospace; font-size: 12px;"><?= htmlspecialchars($sectionsArray['booking_widget_html'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                <p class="form-help">Paste the widget's required HTML here. It will render between the hero and the next section (inside the booking bridge).</p>
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
                <label for="about_title">About Title</label>
                <textarea id="about_title" name="about_title" rows="2"><?= sanitize($sectionsArray['about_title'] ?? '') ?></textarea>
                <p class="form-help">HTML allowed</p>
            </div>
            
            <div class="form-group">
                <label for="about_description">About Description</label>
                <textarea id="about_description" name="about_description" rows="4"><?= sanitize($sectionsArray['about_description'] ?? '') ?></textarea>
                <p class="form-help">HTML allowed</p>
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
                    <?php if (!empty($sectionsArray['about_image'])): ?>
                        <img id="about_img_img" src="<?= SITE_URL . ltrim($sectionsArray['about_image'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Select an image from the media library or upload a new one</p>
            </div>
            
            <div class="form-group">
                <label>Flower/Decorative Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('about_flower_image', 'about_flower_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="about_flower_image" name="about_flower_image" value="<?= sanitize($sectionsArray['about_flower_image'] ?? '') ?>">
                <div id="about_flower_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['about_flower_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['about_flower_image'])): ?>
                        <img id="about_flower_img_img" src="<?= SITE_URL . ltrim($sectionsArray['about_flower_image'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Select a PNG or JPG image for the decorative flower shape (default: assets/img/flower.svg)</p>
            </div>
        </div>
    </div>
    
    <!-- Rooms Section -->
    <div class="card">
        <div class="card-header">
            <h2>Rooms Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="featured_rooms_title">Featured Rooms Title</label>
                <textarea id="featured_rooms_title" name="featured_rooms_title" rows="2"><?= sanitize($sectionsArray['featured_rooms_title'] ?? '') ?></textarea>
            </div>
            
            <hr style="margin: 20px 0; border-color: var(--border-color);">
            <h3 style="margin-bottom: 15px; font-size: 18px;">Three Feature Boxes (Below Featured Rooms Title)</h3>
            
            <!-- Feature Box 1 -->
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Feature Box 1</h4>
                <div class="form-group">
                    <label>Box 1 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('feature_box_1_image', 'feature_box_1_image_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="feature_box_1_image" name="feature_box_1_image" value="<?= sanitize($sectionsArray['feature_box_1_image'] ?? '') ?>">
                    <div id="feature_box_1_image_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['feature_box_1_image']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['feature_box_1_image'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['feature_box_1_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="feature_box_1_title">Box 1 Title</label>
                    <input type="text" id="feature_box_1_title" name="feature_box_1_title" value="<?= sanitize($sectionsArray['feature_box_1_title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="feature_box_1_description">Box 1 Description</label>
                    <textarea id="feature_box_1_description" name="feature_box_1_description" rows="3"><?= sanitize($sectionsArray['feature_box_1_description'] ?? '') ?></textarea>
                    <p class="form-help">HTML allowed</p>
                </div>
            </div>
            
            <!-- Feature Box 2 -->
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Feature Box 2</h4>
                <div class="form-group">
                    <label>Box 2 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('feature_box_2_image', 'feature_box_2_image_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="feature_box_2_image" name="feature_box_2_image" value="<?= sanitize($sectionsArray['feature_box_2_image'] ?? '') ?>">
                    <div id="feature_box_2_image_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['feature_box_2_image']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['feature_box_2_image'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['feature_box_2_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="feature_box_2_title">Box 2 Title</label>
                    <input type="text" id="feature_box_2_title" name="feature_box_2_title" value="<?= sanitize($sectionsArray['feature_box_2_title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="feature_box_2_description">Box 2 Description</label>
                    <textarea id="feature_box_2_description" name="feature_box_2_description" rows="3"><?= sanitize($sectionsArray['feature_box_2_description'] ?? '') ?></textarea>
                    <p class="form-help">HTML allowed</p>
                </div>
            </div>
            
            <!-- Feature Box 3 -->
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Feature Box 3</h4>
                <div class="form-group">
                    <label>Box 3 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('feature_box_3_image', 'feature_box_3_image_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="feature_box_3_image" name="feature_box_3_image" value="<?= sanitize($sectionsArray['feature_box_3_image'] ?? '') ?>">
                    <div id="feature_box_3_image_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['feature_box_3_image']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['feature_box_3_image'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['feature_box_3_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="feature_box_3_title">Box 3 Title</label>
                    <input type="text" id="feature_box_3_title" name="feature_box_3_title" value="<?= sanitize($sectionsArray['feature_box_3_title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="feature_box_3_description">Box 3 Description</label>
                    <textarea id="feature_box_3_description" name="feature_box_3_description" rows="3"><?= sanitize($sectionsArray['feature_box_3_description'] ?? '') ?></textarea>
                    <p class="form-help">HTML allowed</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="rooms_section_subtitle">Rooms Section Subtitle</label>
                <input type="text" id="rooms_section_subtitle" name="rooms_section_subtitle" value="<?= sanitize($sectionsArray['rooms_section_subtitle'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="rooms_section_title">Rooms Section Title</label>
                <input type="text" id="rooms_section_title" name="rooms_section_title" value="<?= sanitize($sectionsArray['rooms_section_title'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="rooms_section_description">Rooms Section Description</label>
                <textarea id="rooms_section_description" name="rooms_section_description" rows="3"><?= sanitize($sectionsArray['rooms_section_description'] ?? '') ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Why Choose Us Section -->
    <div class="card">
        <div class="card-header">
            <h2>Why Choose Us Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="why_choose_title">Title</label>
                <input type="text" id="why_choose_title" name="why_choose_title" value="<?= sanitize($sectionsArray['why_choose_title'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="why_choose_description">Description</label>
                <textarea id="why_choose_description" name="why_choose_description" rows="3"><?= sanitize($sectionsArray['why_choose_description'] ?? '') ?></textarea>
                <p class="form-help">HTML allowed</p>
            </div>
            
            <hr style="margin: 20px 0; border-color: var(--border-color);">
            <h3 style="margin-bottom: 15px; font-size: 18px;">Why Choose Us Images</h3>
            
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Feature 1</h4>
                <div class="form-group">
                    <label for="why_choose_title_1">Feature 1 Title</label>
                    <input type="text" id="why_choose_title_1" name="why_choose_title_1" value="<?= sanitize($sectionsArray['why_choose_title_1'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Feature 1 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('why_choose_image_1', 'why_choose_image_1_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="why_choose_image_1" name="why_choose_image_1" value="<?= sanitize($sectionsArray['why_choose_image_1'] ?? '') ?>">
                    <div id="why_choose_image_1_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['why_choose_image_1']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['why_choose_image_1'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['why_choose_image_1'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                    <p class="form-help">Select an image from the media library or upload a new one</p>
                </div>
            </div>
            
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Feature 2</h4>
                <div class="form-group">
                    <label for="why_choose_title_2">Feature 2 Title</label>
                    <input type="text" id="why_choose_title_2" name="why_choose_title_2" value="<?= sanitize($sectionsArray['why_choose_title_2'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Feature 2 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('why_choose_image_2', 'why_choose_image_2_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="why_choose_image_2" name="why_choose_image_2" value="<?= sanitize($sectionsArray['why_choose_image_2'] ?? '') ?>">
                    <div id="why_choose_image_2_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['why_choose_image_2']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['why_choose_image_2'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['why_choose_image_2'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                    <p class="form-help">Select an image from the media library or upload a new one</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Awards Section -->
    <div class="card">
        <div class="card-header">
            <h2>Awards Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="awards_subtitle">Subtitle</label>
                <input type="text" id="awards_subtitle" name="awards_subtitle" value="<?= sanitize($sectionsArray['awards_subtitle'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="awards_title">Title</label>
                <input type="text" id="awards_title" name="awards_title" value="<?= sanitize($sectionsArray['awards_title'] ?? '') ?>">
            </div>
            
            <hr style="margin: 20px 0; border-color: var(--border-color);">
            <h3 style="margin-bottom: 15px; font-size: 18px;">Award Items</h3>
            
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Award 1</h4>
                <div class="form-group">
                    <label for="award_title_1">Award 1 Title</label>
                    <input type="text" id="award_title_1" name="award_title_1" value="<?= sanitize($sectionsArray['award_title_1'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Award 1 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('award_image_1', 'award_image_1_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="award_image_1" name="award_image_1" value="<?= sanitize($sectionsArray['award_image_1'] ?? '') ?>">
                    <div id="award_image_1_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['award_image_1']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['award_image_1'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['award_image_1'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                    <p class="form-help">Select an image from the media library or upload a new one</p>
                </div>
            </div>
            
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Award 2</h4>
                <div class="form-group">
                    <label for="award_title_2">Award 2 Title</label>
                    <input type="text" id="award_title_2" name="award_title_2" value="<?= sanitize($sectionsArray['award_title_2'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Award 2 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('award_image_2', 'award_image_2_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="award_image_2" name="award_image_2" value="<?= sanitize($sectionsArray['award_image_2'] ?? '') ?>">
                    <div id="award_image_2_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['award_image_2']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['award_image_2'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['award_image_2'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                    <p class="form-help">Select an image from the media library or upload a new one</p>
                </div>
            </div>
            
            <div style="border: 1px solid var(--border-color); border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 15px; font-size: 16px;">Award 3</h4>
                <div class="form-group">
                    <label for="award_title_3">Award 3 Title</label>
                    <input type="text" id="award_title_3" name="award_title_3" value="<?= sanitize($sectionsArray['award_title_3'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Award 3 Image</label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-outline" onclick="openMediaModal('award_image_3', 'award_image_3_preview')">
                            <i class="fas fa-image"></i> Select Image
                        </button>
                    </div>
                    <input type="hidden" id="award_image_3" name="award_image_3" value="<?= sanitize($sectionsArray['award_image_3'] ?? '') ?>">
                    <div id="award_image_3_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['award_image_3']) ? 'display: block;' : 'display: none;' ?>">
                        <?php if (!empty($sectionsArray['award_image_3'])): ?>
                            <img src="<?= SITE_URL . ltrim($sectionsArray['award_image_3'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                        <?php endif; ?>
                    </div>
                    <p class="form-help">Select an image from the media library or upload a new one</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Booking CTA Section -->
    <div class="card">
        <div class="card-header">
            <h2>Booking CTA Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="booking_cta_title">Title</label>
                <input type="text" id="booking_cta_title" name="booking_cta_title" value="<?= sanitize($sectionsArray['booking_cta_title'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="booking_cta_description">Description</label>
                <textarea id="booking_cta_description" name="booking_cta_description" rows="2"><?= sanitize($sectionsArray['booking_cta_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Booking CTA Background Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('booking_cta_background', 'booking_cta_bg_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="booking_cta_background" name="booking_cta_background" value="<?= sanitize($sectionsArray['booking_cta_background'] ?? '') ?>">
                <div id="booking_cta_bg_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['booking_cta_background']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['booking_cta_background'])): ?>
                        <img id="booking_cta_bg_img" src="<?= SITE_URL . ltrim($sectionsArray['booking_cta_background'], '/') ?>" style="max-width: 500px; max-height: 300px;">
                    <?php else: ?>
                        <img id="booking_cta_bg_img" src="" style="max-width: 500px; max-height: 300px;">
                    <?php endif; ?>
                </div>
                <p class="form-help">Select an image from the media library or upload a new one</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Homepage Content</button>
    </div>
</form>

<script>
// Hero images array - ensure we always have 5 slots
let heroImagesArray = <?= json_encode($heroBackgroundImages) ?>;
let heroImages = [];
for (let i = 0; i < 5; i++) {
    heroImages[i] = heroImagesArray[i] || '';
}
let currentHeroImageIndex = null;

// Select hero image
function selectHeroImage(index) {
    currentHeroImageIndex = index;
    openMediaModal('hero_image_' + index, 'hero_image_preview_' + index);
}

// Remove hero image
function removeHeroImage(index) {
    heroImages[index] = '';
    updateHeroImagesDisplay();
    updateHeroImagesInput();
}

// Update hero images display
function updateHeroImagesDisplay() {
    for (let i = 0; i < 5; i++) {
        const item = document.querySelector(`.hero-image-item[data-index="${i}"]`);
        if (!item) continue;
        
        const imgContainer = item.querySelector('div[style*="padding-top: 100%"]');
        const buttonsContainer = item.querySelector('div[style*="padding: 10px"]');
        
        if (heroImages[i]) {
            imgContainer.innerHTML = `<img src="<?= SITE_URL ?>${heroImages[i].replace(/^\//, '')}" alt="Hero image ${i + 1}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;\'><i class=\'fas fa-image\' style=\'font-size: 32px; color: var(--text-muted);\'></i></div>';">`;
            buttonsContainer.innerHTML = `
                <button type="button" class="btn btn-sm btn-primary" style="width: 100%; margin-bottom: 5px;" onclick="selectHeroImage(${i})">
                    <i class="fas fa-image"></i> Change
                </button>
                <button type="button" class="btn btn-sm btn-danger" style="width: 100%;" onclick="removeHeroImage(${i})">
                    <i class="fas fa-trash"></i> Remove
                </button>
            `;
        } else {
            imgContainer.innerHTML = `
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: var(--text-muted);">
                    <i class="fas fa-image" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
                    <span style="font-size: 12px;">Image ${i + 1}</span>
                </div>
            `;
            buttonsContainer.innerHTML = `
                <button type="button" class="btn btn-sm btn-primary" style="width: 100%;" onclick="selectHeroImage(${i})">
                    <i class="fas fa-image"></i> Select
                </button>
            `;
        }
    }
}

// Update hero images hidden input
function updateHeroImagesInput() {
    const filtered = heroImages.filter(img => img);
    const input = document.getElementById('hero_background');
    if (input) {
        input.value = JSON.stringify(filtered);
    }
}

// Handle media modal selection
window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const targetInputId = mediaModalState.targetInputId;
    
    // Handle hero background images (multiple)
    if (targetInputId && targetInputId.startsWith('hero_image_')) {
        const index = parseInt(targetInputId.replace('hero_image_', ''));
        if (!isNaN(index) && index >= 0 && index < 5) {
            heroImages[index] = selected.path;
            updateHeroImagesDisplay();
            updateHeroImagesInput();
            closeMediaModal();
            if (typeof showToast === 'function') {
                showToast('Image selected', 'success');
            }
            return true;
        }
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
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="about_img_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle about flower image
    if (targetInputId === 'about_flower_image') {
        const input = document.getElementById('about_flower_image');
        const preview = document.getElementById('about_flower_img_preview');
        const previewImg = document.getElementById('about_flower_img_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="about_flower_img_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle feature box images
    if (targetInputId === 'feature_box_1_image' || targetInputId === 'feature_box_2_image' || targetInputId === 'feature_box_3_image') {
        const input = document.getElementById(targetInputId);
        const preview = document.getElementById(targetInputId + '_preview');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            const existingImg = preview.querySelector('img');
            if (existingImg) {
                existingImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 300px; max-height: 200px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle why choose images
    if (targetInputId === 'why_choose_image_1' || targetInputId === 'why_choose_image_2') {
        const input = document.getElementById(targetInputId);
        const preview = document.getElementById(targetInputId + '_preview');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            const existingImg = preview.querySelector('img');
            if (existingImg) {
                existingImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 300px; max-height: 200px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle award images
    if (targetInputId === 'award_image_1' || targetInputId === 'award_image_2' || targetInputId === 'award_image_3') {
        const input = document.getElementById(targetInputId);
        const preview = document.getElementById(targetInputId + '_preview');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            const existingImg = preview.querySelector('img');
            if (existingImg) {
                existingImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 300px; max-height: 200px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Handle booking CTA background
    if (targetInputId === 'booking_cta_background') {
        const input = document.getElementById('booking_cta_background');
        const preview = document.getElementById('booking_cta_bg_preview');
        const previewImg = document.getElementById('booking_cta_bg_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="booking_cta_bg_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
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

// Media modal integration - the openMediaModal function is provided by media-library.js

document.getElementById('homepageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all section data
    const sectionKeys = [
        'hero_title', 'hero_background', 'hero_cta_text', 'hero_cta_link',
        'booking_widget_html',
        'about_title', 'about_description', 'about_image', 'about_flower_image',
        'featured_rooms_title', 'feature_box_1_image', 'feature_box_1_title', 'feature_box_1_description',
        'feature_box_2_image', 'feature_box_2_title', 'feature_box_2_description',
        'feature_box_3_image', 'feature_box_3_title', 'feature_box_3_description',
        'rooms_section_subtitle', 'rooms_section_title', 'rooms_section_description',
        'why_choose_title', 'why_choose_description', 'why_choose_title_1', 'why_choose_image_1', 'why_choose_title_2', 'why_choose_image_2',
        'awards_subtitle', 'awards_title', 'award_title_1', 'award_image_1', 'award_title_2', 'award_image_2', 'award_title_3', 'award_image_3',
        'booking_cta_title', 'booking_cta_description', 'booking_cta_background'
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
    
    // Update hero_background to JSON array before saving
    if (sections['hero_background']) {
        try {
            // If it's already a JSON string, parse and re-encode to ensure clean format
            const parsed = JSON.parse(sections['hero_background']);
            sections['hero_background'] = JSON.stringify(parsed.filter(img => img));
        } catch (e) {
            // If it's not valid JSON, wrap in array
            if (sections['hero_background']) {
                sections['hero_background'] = JSON.stringify([sections['hero_background']]);
            }
        }
    }
    
    // Update each section
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
                content_type: key === 'hero_background' ? 'json' : (key.includes('image') || key.includes('background') ? 'image' : 'html'),
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

