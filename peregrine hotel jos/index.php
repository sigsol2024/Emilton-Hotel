<?php
/**
 * Homepage - Dynamic Content
 * Peregrine Hotel Rayfield
 */

require_once __DIR__ . '/includes/content-loader.php';

// Load site settings
$siteName = getSiteSetting('site_name', 'Peregrine Hotel Rayfield');
$currencySymbol = getSiteSetting('currency_symbol', '₦');

// Load homepage sections
$heroTitle = getPageSection('index', 'hero_title', 'Experience Jos.');
$heroSubtitle = getPageSection('index', 'hero_subtitle', 'Stay in Comfort.');
$heroDescription = getPageSection('index', 'hero_description', 'A sanctuary of modern luxury in the heart of Rayfield.');
$heroBackground = getPageSection('index', 'hero_background', 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9XXXbQdZQX_DSKfvOFjS6DzDFvRLPTQz11cwQVPId5SiSGjUKHegaIaE99DcfIMUE86x85uuPs3uTi5KVYcCWbsD-_VD2sWtHMHxgeUXXucKFTUp8V-g6CYIJePgR3EDI2EycLJsN_coiLRcxsAqeZDHGA4yDMgl_VRlQCJzcIRrLUkJ8wzYHufaV2H1BmYbF7pKncmCex-k3Q1hc7HoefvfAOMT21Vvsgz5HmiMdsz4zXUk4mvwoqsYA6cLEnPO5Ai_bSmMH5t4');

// YouTube video settings
$heroYoutubeUrl = getPageSection('index', 'hero_youtube_url', '');
$heroYoutubeStart = getPageSection('index', 'hero_youtube_start', '0');
$heroYoutubeEnd = getPageSection('index', 'hero_youtube_end', '');

// Mobile YouTube video settings
$heroYoutubeMobileUrl = getPageSection('index', 'hero_youtube_mobile_url', '');
$heroYoutubeMobileStart = getPageSection('index', 'hero_youtube_mobile_start', '0');
$heroYoutubeMobileEnd = getPageSection('index', 'hero_youtube_mobile_end', '');

// Extract YouTube video ID from URL
$youtubeVideoId = '';
if (!empty($heroYoutubeUrl)) {
    // Handle various YouTube URL formats including Shorts
    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $heroYoutubeUrl, $matches)) {
        $youtubeVideoId = $matches[1];
    }
}

// Extract mobile YouTube video ID from URL
$youtubeMobileVideoId = '';
if (!empty($heroYoutubeMobileUrl)) {
    // Handle various YouTube URL formats including Shorts
    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $heroYoutubeMobileUrl, $matches)) {
        $youtubeMobileVideoId = $matches[1];
    }
}

// About section
$aboutLabel = getPageSection('index', 'about_label', 'Boulevard Hotel Group');
$aboutTitle = getPageSection('index', 'about_title', 'A Refined Stay in the Heart of Rayfield');
$aboutDescription1 = getPageSection('index', 'about_description_1', 'Peregrine Hotel brings world-class hospitality to Jos. Part of the esteemed Boulevard Hotel Group, we offer generous spaces, modern amenities, and a serene atmosphere tailored for both business and leisure travelers seeking a moment of respite.');
$aboutDescription2 = getPageSection('index', 'about_description_2', 'Immerse yourself in elegance where every detail is curated for your comfort. From our signature dining experiences to our plush, tailored suites.');
$aboutImage = getPageSection('index', 'about_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBXwfL--8AQE85elH-Wh25m9jRbCtgY2FgmOXTL9ydZHwgmGs3LxjFYOjp4PI73wd73yvIMF61YHb90MD1_XlTfLINbKB1O0TXDSy-8SPDBe0xAc5Kg1non_vCjzI0XPlt-XgOcM8PIrDUagyBBP3ym1sH-n1ogESWv2dOq9nCwgnfV0CidgkGsTfe56nxHYOpX03Z2pI4GEhiXzwfDsLuDQUPuoklZCrcXh-UUoogRhIEnSqH63LE8fWBT9slURc5KAYs8REtcjWc');

