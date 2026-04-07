<?php
/**
 * Room Details Page - Modern Design
 */

require_once __DIR__ . '/includes/content-loader.php';

$slug = $_GET['slug'] ?? '';
// Sanitize slug input
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($slug)));

if (empty($slug)) {
    header('Location: rooms.php');
    exit;
}

$room = getRoomBySlug($slug);

if (!$room) {
    header('Location: rooms.php');
    exit;
}

// Load site settings
$siteName = getSiteSetting('site_name', 'TM Luxury Apartments');
$siteLogo = getSiteSetting('site_logo', 'assets/img/logo1.png');
$siteFavicon = getSiteSetting('site_favicon', 'assets/img/logo1.png');
$headerLocation = getSiteSetting('header_location', '11 Okpofe Street, Ajoa Estate, Off Int\'l Airport Road');
$whatsappLink = getSiteSetting('whatsapp_link', 'https://wa.me/2348134807718?text=Greetings%20TM%20Luxury%20Apartment');
$footerAddress = getSiteSetting('footer_address', '11 Akpofe Street, Ajao Estate, Off Int\'l Airport Road.');
$footerPhone = getSiteSetting('footer_phone', '+234 813 480 7718 | +234 907 676 0923');
$footerCopyright = getSiteSetting('footer_copyright', 'TM');
$developerText = getSiteSetting('developer_text', 'Brilliant Developers - 07068057873');
$developerLink = getSiteSetting('developer_link', 'https://wa.me/2347068057873?text=Greetings%20Brilliant%20Developers');

// Prepare gallery images
$galleryImages = !empty($room['gallery_images']) && is_array($room['gallery_images']) ? $room['gallery_images'] : [];
if ($room['main_image']) {
    array_unshift($galleryImages, $room['main_image']);
}
$galleryImages = array_unique($galleryImages);
$galleryCount = count($galleryImages);

// Prepare data with defaults
$rating = isset($room['rating']) ? intval($room['rating']) : 5;
$ratingScore = isset($room['rating_score']) && $room['rating_score'] ? floatval($room['rating_score']) : null;
$location = $room['location'] ?? '';
$size = $room['size'] ?? '';
$tags = !empty($room['tags']) && is_array($room['tags']) ? $room['tags'] : [];
$includedItems = !empty($room['included_items']) && is_array($room['included_items']) ? $room['included_items'] : [];
$goodToKnow = !empty($room['good_to_know']) && is_array($room['good_to_know']) ? $room['good_to_know'] : [];
$bookUrl = $room['book_url'] ?? $whatsappLink;
$originalPrice = isset($room['original_price']) && $room['original_price'] ? floatval($room['original_price']) : null;
$urgencyMessage = $room['urgency_message'] ?? '';

// Prepare features
$features = !empty($room['features']) && is_array($room['features']) ? $room['features'] : [];

// Single description rule: use description if present, otherwise fall back to short_description
$displayDescription = trim((string)($room['description'] ?? ''));
if ($displayDescription === '') {
    $displayDescription = trim((string)($room['short_description'] ?? ''));
}

// Calculate discount if original price exists
$discountPercent = null;
if ($originalPrice && $originalPrice > $room['price']) {
    $discountPercent = round((($originalPrice - $room['price']) / $originalPrice) * 100);
}

