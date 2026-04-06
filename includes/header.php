<?php
/**
 * Site Header Template
 * Modern Tailwind CSS-based responsive header
 * This file assumes content-loader.php has already been included
 */

// Ensure content-loader functions are available
if (!function_exists('getSiteSetting')) {
    // If functions don't exist, try to load content-loader.php
    $contentLoaderPath = __DIR__ . '/content-loader.php';
    if (file_exists($contentLoaderPath)) {
        require_once $contentLoaderPath;
    } else {
        // Fallback functions if content-loader.php doesn't exist
        function getSiteSetting($key, $default = '') { return $default; }
        function getRooms($filters = []) { return []; }
        function e($string) { return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8'); }
    }
}

// Ensure site settings are loaded
if (!isset($siteName)) {
    $siteName = function_exists('getSiteSetting') ? getSiteSetting('site_name', 'LUXE HOTEL') : 'LUXE HOTEL';
}
if (!isset($siteLogo)) {
    $siteLogo = function_exists('getSiteSetting') ? getSiteSetting('site_logo', 'assets/img/logo1.png') : 'assets/img/logo1.png';
}
if (!isset($whatsappLink)) {
    $whatsappLink = function_exists('getSiteSetting') ? getSiteSetting('whatsapp_link', '#') : '#';
}

// Get all rooms for menu
$allRooms = function_exists('getRooms') ? getRooms(['is_active' => 1, 'limit' => 10]) : [];

// Get feature images for Facility mega menu
$restaurantFeatureImage = function_exists('getPageSection') ? getPageSection('restaurant', 'feature_image', '') : '';
$barFeatureImage = function_exists('getPageSection') ? getPageSection('bar', 'feature_image', '') : '';
$swimmingPoolFeatureImage = function_exists('getPageSection') ? getPageSection('swimming-pool', 'feature_image', '') : '';

// Extract logo text from site name
$logoParts = explode(' ', $siteName);
$logoMain = $logoParts[0] ?? 'LUXE';
$logoSecondary = isset($logoParts[1]) ? implode(' ', array_slice($logoParts, 1)) : 'HOTEL';

// Track if header styles have been loaded (prevent duplicate loading)
static $headerStylesLoaded = false;
if (!$headerStylesLoaded) {
    $headerStylesLoaded = true;
    echo '<style id="header-styles">
    /* Scoped styles to prevent conflicts */
    .site-header-wrapper {
        font-family: "Plus Jakarta Sans", sans-serif;
    }
    
    /* Custom scrollbar for mobile menu */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Smooth fade for mega menu */
    .mega-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px) translateX(-50%);
        transition: all 0.3s ease-in-out;
    }
    
    .group:hover .mega-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) translateX(-50%);
    }
    
    /* Ensure header stays above content */
    .site-header {
        z-index: 9999;
    }
    
    /* Header scroll effect - transparent by default */
    .site-header {
        background-color: transparent !important;
        border-bottom-color: transparent !important;
    }
    
    /* Exception: Room details page - always solid header */
    body.page-details .site-header,
    body.page-details .site-header:not(.scrolled) {
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(12px);
        border-bottom-color: rgb(226, 232, 240) !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    body.dark.page-details .site-header,
    body.dark.page-details .site-header:not(.scrolled) {
        background-color: rgba(16, 28, 34, 0.95) !important;
        border-bottom-color: rgb(30, 41, 59) !important;
    }
    
    .site-header.scrolled {
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(12px);
        border-bottom-color: rgb(226, 232, 240) !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    body.dark .site-header.scrolled {
        background-color: rgba(16, 28, 34, 0.95) !important;
        border-bottom-color: rgb(30, 41, 59) !important;
    }
    
    /* Text colors when header is transparent (at top) - WHITE */
    .site-header:not(.scrolled) h1,
    .site-header:not(.scrolled) .text-slate-900,
    .site-header:not(.scrolled) h1 span {
        color: white !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }
    
    /* Text colors for details page - always dark (not white) */
    body.page-details .site-header:not(.scrolled) h1,
    body.page-details .site-header:not(.scrolled) .text-slate-900,
    body.page-details .site-header:not(.scrolled) h1 span {
        color: rgb(15, 23, 42) !important;
        text-shadow: none !important;
    }
    
    .site-header:not(.scrolled) .nav-link,
    .site-header:not(.scrolled) .text-slate-600,
    .site-header:not(.scrolled) a.text-slate-600,
    .site-header:not(.scrolled) nav a,
    .site-header:not(.scrolled) button.nav-link {
        color: rgba(255, 255, 255, 0.95) !important;
    }
    
    body.page-details .site-header:not(.scrolled) .nav-link,
    body.page-details .site-header:not(.scrolled) .text-slate-600,
    body.page-details .site-header:not(.scrolled) a.text-slate-600,
    body.page-details .site-header:not(.scrolled) nav a,
    body.page-details .site-header:not(.scrolled) button.nav-link {
        color: rgb(51, 65, 85) !important;
    }
    
    .site-header:not(.scrolled) .text-slate-300 {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    
    .site-header:not(.scrolled) .header-action-btn,
    .site-header:not(.scrolled) .header-action-btn span {
        color: white !important;
    }
    
    body.page-details .site-header:not(.scrolled) .header-action-btn,
    body.page-details .site-header:not(.scrolled) .header-action-btn span {
        color: rgb(51, 65, 85) !important;
    }
    
    /* Hover states for transparent header navigation */
    .site-header:not(.scrolled) .nav-link:hover,
    .site-header:not(.scrolled) a.nav-link:hover,
    .site-header:not(.scrolled) nav a:hover,
    .site-header:not(.scrolled) button.nav-link:hover {
        color: rgba(255, 255, 255, 1) !important; /* Full white on hover when transparent */
    }
    
    .site-header:not(.scrolled) .header-divider {
        background-color: rgba(255, 255, 255, 0.3) !important;
    }
    
    /* Mobile menu button styling - transparent state */
    .site-header:not(.scrolled) .mobile-menu-btn {
        color: white !important;
    }
    
    body.page-details .site-header:not(.scrolled) .mobile-menu-btn {
        color: rgb(15, 23, 42) !important;
    }
    
    .site-header:not(.scrolled) .mobile-menu-btn:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    /* Text colors when header is scrolled (white background) - BLACK/DARK */
    .site-header.scrolled h1,
    .site-header.scrolled .text-slate-900,
    .site-header.scrolled h1 span {
        color: rgb(15, 23, 42) !important;
        text-shadow: none;
    }
    
    .site-header.scrolled .nav-link,
    .site-header.scrolled .text-slate-600,
    .site-header.scrolled a.text-slate-600,
    .site-header.scrolled nav a,
    .site-header.scrolled button.nav-link {
        color: rgb(51, 65, 85) !important;
    }
    
    .site-header.scrolled .header-action-btn,
    .site-header.scrolled .header-action-btn span {
        color: rgb(51, 65, 85) !important;
    }
    
    /* Hover states for scrolled header navigation */
    .site-header.scrolled .nav-link:hover,
    .site-header.scrolled a.nav-link:hover,
    .site-header.scrolled nav a:hover,
    .site-header.scrolled button.nav-link:hover {
        color: #C71C1C !important;
    }
    
    .site-header.scrolled .header-action-btn:hover,
    .site-header.scrolled .header-action-btn:hover span {
        color: #262161 !important;
    }
    
    .site-header.scrolled .header-divider {
        background-color: rgb(226, 232, 240) !important;
    }
    
    .site-header.scrolled .text-primary {
        color: #262161 !important;
    }
    
    /* Mobile menu button styling - scrolled state */
    .site-header.scrolled .mobile-menu-btn {
        color: rgb(15, 23, 42) !important;
    }
    
    .site-header.scrolled .mobile-menu-btn:hover {
        background-color: rgb(241, 245, 249);
    }
    
    /* Ensure mega menu text is always black (not affected by scroll state) */
    .site-header .mega-menu .text-slate-900,
    .site-header.scrolled .mega-menu .text-slate-900,
    .site-header:not(.scrolled) .mega-menu .text-slate-900,
    .site-header .mega-menu h3,
    .site-header.scrolled .mega-menu h3,
    .site-header:not(.scrolled) .mega-menu h3,
    .site-header .mega-menu h4,
    .site-header.scrolled .mega-menu h4,
    .site-header:not(.scrolled) .mega-menu h4,
    .site-header .mega-menu a.text-slate-900,
    .site-header.scrolled .mega-menu a.text-slate-900,
    .site-header:not(.scrolled) .mega-menu a.text-slate-900 {
        color: rgb(15, 23, 42) !important; /* Always black for titles/text */
        text-shadow: none !important; /* Remove text shadow */
    }
    
    .site-header .mega-menu .text-slate-400,
    .site-header.scrolled .mega-menu .text-slate-400,
    .site-header:not(.scrolled) .mega-menu .text-slate-400 {
        color: rgb(100, 116, 139) !important; /* Slate-400 color for headings */
        text-shadow: none !important; /* Remove text shadow */
    }
    
    /* Ensure hero section starts from top */
    .cs_hero {
        margin-top: -80px !important;
        padding-top: 80px !important;
    }
    
    /* Mobile sidebar - match reference design exactly */
    aside.fixed {
        font-family: "Plus Jakarta Sans", sans-serif;
    }
    
    aside h2 {
        font-size: 1.125rem !important;
        line-height: 1.75rem !important;
        font-weight: 700 !important;
    }
    
    aside .size-6 {
        width: 1.5rem !important;
        height: 1.5rem !important;
    }
    
    aside .material-symbols-outlined {
        font-size: 18px !important;
        width: 18px !important;
        height: 18px !important;
    }
    
    aside summary {
        padding: 0.75rem !important;
        font-size: 1rem !important;
        line-height: 1.5rem !important;
        font-weight: 700 !important;
    }
    
    aside summary .material-symbols-outlined {
        font-size: inherit !important;
    }
    
    aside a.flex.items-center {
        padding: 0.75rem !important;
        font-size: 1rem !important;
        line-height: 1.5rem !important;
        font-weight: 700 !important;
    }
    
    aside a.block {
        padding: 0.25rem 0 !important;
        font-size: 0.875rem !important;
        line-height: 1.25rem !important;
        font-weight: 500 !important;
    }
    
    aside .p-5 {
        padding: 1.25rem !important;
    }
    
    aside button.w-full,
    aside a.w-full.bg-primary {
        padding: 0.75rem 1rem !important;
        font-size: 1rem !important;
        line-height: 1.5rem !important;
        font-weight: 700 !important;
    }
    
    aside .space-y-2 > * + * {
        margin-top: 0.5rem !important;
    }
    
    aside .space-y-3 > * + * {
        margin-top: 0.75rem !important;
    }
    
    aside .gap-3 {
        gap: 0.75rem !important;
    }
    
    aside .gap-4 {
        gap: 1rem !important;
    }
    
    aside .mb-4 {
        margin-bottom: 1rem !important;
    }
    
    aside .px-2 {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
    
    /* Book Your Stay button - force primary color #262161 */
    .header-book-btn.bg-primary,
    button.bg-primary.w-full,
    aside button.bg-primary {
        background-color: #262161 !important;
    }
    
    .header-book-btn.bg-primary:hover,
    button.bg-primary.w-full:hover,
    aside button.bg-primary:hover {
        background-color: #C71C1C !important;
    }
    
    /* Shadow color for primary buttons */
    .shadow-primary\/20 {
        --tw-shadow-color: rgba(38, 33, 97, 0.2) !important;
        box-shadow: 0 10px 15px -3px rgba(38, 33, 97, 0.2), 0 4px 6px -4px rgba(38, 33, 97, 0.2) !important;
    }
</style>';
}
?>
<script>
// Header scroll effect
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.site-header');
    const isDetailsPage = window.location.pathname.includes('details.php');
    
    if (header) {
        function handleScroll() {
            // On details page, always keep header solid (scrolled state)
            if (isDetailsPage) {
                header.classList.add('scrolled');
                return;
            }
            
            // For other pages, use normal scroll behavior
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
        
        // Check on load
        handleScroll();
        
        // Listen to scroll events
        window.addEventListener('scroll', handleScroll);
    }
});
</script>
<!-- Mobile Menu Logic (Checkbox Hack) -->
<input class="peer hidden" id="mobile-menu-toggle" type="checkbox"/>

<!-- Header Container -->
<header class="site-header fixed top-0 left-0 w-full z-50 border-b transition-all duration-300 site-header-wrapper">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Logo Area -->
        <div class="flex items-center gap-2 z-50 relative">
            <a href="index.php" class="flex items-center gap-2">
                <?php if (!empty($siteLogo)): ?>
                    <img src="<?= e($siteLogo) ?>" alt="<?= e($siteName) ?>" class="h-10 w-auto">
                <?php else: ?>
                    <div class="size-8 text-primary flex items-center justify-center bg-primary/10 rounded-lg">
                        <span class="material-symbols-outlined !text-[24px]">apartment</span>
                    </div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                        <?= e($logoMain) ?> <span class="text-primary font-normal"><?= e($logoSecondary) ?></span>
                    </h1>
                <?php endif; ?>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-1 h-full">
            <!-- Nav Item: Home -->
            <a class="h-full flex items-center px-4 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-[#C71C1C] transition-colors" href="index.php">
                Home
            </a>
            
            <!-- Nav Item: About -->
            <a class="h-full flex items-center px-4 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-[#C71C1C] transition-colors" href="about.php">
                About
            </a>
            
            <!-- Nav Item: Rooms (Mega Menu Trigger) -->
            <?php if (!empty($allRooms)): ?>
            <div class="group h-full flex items-center px-4 relative cursor-pointer">
                <button class="nav-link flex items-center gap-1 text-xs font-semibold text-slate-600 dark:text-slate-300 group-hover:text-[#C71C1C] transition-colors">
                    Rooms
                    <span class="material-symbols-outlined !text-[20px] transition-transform group-hover:-rotate-180">keyboard_arrow_down</span>
                </button>
                <!-- Mega Menu Dropdown -->
                <div class="mega-menu absolute top-full left-1/2 w-[900px] bg-white dark:bg-surface-dark shadow-2xl rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden p-6">
                    <div class="mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">All Rooms &amp; Suites</h3>
                        <div class="grid grid-cols-4 gap-3">
                            <?php foreach (array_slice($allRooms, 0, 4) as $navRoom):
                                $roomImage = !empty($navRoom['main_image']) ? $navRoom['main_image'] : 'assets/img/no-image.jpg';
                            ?>
                            <a href="details.php?slug=<?= e($navRoom['slug']) ?>" class="group/room flex flex-col items-center text-center p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <div class="w-14 h-14 rounded-full overflow-hidden mb-3 bg-slate-100 border border-slate-200">
                                    <img src="<?= e($roomImage) ?>" alt="<?= e($navRoom['title']) ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover/room:scale-105">
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 group-hover/room:text-[#C71C1C] transition-colors leading-tight">
                                    <?= e($navRoom['title']) ?>
                                </h4>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700 text-center">
                        <a class="inline-flex items-center gap-1 text-sm font-bold text-slate-900 hover:text-[#C71C1C]" href="rooms.php">
                            View All Rooms <span class="material-symbols-outlined !text-[16px]">arrow_outward</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Fallback if no rooms -->
            <a class="h-full flex items-center px-4 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-[#C71C1C] transition-colors" href="rooms.php">
                Rooms
            </a>
            <?php endif; ?>
            
            <!-- Nav Item: Facilities (Mega Menu Trigger) -->
            <div class="group h-full flex items-center px-4 relative cursor-pointer">
                <a href="#" class="nav-link flex items-center gap-1 text-xs font-semibold text-slate-600 dark:text-slate-300 group-hover:text-[#C71C1C] transition-colors">
                    Facilities
                    <span class="material-symbols-outlined !text-[20px] transition-transform group-hover:-rotate-180">keyboard_arrow_down</span>
                </a>
                <!-- Mega Menu Dropdown -->
                <div class="mega-menu absolute top-full left-1/2 -translate-x-1/2 w-[600px] bg-white dark:bg-surface-dark shadow-2xl rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden p-6">
                    <div class="mb-4">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Our Facilities</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Restaurant -->
                            <a href="restaurant.php" class="group/facility flex flex-col items-center text-center p-4 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <?php if (!empty($restaurantFeatureImage)): ?>
                                    <div class="w-16 h-16 rounded-full overflow-hidden mb-3 bg-slate-100">
                                        <img src="<?= e($restaurantFeatureImage) ?>" alt="Restaurant" class="w-full h-full object-cover transition-transform duration-300 group-hover/facility:scale-105">
                                    </div>
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-3 group-hover/facility:bg-primary/20 transition-colors">
                                        <span class="material-symbols-outlined text-primary text-2xl">restaurant</span>
                                    </div>
                                <?php endif; ?>
                                <h4 class="text-sm font-bold text-slate-900 group-hover/facility:text-[#C71C1C] transition-colors">Restaurant</h4>
                            </a>
                            <!-- Bar -->
                            <a href="bar.php" class="group/facility flex flex-col items-center text-center p-4 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <?php if (!empty($barFeatureImage)): ?>
                                    <div class="w-16 h-16 rounded-full overflow-hidden mb-3 bg-slate-100">
                                        <img src="<?= e($barFeatureImage) ?>" alt="Bar" class="w-full h-full object-cover transition-transform duration-300 group-hover/facility:scale-105">
                                    </div>
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-3 group-hover/facility:bg-primary/20 transition-colors">
                                        <span class="material-symbols-outlined text-primary text-2xl">local_bar</span>
                                    </div>
                                <?php endif; ?>
                                <h4 class="text-sm font-bold text-slate-900 group-hover/facility:text-[#C71C1C] transition-colors">Bar</h4>
                            </a>
                            <!-- Swimming Pool -->
                            <a href="swimming-pool.php" class="group/facility flex flex-col items-center text-center p-4 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <?php if (!empty($swimmingPoolFeatureImage)): ?>
                                    <div class="w-16 h-16 rounded-full overflow-hidden mb-3 bg-slate-100">
                                        <img src="<?= e($swimmingPoolFeatureImage) ?>" alt="Swimming Pool" class="w-full h-full object-cover transition-transform duration-300 group-hover/facility:scale-105">
                                    </div>
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-3 group-hover/facility:bg-primary/20 transition-colors">
                                        <span class="material-symbols-outlined text-primary text-2xl">pool</span>
                                    </div>
                                <?php endif; ?>
                                <h4 class="text-sm font-bold text-slate-900 group-hover/facility:text-[#C71C1C] transition-colors">Swimming Pool</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Nav Item: Gallery -->
            <a class="h-full flex items-center px-4 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-[#C71C1C] transition-colors" href="gallery.php">
                Gallery
            </a>
            
            <!-- Nav Item: Contact -->
            <a class="h-full flex items-center px-4 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-[#C71C1C] transition-colors" href="contact.php">
                Contact
            </a>
        </nav>

        <!-- Right Actions Area -->
        <div class="hidden lg:flex items-center gap-4">
            <a href="rooms.php" class="header-book-btn bg-primary hover:bg-[#C71C1C] text-white text-xs font-bold py-2 px-4 rounded-lg transition-all shadow-lg shadow-primary/20 transform hover:-translate-y-0.5">
                Book Your Stay
            </a>
        </div>

        <!-- Mobile Menu Toggle Button -->
        <div class="lg:hidden flex items-center gap-4">
            <label class="cursor-pointer p-2 rounded-lg transition-colors mobile-menu-btn" for="mobile-menu-toggle">
                <span class="material-symbols-outlined !text-[28px]">menu</span>
            </label>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Menu Overlay -->
<div class="fixed inset-0 z-[9999] lg:hidden transition-opacity duration-300 opacity-0 pointer-events-none peer-checked:opacity-100 peer-checked:pointer-events-auto bg-black/50 backdrop-blur-sm" onclick="document.getElementById('mobile-menu-toggle').checked = false"></div>

<!-- Mobile Sidebar Content -->
<aside class="fixed top-0 right-0 z-[10000] w-[85%] max-w-[360px] h-full bg-white dark:bg-background-dark shadow-2xl transform translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-out flex flex-col overflow-hidden">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <div class="size-6 text-primary flex items-center justify-center bg-primary/10 rounded-md">
                <span class="material-symbols-outlined !text-[18px]">apartment</span>
            </div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Menu</h2>
        </div>
        <label class="cursor-pointer p-2 text-slate-500 hover:text-red-500 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors" for="mobile-menu-toggle">
            <span class="material-symbols-outlined !text-[24px]">close</span>
        </label>
    </div>

    <!-- Sidebar Links -->
    <div class="flex-1 overflow-y-auto p-5 space-y-2 scrollbar-hide">
        <!-- Mobile Link: Home -->
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-slate-900 dark:text-white font-bold text-base hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" href="index.php">
            <span class="material-symbols-outlined" style="color: #C71C1C;">home</span>
            Home
        </a>

        <!-- Mobile Link: About -->
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-slate-900 dark:text-white font-bold text-base hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" href="about.php">
            <span class="material-symbols-outlined" style="color: #C71C1C;">info</span>
            About
        </a>

        <!-- Mobile Accordion: Rooms -->
        <?php if (!empty($allRooms)): ?>
        <details class="group/accordion">
            <summary class="flex items-center justify-between w-full p-3 rounded-lg text-slate-900 dark:text-white font-bold text-base cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors list-none">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined" style="color: #C71C1C;">bed</span>
                    Rooms
                </div>
                <span class="material-symbols-outlined text-slate-400 transition-transform group-open/accordion:rotate-180">expand_more</span>
            </summary>
            <div class="pl-12 pr-2 py-2 space-y-3">
                <?php foreach ($allRooms as $navRoom): ?>
                <a class="block text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-[#C71C1C]" href="details.php?slug=<?= e($navRoom['slug']) ?>"><?= e($navRoom['title']) ?></a>
                <?php endforeach; ?>
            </div>
        </details>
        <?php else: ?>
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-slate-900 dark:text-white font-bold text-base hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" href="rooms.php">
            <span class="material-symbols-outlined" style="color: #C71C1C;">bed</span>
            Rooms
        </a>
        <?php endif; ?>

        <!-- Mobile Accordion: Facilities -->
        <details class="group/accordion">
            <summary class="flex items-center justify-between w-full p-3 rounded-lg text-slate-900 dark:text-white font-bold text-base cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors list-none">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined" style="color: #C71C1C;">spa</span>
                    Facilities
                </div>
                <span class="material-symbols-outlined text-slate-400 transition-transform group-open/accordion:rotate-180">expand_more</span>
            </summary>
            <div class="pl-12 pr-2 py-2 space-y-3">
                <a class="flex items-center gap-3 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-[#C71C1C]" href="restaurant.php">
                    <span class="material-symbols-outlined text-lg" style="color: #C71C1C;">restaurant</span>
                    Restaurant
                </a>
                <a class="flex items-center gap-3 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-[#C71C1C]" href="bar.php">
                    <span class="material-symbols-outlined text-lg" style="color: #C71C1C;">local_bar</span>
                    Bar
                </a>
                <a class="flex items-center gap-3 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-[#C71C1C]" href="swimming-pool.php">
                    <span class="material-symbols-outlined text-lg" style="color: #C71C1C;">pool</span>
                    Swimming Pool
                </a>
            </div>
        </details>

        <!-- Mobile Link: Gallery -->
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-slate-900 dark:text-white font-bold text-base hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" href="gallery.php">
            <span class="material-symbols-outlined" style="color: #C71C1C;">photo_library</span>
            Gallery
        </a>

        <!-- Mobile Link: Contact -->
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-slate-900 dark:text-white font-bold text-base hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" href="contact.php">
            <span class="material-symbols-outlined" style="color: #C71C1C;">phone</span>
            Contact
        </a>
    </div>

    <!-- Sidebar Footer -->
    <div class="p-5 border-t border-slate-100 dark:border-slate-800 bg-surface-light dark:bg-surface-dark">
        <a href="rooms.php" class="block w-full bg-primary hover:bg-[#C71C1C] text-white text-xs font-bold py-2 px-4 rounded-lg shadow-lg shadow-primary/20 mb-4 transition-all text-center">
            Book Your Stay
        </a>
        <div class="flex justify-end items-center px-2">
            <div class="flex gap-4">
                <a class="text-slate-400 hover:text-primary" href="<?= e($whatsappLink) ?>" target="_blank" aria-label="Call">
                    <span class="material-symbols-outlined !text-[20px]">call</span>
                </a>
            </div>
        </div>
    </div>
</aside>

<!-- No spacer needed - hero section will handle positioning -->

