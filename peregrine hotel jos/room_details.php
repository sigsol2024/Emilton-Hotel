<?php
/**
 * Room Details Page - Dynamic Content
 * Peregrine Hotel Rayfield
 */

require_once __DIR__ . '/includes/content-loader.php';

// Get room slug from URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: rooms_&_suites.php');
    exit;
}

// Load room by slug
$room = getRoomBySlug($slug);

if (!$room) {
    header('Location: rooms_&_suites.php');
    exit;
}

// Load site settings
$siteName = getSiteSetting('site_name', 'Peregrine Hotel Rayfield');
$currencySymbol = getSiteSetting('currency_symbol', '₦');
$whatsappLink = getSiteSetting('whatsapp_link', '#');
$contactPhone = getSiteSetting('footer_phone', '+234 800 123 4567');

// Process room data
$mainImage = !empty($room['main_image']) ? $room['main_image'] : '';
if ($mainImage && strpos($mainImage, 'http') !== 0) {
    $mainImage = (defined('SITE_URL') ? SITE_URL : '') . ltrim($mainImage, '/');
}

$galleryImages = is_array($room['gallery_images'] ?? null) ? $room['gallery_images'] : json_decode($room['gallery_images'] ?? '[]', true);
if (empty($galleryImages) && !empty($mainImage)) {
    $galleryImages = [$mainImage];
}

$features = is_array($room['features'] ?? null) ? $room['features'] : json_decode($room['features'] ?? '[]', true);
$amenities = is_array($room['amenities'] ?? null) ? $room['amenities'] : json_decode($room['amenities'] ?? '[]', true);
$goodToKnow = is_array($room['good_to_know'] ?? null) ? $room['good_to_know'] : json_decode($room['good_to_know'] ?? '{}', true);

$ratingDisplay = !empty($room['rating_score']) ? number_format((float)$room['rating_score'], 1) : '';
$originalPrice = !empty($room['original_price']) ? number_format((float)$room['original_price'], 0) : null;
$displayPrice = number_format((float)$room['price'], 0);
$bookUrl = !empty($room['book_url']) ? $room['book_url'] : $whatsappLink;

// Load other rooms for suggestions (exclude current room)
$otherRooms = getRooms(['is_active' => 1]);
$otherRooms = array_filter($otherRooms, function($r) use ($room) {
    return $r['id'] != $room['id'];
});
$suggestedRooms = array_slice($otherRooms, 0, 3);
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= e($room['title']) ?> - <?= e($siteName) ?></title>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;family=Noto+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
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
                        "text-secondary": "#4e6797",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
</head>
<body class="bg-white dark:bg-background-dark text-text-main font-display antialiased selection:bg-primary/20">
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-20 mt-20">
<!-- Breadcrumbs -->
<nav class="flex items-center gap-2 text-sm text-text-secondary mb-6">
<a class="hover:text-amber-700 transition-colors" href="index.php">Home</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<a class="hover:text-amber-700 transition-colors" href="rooms_&_suites.php">Rooms</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="text-text-main font-semibold"><?= e($room['title']) ?></span>
</nav>

<!-- Page Heading & Rating -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
<div class="max-w-2xl">
<h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-text-main mb-3"><?= e($room['title']) ?></h1>
</div>
<?php if ($ratingDisplay !== ''): ?>
<div class="flex items-center gap-2 bg-background-light px-3 py-1.5 rounded-full">
<span class="material-symbols-outlined text-amber-700 fill-current text-sm">star</span>
<span class="text-sm font-bold text-text-main"><?= e($ratingDisplay) ?></span>
</div>
<?php endif; ?>
</div>