// Rooms section
$roomsTitle = getPageSection('index', 'rooms_title', 'Accommodations');
$roomsSubtitle = getPageSection('index', 'rooms_subtitle', 'Designed for tranquility and style. Choose the space that fits your journey.');

// Amenities section
$amenitiesTitle = getPageSection('index', 'amenities_title', 'Premium Amenities');
$amenitiesDescription = getPageSection('index', 'amenities_description', 'We have curated every aspect of your stay to ensure maximum comfort and convenience.');

// CTA section
$ctaTitle = getPageSection('index', 'cta_title', 'Your Perfect Stay in Jos Awaits');
$ctaDescription = getPageSection('index', 'cta_description', 'Experience the perfect blend of luxury, comfort, and Nigerian hospitality. Book directly with us for the best rates.');

// Load rooms for preview (limit to 3 featured or first 3 active)
$allRooms = getRooms(['is_active' => 1]);
$featuredRooms = array_filter($allRooms, function($room) {
    return !empty($room['is_featured']);
});
$previewRooms = !empty($featuredRooms) ? array_slice($featuredRooms, 0, 3) : array_slice($allRooms, 0, 3);
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= e($siteName) ?> | Luxury Hotel in Jos</title>
<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;family=Playfair+Display:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Theme Config -->
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1754cf",
                        "background-light": "#ffffff",
                        "background-dark": "#111621",
                        "text-main": "#0e121b",
                        "accent-black": "#111111",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"],
                        "serif": ["Playfair Display", "serif"],
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; }
        
        /* YouTube video background - cover fit like background image */
        #hero-youtube-video-desktop {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            width: 100vw !important;
            height: 56.25vw !important; /* 16:9 aspect ratio */
            min-width: 177.77vh !important; /* 16:9 aspect ratio for height */
            min-height: 100vh !important;
            transform: translate(-50%, -50%) !important;
            object-fit: cover !important;
        }
        
        /* Mobile video (portrait/Shorts) - different sizing for portrait orientation */
        #hero-youtube-video-mobile {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            width: 100vw !important;
            height: 100vh !important;
            min-width: 100vw !important;
            min-height: 100vh !important;
            transform: translate(-50%, -50%) !important;
            object-fit: cover !important;
        }
        
        /* Ensure video container covers full area */
        .hero-video-container {
            position: relative;
            overflow: hidden;
        }
        
        /* Hide mobile video on desktop, hide desktop video on mobile */
        @media (min-width: 768px) {
            #hero-youtube-video-mobile {
                opacity: 0 !important;
                visibility: hidden !important;
                pointer-events: none !important;
            }
        }
        
        @media (max-width: 767px) {
            #hero-youtube-video-desktop {
                opacity: 0 !important;
                visibility: hidden !important;
                pointer-events: none !important;
            }
        }
        
        /* Booking widget (StayEazi) - styled to match Peregrine Hotel design */
        #booking-peregrine #booking-widget {
            margin: 0 !important;
            padding: 0 !important;
            border: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            max-width: none !important;
        }

        #booking-peregrine #booking-form {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            gap: 0 !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        #booking-peregrine #booking-form > div {
            flex: 1 !important;
            width: auto !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 0 16px !important;
            border-right: 1px solid #e5e7eb !important;
        }

        #booking-peregrine #booking-form > div:last-of-type {
            border-right: none !important;
        }

        #booking-peregrine #booking-form label {
            font-size: 12px !important;
            font-weight: 700 !important;
            letter-spacing: 0.05em !important;
            text-transform: uppercase !important;
            margin-bottom: 4px !important;
            color: #9ca3af !important;
            display: block !important;
        }

        #booking-peregrine #booking-form input,
        #booking-peregrine #booking-form select {
            width: 100% !important;
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
            color: #0e121b !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            outline: none !important;
            box-shadow: none !important;
        }

        #booking-peregrine #booking-form input:focus,
        #booking-peregrine #booking-form select:focus {
            outline: none !important;
            box-shadow: none !important;
            ring: 0 !important;
        }

        #booking-peregrine #booking-form button {
            width: auto !important;
            min-width: auto !important;
            height: 52px !important;
            padding: 0 32px !important;
            margin: 0 !important;
            margin-left: 8px !important;
            border: 0 !important;
            border-radius: 8px !important;
            background: #3f3f3f !important;
            color: #fff !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            transition: background-color 0.2s !important;
        }

        #booking-peregrine #booking-form button:hover {
            background: #2a2a2a !important;
        }

        /* Mobile/Tablet: Stack vertically */
        @media (max-width: 1024px) {
            #booking-peregrine #booking-form {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 16px !important;
            }
            
            #booking-peregrine #booking-form > div {
                padding: 0 !important;
                padding-bottom: 16px !important;
                border-right: none !important;
                border-bottom: 1px solid #e5e7eb !important;
            }
            
            #booking-peregrine #booking-form > div:last-of-type {
                border-bottom: none !important;
                padding-bottom: 0 !important;
            }
            
            #booking-peregrine #booking-form button {
                width: 100% !important;
                margin-left: 0 !important;
                margin-top: 0 !important;
                font-size: 14px !important;
                height: 44px !important;
            }
        }
    </style>
