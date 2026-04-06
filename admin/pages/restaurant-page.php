<?php
/**
 * Restaurant Page Editor
 */

$pageTitle = 'Restaurant Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all restaurant page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'restaurant' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Restaurant page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

// Dining Experience section uses simple keys (dining_title, dining_card_1_title, etc.)

$csrfToken = generateCSRFToken();
?>

<form id="restaurantPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Hero Section -->
    <div class="card">
        <div class="card-header">
            <h2>Hero Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="hero_subtitle">Hero Subtitle</label>
                <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?= sanitize($sectionsArray['hero_subtitle'] ?? 'Est. 1924') ?>">
                <p class="form-help">Small text above main title (e.g., "Est. 1924")</p>
            </div>
            
            <div class="form-group">
                <label for="hero_title">Hero Title</label>
                <input type="text" id="hero_title" name="hero_title" value="<?= sanitize($sectionsArray['hero_title'] ?? 'A Culinary Sanctuary') ?>">
            </div>
            
            <div class="form-group">
                <label for="hero_description">Hero Description</label>
                <textarea id="hero_description" name="hero_description" rows="3"><?= sanitize($sectionsArray['hero_description'] ?? 'Experience the pinnacle of fine dining in the heart of the city, where tradition meets modern innovation.') ?></textarea>
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
            
            <div class="form-group">
                <label for="hero_button_text">Hero Button Text</label>
                <input type="text" id="hero_button_text" name="hero_button_text" value="<?= sanitize($sectionsArray['hero_button_text'] ?? 'Reserve Your Table') ?>">
            </div>
        </div>
    </div>
    
    <!-- Philosophy Section -->
    <div class="card">
        <div class="card-header">
            <h2>Philosophy Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="philosophy_subtitle">Subtitle</label>
                <input type="text" id="philosophy_subtitle" name="philosophy_subtitle" value="<?= sanitize($sectionsArray['philosophy_subtitle'] ?? 'Our Vision') ?>">
            </div>
            
            <div class="form-group">
                <label for="philosophy_title">Title</label>
                <input type="text" id="philosophy_title" name="philosophy_title" value="<?= sanitize($sectionsArray['philosophy_title'] ?? 'The Philosophy of Taste') ?>">
            </div>
            
            <div class="form-group">
                <label for="philosophy_description">Description</label>
                <textarea id="philosophy_description" name="philosophy_description" rows="4"><?= sanitize($sectionsArray['philosophy_description'] ?? 'Our culinary vision is rooted in a deep respect for nature\'s bounty. We source the finest seasonal ingredients to craft dishes that are both visually stunning and exquisitely flavored, served in an ambiance of understated elegance.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="philosophy_quote">Quote</label>
                <textarea id="philosophy_quote" name="philosophy_quote" rows="2"><?= sanitize($sectionsArray['philosophy_quote'] ?? '"Food is not just sustenance, it is an emotional journey that connects us to the earth and to each other."') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="philosophy_quote_author">Quote Author</label>
                <input type="text" id="philosophy_quote_author" name="philosophy_quote_author" value="<?= sanitize($sectionsArray['philosophy_quote_author'] ?? '— Chef Henri Dubois') ?>">
            </div>
            
            <div class="form-group">
                <label for="philosophy_button_text">Button Text</label>
                <input type="text" id="philosophy_button_text" name="philosophy_button_text" value="<?= sanitize($sectionsArray['philosophy_button_text'] ?? 'Read Our Story') ?>">
            </div>
            
            <div class="form-group">
                <label>Philosophy Image 1</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('philosophy_image_1', 'philosophy_img_1_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="philosophy_image_1" name="philosophy_image_1" value="<?= sanitize($sectionsArray['philosophy_image_1'] ?? '') ?>">
                <div id="philosophy_img_1_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['philosophy_image_1']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['philosophy_image_1'])): ?>
                        <img id="philosophy_img_1_img" src="<?= SITE_URL . ltrim($sectionsArray['philosophy_image_1'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>Philosophy Image 2</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('philosophy_image_2', 'philosophy_img_2_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="philosophy_image_2" name="philosophy_image_2" value="<?= sanitize($sectionsArray['philosophy_image_2'] ?? '') ?>">
                <div id="philosophy_img_2_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['philosophy_image_2']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['philosophy_image_2'])): ?>
                        <img id="philosophy_img_2_img" src="<?= SITE_URL . ltrim($sectionsArray['philosophy_image_2'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="card">
        <div class="card-header">
            <h2>Features Section (3 Cards)</h2>
        </div>
        <div style="padding: 20px;">
            <h3 style="margin-bottom: 20px; font-size: 18px;">Feature 1</h3>
            <div class="form-group">
                <label for="feature_1_icon">Icon Name (Material Symbols)</label>
                <input type="text" id="feature_1_icon" name="feature_1_icon" value="<?= sanitize($sectionsArray['feature_1_icon'] ?? 'eco') ?>" placeholder="e.g., eco, palette, room_service">
                <p class="form-help">Material Symbols icon name (see <a href="https://fonts.google.com/icons" target="_blank">Material Symbols</a>)</p>
            </div>
            <div class="form-group">
                <label for="feature_1_title">Title</label>
                <input type="text" id="feature_1_title" name="feature_1_title" value="<?= sanitize($sectionsArray['feature_1_title'] ?? 'Sustainable Sourcing') ?>">
            </div>
            <div class="form-group">
                <label for="feature_1_description">Description</label>
                <textarea id="feature_1_description" name="feature_1_description" rows="2"><?= sanitize($sectionsArray['feature_1_description'] ?? 'We partner exclusively with local artisan farms to ensure absolute freshness and minimize our carbon footprint.') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Feature 2</h3>
            <div class="form-group">
                <label for="feature_2_icon">Icon Name</label>
                <input type="text" id="feature_2_icon" name="feature_2_icon" value="<?= sanitize($sectionsArray['feature_2_icon'] ?? 'palette') ?>">
            </div>
            <div class="form-group">
                <label for="feature_2_title">Title</label>
                <input type="text" id="feature_2_title" name="feature_2_title" value="<?= sanitize($sectionsArray['feature_2_title'] ?? 'Artful Plating') ?>">
            </div>
            <div class="form-group">
                <label for="feature_2_description">Description</label>
                <textarea id="feature_2_description" name="feature_2_description" rows="2"><?= sanitize($sectionsArray['feature_2_description'] ?? 'Every dish is conceived as a masterpiece of design, balancing color, texture, and negative space.') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Feature 3</h3>
            <div class="form-group">
                <label for="feature_3_icon">Icon Name</label>
                <input type="text" id="feature_3_icon" name="feature_3_icon" value="<?= sanitize($sectionsArray['feature_3_icon'] ?? 'room_service') ?>">
            </div>
            <div class="form-group">
                <label for="feature_3_title">Title</label>
                <input type="text" id="feature_3_title" name="feature_3_title" value="<?= sanitize($sectionsArray['feature_3_title'] ?? 'Impeccable Service') ?>">
            </div>
            <div class="form-group">
                <label for="feature_3_description">Description</label>
                <textarea id="feature_3_description" name="feature_3_description" rows="2"><?= sanitize($sectionsArray['feature_3_description'] ?? 'Our service is attentive yet discreet, personalized to anticipate your every need before you ask.') ?></textarea>
            </div>
        </div>
    </div>
    
    <!-- Dining Experience Section (3 Cards) -->
    <div class="card">
        <div class="card-header">
            <h2>Dining Experience Section (3 Cards)</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="dining_title">Section Title</label>
                <input type="text" id="dining_title" name="dining_title" value="<?= sanitize($sectionsArray['dining_title'] ?? 'A Refined Dining Experience at Emilton Restaurant') ?>">
            </div>
            
            <div class="form-group">
                <label for="dining_intro">Intro (Short)</label>
                <textarea id="dining_intro" name="dining_intro" rows="2"><?= sanitize($sectionsArray['dining_intro'] ?? 'Discover a dining space where exceptional cuisine, elegant surroundings, and thoughtful design come together to create unforgettable moments.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="dining_description">Description (Long)</label>
                <textarea id="dining_description" name="dining_description" rows="3"><?= sanitize($sectionsArray['dining_description'] ?? 'At Emilton Restaurant, dining is more than a meal—it is an experience. From carefully crafted dishes to a warm and sophisticated atmosphere, every detail is designed to delight the senses and elevate your stay.') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 1 — Food Experience</h3>
            <div class="form-group">
                <label>Card 1 Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('dining_card_1_image', 'dining_card_1_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="dining_card_1_image" name="dining_card_1_image" value="<?= sanitize($sectionsArray['dining_card_1_image'] ?? '') ?>">
                <div id="dining_card_1_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['dining_card_1_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['dining_card_1_image'])): ?>
                        <img id="dining_card_1_img" src="<?= SITE_URL . ltrim($sectionsArray['dining_card_1_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="dining_card_1_icon">Icon Name (Material Symbols)</label>
                <input type="text" id="dining_card_1_icon" name="dining_card_1_icon" value="<?= sanitize($sectionsArray['dining_card_1_icon'] ?? 'restaurant') ?>" placeholder="e.g., restaurant">
                <p class="form-help">Material Symbols icon name (see <a href="https://fonts.google.com/icons" target="_blank">Material Symbols</a>)</p>
            </div>
            <div class="form-group">
                <label for="dining_card_1_title">Title</label>
                <input type="text" id="dining_card_1_title" name="dining_card_1_title" value="<?= sanitize($sectionsArray['dining_card_1_title'] ?? 'Exquisite Culinary Creations') ?>">
            </div>
            <div class="form-group">
                <label for="dining_card_1_description">Description</label>
                <textarea id="dining_card_1_description" name="dining_card_1_description" rows="3"><?= sanitize($sectionsArray['dining_card_1_description'] ?? 'Our menu is a celebration of flavor, combining expertly prepared local Nigerian dishes with continental and international cuisine. Every meal is freshly prepared using quality ingredients, delivering rich taste, beautiful presentation, and consistent excellence with every bite.') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 2 — Ambience</h3>
            <div class="form-group">
                <label>Card 2 Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('dining_card_2_image', 'dining_card_2_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="dining_card_2_image" name="dining_card_2_image" value="<?= sanitize($sectionsArray['dining_card_2_image'] ?? '') ?>">
                <div id="dining_card_2_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['dining_card_2_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['dining_card_2_image'])): ?>
                        <img id="dining_card_2_img" src="<?= SITE_URL . ltrim($sectionsArray['dining_card_2_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="dining_card_2_icon">Icon Name</label>
                <input type="text" id="dining_card_2_icon" name="dining_card_2_icon" value="<?= sanitize($sectionsArray['dining_card_2_icon'] ?? 'wb_twilight') ?>">
            </div>
            <div class="form-group">
                <label for="dining_card_2_title">Title</label>
                <input type="text" id="dining_card_2_title" name="dining_card_2_title" value="<?= sanitize($sectionsArray['dining_card_2_title'] ?? 'Warm & Inviting Ambience') ?>">
            </div>
            <div class="form-group">
                <label for="dining_card_2_description">Description</label>
                <textarea id="dining_card_2_description" name="dining_card_2_description" rows="3"><?= sanitize($sectionsArray['dining_card_2_description'] ?? 'The restaurant offers a calm and welcoming atmosphere designed for comfort and relaxation. Soft lighting, tasteful décor, and a serene setting create the perfect environment for breakfast meetings, relaxed lunches, and intimate dinners.') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <h3 style="margin-bottom: 20px; font-size: 18px;">Card 3 — Restaurant Interior</h3>
            <div class="form-group">
                <label>Card 3 Image</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('dining_card_3_image', 'dining_card_3_img_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="dining_card_3_image" name="dining_card_3_image" value="<?= sanitize($sectionsArray['dining_card_3_image'] ?? '') ?>">
                <div id="dining_card_3_img_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['dining_card_3_image']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['dining_card_3_image'])): ?>
                        <img id="dining_card_3_img" src="<?= SITE_URL . ltrim($sectionsArray['dining_card_3_image'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="dining_card_3_icon">Icon Name</label>
                <input type="text" id="dining_card_3_icon" name="dining_card_3_icon" value="<?= sanitize($sectionsArray['dining_card_3_icon'] ?? 'chair') ?>">
            </div>
            <div class="form-group">
                <label for="dining_card_3_title">Title</label>
                <input type="text" id="dining_card_3_title" name="dining_card_3_title" value="<?= sanitize($sectionsArray['dining_card_3_title'] ?? 'Elegant Restaurant Interior') ?>">
            </div>
            <div class="form-group">
                <label for="dining_card_3_description">Description</label>
                <textarea id="dining_card_3_description" name="dining_card_3_description" rows="3"><?= sanitize($sectionsArray['dining_card_3_description'] ?? 'Designed with modern luxury in mind, Emilton Restaurant features stylish interiors that blend contemporary design with timeless elegance. The thoughtfully arranged seating and refined finishes provide a comfortable yet sophisticated dining environment for every guest.') ?></textarea>
            </div>
            
            <hr style="margin: 30px 0;">
            
            <div class="form-group">
                <label for="dining_cta">Optional CTA (Text Under Cards)</label>
                <textarea id="dining_cta" name="dining_cta" rows="2"><?= sanitize($sectionsArray['dining_cta'] ?? "Experience fine dining at its best.\nDine with us and enjoy exceptional food in an elegant setting.") ?></textarea>
                <p class="form-help">Tip: Use a new line to break text into two lines.</p>
            </div>
        </div>
    </div>
    
    <!-- Ambience Section -->
    <div class="card">
        <div class="card-header">
            <h2>Ambience Section</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="ambience_subtitle">Subtitle</label>
                <input type="text" id="ambience_subtitle" name="ambience_subtitle" value="<?= sanitize($sectionsArray['ambience_subtitle'] ?? 'Design & Atmosphere') ?>">
            </div>
            
            <div class="form-group">
                <label for="ambience_title">Title</label>
                <input type="text" id="ambience_title" name="ambience_title" value="<?= sanitize($sectionsArray['ambience_title'] ?? 'An Oasis of Calm') ?>">
            </div>
            
            <div class="form-group">
                <label for="ambience_description_1">Description Paragraph 1</label>
                <textarea id="ambience_description_1" name="ambience_description_1" rows="3"><?= sanitize($sectionsArray['ambience_description_1'] ?? 'Immerse yourself in an atmosphere designed to soothe the senses. Our dining room features plush velvet seating, ambient warm lighting, and panoramic views of the skyline through floor-to-ceiling windows.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="ambience_description_2">Description Paragraph 2</label>
                <textarea id="ambience_description_2" name="ambience_description_2" rows="3"><?= sanitize($sectionsArray['ambience_description_2'] ?? 'Whether you are here for an intimate conversation or a celebratory moment, the Jade Room provides the perfect backdrop of modern luxury and timeless comfort.') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="ambience_button_text">Button Text</label>
                <input type="text" id="ambience_button_text" name="ambience_button_text" value="<?= sanitize($sectionsArray['ambience_button_text'] ?? 'View Gallery') ?>">
            </div>
            
            <div class="form-group">
                <label>Ambience Image 1</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('ambience_image_1', 'ambience_img_1_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="ambience_image_1" name="ambience_image_1" value="<?= sanitize($sectionsArray['ambience_image_1'] ?? '') ?>">
                <div id="ambience_img_1_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['ambience_image_1']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['ambience_image_1'])): ?>
                        <img id="ambience_img_1_img" src="<?= SITE_URL . ltrim($sectionsArray['ambience_image_1'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>Ambience Image 2</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('ambience_image_2', 'ambience_img_2_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="ambience_image_2" name="ambience_image_2" value="<?= sanitize($sectionsArray['ambience_image_2'] ?? '') ?>">
                <div id="ambience_img_2_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['ambience_image_2']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['ambience_image_2'])): ?>
                        <img id="ambience_img_2_img" src="<?= SITE_URL . ltrim($sectionsArray['ambience_image_2'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>Ambience Image 3</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('ambience_image_3', 'ambience_img_3_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="ambience_image_3" name="ambience_image_3" value="<?= sanitize($sectionsArray['ambience_image_3'] ?? '') ?>">
                <div id="ambience_img_3_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['ambience_image_3']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['ambience_image_3'])): ?>
                        <img id="ambience_img_3_img" src="<?= SITE_URL . ltrim($sectionsArray['ambience_image_3'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>Ambience Image 4</label>
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn btn-outline" onclick="openMediaModal('ambience_image_4', 'ambience_img_4_preview')">
                        <i class="fas fa-image"></i> Select Image
                    </button>
                </div>
                <input type="hidden" id="ambience_image_4" name="ambience_image_4" value="<?= sanitize($sectionsArray['ambience_image_4'] ?? '') ?>">
                <div id="ambience_img_4_preview" class="image-preview" style="margin-top: 10px; <?= !empty($sectionsArray['ambience_image_4']) ? 'display: block;' : 'display: none;' ?>">
                    <?php if (!empty($sectionsArray['ambience_image_4'])): ?>
                        <img id="ambience_img_4_img" src="<?= SITE_URL . ltrim($sectionsArray['ambience_image_4'], '/') ?>" style="max-width: 300px; max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reservation Section (removed) -->
    
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
        <button type="submit" class="btn btn-primary">Save Restaurant Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
// (Dining Experience section uses simple text fields; no JSON management needed)

// Handle media modal selection
window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    const targetInputId = mediaModalState.targetInputId;
    
    // Hero background
    if (targetInputId === 'hero_background') {
        const input = document.getElementById('hero_background');
        const preview = document.getElementById('hero_bg_preview');
        const previewImg = document.getElementById('hero_bg_img');
        
        if (input && preview) {
            input.value = selected.path;
            preview.style.display = 'block';
            if (previewImg) {
                previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
            } else {
                preview.innerHTML = '<img id="hero_bg_img" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 500px; max-height: 300px;">';
            }
        }
        closeMediaModal();
        if (typeof showToast === 'function') {
            showToast('Image selected', 'success');
        }
        return true;
    }
    
    // Philosophy images
    if (targetInputId === 'philosophy_image_1') {
        handleImageSelection('philosophy_image_1', 'philosophy_img_1_preview', 'philosophy_img_1_img');
        return true;
    }
    if (targetInputId === 'philosophy_image_2') {
        handleImageSelection('philosophy_image_2', 'philosophy_img_2_preview', 'philosophy_img_2_img');
        return true;
    }
    
    // Ambience images
    if (targetInputId === 'ambience_image_1') {
        handleImageSelection('ambience_image_1', 'ambience_img_1_preview', 'ambience_img_1_img');
        return true;
    }
    if (targetInputId === 'ambience_image_2') {
        handleImageSelection('ambience_image_2', 'ambience_img_2_preview', 'ambience_img_2_img');
        return true;
    }
    if (targetInputId === 'ambience_image_3') {
        handleImageSelection('ambience_image_3', 'ambience_img_3_preview', 'ambience_img_3_img');
        return true;
    }
    if (targetInputId === 'ambience_image_4') {
        handleImageSelection('ambience_image_4', 'ambience_img_4_preview', 'ambience_img_4_img');
        return true;
    }
    
    // Feature image
    if (targetInputId === 'feature_image') {
        handleImageSelection('feature_image', 'feature_img_preview', 'feature_img_img');
        return true;
    }

    // Dining card images
    if (targetInputId === 'dining_card_1_image') {
        handleImageSelection('dining_card_1_image', 'dining_card_1_img_preview', 'dining_card_1_img');
        return true;
    }
    if (targetInputId === 'dining_card_2_image') {
        handleImageSelection('dining_card_2_image', 'dining_card_2_img_preview', 'dining_card_2_img');
        return true;
    }
    if (targetInputId === 'dining_card_3_image') {
        handleImageSelection('dining_card_3_image', 'dining_card_3_img_preview', 'dining_card_3_img');
        return true;
    }
    
    return false;
};

function handleImageSelection(inputId, previewId, imgId) {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return;
    
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const previewImg = document.getElementById(imgId);
    
    if (input && preview) {
        input.value = selected.path;
        preview.style.display = 'block';
        if (previewImg) {
            previewImg.src = '<?= SITE_URL ?>' + selected.path.replace(/^\//, '');
        } else {
            preview.innerHTML = '<img id="' + imgId + '" src="<?= SITE_URL ?>' + selected.path.replace(/^\//, '') + '" style="max-width: 300px; max-height: 200px;">';
        }
    }
    closeMediaModal();
    if (typeof showToast === 'function') {
        showToast('Image selected', 'success');
    }
}

// Form submission
document.getElementById('restaurantPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all form fields
    const fields = [
        'hero_subtitle', 'hero_title', 'hero_description', 'hero_background', 'hero_button_text',
        'philosophy_subtitle', 'philosophy_title', 'philosophy_description', 'philosophy_quote', 'philosophy_quote_author', 'philosophy_button_text',
        'philosophy_image_1', 'philosophy_image_2',
        'feature_1_icon', 'feature_1_title', 'feature_1_description',
        'feature_2_icon', 'feature_2_title', 'feature_2_description',
        'feature_3_icon', 'feature_3_title', 'feature_3_description',
        'dining_title', 'dining_intro', 'dining_description',
        'dining_card_1_image',
        'dining_card_1_icon', 'dining_card_1_title', 'dining_card_1_description',
        'dining_card_2_image',
        'dining_card_2_icon', 'dining_card_2_title', 'dining_card_2_description',
        'dining_card_3_image',
        'dining_card_3_icon', 'dining_card_3_title', 'dining_card_3_description',
        'dining_cta',
        'ambience_subtitle', 'ambience_title', 'ambience_description_1', 'ambience_description_2', 'ambience_button_text',
        'ambience_image_1', 'ambience_image_2', 'ambience_image_3', 'ambience_image_4',
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
                page: 'restaurant',
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
                showToast('Restaurant page content saved successfully', 'success');
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
