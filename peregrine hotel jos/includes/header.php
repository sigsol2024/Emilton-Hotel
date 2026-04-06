<?php
/**
 * Header Template
 * Peregrine Hotel design
 * Make sure content-loader.php is included before this file
 */

// Ensure required functions exist
if (!function_exists('getSiteSetting')) {
    function getSiteSetting($key, $default = '') { return $default; }
}
if (!function_exists('e')) {
    function e($string) { return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8'); }
}

// Load site settings
$siteName = getSiteSetting('site_name', 'Peregrine Hotel Rayfield');
$siteLogo = getSiteSetting('site_logo', '');

// Helper function to get base URL for images
if (!function_exists('getBaseUrl')) {
    function getBaseUrl() {
        if (defined('SITE_URL')) {
            return SITE_URL;
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $scriptPath = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        return rtrim($protocol . $host . $scriptPath, '/') . '/';
    }
}

// Helper function to get logo URL
if (!function_exists('getLogoUrl')) {
    function getLogoUrl($logoPath) {
        if (empty($logoPath)) return '';
        // Check if it's already a full URL
        if (strpos($logoPath, 'http://') === 0 || strpos($logoPath, 'https://') === 0) {
            return $logoPath;
        }
        // It's a relative path, prepend base URL
        return getBaseUrl() . ltrim($logoPath, '/');
    }
}
?>
<!-- Navbar -->
<header class="fixed top-0 z-50 w-full transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-gray-100">
<div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
<!-- Logo -->
<div class="flex items-center gap-2">
<?php if (!empty($siteLogo)): 
    $logoUrl = getLogoUrl($siteLogo);
?>
    <a href="index.php" class="flex items-center">
        <img src="<?= htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') ?>" 
             alt="<?= e($siteName) ?>" 
             class="h-16 w-auto object-contain"
             style="max-height: 90px;">
    </a>
<?php else: ?>
    <a href="index.php" class="flex items-center gap-2">
        <span class="material-symbols-outlined text-amber-700" style="font-size: 32px;">flight_takeoff</span>
        <h2 class="text-xl font-bold tracking-tight text-accent-black font-display uppercase"><?= e($siteName) ?></h2>
    </a>
<?php endif; ?>
</div>
<!-- Desktop Menu -->
<nav class="hidden md:flex items-center gap-8">
<a class="text-sm font-medium text-gray-600 hover:text-amber-700 transition-colors" href="index.php">Home</a>
<a class="text-sm font-medium text-gray-600 hover:text-amber-700 transition-colors" href="about_us.php">About</a>
<a class="text-sm font-medium text-gray-600 hover:text-amber-700 transition-colors" href="rooms_&_suites.php">Rooms</a>
<a class="text-sm font-medium text-gray-600 hover:text-amber-700 transition-colors" href="amenities.php">Amenities</a>
<a class="text-sm font-medium text-gray-600 hover:text-amber-700 transition-colors" href="contact_us.php">Contact</a>
</nav>
<!-- Action -->
<div class="flex items-center">
<a href="rooms_&_suites.php" class="hidden md:flex h-10 items-center justify-center rounded-lg bg-[#3f3f3f] px-6 text-sm font-bold text-white transition-transform hover:scale-105 shadow-md hover:bg-[#2a2a2a]">
    Book Now
</a>
<!-- Mobile Menu Button -->
<button class="md:hidden p-2 text-gray-600" id="mobile-menu-toggle">
<span class="material-symbols-outlined">menu</span>
</button>
</div>
</div>
</header>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-[9999] bg-black/50 backdrop-blur-sm hidden md:hidden" onclick="document.getElementById('mobile-menu-overlay').classList.add('hidden'); document.getElementById('mobile-menu-sidebar').classList.add('translate-x-full');"></div>

<!-- Mobile Sidebar -->
<aside id="mobile-menu-sidebar" class="fixed top-0 right-0 z-[10000] w-[85%] max-w-[360px] h-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-out flex flex-col overflow-hidden md:hidden">
    <div class="flex items-center justify-between p-5 border-b border-gray-100">
        <h2 class="text-lg font-bold text-text-main">Menu</h2>
        <button class="p-2 text-gray-600 hover:text-red-500" onclick="document.getElementById('mobile-menu-overlay').classList.add('hidden'); document.getElementById('mobile-menu-sidebar').classList.add('translate-x-full');">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>
    </div>
    <div class="flex-1 overflow-y-auto p-5 space-y-2">
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-text-main font-bold text-base hover:bg-gray-50 transition-colors" href="index.php">Home</a>
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-text-main font-bold text-base hover:bg-gray-50 transition-colors" href="about_us.php">About</a>
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-text-main font-bold text-base hover:bg-gray-50 transition-colors" href="rooms_&_suites.php">Rooms</a>
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-text-main font-bold text-base hover:bg-gray-50 transition-colors" href="amenities.php">Amenities</a>
        <a class="flex items-center gap-3 w-full p-3 rounded-lg text-text-main font-bold text-base hover:bg-gray-50 transition-colors" href="contact_us.php">Contact</a>
    </div>
    <div class="p-5 border-t border-gray-100">
        <a href="rooms_&_suites.php" class="block w-full bg-[#3f3f3f] hover:bg-[#2a2a2a] text-white text-sm font-bold py-3 px-4 rounded-lg shadow-md transition-all text-center">
            Book Now
        </a>
    </div>
</aside>

<script>
document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
    document.getElementById('mobile-menu-overlay').classList.remove('hidden');
    document.getElementById('mobile-menu-sidebar').classList.remove('translate-x-full');
});
</script>