<?php
// Output custom header scripts from admin settings (needed for booking widget script)
if (function_exists('getSiteSetting')) {
    $headerScripts = getSiteSetting('header_scripts', '');
    if (!empty($headerScripts)) {
        echo "\n<!-- Custom Header Scripts -->\n";
        echo $headerScripts . "\n";
    }
}
?>
</head>
<body class="bg-background-light text-text-main antialiased selection:bg-primary/20">
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
<?php require_once __DIR__ . '/includes/header.php'; ?>

<!-- Hero Section -->
<section class="relative h-[90vh] min-h-[600px] w-full flex items-center justify-center bg-gray-900 mt-20">
<?php if (!empty($youtubeVideoId) || !empty($youtubeMobileVideoId)): ?>
<!-- YouTube Video Background -->
<div class="hero-video-container absolute inset-0 z-0 h-full w-full overflow-hidden">
    <!-- Cover Image (placeholder while video loads) -->
    <div id="hero-video-cover" class="absolute inset-0 z-10 h-full w-full bg-cover bg-center bg-no-repeat transition-opacity duration-500" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)), url('<?= e($heroBackground) ?>');">
    </div>
    <!-- Dark overlay for video -->
    <div class="absolute inset-0 z-5 bg-gradient-to-b from-black/50 to-black/60 pointer-events-none"></div>
    
    <?php if (!empty($youtubeVideoId)): ?>
    <!-- Desktop YouTube iframe (hidden on mobile) -->
    <iframe id="hero-youtube-video-desktop" class="absolute inset-0 z-0 w-full h-full pointer-events-none opacity-0 transition-opacity duration-500" 
        src="" 
        frameborder="0" 
        allow="autoplay; encrypted-media; picture-in-picture" 
        allowfullscreen>
    </iframe>
    <?php endif; ?>
    
    <?php if (!empty($youtubeMobileVideoId)): ?>
    <!-- Mobile YouTube iframe (visible only on mobile) -->
    <iframe id="hero-youtube-video-mobile" class="absolute inset-0 z-0 w-full h-full pointer-events-none opacity-0 transition-opacity duration-500" 
        src="" 
        frameborder="0" 
        allow="autoplay; encrypted-media; picture-in-picture" 
        allowfullscreen>
    </iframe>
    <?php endif; ?>
</div>
<?php else: ?>
<!-- Background Image (default when no video) -->
<div class="absolute inset-0 z-0 h-full w-full bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.4)), url('<?= e($heroBackground) ?>');">
</div>
<?php endif; ?>
<div class="relative z-10 flex flex-col items-center gap-8 px-4 text-center max-w-4xl mx-auto">
<div class="flex flex-col gap-4">
<h1 class="text-white text-5xl md:text-7xl font-bold leading-tight drop-shadow-lg">
    <?= e($heroTitle) ?><br/><span class="italic font-light"><?= e($heroSubtitle) ?></span>
