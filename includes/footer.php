<?php
/**
 * Footer Template
 * Reusable footer component for all frontend pages
 * Make sure content-loader.php is included before this file
 */

// Ensure required functions exist
if (!function_exists('getSiteSetting')) {
    function getSiteSetting($key, $default = '') { return $default; }
}
if (!function_exists('e')) {
    function e($string) { return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8'); }
}

// Load site settings for footer
$siteName = getSiteSetting('site_name', 'TM Luxury Apartments');
$siteLogo = getSiteSetting('site_logo', 'assets/img/logo1.png');
$footerAddress = getSiteSetting('footer_address', '11 Akpofe Street, Ajao Estate, Off Int\'l Airport Road.');
$footerPhone = getSiteSetting('footer_phone', '+234 813 480 7718 | +234 907 676 0923');
$footerCopyright = getSiteSetting('footer_copyright', 'TM');
$developerText = getSiteSetting('developer_text', 'Brilliant Developers - 07068057873');
$developerLink = getSiteSetting('developer_link', 'https://wa.me/2347068057873?text=Greetings%20Brilliant%20Developers');
$whatsappLink = getSiteSetting('whatsapp_link', 'https://wa.me/2348134807718?text=Greetings%20TM%20Luxury%20Apartment');

// Extract logo text from site name (same logic as header)
$logoParts = explode(' ', $siteName);
$logoMain = $logoParts[0] ?? 'TM';
$logoSecondary = isset($logoParts[1]) ? implode(' ', array_slice($logoParts, 1)) : 'Luxury Apartments';
?>

<footer class="bg-background-dark text-white pt-16 pb-8 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- Column 1: Brand & Contact -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <?php if (!empty($siteLogo)): ?>
                        <img src="<?= e($siteLogo) ?>" alt="<?= e($siteName) ?>" class="h-8 w-auto">
                    <?php else: ?>
                        <div class="size-8 text-primary flex items-center justify-center bg-primary/10 rounded-lg">
                            <span class="material-symbols-outlined !text-[24px]">apartment</span>
                        </div>
                        <h2 class="text-xl font-bold tracking-tight text-white"><?= e($logoMain) ?> <span class="text-primary font-normal"><?= e($logoSecondary) ?></span></h2>
                    <?php endif; ?>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed">
                    Experience the epitome of luxury and comfort. Your perfect getaway awaits in the heart of paradise.
                </p>
                <div class="flex items-center gap-2 text-slate-400 text-xs mt-4">
                    <span class="material-symbols-outlined !text-[18px]">location_on</span>
                    <?= e($footerAddress) ?>
                </div>
                <div class="flex items-center gap-2 text-slate-400 text-xs">
                    <span class="material-symbols-outlined !text-[18px]">call</span>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $footerPhone) ?>" class="hover:text-[#C71C1C] transition-colors"><?= e($footerPhone) ?></a>
                </div>
            </div>

            <!-- Column 2: Explore -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6">Explore</h3>
                <ul class="space-y-3">
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="about.php">About Us</a></li>
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="rooms.php">Rooms &amp; Suites</a></li>
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="restaurant.php">Restaurant</a></li>
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="gallery.php">Gallery</a></li>
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- Column 3: Legal & Support -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6">Legal &amp; Support</h3>
                <ul class="space-y-3">
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="contact.php">Contact Us</a></li>
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="about.php">About</a></li>
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="terms-of-use.php">Terms of Use</a></li>
                    <li><a class="text-slate-300 hover:text-[#C71C1C] transition-colors text-xs" href="hotel-policy.php">Hotel Policy</a></li>
                </ul>
            </div>

            <!-- Column 4: Subscribe -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6">Subscribe</h3>
                <p class="text-slate-400 text-xs mb-4">Join our newsletter for exclusive offers, travel inspiration, and updates.</p>
                <form class="space-y-3" action="#" method="POST">
                    <div class="relative">
                        <input class="w-full h-10 pl-3 pr-10 bg-slate-800 border-slate-700 rounded-lg text-sm text-white placeholder-slate-500 focus:ring-primary focus:border-primary transition-colors" placeholder="Enter your email" type="email" name="email" required/>
                    </div>
                    <button class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-2.5 rounded-lg text-sm transition-all shadow-lg shadow-primary/20" type="submit">Subscribe</button>
                </form>
            </div>
        </div>

        <!-- Footer Bottom: Copyright & Social -->
        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-xs">© <?= date('Y') ?> <?= e($footerCopyright) ?>. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a class="text-slate-400 hover:text-[#C71C1C] transition-colors group" href="<?= e($whatsappLink) ?>" target="_blank" aria-label="WhatsApp">
                    <div class="p-2 rounded-full bg-slate-800 group-hover:bg-white/10 transition-colors">
                        <svg aria-hidden="true" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path clip-rule="evenodd" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" fill-rule="evenodd"></path></svg>
                    </div>
                </a>
                <a class="text-slate-400 hover:text-[#C71C1C] transition-colors group" href="<?= e($developerLink) ?>" target="_blank" aria-label="Contact Developer">
                    <div class="p-2 rounded-full bg-slate-800 group-hover:bg-white/10 transition-colors">
                        <span class="material-symbols-outlined !text-[16px]">call</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</footer>

<?php
// Include WhatsApp widget if configured
require_once __DIR__ . '/whatsapp-widget.php';
?>

