<?php
/**
 * About Us Page - Dynamic Content
 * Peregrine Hotel Rayfield
 */

require_once __DIR__ . '/includes/content-loader.php';

// Load site settings
$siteName = getSiteSetting('site_name', 'Peregrine Hotel Rayfield');

// Load page sections
$pageSubtitle = getPageSection('about', 'page_subtitle', 'About Peregrine Hotel');
$heroTitle = getPageSection('about', 'hero_title', 'The Essence of');
$heroTitleItalic = getPageSection('about', 'hero_title_italic', 'Rayfield Luxury');
$heroBackground = getPageSection('about', 'hero_background', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBTf78SDLBYRls1ySmKF4WsCAN-qDa13xSezqXFEbPdgfNaAW8L5dxckdgCczLiYlMG46wFqh-jR60JPMyjP8gFRiLZ__fMcBEj_DieB42pe8T9tF0P0u412FPC34nTB5vh5Sfx8RDM4gTgLF610c5oEefiOcOiYLEcMX1yvB89Lg2U8Fu5eKKDL_wxOZ3cnPdAHaWcs9XY9b1d7lTY7Mm_S1vAxnrl38T3zZLEmbO2BfmgNvJDhZzJ5B6yYB4a42GZ8y-HvUDChII');

$introQuote = getPageSection('about', 'intro_quote', '"We believe luxury is found in the quiet moments of perfect service, where every detail is curated for your peace of mind."');

$storyLabel = getPageSection('about', 'story_label', 'Our Origins');
$storyTitle = getPageSection('about', 'story_title', 'A Legacy of Hospitality');
$storyDescription1 = getPageSection('about', 'story_description_1', 'Founded on the principles of timeless elegance and local warmth, Peregrine Hotel brings world-class standards to the serene district of Rayfield. Our story is one of passion for detail and a commitment to redefining luxury in Jos.');
$storyDescription2 = getPageSection('about', 'story_description_2', 'Every corner of our establishment whispers a tale of dedication, designed to be a sanctuary for the discerning traveler seeking refuge and refinement.');
$storyImage = getPageSection('about', 'story_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAksFHXWWphepg4poMtCBNPzUBinkVYyEL87iw-tqz3AlPDoSKyN0aGmbjB00HfKKb2-7XXwh9YFhuEv-su8Lvb3bSa2lEwMl9zybSCqU2gk7bMDmerifblKxykfpvlgAZYYphbsvzkhwU-xW9PX_RmK2tKf8gnO1yD-LCQlsynB8Lr1qKNnUv8zoGrT0_rQCIVdMh1KeqY_sq5rNMaMHrUGwXmEJ-BoifLu6aH-yQJzBd7x9jgQfry_G_N6wGAVYOm3KWPDmUSNtk');

$boulevardLabel = getPageSection('about', 'boulevard_label', 'Boulevard Group');
$boulevardTitle = getPageSection('about', 'boulevard_title', 'Boulevard Connection');
$boulevardDescription = getPageSection('about', 'boulevard_description', 'As a proud member of the Boulevard Hotel Group family, we inherit a tradition of excellence that spans decades. This affiliation ensures that while our character remains uniquely local, our standards are globally recognized.');
$boulevardImage = getPageSection('about', 'boulevard_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC0WGC-WMnb65iH0ib4osE0z12xpuMmo9c3Vlqbmyc7_B_KnzhJhSJNuXw5cmeAqn1qCY_yWriMOXSteNKN0G86P2qN29BWPOM73KuLwrPtF4BqOrVqLGIJE6GBnmFLaj6EVQnb5s1sOXOrUa11-MJ2BFp2ZwoSF1aDeKEjJOcbO6Mpq4HLVI6m4j04ETAvI96t-Kgd5WWyM7YIz3h0rcFrHO4vLF3FID-bisEY04Dxxjm1Jt4K7EJy1I3QsCZyQldadfeW8CichZE');

$locationTitle = getPageSection('about', 'location_title', 'In the Heart of Rayfield');
$locationDescription = getPageSection('about', 'location_description', 'Located in the most secure and serene district of Jos, Peregrine Hotel offers a peaceful retreat from the city\'s bustle while remaining conveniently close to key landmarks.');
$googleMapsApiKey = getSiteSetting('google_maps_api_key', '');
// Get map address from page section, or fall back to footer address from site settings (strip HTML tags)
$mapAddressFromPage = getPageSection('about', 'map_address', '');
$footerAddress = getSiteSetting('footer_address', '12 Rayfield Avenue, Jos, Plateau State, Nigeria');
// Clean footer address (remove HTML tags and <br/> tags, replace with commas)
$footerAddressClean = strip_tags(str_replace(['<br/>', '<br>', '<br />'], ', ', $footerAddress));
$mapAddress = !empty($mapAddressFromPage) ? $mapAddressFromPage : $footerAddressClean;

$galleryTitle = getPageSection('about', 'gallery_title', 'Designed for Tranquility');
$gallerySubtitle = getPageSection('about', 'gallery_subtitle', 'A glimpse into our aesthetic.');
$galleryImage1 = getPageSection('about', 'gallery_image_1', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDCkCeP7g4Dy8vikL6iWaGdUfpeiDSGmAuI1TbcKwZ1XaTU59JRFuVIWuFXPiDm0dJsCQsGToWf7FkGVP0_DPxO0jm8cc8SK0PVZYG_h6UJ0sf-hP5Ks73Li7bsUt7Z--gAe_4KTz2nvPsDp1v_x_JrgFqfGlgY0llAFbrukqpqEEaUCSozcTCmy7MK39cJhPjcXJ1xQzrm-tJVJCEoRZ9TsX_ztFbbdGbk4GXC6mpTAAnJzGwUQXDxtJb8cX0YVKtvc4PEjHjBfV4');
$galleryImage2 = getPageSection('about', 'gallery_image_2', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBQYHROmYzBpxOeOD3AYkKrH5sOVUvjAwQ_nD_29Rxzu9G6d0BWQmpq7XCKn8VjJZA23rA8xuNOY1ZnCyHDfy-GbihzEIS1v9ZDixMtJovu5pRGK7MRiZOsoz0F9xcnBJKJlNy-sn5OSk7bUXTeXVkuvhl9dWOshU-8cLJ_NguD6LcF2DNPDH679_QA_QolMMvBjmJeFnd180lduCfNJZshAW8NEq6Qiho2xXXO-PNnDKKcILAT10cp-IXBtgQ89C5ntpTcqaHYjCA');
$galleryImage3 = getPageSection('about', 'gallery_image_3', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_Bo9tfEtOKvkdOWIML9xfH78nzBOu_WVObwHMsfhf5WfSOKwSeuNKZTmaaSKA4EB8SkxbA9P6Be-8iSgRzMNXWSSQY5CpBUMTRqgi98MXai_-czHGwQP0xfZGMwVeXHj_zWpy6aLHxlnZguAaE3GC25YtTKSyTQUJnzp5TvnKWEs-ddUyFJleWF6qD7oQ7crJtCr0-sDlVnn8QUHueV3_YnQpra9OMfeeSCNxgIMaRi9XkvHqF0LMUGhPPXb5cvB0F6-F7x7py5A');
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>About Us - <?= e($siteName) ?></title>
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
        
        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .slide-in-right {
            animation: slideInFromRight 0.8s ease-out forwards;
            opacity: 0;
        }
    </style>
</head>
<body class="bg-white dark:bg-background-dark text-text-main antialiased selection:bg-primary/20 selection:text-primary">
<?php require_once __DIR__ . '/includes/header.php'; ?>

<!-- Hero Section -->
<div class="relative w-full h-[60vh] min-h-[500px] flex items-center justify-center bg-black mt-20">
<div class="absolute inset-0 w-full h-full bg-cover bg-center" style="background-image: url('<?= e($heroBackground) ?>');">
</div>
<div class="absolute inset-0 bg-black/40 bg-gradient-to-t from-black/80 to-transparent"></div>
<div class="relative z-10 flex flex-col items-center text-center px-4 max-w-4xl mx-auto animate-fade-in-up">
<h2 class="text-white/90 text-sm md:text-base font-medium tracking-[0.2em] uppercase mb-4"><?= e($pageSubtitle) ?></h2>
<h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-serif font-medium leading-tight mb-8">
    <?= e($heroTitle) ?> <br/><span class="italic"><?= e($heroTitleItalic) ?></span>
</h1>
<?php 
$videoButtonText = getPageSection('about', 'video_button_text', 'Play Experience Video');
$videoButtonUrl = getPageSection('about', 'video_button_url', '#');
?>
<button class="group flex items-center gap-3 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 rounded-full pl-2 pr-6 py-2 transition-all duration-300" onclick="openVideoModal('<?= e($videoButtonUrl) ?>')">
<div class="bg-white text-amber-500 rounded-full p-2 flex items-center justify-center">
<span class="material-symbols-outlined text-xl text-amber-500">play_arrow</span>
</div>
<span class="text-white text-sm font-semibold tracking-wide"><?= e($videoButtonText) ?></span>
</button>
</div>
</div>

<!-- Main Content -->
<main class="flex flex-col w-full bg-white">
<!-- Intro Text -->
<div class="max-w-4xl mx-auto px-6 py-24 text-center">
<h2 class="font-serif text-3xl md:text-4xl text-text-main leading-relaxed mb-6">
    <?= e($introQuote) ?>
</h2>
<div class="w-16 h-0.5 bg-amber-500/30 mx-auto"></div>
</div>

<!-- Story Section (ZigZag) -->
<div class="max-w-7xl mx-auto px-6 lg:px-8 pb-24 flex flex-col gap-24 md:gap-32">
<!-- Item 1 -->
<div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-center">
<div class="order-2 md:order-1 flex flex-col gap-6">
<div class="flex items-center gap-3 text-amber-500 mb-2">
<span class="material-symbols-outlined text-amber-500">history_edu</span>
<span class="text-sm font-bold tracking-wider uppercase"><?= e($storyLabel) ?></span>
</div>
<h3 class="text-3xl md:text-4xl font-bold text-text-main"><?= e($storyTitle) ?></h3>
<p class="text-text-muted text-lg leading-relaxed">
    <?= e($storyDescription1) ?>
</p>
<p class="text-text-muted text-lg leading-relaxed">
    <?= e($storyDescription2) ?>
</p>
</div>
<div class="order-1 md:order-2 relative group">
<div class="absolute -inset-4 bg-amber-500/5 rounded-2xl -z-10 transform rotate-2 transition-transform group-hover:rotate-1"></div>
<div class="aspect-[4/3] rounded-xl overflow-hidden shadow-lg">
<div class="w-full h-full bg-cover bg-center hover:scale-105 transition-transform duration-700" style="background-image: url('<?= e($storyImage) ?>');"></div>
</div>
</div>
</div>

<!-- Item 2 -->
<div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-center">
<div class="order-1 relative group">
<div class="absolute -inset-4 bg-amber-500/5 rounded-2xl -z-10 transform -rotate-2 transition-transform group-hover:-rotate-1"></div>
<div class="aspect-[4/3] rounded-xl overflow-hidden shadow-lg">
<div class="w-full h-full bg-cover bg-center hover:scale-105 transition-transform duration-700" style="background-image: url('<?= e($boulevardImage) ?>');"></div>
</div>
</div>
<div class="order-2 flex flex-col gap-6">
<div class="flex items-center gap-3 text-amber-500 mb-2">
<span class="material-symbols-outlined text-amber-500">apartment</span>
<span class="text-sm font-bold tracking-wider uppercase"><?= e($boulevardLabel) ?></span>
</div>
<h3 class="text-3xl md:text-4xl font-bold text-text-main"><?= e($boulevardTitle) ?></h3>
<p class="text-text-muted text-lg leading-relaxed">
    <?= e($boulevardDescription) ?>
</p>
<ul class="flex flex-col gap-3 mt-2">
<li class="flex items-center gap-3 text-text-main font-medium">
<span class="material-symbols-outlined text-amber-500 text-xl">check_circle</span>
    Global Standards of Service
</li>
<li class="flex items-center gap-3 text-text-main font-medium">
<span class="material-symbols-outlined text-amber-500 text-xl">check_circle</span>
    Exclusive Member Benefits
</li>
<li class="flex items-center gap-3 text-text-main font-medium">
<span class="material-symbols-outlined text-amber-500 text-xl">check_circle</span>
    Award-Winning Hospitality
</li>
</ul>
</div>
</div>
</div>

<!-- Location Section -->
<section class="bg-background-light py-24">
<div class="max-w-7xl mx-auto px-6 lg:px-8">
<div class="grid lg:grid-cols-12 gap-12 items-start">
<!-- Text Side -->
<div class="lg:col-span-5 flex flex-col justify-center h-full gap-8">
<div>
<h2 class="text-3xl md:text-4xl font-bold text-text-main mb-4"><?= e($locationTitle) ?></h2>
<p class="text-text-muted text-lg leading-relaxed">
    <?= e($locationDescription) ?>
</p>
</div>
<div class="space-y-6">
<div class="flex gap-4">
<div class="bg-white p-3 rounded-lg shadow-sm h-fit text-amber-500">
<span class="material-symbols-outlined text-amber-500">security</span>
</div>
<div>
<h4 class="font-bold text-text-main text-lg">Secure &amp; Serene</h4>
<p class="text-text-muted text-sm mt-1">Rayfield is known for its tranquility and high-level security, perfect for business and leisure.</p>
</div>
</div>
<div class="flex gap-4">
<div class="bg-white p-3 rounded-lg shadow-sm h-fit text-amber-500">
<span class="material-symbols-outlined text-amber-500">golf_course</span>
</div>
<div>
<h4 class="font-bold text-text-main text-lg">Leisure Nearby</h4>
<p class="text-text-muted text-sm mt-1">Minutes away from the Rayfield Golf Club and the scenic Rayfield Resort.</p>
</div>
</div>
</div>
<?php 
$directionsText = getPageSection('about', 'location_directions_text', 'Get Directions');
$directionsLink = getPageSection('about', 'location_directions_link', 'contact_us.php');
?>
<a href="<?= e($directionsLink) ?>" class="w-fit text-amber-500 font-bold text-sm flex items-center gap-2 hover:gap-3 transition-all mt-4">
    <?= e($directionsText) ?> <span class="material-symbols-outlined text-lg">arrow_forward</span>
</a>
</div>
<!-- Map Side -->
<div class="lg:col-span-7 w-full h-[450px] bg-white p-2 rounded-2xl shadow-sm border border-slate-200">
<div class="w-full h-full rounded-xl overflow-hidden relative bg-slate-100">
<?php if (!empty($googleMapsApiKey) && !empty($mapAddress)): ?>
<iframe 
    id="googleMap"
    class="w-full h-full rounded-xl"
    frameborder="0"
    style="border:0"
    allowfullscreen
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
    src="https://www.google.com/maps/embed/v1/place?key=<?= e($googleMapsApiKey) ?>&q=<?= urlencode($mapAddress) ?>">
</iframe>
<?php else: ?>
<div class="w-full h-full flex items-center justify-center bg-slate-200 rounded-xl">
<div class="text-center p-8">
<div class="bg-amber-500 text-white p-4 rounded-full shadow-lg mx-auto mb-4 w-fit">
<span class="material-symbols-outlined text-4xl">location_on</span>
</div>
<p class="text-text-muted font-medium">Map address not configured</p>
<p class="text-text-muted text-sm mt-2">Please add a map address in the page editor or configure Google Maps API key in Settings</p>
</div>
</div>
<?php endif; ?>
</div>
</div>
</div>
</div>
</section>

<!-- Image Grid / Philosophy Visuals -->
<section id="gallery-section" class="py-20 px-4 sm:px-6 lg:px-8 bg-white relative overflow-hidden">
<!-- Background Image -->
<div class="absolute inset-0 z-0">
    <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://peregrinehoteljos.com/assets/uploads/img_696fb5b1e5fc16.89999379.png');"></div>
</div>
<!-- White Overlay -->
<div class="absolute inset-0 z-10 bg-white/70"></div>
<!-- Content -->
<div class="relative z-20 mx-auto max-w-6xl">
<div class="text-center mb-12">
<h3 class="text-2xl font-bold text-text-main"><?= e($galleryTitle) ?></h3>
<p class="text-text-muted mt-2"><?= e($gallerySubtitle) ?></p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-3 h-auto md:h-96 md:justify-items-center">
<div class="gallery-image md:col-span-1 h-64 md:h-full w-full md:w-[220px] lg:w-[260px] rounded-lg overflow-hidden relative group">
<div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('<?= e($galleryImage1) ?>');"></div>
<div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors duration-300"></div>
</div>
<div class="gallery-image md:col-span-1 h-64 md:h-full w-full md:w-[220px] lg:w-[260px] rounded-lg overflow-hidden relative group">
<div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('<?= e($galleryImage2) ?>');"></div>
<div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors duration-300"></div>
</div>
<div class="gallery-image md:col-span-1 h-64 md:h-full w-full md:w-[220px] lg:w-[260px] rounded-lg overflow-hidden relative group">
<div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('<?= e($galleryImage3) ?>');"></div>
<div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors duration-300"></div>
</div>
</div>
</div>
</section>
</main>

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 z-[9999] bg-black/90 backdrop-blur-sm hidden items-center justify-center p-4" onclick="closeVideoModal()">
<div class="relative w-full max-w-6xl max-h-[90vh] bg-black rounded-xl overflow-hidden" onclick="event.stopPropagation()">
<button onclick="closeVideoModal()" class="absolute top-4 right-4 z-10 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white rounded-full p-2 transition-all">
<span class="material-symbols-outlined text-2xl">close</span>
</button>
<div class="relative w-full" style="padding-bottom: 56.25%;">
<iframe id="videoFrame" class="absolute top-0 left-0 w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
</div>
</div>

<script>
// Gallery images scroll-triggered animation
(function() {
    const gallerySection = document.getElementById('gallery-section');
    const galleryImages = document.querySelectorAll('.gallery-image');
    
    if (!gallerySection || galleryImages.length === 0) return;
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                // Add animation classes with staggered delays
                galleryImages.forEach(function(img, index) {
                    setTimeout(function() {
                        img.classList.add('slide-in-right');
                        img.style.animationDelay = (index * 0.2) + 's';
                    }, 50);
                });
                // Stop observing after animation triggers
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2 // Trigger when 20% of section is visible
    });
    
    observer.observe(gallerySection);
})();

function openVideoModal(videoUrl) {
    const modal = document.getElementById('videoModal');
    const frame = document.getElementById('videoFrame');
    
    // Extract YouTube video ID from URL
    let embedUrl = videoUrl;
    if (videoUrl.includes('youtube.com/watch?v=')) {
        const videoId = videoUrl.split('v=')[1]?.split('&')[0];
        embedUrl = `https://www.youtube.com/embed/${videoId}`;
    } else if (videoUrl.includes('youtu.be/')) {
        const videoId = videoUrl.split('youtu.be/')[1]?.split('?')[0];
        embedUrl = `https://www.youtube.com/embed/${videoId}`;
    } else if (videoUrl.includes('youtube.com/embed/')) {
        embedUrl = videoUrl;
    } else if (videoUrl && !videoUrl.startsWith('http')) {
        embedUrl = `https://www.youtube.com/embed/${videoUrl}`;
    }
    
    frame.src = embedUrl;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    const modal = document.getElementById('videoModal');
    const frame = document.getElementById('videoFrame');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    frame.src = '';
    document.body.style.overflow = '';
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoModal();
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