<!-- Gallery Section -->
<div class="space-y-4 mb-12">
<!-- Main Image -->
<div class="w-full h-[400px] md:h-[540px] rounded-xl overflow-hidden shadow-sm relative group cursor-pointer">
<div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('<?= e($mainImage) ?>');">
</div>
<?php if (count($galleryImages) > 1): ?>
<div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-bold shadow-sm">
<span class="material-symbols-outlined text-[20px]">grid_view</span>
View all photos (<?= count($galleryImages) ?>)
</div>
<?php endif; ?>
</div>
<!-- Thumbnails -->
<?php if (count($galleryImages) > 1): ?>
<div class="grid grid-cols-4 gap-3 md:gap-4">
<?php foreach (array_slice($galleryImages, 0, 4) as $idx => $img): 
    $imgUrl = $img;
    if ($imgUrl && strpos($imgUrl, 'http') !== 0) {
        $imgUrl = (defined('SITE_URL') ? SITE_URL : '') . ltrim($imgUrl, '/');
    }
    $isLast = $idx === 3 && count($galleryImages) > 4;
?>
<div class="aspect-[4/3] rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity relative">
<div class="w-full h-full bg-cover bg-center" style="background-image: url('<?= e($imgUrl) ?>');"></div>
<?php if ($isLast): ?>
<div class="absolute inset-0 flex items-center justify-center bg-black/20 text-white font-bold text-lg backdrop-blur-[1px]">
+<?= count($galleryImages) - 4 ?>
</div>
<?php endif; ?>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>

<!-- Main Content Split -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 relative">
<!-- Left Column: Details -->
<div class="lg:col-span-8 flex flex-col gap-10">
<!-- Description -->
<?php if (!empty($room['description'])): ?>
<section>
<h3 class="text-2xl font-bold text-text-main mb-4">About this <?= e($room['room_type'] ?: 'room') ?></h3>
<div class="text-text-secondary leading-relaxed space-y-4 text-base md:text-lg font-light">
<?= nl2br(e($room['description'])) ?>
</div>
</section>
<hr class="border-[#e7ebf3]"/>
<?php endif; ?>

<!-- Key Highlights -->
<?php if (!empty($features) || !empty($room['size']) || !empty($room['max_guests'])): ?>
<section>
<h3 class="text-xl font-bold text-text-main mb-6">Room Highlights</h3>
<div class="grid grid-cols-2 md:grid-cols-3 gap-6">
<?php if (!empty($room['size'])): ?>
<div class="flex items-start gap-3 p-4 rounded-xl bg-background-light">
<span class="material-symbols-outlined text-amber-700 text-2xl">square_foot</span>
<div>
<p class="text-xs text-text-secondary uppercase tracking-wider font-semibold">Size</p>
<p class="font-bold text-text-main"><?= e($room['size']) ?></p>
</div>
</div>
<?php endif; ?>
<?php if (!empty($room['room_type'])): ?>
<div class="flex items-start gap-3 p-4 rounded-xl bg-background-light">
<span class="material-symbols-outlined text-amber-700 text-2xl">bed</span>
<div>
<p class="text-xs text-text-secondary uppercase tracking-wider font-semibold">Room Type</p>
<p class="font-bold text-text-main"><?= e($room['room_type']) ?></p>
</div>
</div>
<?php endif; ?>
<?php if (!empty($room['max_guests'])): ?>
<div class="flex items-start gap-3 p-4 rounded-xl bg-background-light">
<span class="material-symbols-outlined text-amber-700 text-2xl">group</span>
<div>
<p class="text-xs text-text-secondary uppercase tracking-wider font-semibold">Occupancy</p>
<p class="font-bold text-text-main">Up to <?= e($room['max_guests']) ?> <?= $room['max_guests'] == 1 ? 'Guest' : 'Guests' ?></p>
</div>
</div>
<?php endif; ?>
<?php foreach (array_slice($features, 0, 3) as $feature): ?>
<div class="flex items-start gap-3 p-4 rounded-xl bg-background-light">
<span class="material-symbols-outlined text-amber-700 text-2xl">check_circle</span>
<div>
<p class="text-xs text-text-secondary uppercase tracking-wider font-semibold">Feature</p>
<p class="font-bold text-text-main"><?= e($feature) ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</section>
<hr class="border-[#e7ebf3]"/>
<?php endif; ?>

