<?php
/**
 * Rooms Listing Page - Dynamic Content
 * Peregrine Hotel Rayfield
 */

require_once __DIR__ . '/includes/content-loader.php';

// Load site settings
$siteName = getSiteSetting('site_name', 'Peregrine Hotel Rayfield');
$currencySymbol = getSiteSetting('currency_symbol', '₦');

// Load page sections
$pageTitle = getPageSection('rooms', 'page_title', 'Accommodations');
$pageSubtitle = getPageSection('rooms', 'page_subtitle', 'Designed for tranquility and style. Choose the space that fits your journey.');
$heroBackground = getPageSection('rooms', 'hero_background', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBTf78SDLBYRls1ySmKF4WsCAN-qDa13xSezqXFEbPdgfNaAW8L5dxckdgCczLiYlMG46wFqh-jR60JPMyjP8gFRiLZ__fMcBEj_DieB42pe8T9tF0P0u412FPC34nTB5vh5Sfx8RDM4gTgLF610c5oEefiOcOiYLEcMX1yvB89Lg2U8Fu5eKKDL_wxOZ3cnPdAHaWcs9XY9b1d7lTY7Mm_S1vAxnrl38T3zZLEmbO2BfmgNvJDhZzJ5B6yYB4a42GZ8y-HvUDChII');

// Load all active rooms
$allRooms = getRooms(['is_active' => 1]);
$totalRooms = count($allRooms);
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= e($pageTitle) ?> - <?= e($siteName) ?></title>
<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&amp;display=swap" rel="stylesheet"/>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1754cf",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111621",
                        "text-main": "#0e121b",
                        "text-muted": "#4e6797",
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
        body { font-family: "Plus Jakarta Sans", sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
        
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
            height: 48px !important;
            padding: 0 32px !important;
            margin: 0 !important;
            margin-left: 8px !important;
            border: 0 !important;
            border-radius: 8px !important;
            background: #3f3f3f !important;
            color: #fff !important;
            font-weight: 700 !important;
            font-size: 16px !important;
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
<body class="bg-white dark:bg-background-dark text-text-main antialiased selection:bg-primary/20 selection:text-primary">
<?php require_once __DIR__ . '/includes/header.php'; ?>

<!-- Hero Section -->
<div class="relative w-full h-[60vh] min-h-[500px] flex items-center justify-center bg-black mt-20">
<div class="absolute inset-0 w-full h-full bg-cover bg-center" style="background-image: url('<?= e($heroBackground) ?>');">
</div>
<div class="absolute inset-0 bg-black/40 bg-gradient-to-t from-black/80 to-transparent"></div>
<div class="relative z-10 flex flex-col items-center text-center px-4 max-w-4xl mx-auto">
<h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-serif font-medium leading-tight mb-4">
    <?= e($pageTitle) ?>
</h1>
<p class="text-white/90 text-lg md:text-xl font-display font-light max-w-2xl mx-auto">
    <?= e($pageSubtitle) ?>
</p>
</div>
<!-- Booking Widget -->
<div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-full max-w-5xl px-4 z-20">
    <div class="mx-auto rounded-xl bg-white p-4 shadow-2xl border border-gray-100/50">
        <div class="col-md-12">
            <div id="booking-peregrine"></div>
        </div>
    </div>
</div>
</div>

<!-- Main Content -->
<main class="flex flex-col w-full bg-white py-20">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
<?php if (empty($allRooms)): ?>
<div class="text-center py-20">
<p class="text-text-muted text-lg">No rooms available at this time.</p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
<?php foreach ($allRooms as $room): 
    $imageUrl = !empty($room['main_image']) ? $room['main_image'] : '';
    if ($imageUrl && strpos($imageUrl, 'http') !== 0) {
        $imageUrl = (defined('SITE_URL') ? SITE_URL : '') . ltrim($imageUrl, '/');
    }
    $badge = !empty($room['is_featured']) ? 'Most Popular' : '';
    $features = is_array($room['features'] ?? null) ? $room['features'] : json_decode($room['features'] ?? '[]', true);
    $featuresText = !empty($features) ? implode(' · ', array_slice($features, 0, 3)) : '';
    $ratingDisplay = !empty($room['rating_score']) ? number_format((float)$room['rating_score'], 1) : (!empty($room['rating']) ? (string)$room['rating'] : '');
?>
<div class="group flex flex-col bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
<div class="h-64 w-full bg-cover bg-center relative" style="background-image: url('<?= e($imageUrl) ?>');">
<?php if ($badge): ?>
<div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded text-xs font-bold uppercase tracking-wider"><?= e($badge) ?></div>
<?php endif; ?>
</div>
<div class="p-6 flex flex-col gap-3 flex-1">
<div class="flex justify-between items-start mb-2">
<h3 class="text-xl font-bold font-serif text-accent-black"><?= e($room['title']) ?></h3>
<?php if ($ratingDisplay !== ''): ?>
<div class="flex items-center text-amber-700">
<span class="material-symbols-outlined text-sm fill-current">star</span>
<span class="text-sm font-bold ml-1"><?= e($ratingDisplay) ?></span>
</div>
<?php endif; ?>
</div>
<?php if ($featuresText): ?>
<p class="text-gray-500 text-sm line-clamp-2"><?= e($featuresText) ?></p>
<?php endif; ?>
<?php if (!empty($room['short_description'])): ?>
<p class="text-gray-500 text-sm line-clamp-2"><?= e($room['short_description']) ?></p>
<?php endif; ?>
<div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-100">
<div>
<span class="text-xs text-gray-500">From</span>
<p class="font-bold text-[#3f3f3f] text-lg"><?= e($currencySymbol) ?><?= number_format((float)($room['price'] ?? 0), 0) ?> <span class="text-xs font-normal text-gray-500">/night</span></p>
</div>
<a href="room_details.php?slug=<?= e($room['slug']) ?>" class="h-8 px-4 rounded bg-gray-100 text-xs font-bold text-accent-black hover:bg-gray-200 transition-colors inline-flex items-center justify-center">Details</a>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
