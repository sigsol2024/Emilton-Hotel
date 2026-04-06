<?php
/**
 * Bar Page - Luxury Bar & Lounge Experience
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

// Load bar page sections with defaults
$heroSubtitle = getPageSection('bar', 'hero_subtitle', 'Bar & Lounge');
$heroTitle = getPageSection('bar', 'hero_title', 'Emilton Bar & Lounge');
$heroIntro = getPageSection('bar', 'hero_intro', 'Welcome to Emilton Bar & Lounge, a sophisticated relaxation space designed for guests who appreciate premium drinks, stylish surroundings, and a calm social atmosphere. Whether you\'re unwinding after a long day, hosting a casual meeting, or enjoying an evening out, Emilton Bar offers the perfect setting.');
$heroBackground = getPageSection('bar', 'hero_background', 'assets/img/about1.jpg');

// Section 1: Premium Drinks
$drinksTitle = getPageSection('bar', 'drinks_title', 'Carefully Curated Beverages');
$drinksDescription = getPageSection('bar', 'drinks_description', 'At Emilton Bar, we offer an impressive selection of beverages crafted to suit refined tastes. From expertly mixed cocktails to premium spirits and fine wines, every drink is served with attention to quality and presentation.');
$drinksImage = getPageSection('bar', 'drinks_image', 'assets/img/about1.jpg');
$drinksBulletLabel = getPageSection('bar', 'drinks_bullet_label', 'What we offer:');
$drinksBullet1 = getPageSection('bar', 'drinks_bullet_1', 'Signature cocktails');
$drinksBullet2 = getPageSection('bar', 'drinks_bullet_2', 'Premium wines & champagnes');
$drinksBullet3 = getPageSection('bar', 'drinks_bullet_3', 'Top-shelf spirits');
$drinksBullet4 = getPageSection('bar', 'drinks_bullet_4', 'Non-alcoholic beverages and mocktails');
$drinksFooter = getPageSection('bar', 'drinks_footer', 'Each drink is prepared by skilled bartenders to ensure consistency, balance, and satisfaction.');

// Section 2: Ambience
$ambienceTitle = getPageSection('bar', 'ambience_title', 'Relaxed, Stylish & Inviting');
$ambienceDescription = getPageSection('bar', 'ambience_description', 'The Emilton Bar & Lounge features a warm and relaxed atmosphere enhanced by tasteful lighting, modern décor, and comfortable seating. Designed to encourage conversation and relaxation, the space is ideal for both quiet evenings and social moments. Whether you prefer a calm corner or a lively setting, our bar provides the right mood for every occasion.');
$ambienceImage = getPageSection('bar', 'ambience_image', 'assets/img/about1.jpg');

// Section 3: Interior
$interiorTitle = getPageSection('bar', 'interior_title', 'Contemporary Bar Interior');
$interiorDescription = getPageSection('bar', 'interior_description', 'Our bar interior reflects modern luxury, combining sleek finishes with elegant design elements. The thoughtfully arranged seating ensures comfort and privacy, making it suitable for individuals, couples, and small groups. The layout balances style and function, allowing guests to enjoy their drinks in a refined yet welcoming environment.');
$interiorImage = getPageSection('bar', 'interior_image', 'assets/img/about1.jpg');

// Why Choose Section
$whyChooseTitle = getPageSection('bar', 'why_choose_title', 'Why Choose Emilton Bar & Lounge');
$whyChooseCard1Icon = getPageSection('bar', 'why_choose_card_1_icon', 'local_bar');
$whyChooseCard1Title = getPageSection('bar', 'why_choose_card_1_title', 'Premium drinks and cocktails');
$whyChooseCard1Description = getPageSection('bar', 'why_choose_card_1_description', 'Expertly crafted beverages using quality ingredients');
$whyChooseCard2Icon = getPageSection('bar', 'why_choose_card_2_icon', 'spa');
$whyChooseCard2Title = getPageSection('bar', 'why_choose_card_2_title', 'Elegant and relaxed environment');
$whyChooseCard2Description = getPageSection('bar', 'why_choose_card_2_description', 'Tasteful décor and comfortable seating');
$whyChooseCard3Icon = getPageSection('bar', 'why_choose_card_3_icon', 'room_service');
$whyChooseCard3Title = getPageSection('bar', 'why_choose_card_3_title', 'Professional and friendly service');
$whyChooseCard3Description = getPageSection('bar', 'why_choose_card_3_description', 'Attentive staff ensuring your comfort');
$whyChooseCard4Icon = getPageSection('bar', 'why_choose_card_4_icon', 'location_on');
$whyChooseCard4Title = getPageSection('bar', 'why_choose_card_4_title', 'Conveniently located within Emilton Hotel & Suites');
$whyChooseCard4Description = getPageSection('bar', 'why_choose_card_4_description', 'Perfect for leisure, meetings, and evening relaxation');

// Closing CTA
$ctaTitle = getPageSection('bar', 'cta_title', 'Unwind in Style');
$ctaDescription = getPageSection('bar', 'cta_description', 'Step into Emilton Bar & Lounge and enjoy premium drinks, refined ambience, and exceptional service—all designed to elevate your evening experience.');
$ctaTagline = getPageSection('bar', 'cta_tagline', 'Relax. Sip. Enjoy.');
$ctaBackground = getPageSection('bar', 'cta_background', '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= e($siteName) ?> - Bar & Lounge</title>
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

        /* Scope bar-only theme tokens */
        .bar-scope .bg-background-light {
            background-color: #EDEAE5 !important;
        }
        .bar-scope .bg-background-dark {
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
    <div class="bar-scope relative flex min-h-screen w-full flex-col group/design-root bg-background-dark text-white font-display">
  
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
    
    <!-- Section 1: Premium Drinks Experience -->
    <div class="py-16 px-4 md:px-10 lg:px-40 bg-background-dark">
        <div class="max-w-[1200px] mx-auto flex flex-col md:flex-row items-center gap-16">
            <div class="w-full md:w-1/2">
                <div class="w-full aspect-[4/3] rounded-lg overflow-hidden border border-white/20">
                    <img src="<?= e($drinksImage) ?>" alt="<?= e($drinksTitle) ?>" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="w-full md:w-1/2 flex flex-col gap-6">
                <h2 class="text-white text-4xl md:text-5xl font-display font-bold leading-tight">
                    <?= e($drinksTitle) ?>
                </h2>
                <p class="text-white/75 text-lg leading-relaxed font-sans">
                    <?= nl2br(e($drinksDescription)) ?>
                </p>
                <div class="mt-4">
                    <p class="text-white font-semibold mb-3 font-sans"><?= e($drinksBulletLabel) ?></p>
                    <ul class="space-y-2 text-white/75 font-sans">
                        <li class="flex items-start gap-2">
                            <span class="text-primary mt-1">•</span>
                            <span><?= e($drinksBullet1) ?></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary mt-1">•</span>
                            <span><?= e($drinksBullet2) ?></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary mt-1">•</span>
                            <span><?= e($drinksBullet3) ?></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-primary mt-1">•</span>
                            <span><?= e($drinksBullet4) ?></span>
                        </li>
                    </ul>
                </div>
                <p class="text-white/70 text-base leading-relaxed font-sans mt-2">
                    <?= e($drinksFooter) ?>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Section 2: Ambience & Atmosphere -->
    <div class="py-16 px-4 md:px-10 lg:px-40 bg-white">
        <div class="max-w-[1200px] mx-auto flex flex-col md:flex-row-reverse items-center gap-16">
            <div class="w-full md:w-1/2">
                <div class="w-full aspect-[4/3] rounded-lg overflow-hidden border border-slate-200 shadow-sm">
                    <img src="<?= e($ambienceImage) ?>" alt="<?= e($ambienceTitle) ?>" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="w-full md:w-1/2 flex flex-col gap-6">
                <h2 class="text-slate-900 text-4xl md:text-5xl font-display font-bold leading-tight">
                    <?= e($ambienceTitle) ?>
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed font-sans">
                    <?= nl2br(e($ambienceDescription)) ?>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Section 3: Interior Design & Seating -->
    <div class="py-16 px-4 md:px-10 lg:px-40 bg-background-dark">
        <div class="max-w-[1200px] mx-auto flex flex-col md:flex-row items-center gap-16">
            <div class="w-full md:w-1/2">
                <div class="w-full aspect-[4/3] rounded-lg overflow-hidden border border-white/20">
                    <img src="<?= e($interiorImage) ?>" alt="<?= e($interiorTitle) ?>" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="w-full md:w-1/2 flex flex-col gap-6">
                <h2 class="text-white text-4xl md:text-5xl font-display font-bold leading-tight">
                    <?= e($interiorTitle) ?>
                </h2>
                <p class="text-white/75 text-lg leading-relaxed font-sans">
                    <?= nl2br(e($interiorDescription)) ?>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Why Choose Section -->
    <div class="py-16 px-4 md:px-10 lg:px-40 bg-white">
        <div class="max-w-[1200px] mx-auto flex flex-col gap-12">
            <div class="text-center">
                <h2 class="text-slate-900 text-4xl md:text-5xl font-display font-bold leading-tight">
                    <?= e($whyChooseTitle) ?>
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-white border border-slate-200 hover:border-primary/50 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-primary text-4xl"><?= e($whyChooseCard1Icon) ?></span>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-primary text-xl font-bold font-display"><?= e($whyChooseCard1Title) ?></h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-sans"><?= e($whyChooseCard1Description) ?></p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#C71C1C] border border-[#C71C1C] hover:bg-[#C71C1C]/90 transition-colors">
                    <span class="material-symbols-outlined text-white text-4xl"><?= e($whyChooseCard2Icon) ?></span>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-white text-xl font-bold font-display"><?= e($whyChooseCard2Title) ?></h3>
                        <p class="text-white/90 text-sm leading-relaxed font-sans"><?= e($whyChooseCard2Description) ?></p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-[#262161] border border-[#262161] hover:bg-[#262161]/90 transition-colors">
                    <span class="material-symbols-outlined text-white text-4xl"><?= e($whyChooseCard3Icon) ?></span>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-white text-xl font-bold font-display"><?= e($whyChooseCard3Title) ?></h3>
                        <p class="text-white/90 text-sm leading-relaxed font-sans"><?= e($whyChooseCard3Description) ?></p>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="flex flex-col gap-4 p-6 rounded-xl bg-white border border-slate-200 hover:border-primary/50 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-primary text-4xl"><?= e($whyChooseCard4Icon) ?></span>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-primary text-xl font-bold font-display"><?= e($whyChooseCard4Title) ?></h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-sans"><?= e($whyChooseCard4Description) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Closing CTA Section -->
    <div class="py-16 px-4 md:px-10 lg:px-40 relative <?= !empty($ctaBackground) ? '' : 'bg-white' ?>" <?= !empty($ctaBackground) ? 'style="background-image: linear-gradient(rgba(58, 58, 58, 0.6) 0%, rgba(58, 58, 58, 0.8) 100%), url(\'' . e($ctaBackground) . '\'); background-size: cover; background-position: center; background-repeat: no-repeat;"' : '' ?>>
        <div class="max-w-[800px] mx-auto text-center flex flex-col gap-6 relative z-10">
            <h2 class="<?= !empty($ctaBackground) ? 'text-white' : 'text-primary' ?> text-3xl md:text-5xl font-display font-bold leading-tight">
                <?= e($ctaTitle) ?>
            </h2>
            <p class="<?= !empty($ctaBackground) ? 'text-white/90' : 'text-slate-600' ?> text-lg leading-relaxed font-sans">
                <?= nl2br(e($ctaDescription)) ?>
            </p>
            <p class="<?= !empty($ctaBackground) ? 'text-white' : 'text-primary' ?> text-xl md:text-2xl font-display font-bold italic mt-4">
                <?= e($ctaTagline) ?>
            </p>
        </div>
    </div>
    
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

