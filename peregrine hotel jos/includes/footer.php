<?php
/**
 * Footer Template
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
$footerAddress = getSiteSetting('footer_address', '12 Rayfield Avenue,<br/>Jos, Plateau State,<br/>Nigeria');
$footerPhone = getSiteSetting('footer_phone', '+234 800 123 4567');
$footerEmail = getSiteSetting('footer_email', 'reservations@peregrinehotel.com');
$footerCopyright = getSiteSetting('footer_copyright', '© 2024 Peregrine Hotel Rayfield. All rights reserved.');

// Load social media links
$socialMediaJson = getSiteSetting('social_media_json', '[]');
$socialMediaList = json_decode($socialMediaJson, true) ?: [];

// Helper function to get base URL for images (if not already defined)
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

// Helper function to get logo URL (if not already defined)
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
<!-- Footer -->
<footer class="bg-[#3f3f3f] pt-16 pb-8 px-4 sm:px-6 lg:px-8 border-t border-gray-700">
<div class="mx-auto max-w-7xl">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
<!-- Col 1: Brand -->
<div class="flex flex-col gap-6">
<div class="flex items-center gap-2">
<?php if (!empty($siteLogo)): 
    $logoUrl = getLogoUrl($siteLogo);
?>
    <a href="index.php" class="flex items-center">
        <img src="<?= htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') ?>" 
             alt="<?= e($siteName) ?>" 
             class="h-12 w-auto object-contain"
             style="max-height: 70px;">
    </a>
<?php else: ?>
    <span class="material-symbols-outlined text-amber-500" style="font-size: 28px;">flight_takeoff</span>
    <h3 class="text-lg font-bold text-white font-display uppercase"><?= e($siteName) ?></h3>
<?php endif; ?>
</div>
<p class="text-sm text-white/80 leading-relaxed">
    A member of the Boulevard Hotel Group. Redefining luxury hospitality in Plateau State.
</p>
<?php if (!empty($socialMediaList)): ?>
<div class="flex gap-4">
<?php foreach ($socialMediaList as $social): 
    if (!empty($social['icon']) && !empty($social['url'])): ?>
<a class="text-amber-500 hover:text-amber-400 transition-colors" href="<?= htmlspecialchars($social['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer">
    <?php if ($social['icon'] === 'facebook'): ?>
        <span class="sr-only">Facebook</span>
        <svg class="h-5 w-5" fill="currentColor" viewbox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path></svg>
    <?php elseif ($social['icon'] === 'instagram'): ?>
        <span class="sr-only">Instagram</span>
        <svg class="h-5 w-5" fill="currentColor" viewbox="0 0 24 24"><path clip-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.047 1.407-.06 3.808-.06zM12 5.352c-3.632 0-4.095.013-5.526.078-1.226.056-1.892.274-2.333.445-.584.227-1.002.498-1.442.938-.44.44-.71.858-.938 1.442-.17.441-.389 1.107-.445 2.333-.065 1.431-.078 1.894-.078 5.526s.013 4.095.078 5.526c.056 1.226.274 1.892.445 2.333.227.584.498 1.002.938 1.442.44.44.858.71 1.442.938.441.17 1.107.389 2.333.445 1.431.065 1.894.078 5.526.078s4.095-.013 5.526-.078c1.226-.056 1.892-.274 2.333-.445.584-.227 1.002-.498 1.442-.938.44-.44.71-.858.938-1.442.17-.441.389-1.107.445-2.333.065-1.431.078-1.894.078-5.526s-.013-4.095-.078-5.526c-.056-1.226-.274-1.892-.445-2.333-.227-.584-.498-1.002-.938-1.442-.44-.44-.858-.71-1.442-.938-.441-.17-1.107-.389-2.333-.445-1.431-.065-1.894-.078-5.526-.078zM12 8.448a3.552 3.552 0 100 7.104 3.552 3.552 0 000-7.104zm0 1.63a1.922 1.922 0 110 3.844 1.922 1.922 0 010-3.844zM18.895 6.33a1.086 1.086 0 11-2.172 0 1.086 1.086 0 012.172 0z" fill-rule="evenodd"></path></svg>
    <?php else: ?>
        <span class="material-symbols-outlined"><?= htmlspecialchars($social['icon'], ENT_QUOTES, 'UTF-8') ?></span>
    <?php endif; ?>
</a>
<?php endif; 
endforeach; ?>
</div>
<?php endif; ?>
</div>
<!-- Col 2: Navigation -->
<div class="flex flex-col gap-4">
<h4 class="font-bold text-white">Hotel</h4>
<ul class="flex flex-col gap-2 text-sm text-white/80">
<li><a class="hover:text-amber-500 transition-colors" href="about_us.php">Our Story</a></li>
<li><a class="hover:text-amber-500 transition-colors" href="rooms_&_suites.php">Accommodations</a></li>
<li><a class="hover:text-amber-500 transition-colors" href="amenities.php#dining">Dining &amp; Bar</a></li>
<li><a class="hover:text-amber-500 transition-colors" href="amenities.php">Facilities</a></li>
</ul>
</div>
<!-- Col 3: Support -->
<div class="flex flex-col gap-4">
<h4 class="font-bold text-white">Guest Services</h4>
<ul class="flex flex-col gap-2 text-sm text-white/80">
<li><a class="hover:text-amber-500 transition-colors" href="contact_us.php">Contact Us</a></li>
<li><a class="hover:text-amber-500 transition-colors" href="policies_&_terms.php">Terms &amp; Conditions</a></li>
<li><a class="hover:text-amber-500 transition-colors" href="policies_&_terms.php">Privacy Policy</a></li>
</ul>
</div>
<!-- Col 4: Contact -->
<div class="flex flex-col gap-4">
<h4 class="font-bold text-white">Visit Us</h4>
<div class="flex flex-col gap-4 text-sm text-white/80">
<div class="flex items-start gap-2">
<span class="material-symbols-outlined text-amber-500 text-lg mt-0.5">location_on</span>
<p><?= $footerAddress ?></p>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-amber-500 text-lg">call</span>
<p><?= e($footerPhone) ?></p>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-amber-500 text-lg">mail</span>
<p><?= e($footerEmail) ?></p>
</div>
</div>
</div>
</div>
<div class="border-t border-gray-600 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-amber-500">
<p><?= $footerCopyright ?></p>
<p class="flex items-center gap-1">Designed by <a href="https://signature-solutions.com/" target="_blank" rel="noopener noreferrer" class="hover:underline font-semibold">Signature Solutions</a>.</p>
</div>
</div>
</footer>
</div>
</body></html>