// Prepare amenities - handle both old format (strings) and new format (objects with icon, title, description)
$amenities = [];
if (!empty($room['amenities']) && is_array($room['amenities'])) {
    foreach ($room['amenities'] as $amenity) {
        if (is_array($amenity)) {
            $amenities[] = [
                'icon' => $amenity['icon'] ?? 'check_circle',
                'title' => $amenity['title'] ?? '',
                'description' => $amenity['description'] ?? ''
            ];
        } else {
            $amenities[] = [
                'icon' => 'check_circle',
                'title' => $amenity,
                'description' => ''
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= e($room['short_description'] ?: $room['description']) ?>">
    <meta name="author" content="<?= e($siteName) ?>">
    <!-- Favicon -->
    <link rel="icon" href="<?= e($siteFavicon) ?>" />
    <!-- All CSS Files -->
    <link rel="stylesheet" href="code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/slick.min.css" />
    <link rel="stylesheet" href="assets/css/aos.min.css" />
    <link rel="stylesheet" href="assets/css/datepicker.css" />
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/css/lightgallery.min.css" />
    <link rel="stylesheet" href="assets/css/odometer.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- Header Head Includes (Tailwind CSS, Fonts) -->
    <?php require_once __DIR__ . '/includes/head-header.php'; ?>
    <!-- Site Title -->
    <title><?= e($room['title']) ?> - <?= e($siteName) ?></title>
    <style>
        /* Custom styles for room detail page */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Ensure booking button matches site style */
        .cs_btn.cs_style_1 {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        
        /* LightGallery fixes */
        .lg-outer {
            z-index: 99999 !important;
        }
        .lg-backdrop {
            z-index: 99998 !important;
        }
        
        /* Fix header covering lightbox */
        body.lg-on {
            overflow: hidden !important;
        }
        body.lg-on header,
        body.lg-on .header,
        body.lg-on nav {
            z-index: 1 !important;
        }
        
        /* Fix lightGallery icons - use Unicode characters if fonts fail */
        .lg-icon {
            font-family: Arial, sans-serif !important;
        }
        .lg-icon.lg-close:before {
            content: "×" !important;
            font-size: 32px !important;
            line-height: 1 !important;
        }
        .lg-icon.lg-prev:before {
            content: "‹" !important;
            font-size: 32px !important;
            line-height: 1 !important;
        }
        .lg-icon.lg-next:before {
            content: "›" !important;
            font-size: 32px !important;
            line-height: 1 !important;
        }
        
        /* Improve lightGallery toolbar styling */
        .lg-toolbar {
            background: rgba(0, 0, 0, 0.45) !important;
            backdrop-filter: blur(10px);
        }
        .lg-toolbar .lg-icon {
            color: #fff !important;
            background: transparent !important;
            border: none !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 24px !important;
            line-height: 1 !important;
            padding: 0 !important;
        }
        .lg-toolbar .lg-icon:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 4px !important;
        }
        
        /* Fix navigation arrows */
        .lg-actions .lg-icon {
            color: #fff !important;
            background: rgba(0, 0, 0, 0.5) !important;
            border-radius: 50% !important;
            width: 50px !important;
            height: 50px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 28px !important;
            line-height: 1 !important;
            transition: all 0.3s ease !important;
        }
        .lg-actions .lg-icon:hover {
            background: rgba(0, 0, 0, 0.8) !important;
            transform: scale(1.1) !important;
        }
        
        /* Fix counter styling */
        #lg-counter {
            color: #fff !important;
            font-size: 14px !important;
            font-weight: 500 !important;
        }
        
        /* Ensure lightbox content is properly centered */
        .lg-outer .lg {
            max-width: 100vw !important;
            max-height: 100vh !important;
        }
        .lg-item {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .lg-img-wrap {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100% !important;
        }
        .lg-image {
            max-width: 90vw !important;
            max-height: 90vh !important;
            object-fit: contain !important;
        }
    </style>
</head>
<body class="bg-background-light page-details">
    <?php require_once __DIR__ . '/includes/body-scripts.php'; ?>
    <!-- Include Header Template -->
    <?php require_once __DIR__ . '/includes/header.php'; ?>
    
    <?php
    // SMOKING GUN TEST - Check if room was overwritten
    if (isset($roomBeforeHeader) && isset($room)) {
        if ($roomBeforeHeader['id'] !== $room['id']) {
            echo '<pre style="color:red;background:yellow;padding:20px;font-size:16px;z-index:99999;position:fixed;top:0;left:0;width:100%;height:100%;overflow:auto;">';
            echo "🚨 ROOM WAS OVERWRITTEN AFTER HEADER! 🚨\n\n";
            echo "Before Header:\n";
            echo "  ID: {$roomBeforeHeader['id']}\n";
            echo "  Title: {$roomBeforeHeader['title']}\n";
            echo "  Price: {$roomBeforeHeader['price']}\n\n";
            echo "After Header:\n";
            echo "  ID: {$room['id']}\n";
            echo "  Title: {$room['title']}\n";
            echo "  Price: {$room['price']}\n\n";
            echo "This confirms the bug is in header.php foreach loops!\n";
            exit;
        }
    }
    ?>

    <!-- Spacer for fixed header -->
    <div class="h-20"></div>

    <!-- Main Container -->
    <div class="flex-1 w-full max-w-[1280px] mx-auto px-4 md:px-10 py-6">
        <!-- Breadcrumbs -->
        <div class="flex flex-wrap gap-2 mb-6 text-sm">
            <a class="text-text-muted hover:text-primary font-medium transition-colors" href="index.php">Home</a>
            <span class="text-text-muted">/</span>
            <a class="text-text-muted hover:text-primary font-medium transition-colors" href="rooms.php">Rooms</a>
            <span class="text-text-muted">/</span>
            <span class="text-text-main font-medium"><?= e($room['title']) ?></span>
        </div>

        <!-- Hero Image Gallery (Split 60/40) -->
        <?php if (!empty($galleryImages)): ?>
        <?php
            $featuredImage = $galleryImages[0];
            $thumbImages = array_slice($galleryImages, 1, 4);
        ?>
        <div class="mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-3 h-[400px] md:h-[500px]">
                <!-- Featured image (60%) -->
                <button type="button" onclick="openGallery(0, event); return false;" class="lg:col-span-3 relative rounded-xl overflow-hidden bg-gray-200 group cursor-pointer">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('<?= e($featuredImage) ?>');"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-60"></div>
                    <?php if ($galleryCount > 1): ?>
                    <div class="absolute bottom-4 left-4 bg-white text-text-main px-4 py-2 rounded-lg font-bold text-sm shadow-lg flex items-center gap-2 hover:bg-gray-100 transition-colors pointer-events-none">
                        <span class="material-symbols-outlined text-[20px]">grid_view</span>
                        View All <?= $galleryCount ?> Photos
                    </div>
                    <?php endif; ?>
                </button>

                <!-- Gallery thumbs (40%) - Hidden on mobile, visible on desktop -->
                <div class="hidden lg:grid lg:col-span-2 grid-cols-2 grid-rows-2 gap-3 h-full">
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <?php $img = $thumbImages[$i] ?? null; ?>
                        <button type="button"
                                onclick="openGallery(<?= $i + 1 ?>, event); return false;"
                                class="relative rounded-xl overflow-hidden bg-gray-200 group cursor-pointer <?= $img ? '' : 'opacity-0 pointer-events-none' ?>">
                            <?php if ($img): ?>
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('<?= e($img) ?>');"></div>
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                            <?php endif; ?>
                        </button>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Hidden items for lightbox -->
            <div id="gallery-container" style="display: none;">
                <?php foreach ($galleryImages as $img): ?>
                    <a href="<?= e($img) ?>" class="gallery-item" data-src="<?= e($img) ?>">
                        <img src="<?= e($img) ?>" alt="Gallery image" />
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Header Title Section (below images) -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div class="w-full">
                <div class="flex items-center gap-2 mb-2">
                    <?php if ($room['room_type']): ?>
                    <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded uppercase"><?= e($room['room_type']) ?></span>
                    <?php endif; ?>
                    <?php if ($rating > 0): ?>
                    <div class="flex text-yellow-400 text-[18px]">
                        <?php for ($i = 0; $i < $rating; $i++): ?>
                        <span class="material-symbols-outlined fill-current" style="font-variation-settings: 'FILL' 1">star</span>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-text-main mb-2 hero-font-serif"><?= e($room['title']) ?></h1>

                <div class="flex items-center gap-4 text-sm text-text-muted flex-wrap mb-4">
                    <?php if ($location): ?>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">location_on</span> <?= e($location) ?></span>
                    <?php endif; ?>
                    <?php if ($size): ?>
                    <?php if ($location): ?><span class="w-1 h-1 bg-gray-300 rounded-full"></span><?php endif; ?>
                    <span><?= e($size) ?></span>
                    <?php endif; ?>
                    <?php if ($ratingScore): ?>
                    <?php if ($location || $size): ?><span class="w-1 h-1 bg-gray-300 rounded-full"></span><?php endif; ?>
                    <span class="flex items-center gap-1 text-primary font-medium"><span class="material-symbols-outlined text-[18px]">thumb_up</span> <?= number_format($ratingScore, 1) ?> Exceptional</span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($displayDescription)): ?>
                <p class="text-text-main leading-relaxed mb-6">
                    <?= nl2br(e($displayDescription)) ?>
                </p>
                <?php endif; ?>

                <?php if (!empty($tags)): ?>
                <div class="flex flex-wrap gap-3">
                    <?php foreach ($tags as $tag): ?>
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-primary/10 text-primary text-sm font-medium border border-primary/20">
                        <?= e($tag) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative">
            <!-- Left Content Column -->
            <div class="lg:col-span-2 space-y-4 md:space-y-6">

                <!-- Features and Amenities Combined Section -->
                <?php if (!empty($features) || !empty($amenities)): ?>
                <div class="h-px w-full bg-[#f0f2f4] dark:bg-gray-800"></div>
                <section class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <!-- Features Column -->
                    <?php if (!empty($features)): ?>
                    <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl p-3 md:p-5">
                        <h3 class="text-base md:text-lg font-bold mb-2 md:mb-3 text-text-main">Features</h3>
                        <ul class="space-y-1.5 md:space-y-2">
                            <?php foreach ($features as $feature): ?>
                            <li class="flex items-center gap-2 text-text-main">
                                <span class="material-symbols-outlined text-primary text-[16px] md:text-[18px] flex-shrink-0">check_circle</span>
                                <span class="text-xs md:text-sm"><?= e(is_array($feature) ? ($feature['title'] ?? $feature) : $feature) ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- Room Amenities Column -->
                    <?php if (!empty($amenities)): ?>
                    <div class="bg-[#f0f9ff] dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/30 rounded-xl p-3 md:p-5">
                        <h3 class="text-base md:text-lg font-bold mb-2 md:mb-3 text-text-main">Room Amenities</h3>
                        <div class="space-y-2 md:space-y-3">
                            <?php foreach ($amenities as $amenity): ?>
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px] md:text-[20px] flex-shrink-0 mt-0.5"><?= e($amenity['icon']) ?></span>
                                <div class="min-w-0">
                                    <p class="font-medium text-xs text-text-main leading-tight"><?= e($amenity['title']) ?></p>
                                    <?php if (!empty($amenity['description'])): ?>
                                    <p class="text-xs text-[#617589] dark:text-gray-500 mt-0.5 leading-tight"><?= e($amenity['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </section>
                <?php endif; ?>

                <!-- Included in Stay -->
                <?php if (!empty($includedItems)): ?>
                <div class="h-px w-full bg-[#f0f2f4] dark:bg-gray-800"></div>
                <section class="bg-[#f0f9ff] dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/30 rounded-xl p-3 md:p-5">
                    <h3 class="text-base md:text-lg font-bold mb-2 md:mb-3 flex items-center gap-2 text-text-main">
                        <span class="material-symbols-outlined text-primary text-[18px] md:text-[20px]">redeem</span>
                        Included in your stay
                    </h3>
                    <div class="space-y-1.5 md:space-y-2">
                        <?php foreach ($includedItems as $item): ?>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-green-600 text-[16px] md:text-[18px] flex-shrink-0">check_circle</span>
                            <span class="text-xs md:text-sm font-medium text-text-main"><?= e($item) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

                <div class="h-px w-full bg-[#f0f2f4] dark:bg-gray-800"></div>

                <!-- Good to Know -->
                <?php if (!empty($goodToKnow)): ?>
                <section>
                    <h3 class="text-lg font-bold mb-4 text-text-main">Good to know</h3>
                    <div class="flex flex-wrap gap-4">
                        <?php 
                        $items = [];
                        if (isset($goodToKnow['check_in']) || isset($goodToKnow['check_out'])) {
                            $items[] = ['icon' => 'schedule', 'title' => 'Check-in / Check-out', 'content' => [
                                isset($goodToKnow['check_in']) ? 'Check-in from ' . e($goodToKnow['check_in']) : null,
                                isset($goodToKnow['check_out']) ? 'Check-out until ' . e($goodToKnow['check_out']) : null
                            ]];
                        }
                        if (isset($goodToKnow['pets'])) {
                            $items[] = ['icon' => 'pets', 'title' => 'Pets', 'content' => [nl2br(e($goodToKnow['pets']))]];
                        }
                        ?>
                        <?php foreach ($items as $index => $item): ?>
                            <?php if ($index > 0 && $index % 3 == 0): ?>
                                </div><div class="flex flex-wrap gap-4 mt-4">
                            <?php endif; ?>
                            <div class="flex-1 min-w-[200px] max-w-[300px]">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="material-symbols-outlined text-[#617589] dark:text-gray-400 text-[18px]"><?= e($item['icon']) ?></span>
                                    <h4 class="font-bold text-xs text-text-main"><?= e($item['title']) ?></h4>
                                </div>
                                <ul class="list-none space-y-0.5 text-xs text-[#617589] dark:text-gray-400 pl-6">
                                    <?php foreach ($item['content'] as $line): ?>
                                        <?php if ($line): ?>
                                        <li><?= $line ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
            </div>

            <!-- Right Sidebar (Sticky) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-surface-light border border-border-light rounded-xl shadow-lg overflow-hidden">
                    <!-- Price Header -->
                    <div class="p-4 border-b border-border-light bg-gray-50">
                        <?php if ($originalPrice && $discountPercent): ?>
                        <div class="flex items-baseline gap-2 mb-1">
                            <span class="text-sm text-text-muted line-through">₦<?= number_format($originalPrice, 0) ?></span>
                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded">-<?= $discountPercent ?>%</span>
                        </div>
                        <?php endif; ?>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-bold text-text-main">₦<?= number_format($room['price'], 0) ?></span>
                            <span class="text-text-muted">/ night</span>
                        </div>
                        <div class="text-xs text-green-600 mt-1 font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">check</span> Includes taxes & fees
                        </div>
                    </div>

                    <!-- Booking Button -->
                    <div class="p-4">
                        <a href="<?= e($bookUrl) ?>" target="_blank"
                           class="w-full bg-[#1b180d] hover:bg-primary text-white font-bold py-3 px-4 rounded-lg shadow-md transition-colors flex items-center justify-center gap-2">
                            <span>Book Now</span>
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                        <div class="text-center mt-2">
                            <p class="text-xs text-text-muted flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">lock</span> Secure booking
                            </p>
                        </div>
                    </div>

                    <!-- Urgency Footer -->
                    <?php if ($urgencyMessage): ?>
                    <div class="bg-red-50 p-3 text-center border-t border-red-100">
                        <p class="text-xs text-red-600 font-bold flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">local_fire_department</span>
                            <?= e($urgencyMessage) ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer Template -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <!-- Start Scroll Top Button -->
    <button type="button" class="cs_scrollup" id="scrollToTopBtn">
      <svg style="width: 100%; height: 100%;" viewBox="0 0 48 44" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M23.9999 33.0001C24.3835 33.0001 24.7675 32.8535 25.0604 32.5606L40.0604 17.5606C40.6465 16.9745 40.6465 16.0253 40.0604 15.4396C39.4743 14.8538 38.5252 14.8535 37.9394 15.4396L23.9999 29.3791L10.0604 15.4396C9.47428 14.8535 8.52515 14.8535 7.9394 15.4396C7.35365 16.0257 7.35328 16.9748 7.9394 17.5606L22.9394 32.5606C23.2323 32.8535 23.6163 33.0001 23.9999 33.0001Z" fill="currentColor"></path>
      </svg>
    </button>

    <!-- Scripts -->
    <script src="code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/datepicker.min.js"></script>
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/lightgallery.min.js"></script>
    <script src="assets/js/fontawesome.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        // Fix for loadingText error - patch immediately after main.js loads
        (function() {
            // Wait a tick for main.js to define the function
            setTimeout(function() {
                if (typeof window.loadingText === 'function') {
                    const original = window.loadingText;
                    window.loadingText = function() {
                        const text = document.querySelector(".cs_loading_text");
                        if (text && text.textContent) {
                            try {
                                original();
                            } catch(e) {
                                // Silently fail if element doesn't exist
                            }
                        }
                    };
                }
            }, 0);
        })();
        
        // Initialize gallery on page load
        let galleryInstance = null;
        
        $(document).ready(function() {
            // Wait for all scripts to load
            function initGallery() {
                const galleryContainer = document.getElementById('gallery-container');
                if (!galleryContainer) {
                    console.warn('Gallery container not found');
                    return false;
                }
                
                const galleryItems = document.querySelectorAll('.gallery-item');
                if (galleryItems.length === 0) {
                    console.warn('No gallery items found');
                    return false;
                }
                
                // Check if jQuery and lightGallery plugin are loaded
                if (typeof jQuery === 'undefined' || typeof $ === 'undefined') {
                    console.error('jQuery is not loaded');
                    return false;
                }
                
                if (typeof $.fn.lightGallery === 'undefined') {
                    console.error('lightGallery jQuery plugin not loaded. Check if assets/js/lightgallery.min.js is loading correctly.');
                    return false;
                }
                
                try {
                    // Initialize lightGallery using jQuery syntax
                    galleryContainer.style.display = 'block';
                    
                    $(galleryContainer).lightGallery({
                        selector: '.gallery-item',
                        download: false,
                        share: false,
                        counter: true,
                        enableDrag: true,
                        enableSwipe: true,
                        mode: 'lg-slide'
                    });
                    
                    // Store the jQuery object as the instance
                    galleryInstance = $(galleryContainer);
                    
                    // Hide container again after initialization
                    galleryContainer.style.display = 'none';
                    
                    console.log('Gallery initialized successfully with', galleryItems.length, 'images');
                    return true;
                } catch (error) {
                    console.error('Error initializing gallery:', error);
                    galleryContainer.style.display = 'none';
                    return false;
                }
            }
            
            // Try to initialize after a short delay to ensure all scripts are loaded
            setTimeout(function() {
                if (!initGallery()) {
                    // Try again after another delay
                    setTimeout(function() {
                        initGallery();
                    }, 1000);
                }
            }, 100);
        });
        
        function openGallery(index, event) {
            index = index || 0;
            console.log('openGallery() called with index:', index);
            
            // Prevent any default behavior if event is provided
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            if (galleryInstance && galleryInstance.length > 0) {
                try {
                    // lightGallery opens when you click the items, so we need to trigger click on the specific item
                    const items = galleryInstance.find('.gallery-item');
                    if (items.length > index) {
                        items.eq(index).trigger('click');
                        console.log('Gallery opened at index', index);
                    } else {
                        console.warn('Index out of range. Opening first image.');
                        items.first().trigger('click');
                    }
                } catch (error) {
                    console.error('Error opening gallery:', error);
                }
            } else {
                console.warn('Gallery not initialized yet. Attempting to initialize now...');
                const galleryContainer = document.getElementById('gallery-container');
                if (galleryContainer && typeof $ !== 'undefined' && typeof $.fn.lightGallery !== 'undefined') {
                    try {
                        galleryContainer.style.display = 'block';
                        $(galleryContainer).lightGallery({
                            selector: '.gallery-item',
                            download: false,
                            share: false
                        });
                        galleryInstance = $(galleryContainer);
                        galleryContainer.style.display = 'none';
                        
                        // Open the specific image
                        const items = galleryInstance.find('.gallery-item');
                        if (items.length > index) {
                            items.eq(index).trigger('click');
                        } else {
                            items.first().trigger('click');
                        }
                    } catch (error) {
                        console.error('Failed to initialize and open gallery:', error);
                    }
                } else {
                    console.error('Cannot open gallery - container or library not available');
                }
            }
            
            return false;
        }
    </script>
    <script>
        // #region agent log
        (function () {
            var ENDPOINT = 'http://127.0.0.1:7243/ingest/a1aac6c6-ff27-4da6-a86c-6c175a5ad1ae';
            function log(hypothesisId, location, message, data) {
                try {
                    fetch(ENDPOINT, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            sessionId: 'debug-session',
                            runId: 'pre-fix',
                            hypothesisId: hypothesisId,
                            location: location,
                            message: message,
                            data: data || {},
                            timestamp: Date.now()
                        })
                    }).catch(function () { });
                } catch (e) { }
            }

            var php = {
                querySlug: <?= json_encode($slug) ?>,
                roomId: <?= json_encode($room['id'] ?? null) ?>,
                roomSlug: <?= json_encode($room['slug'] ?? null) ?>,
                roomTitle: <?= json_encode($room['title'] ?? null) ?>,
                roomShort: <?= json_encode($room['short_description'] ?? null) ?>,
                roomDescLen: <?= json_encode(isset($room['description']) ? strlen((string)$room['description']) : null) ?>,
                roomShortLen: <?= json_encode(isset($room['short_description']) ? strlen((string)$room['short_description']) : null) ?>,
            };

            // H1/H2: server rendered wrong room OR wrong template/cached HTML
            log('H1', 'details.php:agentlog:php', 'Rendered PHP room payload', php);

            // H4/H5: DOM being mutated client-side or cached same HTML for different slugs
            function domSnapshot() {
                var h1 = document.querySelector('h1');
                var tagline = (h1 && h1.nextElementSibling && h1.nextElementSibling.tagName === 'P') ? h1.nextElementSibling : null;
                var overviewP = document.querySelector('section p.text-text-muted.leading-relaxed');
                return {
                    href: location.href,
                    domH1: h1 ? (h1.textContent || '').trim() : null,
                    domTagline: tagline ? (tagline.textContent || '').trim() : null,
                    domOverview: overviewP ? (overviewP.textContent || '').trim().slice(0, 180) : null
                };
            }
            log('H4', 'details.php:agentlog:dom', 'DOM snapshot after load', domSnapshot());
        })();
        // #endregion agent log
    </script>
    
    <?php
    // Output custom footer scripts from admin settings
    if (function_exists('getSiteSetting')) {
        $footerScripts = getSiteSetting('footer_scripts', '');
        if (!empty($footerScripts)) {
            echo "\n<!-- Custom Footer Scripts -->\n";
            echo $footerScripts . "\n";
        }
    }
    ?>
</body>
</html>
