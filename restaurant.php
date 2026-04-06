<?php
/**
 * Restaurant Page - Luxury Dining Experience
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

// Load restaurant page sections
$heroSubtitle = getPageSection('restaurant', 'hero_subtitle', 'Est. 1924');
$heroTitle = getPageSection('restaurant', 'hero_title', 'A Culinary Sanctuary');
$heroDescription = getPageSection('restaurant', 'hero_description', 'Experience the pinnacle of fine dining in the heart of the city, where tradition meets modern innovation.');
$heroBackground = getPageSection('restaurant', 'hero_background', 'assets/img/about1.jpg');
$heroButtonText = getPageSection('restaurant', 'hero_button_text', 'Reserve Your Table');

// Philosophy Section
$philosophySubtitle = getPageSection('restaurant', 'philosophy_subtitle', 'Our Vision');
$philosophyTitle = getPageSection('restaurant', 'philosophy_title', 'The Philosophy of Taste');
$philosophyDescription = getPageSection('restaurant', 'philosophy_description', 'Our culinary vision is rooted in a deep respect for nature\'s bounty. We source the finest seasonal ingredients to craft dishes that are both visually stunning and exquisitely flavored, served in an ambiance of understated elegance.');
$philosophyQuote = getPageSection('restaurant', 'philosophy_quote', '"Food is not just sustenance, it is an emotional journey that connects us to the earth and to each other."');
$philosophyQuoteAuthor = getPageSection('restaurant', 'philosophy_quote_author', '— Chef Henri Dubois');
$philosophyButtonText = getPageSection('restaurant', 'philosophy_button_text', 'Read Our Story');
$philosophyImage1 = getPageSection('restaurant', 'philosophy_image_1', 'assets/img/about1.jpg');
$philosophyImage2 = getPageSection('restaurant', 'philosophy_image_2', 'assets/img/about1.jpg');

// Features Section
$feature1Icon = getPageSection('restaurant', 'feature_1_icon', 'eco');
$feature1Title = getPageSection('restaurant', 'feature_1_title', 'Sustainable Sourcing');
$feature1Description = getPageSection('restaurant', 'feature_1_description', 'We partner exclusively with local artisan farms to ensure absolute freshness and minimize our carbon footprint.');
$feature2Icon = getPageSection('restaurant', 'feature_2_icon', 'palette');
$feature2Title = getPageSection('restaurant', 'feature_2_title', 'Artful Plating');
$feature2Description = getPageSection('restaurant', 'feature_2_description', 'Every dish is conceived as a masterpiece of design, balancing color, texture, and negative space.');
$feature3Icon = getPageSection('restaurant', 'feature_3_icon', 'room_service');
$feature3Title = getPageSection('restaurant', 'feature_3_title', 'Impeccable Service');
$feature3Description = getPageSection('restaurant', 'feature_3_description', 'Our service is attentive yet discreet, personalized to anticipate your every need before you ask.');

// Dining Experience Section (3 Cards)
$diningTitle = getPageSection('restaurant', 'dining_title', 'A Refined Dining Experience at Emilton Restaurant');
$diningIntro = getPageSection('restaurant', 'dining_intro', 'Discover a dining space where exceptional cuisine, elegant surroundings, and thoughtful design come together to create unforgettable moments.');
$diningDescription = getPageSection('restaurant', 'dining_description', 'At Emilton Restaurant, dining is more than a meal—it is an experience. From carefully crafted dishes to a warm and sophisticated atmosphere, every detail is designed to delight the senses and elevate your stay.');

$diningCard1Icon = getPageSection('restaurant', 'dining_card_1_icon', 'restaurant');
$diningCard1Image = getPageSection('restaurant', 'dining_card_1_image', 'assets/img/about1.jpg');
$diningCard1Title = getPageSection('restaurant', 'dining_card_1_title', 'Exquisite Culinary Creations');
$diningCard1Description = getPageSection('restaurant', 'dining_card_1_description', 'Our menu is a celebration of flavor, combining expertly prepared local Nigerian dishes with continental and international cuisine. Every meal is freshly prepared using quality ingredients, delivering rich taste, beautiful presentation, and consistent excellence with every bite.');

$diningCard2Icon = getPageSection('restaurant', 'dining_card_2_icon', 'wb_twilight');
$diningCard2Image = getPageSection('restaurant', 'dining_card_2_image', 'assets/img/about1.jpg');
$diningCard2Title = getPageSection('restaurant', 'dining_card_2_title', 'Warm & Inviting Ambience');
$diningCard2Description = getPageSection('restaurant', 'dining_card_2_description', 'The restaurant offers a calm and welcoming atmosphere designed for comfort and relaxation. Soft lighting, tasteful décor, and a serene setting create the perfect environment for breakfast meetings, relaxed lunches, and intimate dinners.');

$diningCard3Icon = getPageSection('restaurant', 'dining_card_3_icon', 'chair');
$diningCard3Image = getPageSection('restaurant', 'dining_card_3_image', 'assets/img/about1.jpg');
$diningCard3Title = getPageSection('restaurant', 'dining_card_3_title', 'Elegant Restaurant Interior');
$diningCard3Description = getPageSection('restaurant', 'dining_card_3_description', 'Designed with modern luxury in mind, Emilton Restaurant features stylish interiors that blend contemporary design with timeless elegance. The thoughtfully arranged seating and refined finishes provide a comfortable yet sophisticated dining environment for every guest.');

$diningCta = getPageSection('restaurant', 'dining_cta', "Experience fine dining at its best.\nDine with us and enjoy exceptional food in an elegant setting.");

// Ambience Section
$ambienceSubtitle = getPageSection('restaurant', 'ambience_subtitle', 'Design & Atmosphere');
$ambienceTitle = getPageSection('restaurant', 'ambience_title', 'An Oasis of Calm');
$ambienceDescription1 = getPageSection('restaurant', 'ambience_description_1', 'Immerse yourself in an atmosphere designed to soothe the senses. Our dining room features plush velvet seating, ambient warm lighting, and panoramic views of the skyline through floor-to-ceiling windows.');
$ambienceDescription2 = getPageSection('restaurant', 'ambience_description_2', 'Whether you are here for an intimate conversation or a celebratory moment, the Jade Room provides the perfect backdrop of modern luxury and timeless comfort.');
$ambienceButtonText = getPageSection('restaurant', 'ambience_button_text', 'View Gallery');
$ambienceImage1 = getPageSection('restaurant', 'ambience_image_1', 'assets/img/about1.jpg');
$ambienceImage2 = getPageSection('restaurant', 'ambience_image_2', 'assets/img/about1.jpg');
$ambienceImage3 = getPageSection('restaurant', 'ambience_image_3', 'assets/img/about1.jpg');
$ambienceImage4 = getPageSection('restaurant', 'ambience_image_4', 'assets/img/about1.jpg');

// Reservation Section (removed)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= e($siteName) ?> - Restaurant</title>
    <link rel="icon" href="<?= e($siteFavicon) ?>" />
    <!-- Site Head Includes (Tailwind CSS + default theme tokens used by shared header/footer) -->
    <?php require_once __DIR__ . '/includes/head-header.php'; ?>
    <style>
        /* 
         * Restaurant page loads a different CSS stack than other pages.
         * Other pages set html font-size: 20px (see assets/css/style.css), which makes Tailwind rem-based sizes larger.
         * To keep restaurant content unchanged while matching global header/footer sizing, we normalize header/footer
         * to the same pixel sizes used on the rest of the site.
         */
        .site-header-wrapper > div {
            height: 100px !important; /* match 5rem @ 20px root */
        }
        .site-header-wrapper img.h-10 {
            height: 50px !important; /* match h-10 @ 20px root */
        }
        .site-header-wrapper nav a,
        .site-header-wrapper nav button.nav-link,
        .site-header-wrapper .header-book-btn {
            font-size: 15px !important; /* match text-xs @ 20px root */
        }
        footer {
            font-size: 20px; /* align rem-based footer scale with other pages */
        }
        footer .text-xs {
            font-size: 15px !important;
        }

        /* Scope restaurant-only theme tokens to avoid overriding site-wide tokens */
        .restaurant-scope .bg-background-light {
            background-color: #EDEAE5 !important;
        }
        .restaurant-scope .bg-background-dark {
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
    <div class="restaurant-scope relative flex min-h-screen w-full flex-col group/design-root bg-background-dark text-white font-display">
  
    <!-- Hero Section -->
    <div class="relative w-full">
        <div class="@container">
            <div class="flex min-h-screen flex-col gap-6 bg-cover bg-center bg-no-repeat items-center justify-center p-4 relative hero-font-serif" style='background-image: linear-gradient(rgba(58, 58, 58, 0.4) 0%, rgba(58, 58, 58, 0.8) 100%), url("<?= e($heroBackground) ?>");'>
                <div class="flex flex-col gap-6 text-center max-w-[800px] animate-fade-in-up">
                    <h2 class="text-white text-sm font-bold tracking-[0.2em] uppercase"><?= e($heroSubtitle) ?></h2>
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight tracking-[-0.033em] italic">
                        <?= e($heroTitle) ?>
                    </h1>
                    <h2 class="text-white/80 text-lg md:text-xl font-normal leading-relaxed max-w-[600px] mx-auto">
                        <?= e($heroDescription) ?>
                    </h2>
                </div>
                <a href="#reservation" class="mt-8 flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-8 bg-primary hover:bg-primary/90 transition-all transform hover:scale-105 text-white text-base font-bold leading-normal tracking-[0.015em] shadow-lg shadow-primary/20">
                    <span class="truncate"><?= e($heroButtonText) ?></span>
                </a>
                <div class="absolute bottom-10 animate-bounce">
                    <span class="material-symbols-outlined text-white/50 text-4xl">keyboard_arrow_down</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Philosophy Section -->
    <div class="flex flex-col items-center justify-center py-16 px-4 md:px-10 lg:px-40 bg-background-dark">
        <div class="max-w-[1200px] w-full flex flex-col gap-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="flex flex-col gap-8">
                    <div class="flex flex-col gap-4">
                        <span class="text-white font-bold tracking-widest text-xs uppercase"><?= e($philosophySubtitle) ?></span>
                        <h2 class="text-white text-4xl md:text-5xl font-display font-bold leading-tight">
                            <?= e($philosophyTitle) ?>
                        </h2>
                        <p class="text-white/75 text-lg leading-relaxed font-sans">
                            <?= nl2br(e($philosophyDescription)) ?>
                        </p>
                        <div class="border-l-2 border-primary pl-6 py-2 mt-4">
                            <p class="text-white text-xl italic font-display">
                                <?= e($philosophyQuote) ?>
                            </p>
                            <p class="text-white mt-2 text-sm font-bold uppercase tracking-widest"><?= e($philosophyQuoteAuthor) ?></p>
                        </div>
                    </div>
                    <button class="group flex items-center gap-2 text-white font-bold text-sm tracking-wide uppercase hover:text-primary transition-colors w-fit">
                        <span><?= e($philosophyButtonText) ?></span>
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform text-lg">arrow_forward</span>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-4 mt-12">
                        <div class="rounded-lg aspect-[3/4] w-full overflow-hidden transform hover:-translate-y-2 transition-transform duration-500">
                            <img src="<?= e($philosophyImage1) ?>" alt="Philosophy" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="rounded-lg aspect-[3/4] w-full overflow-hidden transform hover:-translate-y-2 transition-transform duration-500">
                            <img src="<?= e($philosophyImage2) ?>" alt="Philosophy" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-10 border-t border-white/20">
                <!-- Card 1 (white) -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-white hover:bg-slate-50 transition-colors border border-slate-200">
                    <span class="material-symbols-outlined text-primary text-4xl"><?= e($feature1Icon) ?></span>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-primary text-xl font-bold font-display"><?= e($feature1Title) ?></h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-sans"><?= e($feature1Description) ?></p>
                    </div>
                </div>
                <!-- Card 2 (red) -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#C71C1C] hover:bg-[#B31818] transition-colors border border-[#C71C1C]">
                    <span class="material-symbols-outlined text-white text-4xl"><?= e($feature2Icon) ?></span>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-white text-xl font-bold font-display"><?= e($feature2Title) ?></h3>
                        <p class="text-white/90 text-sm leading-relaxed font-sans"><?= e($feature2Description) ?></p>
                    </div>
                </div>
                <!-- Card 3 (red) -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#C71C1C] hover:bg-[#B31818] transition-colors border border-[#C71C1C]">
                    <span class="material-symbols-outlined text-white text-4xl"><?= e($feature3Icon) ?></span>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-white text-xl font-bold font-display"><?= e($feature3Title) ?></h3>
                        <p class="text-white/90 text-sm leading-relaxed font-sans"><?= e($feature3Description) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dining Experience (3 Cards) -->
    <section class="py-16 bg-white">
        <div class="max-w-[1200px] mx-auto px-4 md:px-10 lg:px-16 flex flex-col gap-12">
            <div class="text-center max-w-[900px] mx-auto flex flex-col gap-4">
                <h2 class="text-primary text-3xl md:text-5xl font-display font-bold leading-tight">
                    <?= e($diningTitle) ?>
                </h2>
                <p class="text-slate-700 text-base md:text-lg leading-relaxed font-sans">
                    <?= e($diningIntro) ?>
                </p>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed font-sans">
                    <?= e($diningDescription) ?>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Food -->
                <div class="p-8 rounded-2xl bg-[#262161] border border-white/10 hover:border-white/30 transition-colors shadow-sm">
                    <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-white/10 border border-white/10 mb-6">
                        <img src="<?= e($diningCard1Image) ?>" alt="<?= e($diningCard1Title) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="mb-4">
                        <h3 class="text-white text-xl font-display font-bold"><?= e($diningCard1Title) ?></h3>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed font-sans">
                        <?= e($diningCard1Description) ?>
                    </p>
                </div>

                <!-- Card 2: Ambience -->
                <div class="p-8 rounded-2xl bg-[#262161] border border-white/10 hover:border-white/30 transition-colors shadow-sm">
                    <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-white/10 border border-white/10 mb-6">
                        <img src="<?= e($diningCard2Image) ?>" alt="<?= e($diningCard2Title) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="mb-4">
                        <h3 class="text-white text-xl font-display font-bold"><?= e($diningCard2Title) ?></h3>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed font-sans">
                        <?= e($diningCard2Description) ?>
                    </p>
                </div>

                <!-- Card 3: Interior -->
                <div class="p-8 rounded-2xl bg-[#262161] border border-white/10 hover:border-white/30 transition-colors shadow-sm">
                    <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-white/10 border border-white/10 mb-6">
                        <img src="<?= e($diningCard3Image) ?>" alt="<?= e($diningCard3Title) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="mb-4">
                        <h3 class="text-white text-xl font-display font-bold"><?= e($diningCard3Title) ?></h3>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed font-sans">
                        <?= e($diningCard3Description) ?>
                    </p>
                </div>
            </div>

            <div class="text-center">
                <p class="text-slate-700 font-sans">
                    <?= nl2br(e($diningCta)) ?>
                </p>
            </div>
        </div>
    </section>
    
    <!-- Ambience Section -->
    <div class="py-16 px-4 md:px-10 lg:px-40 bg-white relative overflow-hidden">
        <!-- Background Texture (subtle on white) -->
        <div class="absolute inset-0 opacity-[0.035] pointer-events-none" style="background-image: radial-gradient(#262161 1px, transparent 1px); background-size: 32px 32px;"></div>
        <div class="max-w-[1200px] mx-auto flex flex-col md:flex-row items-center gap-16 relative z-10">
            <div class="w-full md:w-1/2 flex flex-col gap-6">
                <span class="text-primary font-bold tracking-widest text-xs uppercase"><?= e($ambienceSubtitle) ?></span>
                <h2 class="text-slate-900 text-4xl md:text-5xl font-display font-bold leading-tight">
                    <?= e($ambienceTitle) ?>
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed font-sans">
                    <?= nl2br(e($ambienceDescription1)) ?>
                </p>
                <p class="text-slate-600 text-lg leading-relaxed font-sans">
                    <?= nl2br(e($ambienceDescription2)) ?>
                </p>
                <div class="flex gap-4 mt-4">
                    <button class="flex min-w-[140px] cursor-pointer items-center justify-center rounded-lg h-12 px-6 bg-primary text-white hover:bg-[#C71C1C] transition-all text-sm font-bold shadow-lg shadow-primary/20">
                        <?= e($ambienceButtonText) ?>
                    </button>
                </div>
            </div>
            <div class="w-full md:w-1/2 relative">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4 translate-y-8">
                        <div class="w-full aspect-[3/4] rounded-lg overflow-hidden border border-slate-200">
                            <img src="<?= e($ambienceImage1) ?>" alt="Ambience" class="w-full h-full object-cover">
                        </div>
                        <div class="w-full aspect-square rounded-lg overflow-hidden border border-slate-200">
                            <img src="<?= e($ambienceImage2) ?>" alt="Ambience" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="w-full aspect-square rounded-lg overflow-hidden border border-slate-200">
                            <img src="<?= e($ambienceImage3) ?>" alt="Ambience" class="w-full h-full object-cover">
                        </div>
                        <div class="w-full aspect-[3/4] rounded-lg overflow-hidden border border-slate-200">
                            <img src="<?= e($ambienceImage4) ?>" alt="Ambience" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reservation CTA Strip (removed) -->
    
    </div>
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    
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