</h1>
<p class="text-white/90 text-lg md:text-xl font-display font-light max-w-2xl mx-auto drop-shadow-md">
    <?= e($heroDescription) ?>
</p>
</div>
<?php 
$heroCtaText = getPageSection('index', 'hero_cta_text', 'Book Your Stay');
$heroCtaLink = getPageSection('index', 'hero_cta_link', 'rooms_&_suites.php');
$heroCta2Text = getPageSection('index', 'hero_cta2_text', 'Explore Our Rooms');
$heroCta2Link = getPageSection('index', 'hero_cta2_link', 'rooms_&_suites.php');
?>
<div class="flex flex-wrap gap-4 justify-center mt-4 items-center">
<a href="<?= e($heroCtaLink) ?>" class="h-12 px-8 rounded-lg bg-accent-black text-white text-base font-bold transition-all hover:bg-black hover:scale-105 border border-transparent shadow-lg flex items-center justify-center">
    <?= e($heroCtaText) ?>
</a>
<a href="<?= e($heroCta2Link) ?>" class="h-12 px-8 rounded-lg bg-transparent text-white text-base font-bold transition-all hover:bg-white/10 border border-white backdrop-blur-sm flex items-center justify-center">
    <?= e($heroCta2Text) ?>
</a>
</div>
</div>
<!-- Booking Widget: desktop = bridged/overlaid -->
<div class="hidden md:block absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-full max-w-5xl px-4 z-20">
    <div class="mx-auto rounded-xl bg-white p-5 shadow-2xl border border-gray-100/50">
        <div class="col-md-12">
            <div id="booking-peregrine"></div>
        </div>
    </div>
</div>
</section>

<!-- Booking Widget: mobile = separate section (normal flow) -->
<section class="md:hidden bg-white py-8 px-4 relative -mt-16 z-30">
    <div class="mx-auto max-w-5xl rounded-xl bg-white p-5 shadow-2xl border border-gray-100/50">
        <div class="col-md-12">
            <div id="booking-peregrine"></div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 bg-white">
<div class="mx-auto max-w-7xl">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
<div class="flex flex-col gap-8 order-2 lg:order-1">
<div class="space-y-4">
<span class="text-amber-700 font-bold tracking-widest text-xs uppercase"><?= e($aboutLabel) ?></span>
<h2 class="text-4xl md:text-5xl font-serif text-accent-black leading-tight">
    <?= e($aboutTitle) ?>
</h2>
<p class="text-gray-600 text-lg leading-relaxed font-light">
    <?= e($aboutDescription1) ?>
</p>
<p class="text-gray-600 text-lg leading-relaxed font-light">
    <?= e($aboutDescription2) ?>
</p>
</div>
<?php 
$aboutCtaText = getPageSection('index', 'about_cta_text', 'Learn More About Us');
$aboutCtaLink = getPageSection('index', 'about_cta_link', 'about_us.php');
?>
<div class="flex gap-4">
<a class="group flex items-center gap-2 text-accent-black font-bold hover:text-amber-700 transition-colors" href="<?= e($aboutCtaLink) ?>">
    <?= e($aboutCtaText) ?> 
    <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
</a>
</div>
</div>
<div class="order-1 lg:order-2 h-[500px] w-full rounded-xl overflow-hidden shadow-2xl relative group">
<div class="absolute inset-0 bg-black/10 transition-opacity group-hover:bg-black/0"></div>
<div class="h-full w-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('<?= e($aboutImage) ?>');">
</div>
</div>
</div>
</div>
</section>