<!-- Amenities -->
<?php if (!empty($amenities)): ?>
<section>
<h3 class="text-xl font-bold text-text-main mb-6">Amenities</h3>
<div class="grid grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-4">
<?php foreach ($amenities as $amenity): 
    $icon = is_array($amenity) ? ($amenity['icon'] ?? 'check_circle') : 'check_circle';
    $title = is_array($amenity) ? ($amenity['title'] ?? '') : $amenity;
    $description = is_array($amenity) ? ($amenity['description'] ?? '') : '';
?>
<div class="flex items-center gap-3 text-text-secondary">
<span class="material-symbols-outlined text-[20px]"><?= e($icon) ?></span>
<div>
<span class="font-medium"><?= e($title) ?></span>
<?php if ($description): ?>
<p class="text-xs text-text-secondary mt-0.5"><?= e($description) ?></p>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</section>
<hr class="border-[#e7ebf3]"/>
<?php endif; ?>

<!-- Good to Know -->
<?php if (!empty($goodToKnow) && (isset($goodToKnow['check_in']) || isset($goodToKnow['check_out']) || isset($goodToKnow['pets']))): ?>
<section>
<h3 class="text-xl font-bold text-text-main mb-6">Good to Know</h3>
<div class="space-y-4">
<?php if (!empty($goodToKnow['check_in'])): ?>
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-amber-700">schedule</span>
<div>
<p class="font-bold text-text-main">Check-in</p>
<p class="text-text-secondary"><?= e($goodToKnow['check_in']) ?></p>
</div>
</div>
<?php endif; ?>
<?php if (!empty($goodToKnow['check_out'])): ?>
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-amber-700">schedule</span>
<div>
<p class="font-bold text-text-main">Check-out</p>
<p class="text-text-secondary"><?= e($goodToKnow['check_out']) ?></p>
</div>
</div>
<?php endif; ?>
<?php if (!empty($goodToKnow['pets'])): ?>
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-amber-700">pets</span>
<div>
<p class="font-bold text-text-main">Pets Policy</p>
<p class="text-text-secondary"><?= e($goodToKnow['pets']) ?></p>
</div>
</div>
<?php endif; ?>
</div>
</section>
<?php endif; ?>
</div>

