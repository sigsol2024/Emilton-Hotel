<?php
/**
 * Amenities Page - Dynamic Content
 * Peregrine Hotel Rayfield
 */

require_once __DIR__ . '/includes/content-loader.php';

// Load site settings
$siteName = getSiteSetting('site_name', 'Peregrine Hotel Rayfield');

// Load page sections
$pageTitle = getPageSection('amenities', 'page_title', 'Hotel Amenities & Facilities');
$pageSubtitle = getPageSection('amenities', 'page_subtitle', 'Experience the pinnacle of relaxation and luxury at Peregrine Hotel Rayfield. Every detail is curated for your comfort.');
$heroBackground = getPageSection('amenities', 'hero_background', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAsmyb7g_tD4XW07hxKcTqm7MDe-AUkrmF4sWpS4fI1XA6rKavcGNAxJSlQAqTKmTXXqth1fb3EoYR3-QvbSM4arG70wlFkMX3Ho2EpKWhMRMIsoTIRlLFk5lGcEZcXRIv2y21Fh2adICmEmuLgqItbIrlgOGqDx7ssOc_axZB1s2fCq0qijtgkhR5pS9WoFJg2p25o8lZJRHIPDAyGopkVgApMInS42toZqxf-8WYyQjD2Ho9WV5NIUoaghunKTmPiH5-mPvACg-8');

// Load amenity sections
$poolLabel = getPageSection('amenities', 'pool_label', 'Relaxation');
$poolTitle = getPageSection('amenities', 'pool_title', 'Serene Swimming Pool');
$poolDescription = getPageSection('amenities', 'pool_description', 'Unwind by our crystal-clear pool, perfect for a refreshing dip or lounging with a cocktail from the poolside bar. Enjoy the sunset in a tranquil atmosphere designed for ultimate relaxation. Our infinity edge design merges seamlessly with the horizon.');
$poolImage = getPageSection('amenities', 'pool_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuA88ADkK70NmHq6yyWJ4c8Viy3XtPEbiMLSRzsRED8Ku4rt9hqNM0B-LZs6oUfrYsypmjFMtf7QGRsjH0oZGFmVEwXYSBvnBzm1try3m5kOLM7XDmAJ31XzErvNs3d6cbENuJ31AvJBFi2i9PFdIMh-RwyNmOOFCbsh1mR6yP3FOkJokm-eDCxcREh70mOX9kjvQRjRxFVhlrFsJ7om0WR9ahLMjPyXw3BQ71U48nj7JOeMtXAvnQiyPtyyNGAz0rTScvu4AXIy4AY');

$restaurantLabel = getPageSection('amenities', 'restaurant_label', 'Culinary');
$restaurantTitle = getPageSection('amenities', 'restaurant_title', 'Gourmet Restaurant & Dining');
$restaurantDescription = getPageSection('amenities', 'restaurant_description', 'Savor exquisite flavors from our world-class chefs. Our restaurant offers a blend of local Rayfield delicacies and international cuisine, served in an elegant setting perfect for intimate dinners or business lunches.');
$restaurantImage = getPageSection('amenities', 'restaurant_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC4g4bR8wjsbceMk7dsVqNIzYdthe_J_RBqj2qoN8n7FnudQlYLxmxhMPtLyrQzuAvwhph08EWUgD4u2u1xuziB88sNxezVViWRsi8JDtJdK6mjkIdT9MxZjCt-cNRL71ZNftyja4q1dQM8EASQeHqbe-0CzEwKWmCNfa56SjxifNkN7aCnumFiBV0FQjYBA76skPTtxm9vyO--TGg4Ai5HQnA9t6wir17iO-WarJDzwnB8kUardoRAr367UF7uo2aU4JbVVyCrA8s');

$leisureLabel = getPageSection('amenities', 'leisure_label', 'Lifestyle');
$leisureTitle = getPageSection('amenities', 'leisure_title', 'Exclusive Leisure Spaces');
$leisureDescription = getPageSection('amenities', 'leisure_description', 'Discover our curated leisure spaces, including a private lounge and manicured gardens. Whether you seek a quiet corner to read or a social space to connect, our hotel offers the perfect environment for rejuvenation.');
$leisureImage = getPageSection('amenities', 'leisure_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDjlooDD4eFlVpovEsmee3i8e4iHNaS0HkA08QfSZ2qimz7H2uCXfph_H7bVnZxN4Mz4uPOhQojSwAeDq2QejTkPhU-myFWxDNFMPQru2lDapWP-Tpw7veEKS-Vx2gxAZLeJTfqWokWrsQ_1SOvY0VhgLEn3SdM6CSGcmFGcCCiKdh9qHZBSWcTlYqKAK6We1VlllkIZN52Xu-hZFNtYst2aihKHUcS4dNHnVbGIg-2NaKGQTY6O7krvyikwcsX2ehMhVzxNbyqzaY');
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= e($pageTitle) ?> - <?= e($siteName) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1754cf",
                        "background-light": "#ffffff",
                        "background-alt": "#f8f9fc",
                        "background-dark": "#111621",
                        "text-main": "#0e121b",
                        "text-muted": "#4b5563",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "full": "9999px"},
                },
            },
        }
    </script>