<!-- Rooms Preview -->
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-[#f8f9fc]">
<div class="mx-auto max-w-7xl flex flex-col gap-12">
<div class="flex flex-col md:flex-row justify-between items-end gap-6">
<div class="max-w-2xl">
<h2 class="text-3xl md:text-4xl font-serif text-accent-black mb-4"><?= e($roomsTitle) ?></h2>
<p class="text-gray-600 text-lg font-light"><?= e($roomsSubtitle) ?></p>
</div>
<?php 
$roomsCtaText = getPageSection('index', 'rooms_cta_text', 'View All Rooms');
$roomsCtaLink = getPageSection('index', 'rooms_cta_link', 'rooms_&_suites.php');
?>
<a class="hidden md:flex h-10 px-6 items-center rounded-lg border border-gray-300 text-sm font-bold text-accent-black hover:bg-gray-50 hover:border-gray-400 transition-colors" href="<?= e($roomsCtaLink) ?>"><?= e($roomsCtaText) ?></a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
<?php foreach ($previewRooms as $room): 
    $imageUrl = !empty($room['main_image']) ? $room['main_image'] : '';
    if ($imageUrl && strpos($imageUrl, 'http') !== 0) {
        $imageUrl = (defined('SITE_URL') ? SITE_URL : '') . ltrim($imageUrl, '/');
    }
    $badge = !empty($room['is_featured']) ? 'Most Popular' : '';
?>
<div class="group flex flex-col bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
<div class="h-64 w-full bg-cover bg-center relative" style="background-image: url('<?= e($imageUrl) ?>');">
<?php if ($badge): ?>
<div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded text-xs font-bold uppercase tracking-wider"><?= e($badge) ?></div>
<?php endif; ?>
</div>
<div class="p-6 flex flex-col gap-3 flex-1">
<h3 class="text-xl font-bold font-serif text-accent-black"><?= e($room['title']) ?></h3>
<p class="text-gray-500 text-sm line-clamp-2"><?= e($room['short_description'] ?? '') ?></p>
<div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-100">
<div>
<span class="text-xs text-gray-500">From</span>
<p class="font-bold text-[#3f3f3f] text-lg"><?= e($currencySymbol) ?><?= number_format((float)($room['price'] ?? 0), 0) ?> <span class="text-xs font-normal text-gray-500">/night</span></p>
</div>
<a href="room_details.php?slug=<?= e($room['slug']) ?>" class="h-8 px-4 rounded bg-gray-100 text-xs font-bold text-accent-black hover:bg-gray-200 inline-flex items-center justify-center">Details</a>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
<div class="md:hidden flex justify-center mt-4">
<a class="h-12 px-8 flex items-center rounded-lg bg-white border border-gray-300 text-sm font-bold text-accent-black shadow-sm" href="<?= e($roomsCtaLink) ?>"><?= e($roomsCtaText) ?></a>
</div>
</div>
</section>

<!-- Amenities Section -->
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-white relative overflow-hidden">
<!-- Background image (below content) -->
<div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://peregrinehoteljos.com/assets/uploads/img_696fb5b17ab6f0.53074818.png');"></div>
<!-- White overlay (80% opacity so image is slightly more visible) -->
<div class="absolute inset-0 bg-white/80"></div>

<div class="relative z-10 mx-auto max-w-7xl flex flex-col lg:flex-row gap-16">
<div class="lg:w-1/3 flex flex-col gap-6">
<h2 class="text-3xl md:text-4xl font-serif text-accent-black"><?= e($amenitiesTitle) ?></h2>
<p class="text-gray-600 font-light text-lg">
    <?= e($amenitiesDescription) ?>
</p>
<?php 
$amenitiesCtaText = getPageSection('index', 'amenities_cta_text', 'View All Amenities');
$amenitiesCtaLink = getPageSection('index', 'amenities_cta_link', 'amenities.php');
?>
<a class="text-amber-700 font-bold text-sm hover:underline" href="<?= e($amenitiesCtaLink) ?>"><?= e($amenitiesCtaText) ?></a>
</div>
<div class="lg:w-2/3 grid grid-cols-2 md:grid-cols-3 gap-px bg-gray-100 border border-gray-100 rounded-xl overflow-hidden">
<?php
// Load amenities from page sections or use defaults
$amenitiesList = getPageSection('index', 'amenities_list', '');
$amenitiesArray = [];
if (!empty($amenitiesList)) {
    $amenitiesArray = json_decode($amenitiesList, true) ?: [];
}
// Default amenities if none set
if (empty($amenitiesArray)) {
    $amenitiesArray = [
        ['icon' => 'wifi', 'title' => 'High-Speed Wi-Fi'],
        ['icon' => 'pool', 'title' => 'Swimming Pool'],
        ['icon' => 'restaurant', 'title' => 'Fine Dining'],
        ['icon' => 'fitness_center', 'title' => 'Fitness Center'],
        ['icon' => 'room_service', 'title' => '24/7 Room Service'],
        ['icon' => 'local_parking', 'title' => 'Secure Parking'],
    ];
}
foreach ($amenitiesArray as $amenity):
    $icon = $amenity['icon'] ?? 'check_circle';
    $title = $amenity['title'] ?? '';
?>
<div class="bg-white p-8 flex flex-col items-center justify-center gap-4 text-center hover:bg-gray-50 transition-colors group">
<span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-amber-700 transition-colors"><?= e($icon) ?></span>
<span class="font-bold text-sm text-accent-black"><?= e($title) ?></span>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<!-- Final CTA -->
<section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50 border-t border-gray-100">
<div class="mx-auto max-w-4xl text-center flex flex-col items-center gap-8">
<h2 class="text-4xl md:text-5xl font-serif text-accent-black"><?= e($ctaTitle) ?></h2>
<p class="text-gray-600 text-lg font-light max-w-xl">
    <?= e($ctaDescription) ?>
</p>
<?php 
$ctaButtonText = getPageSection('index', 'cta_button_text', 'Book Your Stay');
$ctaButtonLink = getPageSection('index', 'cta_button_link', 'rooms_&_suites.php');
?>
<a href="<?= e($ctaButtonLink) ?>" class="h-14 px-10 rounded-lg bg-accent-black text-white text-lg font-bold transition-all hover:bg-black hover:scale-105 shadow-xl shadow-gray-200 flex items-center justify-center">
    <?= e($ctaButtonText) ?>
</a>
</div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

<script>
<?php if (!empty($youtubeVideoId) || !empty($youtubeMobileVideoId)): ?>
// YouTube Video Background Handler
(function() {
    const cover = document.getElementById('hero-video-cover');
    
    <?php if (!empty($youtubeVideoId)): ?>
    // Desktop video handler
    const desktopIframe = document.getElementById('hero-youtube-video-desktop');
    if (desktopIframe) {
        let desktopEmbedUrl = 'https://www.youtube.com/embed/<?= e($youtubeVideoId) ?>?autoplay=1&mute=1&loop=1&playlist=<?= e($youtubeVideoId) ?>&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&iv_load_policy=3&cc_load_policy=0&fs=0&disablekb=1&enablejsapi=0';
        
        <?php if (!empty($heroYoutubeStart) && $heroYoutubeStart > 0): ?>
        desktopEmbedUrl += '&start=<?= (int)$heroYoutubeStart ?>';
        <?php endif; ?>
        
        <?php if (!empty($heroYoutubeEnd) && $heroYoutubeEnd > 0): ?>
        desktopEmbedUrl += '&end=<?= (int)$heroYoutubeEnd ?>';
        <?php endif; ?>
        
        desktopIframe.src = desktopEmbedUrl;
        
        desktopIframe.addEventListener('load', function() {
            setTimeout(function() {
                const isMobile = window.innerWidth < 768;
                // Show desktop video on desktop, or if no mobile video exists
                <?php if (empty($youtubeMobileVideoId)): ?>
                if (cover && desktopIframe) {
                    cover.style.opacity = '0';
                    desktopIframe.style.opacity = '1';
                    desktopIframe.style.visibility = 'visible';
                    setTimeout(function() {
                        cover.style.display = 'none';
                    }, 500);
                }
                <?php else: ?>
                if (!isMobile && cover && desktopIframe) {
                    cover.style.opacity = '0';
                    desktopIframe.style.opacity = '1';
                    desktopIframe.style.visibility = 'visible';
                    setTimeout(function() {
                        cover.style.display = 'none';
                    }, 500);
                }
                <?php endif; ?>
            }, 500);
        });
        
        // Fallback: if load event doesn't fire, fade after 2 seconds
        setTimeout(function() {
            const isMobile = window.innerWidth < 768;
            <?php if (empty($youtubeMobileVideoId)): ?>
            if (desktopIframe && cover && cover.style.opacity !== '0') {
                cover.style.opacity = '0';
                desktopIframe.style.opacity = '1';
                desktopIframe.style.visibility = 'visible';
                setTimeout(function() {
                    cover.style.display = 'none';
                }, 500);
            }
            <?php else: ?>
            if (!isMobile && desktopIframe && cover && cover.style.opacity !== '0') {
                cover.style.opacity = '0';
                desktopIframe.style.opacity = '1';
                desktopIframe.style.visibility = 'visible';
                setTimeout(function() {
                    cover.style.display = 'none';
                }, 500);
            }
            <?php endif; ?>
        }, 2000);
    }
    <?php endif; ?>
    
    <?php if (!empty($youtubeMobileVideoId)): ?>
    // Mobile video handler
    const mobileIframe = document.getElementById('hero-youtube-video-mobile');
    if (mobileIframe) {
        let mobileEmbedUrl = 'https://www.youtube.com/embed/<?= e($youtubeMobileVideoId) ?>?autoplay=1&mute=1&loop=1&playlist=<?= e($youtubeMobileVideoId) ?>&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&iv_load_policy=3&cc_load_policy=0&fs=0&disablekb=1&enablejsapi=0';
        
        <?php if (!empty($heroYoutubeMobileStart) && $heroYoutubeMobileStart > 0): ?>
        mobileEmbedUrl += '&start=<?= (int)$heroYoutubeMobileStart ?>';
        <?php endif; ?>
        
        <?php if (!empty($heroYoutubeMobileEnd) && $heroYoutubeMobileEnd > 0): ?>
        mobileEmbedUrl += '&end=<?= (int)$heroYoutubeMobileEnd ?>';
        <?php endif; ?>
        
        mobileIframe.src = mobileEmbedUrl;
        
        mobileIframe.addEventListener('load', function() {
            setTimeout(function() {
                const isMobile = window.innerWidth < 768;
                if (isMobile && cover && mobileIframe) {
                    cover.style.opacity = '0';
                    mobileIframe.style.opacity = '1';
                    mobileIframe.style.visibility = 'visible';
                    setTimeout(function() {
                        cover.style.display = 'none';
                    }, 500);
                }
            }, 500);
        });
        
        // Fallback: if load event doesn't fire, fade after 2 seconds
        setTimeout(function() {
            const isMobile = window.innerWidth < 768;
            if (isMobile && mobileIframe && cover && cover.style.opacity !== '0') {
                cover.style.opacity = '0';
                mobileIframe.style.opacity = '1';
                mobileIframe.style.visibility = 'visible';
                setTimeout(function() {
                    cover.style.display = 'none';
                }, 500);
            }
        }, 2000);
    }
    <?php endif; ?>
})();
<?php endif; ?>

// Ensure booking widget appears on both desktop and mobile
// Clone widget content to mobile container if needed
(function() {
    function syncBookingWidget() {
        const desktopWidget = document.querySelector('.hidden.md\\:block #booking-peregrine');
        const mobileWidget = document.querySelector('.md\\:hidden #booking-peregrine');
        
        if (desktopWidget && mobileWidget && desktopWidget.innerHTML && !mobileWidget.innerHTML) {
            mobileWidget.innerHTML = desktopWidget.innerHTML;
        }
        if (mobileWidget && desktopWidget && mobileWidget.innerHTML && !desktopWidget.innerHTML) {
            desktopWidget.innerHTML = mobileWidget.innerHTML;
        }
    }
    
    // Check periodically after page load
    setTimeout(syncBookingWidget, 1000);
    setTimeout(syncBookingWidget, 2000);
    setTimeout(syncBookingWidget, 3000);
    
    // Also listen for DOM changes
    const observer = new MutationObserver(syncBookingWidget);
    document.addEventListener('DOMContentLoaded', function() {
        const target = document.getElementById('booking-peregrine');
        if (target) {
            observer.observe(target, { childList: true, subtree: true });
        }
    });
})();
</script>