<!-- Right Column: Sticky Booking Card -->
<div class="lg:col-span-4 relative">
<div class="sticky top-24">
<div class="bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-[#e7ebf3] overflow-hidden p-6">
<!-- Header -->
<div class="flex items-end justify-between mb-6">
<div>
<span class="text-xs font-semibold text-text-secondary uppercase">Starting from</span>
<div class="flex items-baseline gap-1">
<?php if ($originalPrice): ?>
<span class="text-lg line-through text-text-secondary"><?= e($currencySymbol) ?><?= e($originalPrice) ?></span>
<?php endif; ?>
<span class="text-3xl font-bold text-text-main"><?= e($currencySymbol) ?><?= e($displayPrice) ?></span>
<span class="text-text-secondary font-medium">/ night</span>
</div>
<?php if ($originalPrice): ?>
<p class="text-xs text-green-600 font-semibold mt-1">Save <?= e($currencySymbol) ?><?= number_format((float)$originalPrice - (float)$room['price'], 0) ?> per night</p>
<?php endif; ?>
<?php if (!empty($room['urgency_message'])): ?>
<p class="text-xs text-red-600 font-semibold mt-1"><?= e($room['urgency_message']) ?></p>
<?php endif; ?>
</div>
</div>
<!-- Form -->
<div class="flex flex-col gap-4">
<!-- Date Inputs -->
<div class="grid grid-cols-2 gap-3">
<div class="flex flex-col gap-1.5">
<label class="text-xs font-bold text-text-main uppercase tracking-wide">Check-in</label>
<input class="w-full bg-background-light border-0 rounded-lg py-2.5 px-3 text-sm font-medium text-text-main focus:ring-2 focus:ring-primary/20 cursor-pointer" type="date" name="checkin"/>
</div>
<div class="flex flex-col gap-1.5">
<label class="text-xs font-bold text-text-main uppercase tracking-wide">Check-out</label>
<input class="w-full bg-background-light border-0 rounded-lg py-2.5 px-3 text-sm font-medium text-text-main focus:ring-2 focus:ring-primary/20 cursor-pointer" type="date" name="checkout"/>
</div>
</div>
<!-- Guest Input -->
<div class="flex flex-col gap-1.5">
<label class="text-xs font-bold text-text-main uppercase tracking-wide">Guests</label>
<select class="w-full appearance-none bg-background-light border-0 rounded-lg py-3 pl-3 pr-10 text-sm font-medium text-text-main focus:ring-2 focus:ring-primary/20 cursor-pointer">
<?php for ($i = 1; $i <= max(4, (int)($room['max_guests'] ?? 2)); $i++): ?>
<option value="<?= $i ?>" <?= $i == 2 ? 'selected' : '' ?>><?= $i ?> <?= $i == 1 ? 'Adult' : 'Adults' ?></option>
<?php endfor; ?>
</select>
</div>
<!-- CTA -->
<a href="<?= e($bookUrl) ?>" target="_blank" class="w-full bg-[#3f3f3f] hover:bg-[#2a2a2a] text-white font-bold text-base py-3.5 rounded-lg shadow-lg transition-all active:scale-[0.98] flex items-center justify-center gap-2">
<span>Book Now</span>
<span class="material-symbols-outlined text-sm">arrow_forward</span>
</a>
<p class="text-center text-xs text-text-secondary mt-1">You won't be charged yet</p>
</div>
</div>
<!-- Help Box -->
<div class="mt-6 bg-background-light rounded-lg p-4 flex items-center gap-3">
<div class="size-10 rounded-full bg-white flex items-center justify-center shrink-0 text-amber-700">
<span class="material-symbols-outlined">support_agent</span>
</div>
<div>
<p class="text-sm font-bold text-text-main">Need help booking?</p>
<p class="text-xs text-text-secondary">Call our concierge at <a class="underline hover:text-amber-700" href="tel:<?= e($contactPhone) ?>"><?= e($contactPhone) ?></a></p>
</div>
</div>
</div>
</div>
</div>

<!-- Suggested Rooms Section -->
<?php if (!empty($suggestedRooms)): ?>
<div class="mt-24">
<div class="flex items-center justify-between mb-8">
<h2 class="text-2xl font-bold text-text-main">Other rooms you might like</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<?php foreach ($suggestedRooms as $suggested): 
    $sugImage = !empty($suggested['main_image']) ? $suggested['main_image'] : '';
    if ($sugImage && strpos($sugImage, 'http') !== 0) {
        $sugImage = (defined('SITE_URL') ? SITE_URL : '') . ltrim($sugImage, '/');
    }
    $sugBadge = !empty($suggested['is_featured']) ? 'Best Seller' : '';
?>
<div class="group bg-white rounded-xl overflow-hidden border border-[#e7ebf3] hover:shadow-lg transition-all duration-300 flex flex-col">
<div class="aspect-[16/10] overflow-hidden relative">
<div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('<?= e($sugImage) ?>');">
</div>
<?php if ($sugBadge): ?>
<div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-text-main shadow-sm">
<?= e($sugBadge) ?>
</div>
<?php endif; ?>
</div>
<div class="p-5 flex flex-col flex-1">
<div class="flex justify-between items-start mb-2">
<h3 class="text-lg font-bold text-text-main group-hover:text-amber-700 transition-colors"><?= e($suggested['title']) ?></h3>
</div>
<?php if (!empty($suggested['short_description'])): ?>
<p class="text-sm text-text-secondary line-clamp-2 mb-4"><?= e($suggested['short_description']) ?></p>
<?php endif; ?>
<div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-4">
<div>
<span class="text-xs text-text-secondary block">From</span>
<span class="font-bold text-text-main"><?= e($currencySymbol) ?><?= number_format((float)($suggested['price'] ?? 0), 0) ?> <span class="text-sm font-normal text-text-secondary">/ night</span></span>
</div>
<a class="text-sm font-bold text-amber-700 hover:underline" href="room_details.php?slug=<?= e($suggested['slug']) ?>">View details</a>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
