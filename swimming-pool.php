<?php
/**
 * Swimming Pool Page - Pool & Leisure Experience
 */

require_once __DIR__ . '/includes/content-loader.php';

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

// Load swimming pool page sections with defaults
$heroSubtitle = getPageSection('swimming-pool', 'hero_subtitle', 'Pool & Leisure');
$heroTitle = getPageSection('swimming-pool', 'hero_title', 'Swimming Pool & Leisure');
$heroIntro = getPageSection('swimming-pool', 'hero_intro', 'A serene escape designed for relaxation, refreshment, and quiet enjoyment.');
$heroBackground = getPageSection('swimming-pool', 'hero_background', 'assets/img/about1.jpg');

// Pool Experience Section (3 Cards)
$poolTitle = getPageSection('swimming-pool', 'pool_title', 'Swimming Pool & Leisure Experience');
$poolIntro = getPageSection('swimming-pool', 'pool_intro', 'Discover a tranquil pool area where relaxation, refreshment, and peaceful moments come together.');
$poolDescription = getPageSection('swimming-pool', 'pool_description', 'At Emilton Hotel & Suites, our swimming pool offers a serene escape from the everyday. From refreshing morning swims to relaxing evening dips, every moment is designed for comfort and tranquility.');
$poolCard1Image = getPageSection('swimming-pool', 'pool_card_1_image', 'assets/img/about1.jpg');
$poolCard1Icon = getPageSection('swimming-pool', 'pool_card_1_icon', 'pool'); // Icon is now removed from display but kept for admin
$poolCard1Title = getPageSection('swimming-pool', 'pool_card_1_title', 'Refreshing Pool Experience');
$poolCard1Description = getPageSection('swimming-pool', 'pool_card_1_description', 'Enjoy a clean, well-maintained swimming pool designed for comfort and relaxation. Whether you\'re starting your day with a refreshing dip or unwinding in the evening, our pool offers a calm and inviting environment.');
$poolCard2Image = getPageSection('swimming-pool', 'pool_card_2_image', 'assets/img/about1.jpg');
$poolCard2Icon = getPageSection('swimming-pool', 'pool_card_2_icon', 'deck');
$poolCard2Title = getPageSection('swimming-pool', 'pool_card_2_title', 'Calm Poolside Ambience');
$poolCard2Description = getPageSection('swimming-pool', 'pool_card_2_description', 'Surrounded by a peaceful atmosphere, the pool area offers a relaxing setting where guests can unwind, lounge, and enjoy quiet moments away from the city\'s pace.');
$poolCard3Image = getPageSection('swimming-pool', 'pool_card_3_image', 'assets/img/about1.jpg');
$poolCard3Icon = getPageSection('swimming-pool', 'pool_card_3_icon', 'chair');
$poolCard3Title = getPageSection('swimming-pool', 'pool_card_3_title', 'Comfort & Leisure');
$poolCard3Description = getPageSection('swimming-pool', 'pool_card_3_description', 'Thoughtfully arranged seating and a well-designed pool layout provide comfort, privacy, and ease, making the swimming pool ideal for leisure, relaxation, and light recreation.');
$poolCta = getPageSection('swimming-pool', 'pool_cta', 'Relax. Refresh. Recharge.

Experience calm and comfort at the Emilton Hotel & Suites swimming pool.');

// Gallery Slider Section
$sliderTitle = getPageSection('swimming-pool', 'slider_title', 'Pool Gallery');
$sliderImagesJson = getPageSection('swimming-pool', 'slider_images', '[]');
$sliderImages = json_decode($sliderImagesJson, true);
if (!is_array($sliderImages)) {
    $sliderImages = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= e($siteName) ?> - Swimming Pool & Leisure</title>
    <link rel="icon" href="<?= e($siteFavicon) ?>" />
    <!-- Site Head Includes (Tailwind CSS + default theme tokens used by shared header/footer) -->
    <?php require_once __DIR__ . '/includes/head-header.php'; ?>
    <style>
        /* Normalize header/footer sizing (same as restaurant page) */
        .site-header-wrapper > div {
            height: 100px !important;
        }
        .site-header-wrapper img.h-10 {
            height: 50px !important;
        }
        .site-header-wrapper nav a,
        .site-header-wrapper nav button.nav-link,
        .site-header-wrapper .header-book-btn {
            font-size: 15px !important;
        }
        footer {
            font-size: 20px;
        }
        footer .text-xs {
            font-size: 15px !important;
        }

        /* Scope pool-only theme tokens */
        .pool-scope .bg-background-light {
            background-color: #EDEAE5 !important;
        }
        .pool-scope .bg-background-dark {
            background-color: #3a3a3a !important;
        }

        /* Custom scrollbar for horizontal scrolling */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <?php require_once __DIR__ . '/includes/body-scripts.php'; ?>
    <?php require_once __DIR__ . '/includes/header.php'; ?>
    <div class="pool-scope relative flex min-h-screen w-full flex-col group/design-root bg-background-dark text-white font-display">
  
    <!-- Hero Section -->
    <div class="relative w-full">
        <div class="@container">
            <div class="flex min-h-screen flex-col gap-6 bg-cover bg-center bg-no-repeat items-center justify-center p-4 relative hero-font-serif" style='background-image: linear-gradient(rgba(58, 58, 58, 0.4) 0%, rgba(58, 58, 58, 0.8) 100%), url("<?= e($heroBackground) ?>");'>
                <div class="flex flex-col gap-6 text-center max-w-[800px] animate-fade-in-up">
                    <h2 class="text-white text-sm font-bold tracking-[0.2em] uppercase"><?= e($heroSubtitle) ?></h2>
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight tracking-[-0.033em] italic">
                        <?= e($heroTitle) ?>
                    </h1>
                    <p class="text-white/80 text-lg md:text-xl font-normal leading-relaxed max-w-[600px] mx-auto">
                        <?= e($heroIntro) ?>
                    </p>
                </div>
                <div class="absolute bottom-10 animate-bounce">
                    <span class="material-symbols-outlined text-white/50 text-4xl">keyboard_arrow_down</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pool Experience Section (3 Cards) -->
    <section class="py-16 bg-white">
        <div class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-16 flex flex-col gap-12">
            <div class="text-center max-w-[900px] mx-auto flex flex-col gap-4">
                <h2 class="text-primary text-3xl md:text-5xl font-display font-bold leading-tight">
                    <?= e($poolTitle) ?>
                </h2>
                <p class="text-slate-700 text-base md:text-lg leading-relaxed font-sans">
                    <?= e($poolIntro) ?>
                </p>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed font-sans">
                    <?= e($poolDescription) ?>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Pool Experience -->
                <div class="p-8 rounded-2xl bg-[#262161] border border-slate-200 hover:border-primary/40 transition-colors shadow-sm">
                    <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 border border-slate-200 mb-6">
                        <img src="<?= e($poolCard1Image) ?>" alt="<?= e($poolCard1Title) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center gap-3 mb-4">
                        <!-- Icon removed from display -->
                        <h3 class="text-white text-xl font-display font-bold"><?= e($poolCard1Title) ?></h3>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed font-sans">
                        <?= e($poolCard1Description) ?>
                    </p>
                </div>

                <!-- Card 2: Poolside Ambience -->
                <div class="p-8 rounded-2xl bg-[#262161] border border-slate-200 hover:border-primary/40 transition-colors shadow-sm">
                    <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 border border-slate-200 mb-6">
                        <img src="<?= e($poolCard2Image) ?>" alt="<?= e($poolCard2Title) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center gap-3 mb-4">
                        <!-- Icon removed from display -->
                        <h3 class="text-white text-xl font-display font-bold"><?= e($poolCard2Title) ?></h3>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed font-sans">
                        <?= e($poolCard2Description) ?>
                    </p>
                </div>

                <!-- Card 3: Comfort & Leisure -->
                <div class="p-8 rounded-2xl bg-[#262161] border border-slate-200 hover:border-primary/40 transition-colors shadow-sm">
                    <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 border border-slate-200 mb-6">
                        <img src="<?= e($poolCard3Image) ?>" alt="<?= e($poolCard3Title) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center gap-3 mb-4">
                        <!-- Icon removed from display -->
                        <h3 class="text-white text-xl font-display font-bold"><?= e($poolCard3Title) ?></h3>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed font-sans">
                        <?= e($poolCard3Description) ?>
                    </p>
                </div>
            </div>

            <div class="text-center">
                <p class="text-slate-700 font-sans">
                    <?= nl2br(e($poolCta)) ?>
                </p>
            </div>
        </div>
    </section>
    
    <!-- Pool Gallery Slider Section -->
    <?php if (!empty($sliderImages)): ?>
    <section class="py-16" style="background-color: #f8f8f8;">
        <div class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-16 relative">
            <?php if (!empty($sliderTitle)): ?>
            <div class="text-center mb-12">
                <h2 class="text-slate-900 text-3xl md:text-5xl font-display font-bold leading-tight">
                    <?= e($sliderTitle) ?>
                </h2>
            </div>
            <?php endif; ?>
            
            <div class="cs_slider cs_style_1 cs_slider_gap_0 pool-gallery-slider">
                <div class="cs_slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-center="0" data-variable-width="0" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="2" data-md-slides="2" data-lg-slides="3" data-add-slides="3">
                    <div class="cs_slider_wrapper">
                        <?php foreach ($sliderImages as $image): ?>
                            <?php if (!empty($image['url'])): ?>
                            <div class="cs_slide">
                                <div class="rounded-2xl overflow-hidden aspect-[4/3] bg-white border border-slate-200 shadow-sm">
                                    <img src="<?= e($image['url']) ?>" alt="<?= e($image['alt'] ?? 'Pool Gallery') ?>" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Navigation Arrows -->
                <div class="cs_slider_arrows cs_style_1">
                    <div class="cs_left_arrow cs_center cs_accent_bg cs_radius_100 slick-arrow cs_white_color">
                        <svg width="22" height="42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1C1 1 4.96624 21.0179 21 20.8334" stroke="currentColor" stroke-width="2"/>
                            <path d="M1 41C1 41 4.96624 20.9821 21 21.1666" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <div class="cs_right_arrow cs_center cs_accent_bg cs_radius_100 slick-arrow cs_white_color">
                        <svg width="22" height="42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1C1 1 4.96624 21.0179 21 20.8334" stroke="currentColor" stroke-width="2"/>
                            <path d="M1 41C1 41 4.96624 20.9821 21 21.1666" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        /* Small spacing between slides (not touching) */
        .pool-gallery-slider .slick-slide {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        .pool-gallery-slider .slick-list {
            margin-left: -10px !important;
            margin-right: -10px !important;
        }

        /* Always show + style navigation arrows (this page doesn't load the legacy theme CSS) */
        .pool-gallery-slider .cs_slider_arrows.cs_style_1 .cs_left_arrow,
        .pool-gallery-slider .cs_slider_arrows.cs_style_1 .cs_right_arrow {
            visibility: visible !important;
            opacity: 1 !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(148, 163, 184, 0.6); /* slate-400 */
            color: #334155; /* slate-700 */
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 20;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.10);
        }
        .pool-gallery-slider .cs_slider_arrows.cs_style_1 .cs_left_arrow {
            left: 6px !important;
        }
        .pool-gallery-slider .cs_slider_arrows.cs_style_1 .cs_right_arrow {
            right: 6px !important;
        }
        .pool-gallery-slider .cs_slider_arrows.cs_style_1 .cs_left_arrow:hover,
        .pool-gallery-slider .cs_slider_arrows.cs_style_1 .cs_right_arrow:hover {
            background: rgba(255, 255, 255, 1);
            border-color: rgba(100, 116, 139, 0.8); /* slate-500 */
            transform: translateY(-50%) scale(1.06);
        }
        /* Adjust arrow position on smaller screens */
        @media (max-width: 1024px) {
            .pool-gallery-slider .cs_slider_arrows.cs_style_1 .cs_left_arrow {
                left: 8px !important;
            }
            .pool-gallery-slider .cs_slider_arrows.cs_style_1 .cs_right_arrow {
                right: 8px !important;
            }
        }
    </style>
    <?php endif; ?>
    
    </div>
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    
    <!-- Include Slick Slider CSS & JS -->
    <link rel="stylesheet" href="assets/css/slick.min.css" />
    <script src="code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/main.js"></script>
    
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