<style>
        html { scroll-behavior: smooth; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-background-light text-text-main font-display antialiased overflow-x-hidden">
<?php require_once __DIR__ . '/includes/header.php'; ?>

<!-- Hero Section -->
<header class="relative w-full h-[60vh] min-h-[500px] flex items-center justify-center overflow-hidden mt-20">
<div class="absolute inset-0 z-0">
<div class="absolute inset-0 bg-black/30 z-10"></div>
<div class="w-full h-full bg-cover bg-center bg-no-repeat transform hover:scale-105 transition-transform duration-[20s]" style='background-image: url("<?= e($heroBackground) ?>");'>
</div>
</div>
<div class="relative z-20 text-center px-4 max-w-4xl mx-auto">
<h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-4 drop-shadow-lg">
    <?= e($pageTitle) ?>
</h1>
<p class="text-lg md:text-xl text-white/90 font-medium max-w-2xl mx-auto leading-relaxed drop-shadow-md">
    <?= e($pageSubtitle) ?>
</p>
</div>
</header>

<!-- Main Content Container -->
<main class="w-full flex flex-col">
<!-- Section 1: Swimming Pool -->
<section class="py-24 bg-white relative overflow-hidden" id="swimming-pool">
<!-- Background Image -->
<div class="absolute inset-0 z-0">
    <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://peregrinehoteljos.com/assets/uploads/img_696fe70d891c34.86299120.png');"></div>
</div>
<!-- White Overlay -->
<div class="absolute inset-0 z-10 bg-white/85"></div>
<!-- Content -->
<div class="relative z-20 max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
<div class="flex flex-col gap-6 order-2 lg:order-1">
<div class="flex items-center gap-2 text-amber-500 font-bold uppercase tracking-wider text-xs">
<span class="w-8 h-[2px] bg-amber-500"></span>
<?= e($poolLabel) ?>
</div>
<h2 class="text-3xl md:text-4xl font-bold text-text-main leading-tight">
    <?= e($poolTitle) ?>
</h2>
<p class="text-text-muted text-base leading-relaxed">
    <?= e($poolDescription) ?>
</p>
<div class="grid grid-cols-2 gap-4 mt-6">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-amber-500">pool</span>
<span class="text-sm font-medium text-text-main">Free Floaters</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-amber-500">local_bar</span>
<span class="text-sm font-medium text-text-main">Poolside Bar</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-amber-500">beach_access</span>
<span class="text-sm font-medium text-text-main">Private Cabanas</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-amber-500">wb_sunny</span>
<span class="text-sm font-medium text-text-main">Sun Deck</span>
</div>
</div>
</div>
<div class="relative order-1 lg:order-2 h-[350px] lg:h-[450px] w-full rounded-2xl overflow-hidden shadow-2xl group">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style='background-image: url("<?= e($poolImage) ?>");'>
</div>
</div>
</div>
</div>
</section>

<!-- Section 2: Restaurant & Dining -->
<section class="py-24 bg-background-alt" id="signature-restaurant">
<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
<div class="relative h-[350px] lg:h-[450px] w-full rounded-2xl overflow-hidden shadow-2xl group">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style='background-image: url("<?= e($restaurantImage) ?>");'>
</div>
</div>
<div class="flex flex-col gap-6">
<div class="flex items-center gap-2 text-amber-500 font-bold uppercase tracking-wider text-xs">
<span class="w-8 h-[2px] bg-amber-500"></span>
<?= e($restaurantLabel) ?>
</div>
<h2 class="text-3xl md:text-4xl font-bold text-text-main leading-tight">
    <?= e($restaurantTitle) ?>
</h2>
<p class="text-text-muted text-base leading-relaxed">
    <?= e($restaurantDescription) ?>
</p>
</div>
</div>
</div>
</section>

<!-- Section 3: Leisure Spaces -->
<section class="py-24 bg-white relative overflow-hidden" id="major-entertainment-hubs">
<!-- Background Image -->
<div class="absolute inset-0 z-0">
    <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://peregrinehoteljos.com/assets/uploads/img_696fe70d891c34.86299120.png');"></div>
</div>
<!-- White Overlay -->
<div class="absolute inset-0 z-10 bg-white/85"></div>
<!-- Content -->
<div class="relative z-20 max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
<div class="flex flex-col gap-6 order-2 lg:order-1">
<div class="flex items-center gap-2 text-amber-500 font-bold uppercase tracking-wider text-xs">
<span class="w-8 h-[2px] bg-amber-500"></span>
<?= e($leisureLabel) ?>
</div>
<h2 class="text-3xl md:text-4xl font-bold text-text-main leading-tight">
    <?= e($leisureTitle) ?>
</h2>
<p class="text-text-muted text-base leading-relaxed">
    <?= e($leisureDescription) ?>
</p>
</div>
<div class="relative order-1 lg:order-2 h-[350px] lg:h-[450px] w-full rounded-2xl overflow-hidden shadow-2xl group">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style='background-image: url("<?= e($leisureImage) ?>");'>
</div>
</div>
</div>
</div>
</section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
