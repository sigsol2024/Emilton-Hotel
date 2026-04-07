<?php
/**
 * Homepage - Dynamic Content
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

// Load homepage sections
$heroTitle = getPageSection('index', 'hero_title', 'YOUR HOME <span class="cs_accent_color cs_ternary_font cs_hover_layer_2" style="color:#343a40;">away</span> FROM HOME');
$heroBackgroundRaw = getPageSection('index', 'hero_background', 'assets/rooms/luxury-apartment-ajao-estate-bedroom.webp');
// Handle both old single image format and new JSON array format
$heroBackgrounds = [];
$decoded = json_decode($heroBackgroundRaw, true);
if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && !empty($decoded)) {
    $heroBackgrounds = array_filter($decoded);
} else {
    // Old format - single image string
    if (!empty($heroBackgroundRaw)) {
        $heroBackgrounds = [$heroBackgroundRaw];
    }
}
$heroBackground = !empty($heroBackgrounds) ? $heroBackgrounds[0] : 'assets/rooms/luxury-apartment-ajao-estate-bedroom.webp';
$heroCtaText = getPageSection('index', 'hero_cta_text', 'Book Now');
$heroCtaLink = getPageSection('index', 'hero_cta_link', 'rooms.php');
$aboutTitle = getPageSection('index', 'about_title', 'EXPERIENCE THE BEAUTY OF CHRISTMAS AT TM Luxury Apartments - Ajoa Estate Airport Road, <span class="cs_accent_color cs_ternary_font"> Lagos.</span>');
$aboutDescription = getPageSection('index', 'about_description', 'TM is a premiere luxury apartment crafted for comfort, elegance, and a memorable stay. We are committed to give you <br> the best vacation experience you will ever have and truly cherish.');
$aboutImage = getPageSection('index', 'about_image', 'assets/rooms/beautiful-short-let-apartment-in-ajao-estate-lagos.webp');
$aboutFlowerImage = getPageSection('index', 'about_flower_image', 'assets/img/flower.svg');
$featuredRoomsTitle = getPageSection('index', 'featured_rooms_title', 'We provide luxury & fully serviced apartments in Ajao Estate designed for guests who value comfort and privacy.');
// Load feature boxes data
$featureBox1Image = getPageSection('index', 'feature_box_1_image', 'assets/img/about1.jpg');
$featureBox1Title = getPageSection('index', 'feature_box_1_title', 'Luxury Accommodation');
$featureBox1Description = getPageSection('index', 'feature_box_1_description', 'Experience comfort and elegance in our thoughtfully designed spaces.');
$featureBox2Image = getPageSection('index', 'feature_box_2_image', 'assets/img/about1.jpg');
$featureBox2Title = getPageSection('index', 'feature_box_2_title', 'Fine Dining');
$featureBox2Description = getPageSection('index', 'feature_box_2_description', 'Enjoy exceptional cuisine in our elegant restaurant setting.');
$featureBox3Image = getPageSection('index', 'feature_box_3_image', 'assets/img/about1.jpg');
$featureBox3Title = getPageSection('index', 'feature_box_3_title', 'Premium Amenities');
$featureBox3Description = getPageSection('index', 'feature_box_3_description', 'Relax and unwind with our world-class facilities and services.');
$roomsSectionSubtitle = getPageSection('index', 'rooms_section_subtitle', 'Experience luxury living in a fully smart Apartment');
$roomsSectionTitle = getPageSection('index', 'rooms_section_title', 'Truly luxury — just for you.');
$roomsSectionDescription = getPageSection('index', 'rooms_section_description', 'TM Luxury Apartments provides premium luxury apartments in Ajao Estate, Lagos, offering comfort, security,and modern living for short-let and serviced apartment guests. All available for booking rightaway.');
$whyChooseTitle = getPageSection('index', 'why_choose_title', 'Why Choose TM Luxury Apartments in Ajao Estate?');
$whyChooseDescription = getPageSection('index', 'why_choose_description', 'At Tm, we provide luxury range of accommodations to make your stay comfortable and enjoyable. <br> We make sure you have the most memorable experience staying at TM luxury apartment.');
$whyChooseImage1 = getPageSection('index', 'why_choose_image_1', 'assets/rooms/3_Bedroom_Guangzhou.webp');
$whyChooseImage2 = getPageSection('index', 'why_choose_image_2', 'assets/rooms/1Bedroom_LagosPK.webp');
$whyChooseTitle1 = getPageSection('index', 'why_choose_title_1', 'Luxury Apartments');
$whyChooseTitle2 = getPageSection('index', 'why_choose_title_2', 'Exceptional Interiors');
$awardsSubtitle = getPageSection('index', 'awards_subtitle', 'TM Luxury Apartment Located in Ajao Estate Airport Rd.');
$awardsTitle = getPageSection('index', 'awards_title', 'Only Excellence Just For You');
$awardImage1 = getPageSection('index', 'award_image_1', 'assets/rooms/2bedroom_tokyo_palour.webp');
$awardImage2 = getPageSection('index', 'award_image_2', 'assets/img/about1.jpg');
$awardImage3 = getPageSection('index', 'award_image_3', 'assets/rooms/beautiful-apartments-in-ajao-airport-road.webp');
$awardTitle1 = getPageSection('index', 'award_title_1', 'Luxury Apartment');
$awardTitle2 = getPageSection('index', 'award_title_2', 'Top-Class Standard');
$awardTitle3 = getPageSection('index', 'award_title_3', 'Closer to Airport');
$bookingCtaTitle = getPageSection('index', 'booking_cta_title', 'Shanghai Suite');
$bookingCtaDescription = getPageSection('index', 'booking_cta_description', 'Availability is Limited — Book Your Stay Today.');
$bookingCtaBackground = getPageSection('index', 'booking_cta_background', 'assets/img/about1.jpg');

// Booking widget HTML (rendered in the hero bridge area)
$bookingWidgetHtml = getPageSection('index', 'booking_widget_html', '');

// Load rooms
$featuredRooms = getRooms(['is_featured' => 1, 'is_active' => 1, 'limit' => 3]);
$activeRooms = getRooms(['is_active' => 1]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Book a luxury apartment in Ajao Estate Lagos. TM Luxury Apartments offers premium serviced apartments with modern comfort and security.">
    <meta name="author" content="<?= e($siteName) ?>">
    <!-- Favicon -->
    <link rel="icon" href="<?= e($siteFavicon) ?>" />
    <!-- All CSS Files -->
    <link rel="stylesheet" href="code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/slick.min.css" />
    <link rel="stylesheet" href="assets/css/aos.min.css" />
    <link rel="stylesheet" href="assets/css/datepicker.css" />
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/css/lightgallery.min.css" />
    <link rel="stylesheet" href="assets/css/odometer.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- Header Head Includes (Tailwind CSS, Fonts) -->
    <?php require_once __DIR__ . '/includes/head-header.php'; ?>
    <!-- Hero Slider Styles -->
    <style>
        .hero-slider-container {
            overflow: visible;
        }
        .hero-slider-wrapper {
            position: relative;
            width: 100%;
            min-height: 100vh;
            overflow: hidden;
        }
        .hero-slides {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
            animation: kenBurns 20s ease-in-out infinite;
        }
        .hero-slide.active {
            opacity: 1;
            z-index: 1;
        }
        .hero-slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.3) 100%);
            z-index: 1;
        }
        @keyframes kenBurns {
            0% {
                transform: scale(1) translate(0, 0);
            }
            50% {
                transform: scale(1.1) translate(-2%, -2%);
            }
            100% {
                transform: scale(1) translate(0, 0);
            }
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-content h1 {
            transition: opacity 1s ease-out;
        }
        .hero-content h1.fade-out {
            opacity: 0;
        }
        .booking-widget-bridge {
            z-index: 20 !important;
            position: absolute !important;
        }
    </style>
    <!-- Booking Widget Custom Styles -->
    <style>
        /* Booking widget background color - set to primary color */
        #booking-emilton #booking-widget,
        #booking-emilton [id*="booking-widget"],
        #booking-emilton [id*="booking"] {
            background-color: #262161 !important;
            border-color: rgba(255,255,255,0.2) !important;
        }
        
        /* Booking widget - ensure proper padding on all screen sizes */
        #booking-emilton #booking-widget {
            padding: 20px 30px !important;
            max-width: 1000px !important;
            margin: 20px auto !important;
        }
        
        /* Ensure form has proper spacing */
        #booking-emilton #booking-form,
        #booking-emilton form {
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            gap: 15px !important;
            align-items: flex-end !important;
            flex-wrap: wrap !important;
        }
        
        /* Ensure form field groups have proper spacing */
        #booking-emilton #booking-form > div,
        #booking-emilton form > div {
            flex: 1 1 auto !important;
            min-width: 120px !important;
            margin-bottom: 0 !important;
        }
        
        /* Add responsive padding for wider screens */
        @media (min-width: 1200px) {
            #booking-emilton #booking-widget {
                padding: 25px 40px !important;
            }
            
            #booking-emilton #booking-form,
            #booking-emilton form {
                gap: 20px !important;
            }
        }
        
        @media (min-width: 1400px) {
            #booking-emilton #booking-widget {
                padding: 30px 50px !important;
            }
        }
        
        /* Ensure no extra background on outer wrapper */
        #booking-emilton {
            background: transparent !important;
            padding: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        
        /* Reduce all text sizes in booking widget */
        #booking-emilton * {
            font-size: 14px !important;
        }
        
        /* Labels - white text */
        #booking-emilton label,
        #booking-emilton label[for] {
            font-size: 13px !important;
            font-weight: bold !important;
            color: white !important;
        }
        
        #booking-emilton span:not(.material-symbols-outlined) {
            font-size: 13px !important;
            font-weight: 500 !important;
        }
        
        /* Input fields - ensure readability on dark background */
        #booking-emilton input[type="text"],
        #booking-emilton input[type="date"],
        #booking-emilton input[type="number"],
        #booking-emilton select {
            font-size: 14px !important;
            padding: 8px 12px !important;
            height: auto !important;
            background-color: white !important;
            color: #1b180d !important;
            border: 1px solid rgba(255,255,255,0.3) !important;
        }
        
        #booking-emilton input::placeholder {
            color: #666 !important;
        }
        
        /* Button styling - Check Availability and similar buttons */
        #booking-emilton button,
        #booking-emilton input[type="submit"],
        #booking-emilton input[type="button"],
        #booking-emilton .btn,
        #booking-emilton [class*="button"],
        #booking-emilton [class*="btn"] {
            font-size: 14px !important;
            padding: 10px 24px !important;
            min-height: auto !important;
            height: auto !important;
            line-height: 1.4 !important;
            font-weight: 600 !important;
            background-color: #c71c1c !important;
            color: white !important;
            border: none !important;
        }
        
        #booking-emilton button:hover,
        #booking-emilton input[type="submit"]:hover,
        #booking-emilton input[type="button"]:hover {
            background-color: #a01515 !important;
        }
        
        /* Mobile-specific styles - remove bridging effect and fix alignment */
        @media (max-width: 767px) {
            /* Remove absolute positioning on mobile - widget comes after hero */
            .booking-widget-bridge {
                position: relative !important;
                bottom: auto !important;
                margin-top: 0 !important;
                margin-bottom: 20px !important;
            }
            
            /* Container adjustments for mobile */
            .booking-widget-bridge .container {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            
            .booking-widget-bridge .row {
                margin: 0 !important;
            }
            
            .booking-widget-bridge .col-md-12 {
                padding: 0 !important;
            }
            
            /* Adjust about section padding on mobile */
            section.cs_cream_bg {
                padding-top: 40px !important;
            }
            
            /* Widget styling for mobile */
            #booking-emilton #booking-widget {
                padding: 20px !important;
                margin: 20px 15px !important;
                max-width: calc(100% - 30px) !important;
            }
            
            /* Form layout - stack vertically on mobile */
            #booking-emilton #booking-form,
            #booking-emilton form {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 15px !important;
            }
            
            /* Form field groups - full width and left-aligned on mobile */
            #booking-emilton #booking-form > div,
            #booking-emilton form > div {
                width: 100% !important;
                flex: none !important;
                min-width: auto !important;
                margin-bottom: 0 !important;
            }
            
            /* Ensure labels and inputs are left-aligned */
            #booking-emilton label {
                text-align: left !important;
                display: block !important;
            }
            
            #booking-emilton input[type="text"],
            #booking-emilton input[type="date"],
            #booking-emilton input[type="number"],
            #booking-emilton select {
                width: 100% !important;
            }
            
            /* Button full width on mobile */
            #booking-emilton button,
            #booking-emilton input[type="submit"],
            #booking-emilton input[type="button"] {
                width: 100% !important;
                margin-top: 0 !important;
            }
        }
        
        /* Desktop-only spacing adjustments for About section */
        @media (min-width: 768px) {
            .desktop-spacing-remove {
                display: none !important;
            }
            .desktop-spacing-widget {
                height: 60px;
                display: block;
            }
        }
        @media (max-width: 767px) {
            .desktop-spacing-widget {
                display: none !important;
            }
        }
    </style>
    <!-- Site Title -->
    <title><?= e($siteName) ?> | Luxury Apartment in Ajao Estate, Lagos</title>
</head>
<body>
    <?php require_once __DIR__ . '/includes/body-scripts.php'; ?>
    <!-- Include Header Template -->
    <?php require_once __DIR__ . '/includes/header.php'; ?>
  
    <!-- Hero Section -->
    <div class="relative w-full hero-slider-container" style="position: relative;">
        <div class="@container">
            <div class="hero-slider-wrapper flex min-h-screen flex-col gap-6 items-center justify-center p-4 relative hero-font-serif">
                <?php if (count($heroBackgrounds) > 1): ?>
                    <!-- Multiple images - slider with Ken Burns effect -->
                    <div class="hero-slides">
                        <?php foreach ($heroBackgrounds as $index => $bg): ?>
                            <div class="hero-slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" style='background-image: url("<?= e($bg) ?>");'>
                                <div class="hero-slide-overlay"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Single image - no slider -->
                    <div class="hero-slide active" style='background-image: url("<?= e($heroBackground) ?>");'>
                        <div class="hero-slide-overlay"></div>
                    </div>
                <?php endif; ?>
                <div class="hero-content flex flex-col gap-6 text-center max-w-[1200px] animate-fade-in-up" style="position: relative; z-index: 2;">
                    <h1 id="hero-title" class="text-white text-5xl md:text-7xl font-black leading-tight tracking-[-0.033em] italic" data-aos="zoom-in"><?= $heroTitle ?></h1>
                </div>
            </div>
        </div>
        <!-- Booking Widget Bridge - Positioned absolutely to bridge sections -->
        <div class="booking-widget-bridge" style="position: absolute; bottom: -100px; left: 0; right: 0; width: 100%; z-index: 10;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $widgetHtml = trim((string)$bookingWidgetHtml);
                        if ($widgetHtml !== '') {
                            echo $widgetHtml;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->
    
    <!-- Start About Section -->
    <section class="cs_cream_bg" style="position: relative; padding-top: 140px;">
      <div class="cs_height_120 cs_height_lg_80 desktop-spacing-remove"></div>
      <div class="container">
        <div class="cs_card cs_style_1 cs_center_column text-center">
          <span class="cs_flower_shape" data-aos="zoom-in">
          <img src="<?= e($aboutFlowerImage) ?>" alt="Flower shape">
          </span>
          <h2 class="cs_card_title cs_fs_64 position-relative z-1 mb-0"><?= $aboutTitle ?></h2>
          <div class="desktop-spacing-widget"></div>
          <div class="cs_card_thumbnail" data-aos="fade-up">
            <img src="<?= e($aboutImage) ?>" style="height:300px, width:1000px!important" alt="Card image">
          </div>
          <?= $aboutDescription ?>
      </div>
    </section>

<section style="height: fit-content;">
      <div class="cs_height_60 cs_height_lg_40"></div>
      <div class="container">
        <div class="cs_section_heading cs_style_1 text-center">
          <h4 class="cs_section_title cs_fs_64 mb-0" data-aos="zoom-in"><?= e($featuredRoomsTitle) ?></h4>
        </div>
        <div class="cs_height_73 cs_height_lg_45"></div>
        
        <!-- Three Feature Boxes Section -->
        <div class="row cs_gap_y_30 mb-5">
          <div class="col-lg-4 col-md-6">
            <div class="group relative flex flex-col rounded-xl bg-white shadow-sm border border-slate-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1" style="height: 100%;">
              <div class="relative w-full aspect-[4/3] overflow-hidden rounded-t-xl bg-slate-100">
                <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('<?= e($featureBox1Image) ?>');"></div>
              </div>
              <div class="flex flex-1 flex-col p-6">
                <h3 class="text-xl font-bold text-slate-900 mb-2"><?= $featureBox1Title ?></h3>
                <p class="text-slate-600 text-sm leading-relaxed flex-grow mb-4">
                  <?= $featureBox1Description ?>
                </p>
                <a href="rooms.php" class="w-full text-center py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-xs font-semibold hover:bg-[#C71C1C]" style="background-color: #262161; color: white;">
                  <span>Book Now</span>
                  <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="group relative flex flex-col rounded-xl bg-white shadow-sm border border-slate-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1" style="height: 100%;">
              <div class="relative w-full aspect-[4/3] overflow-hidden rounded-t-xl bg-slate-100">
                <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('<?= e($featureBox2Image) ?>');"></div>
              </div>
              <div class="flex flex-1 flex-col p-6">
                <h3 class="text-xl font-bold text-slate-900 mb-2"><?= $featureBox2Title ?></h3>
                <p class="text-slate-600 text-sm leading-relaxed flex-grow mb-4">
                  <?= $featureBox2Description ?>
                </p>
                <a href="rooms.php" class="w-full text-center py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-xs font-semibold hover:bg-[#C71C1C]" style="background-color: #262161; color: white;">
                  <span>Book Now</span>
                  <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="group relative flex flex-col rounded-xl bg-white shadow-sm border border-slate-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1" style="height: 100%;">
              <div class="relative w-full aspect-[4/3] overflow-hidden rounded-t-xl bg-slate-100">
                <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('<?= e($featureBox3Image) ?>');"></div>
              </div>
              <div class="flex flex-1 flex-col p-6">
                <h3 class="text-xl font-bold text-slate-900 mb-2"><?= $featureBox3Title ?></h3>
                <p class="text-slate-600 text-sm leading-relaxed flex-grow mb-4">
                  <?= $featureBox3Description ?>
                </p>
                <a href="rooms.php" class="w-full text-center py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-xs font-semibold hover:bg-[#C71C1C]" style="background-color: #262161; color: white;">
                  <span>Book Now</span>
                  <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="cs_height_73 cs_height_lg_45"></div>
        <div class="cs_grid cs_style_1">
          <?php foreach (array_slice($featuredRooms, 0, 3) as $index => $room): ?>
          <div class="cs_card cs_style_3" data-aos="fade-up" data-aos-delay="<?= $index * 200 ?>">
            <a href="details.php?slug=<?= e($room['slug']) ?>" aria-label="View room details page link" class="cs_card_thumbnail cs_zoom overflow-hidden">
            <img src="<?= e($room['main_image'] ?: 'assets/img/no-image.jpg') ?>" alt="<?= e($room['title']) ?>">
            </a>
            <div class="cs_card_info">
              <h3 class="cs_card_title cs_fs_48 cs_mb_19">
                <a href="details.php?slug=<?= e($room['slug']) ?>" aria-label="View room details page link" style="font-weight:700;"><?= e($room['title']) ?></a>
              </h3>
              <?= $room['short_description'] ? '<p>' . e($room['short_description']) . '</p>' : e($room['description']) ?>
              <a href="details.php?slug=<?= e($room['slug']) ?>" aria-label="Room booking link" class="cs_btn cs_style_1 cs_heading_bg cs_white_color cs_medium text-uppercase" data-aos="fade-up">
          <span>Book Now</span>
          </a>
            </div>
          </div>
          <?php endforeach; ?>
      </div>
    </section>

    <!-- End About Section --> 
    <!-- Start Rooms Section -->
    <section class="cs_heading_bg">
      <div class="container">
        <div class="cs_section_heading cs_style_1 cs_type_1">
          <div class="cs_section_heading_left">
            <p class="cs_section_subtitle cs_fs_24 cs_white_color text-uppercase cs_mb_16" style="line-height:1.6"><?= e($roomsSectionSubtitle) ?></p>
            <h2 class="cs_section_title cs_fs_64 cs_white_color mb-0" data-aos="fade-up"><?= e($roomsSectionTitle) ?></h2>
          </div>
          <div class="cs_section_heading_right" data-aos="fade-left">
            <p class="cs_fs_20 cs_white_color cs_light"><?= e($roomsSectionDescription) ?></p>
            <a href="rooms.php" aria-label="Rooms page visit link" class="cs_text_btn cs_white_color cs_medium text-capitalize">view all rooms</a>
          </div>
        </div>
        <div class="cs_height_66 cs_height_lg_45"></div>
        <div class="cs_slider cs_style_1 cs_slider_gap_138 cs_rooms_slider_wrapper cs_rooms_slider_always_show_arrows">
          <div class="cs_slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-center="0" data-variable-width="0" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="1" data-md-slides="2" data-lg-slides="3" data-add-slides="3">
            <div class="cs_slider_wrapper">
              <?php foreach ($activeRooms as $room): ?>
              <div class="cs_slide">
                <div class="cs_card cs_style_2 cs_rooms_card">
                  <a href="details.php?slug=<?= e($room['slug']) ?>" aria-label="Room details visit link" class="cs_card_thumbnail cs_zoom position-relative overflow-hidden">
                  <img src="<?= e($room['main_image'] ?: 'assets/img/no-image.jpg') ?>" alt="<?= e($room['title']) ?>">
                  </a>
                  <div class="cs_card_info cs_white_bg">
                    <h3 class="cs_card_title cs_rooms_title cs_mb_2"><a href="details.php?slug=<?= e($room['slug']) ?>" aria-label="Room details visit link" style="font-weight:700;"><?= e($room['title']) ?></a></h3>
                    <div class="cs_card_price cs_rooms_price cs_mb_21">
                      <span class="cs_fs_14 cs_heading_color">from</span>
                      <span class="cs_rooms_price_amount cs_accent_color cs_heading_font" style="font-weight:700;">₦<?= number_format($room['price'], 0) ?>/night</span>
                    </div>
                    <ul class="cs_card_meta_wrapper cs_fs_16 cs_normal cs_mp_0">
                      <?php if ($room['room_type']): ?>
                        <li class="cs_card_meta" style="font-weight:700;">room type - <?= e($room['room_type']) ?></li>
                      <?php endif; ?>
                      <?php if ($room['max_guests']): ?>
                        <li class="cs_card_meta" style="font-weight:700;">max-guest: <?= e($room['max_guests']) ?></li>
                      <?php endif; ?>
                      <li class="cs_card_meta" style="font-weight:700;">free WI-FI</li>
                    </ul><br>
                    <a href="details.php?slug=<?= e($room['slug']) ?>" aria-label="Hotel booking button" class="cs_btn cs_style_1 cs_accent_color cs_fs_20 cs_medium"><span>BOOK NOW</span></a>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
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
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Rooms Section -->
    <!-- Start Why Choose Us Section -->
    <section class="cs_cream_bg">
      <div class="container">
        <div class="cs_section_heading cs_style_1 text-center">
          <p class="cs_section_subtitle cs_fs_24 cs_accent_color cs_mb_16 text-uppercase"></p>
          <h2 class="cs_section_title cs_fs_64 mb-0" data-aos="fade-down"><?= e($whyChooseTitle) ?></h2>
        </div>
        <div class="cs_height_66 cs_height_lg_40"></div>
        <div class="cs_grid cs_style_2">
          <div class="cs_card cs_style_4" data-aos="fade-right">
            <h3 class="cs_card_title cs_fs_48 cs_mb_36 cs_mb_lg_24 position-relative">
              <span class="cs_fs_20 cs_accent_color cs_medium">01.</span>
              <?= e($whyChooseTitle1) ?>
            </h3>
            <div class="cs_card_thumbnail">
              <img src="<?= e($whyChooseImage1) ?>" alt="Feature image">
              <img src="<?= e($whyChooseImage1) ?>" alt="Feature image">
            </div>
          </div>
          <div class="cs_card cs_style_4" data-aos="fade-left">
            <h3 class="cs_card_title cs_fs_48 cs_mb_36 cs_mb_lg_24 position-relative">
              <span class="cs_fs_20 cs_accent_color cs_medium">02.</span>
              <?= e($whyChooseTitle2) ?>
            </h3>
            <div class="cs_card_thumbnail">
              <img src="<?= e($whyChooseImage2) ?>" alt="Feature image">
              <img src="<?= e($whyChooseImage2) ?>" alt="Feature image">
            </div>
          </div>
        </div>
       
        <div class="cs_center_column text-center" style="margin-top: 60px;">
          <p class="cs_mb_20 cs_mb_lg_10"><?= $whyChooseDescription ?></p>
          <a href="rooms.php" aria-label="Room booking link" class="cs_btn cs_style_1 cs_heading_bg cs_white_color cs_medium text-uppercase" data-aos="fade-up">
          <span>Book Now</span>
          </a>
        </div>
      </div>
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Why Choose Us Section -->
    <!-- Start Award Section -->
    <section class="cs_heading_bg" id="awards">
      <div class="container"><br>
        <div class="cs_section_heading cs_style_1 text-center">
          <p class="cs_section_subtitle cs_fs_24 cs_white_color cs_mb_16 text-uppercase"><?= e($awardsSubtitle) ?></p>
          <h2 class="cs_section_title cs_fs_64 cs_white_color mb-0" data-aos="fade-down"><?= e($awardsTitle) ?></h2>
        </div>
        <div class="cs_height_73 cs_height_lg_45"></div>
        <div class="cs_award_items_wrapper">
          <div class="cs_award_item cs_style_1 cs_center_column text-center">
            <div class="cs_award_year cs_center cs_radius_100 cs_fs_64 cs_accent_color cs_mb_56 cs_mb_lg_24"><img src="<?= e($awardImage1) ?>" style="border-radius:100px;height:100%"></div>
            <div class="cs_award_info">
              <h3 class="cs_award_title cs_fs_48 cs_white_color cs_mb_27 cs_mb_lg_20"><?= e($awardTitle1) ?></h3>
            </div>
          </div>
          <div class="cs_award_item cs_style_1 cs_center_column text-center">
            <div class="cs_award_year cs_center cs_radius_100 cs_fs_64 cs_accent_color cs_mb_56 cs_mb_lg_24"><img src="<?= e($awardImage2) ?>" style="border-radius:100px;height:100%"></div>
            <div class="cs_award_info">
              <h3 class="cs_award_title cs_fs_48 cs_white_color cs_mb_27 cs_mb_lg_20"><?= e($awardTitle2) ?></h3>
            </div>
          </div>
          <div class="cs_award_item cs_style_1 cs_center_column text-center">
            <div class="cs_award_year cs_center cs_radius_100 cs_fs_64 cs_accent_color cs_mb_56 cs_mb_lg_24"><img src="<?= e($awardImage3) ?>" style="border-radius:100px;height:100%"></div>
            <div class="cs_award_info">
              <h3 class="cs_award_title cs_fs_48 cs_white_color cs_mb_27 cs_mb_lg_20"><?= e($awardTitle3) ?></h3>
            </div>
          </div>
        </div>
      </div>
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Award Section -->
 
    <!-- Start Booking Section -->
    <section class="cs_cream_bg cs_bg_filed" data-src="<?= e($bookingCtaBackground) ?>">
      <div class="container">
        <div class="cs_cta cs_style_1 cs_center_column text-center">
          <h2 class="cs_cta_heading cs_fs_64 cs_mb_24" data-aos="fade-down" style="color:white"><?= e($bookingCtaTitle) ?></h2>
          <p class="cs_mb_48 cs_mb_lg_30" style="color:white; font-size:30px;font-weight:100px;line-height:1.6;font-weight:700;"><?= e($bookingCtaDescription) ?></p>
          <a href="rooms.php" aria-label="Room booking link" class="cs_btn cs_style_1 cs_heading_bg cs_white_color cs_medium text-uppercase" data-aos="fade-up">
          <span>Book Now</span>
          </a>
        </div>
      </div>
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
   
    <!-- Include Footer Template -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <!-- Start Scroll Top Button -->
    <button type="button" class="cs_scrollup" id="scrollToTopBtn">
      <svg style="width: 100%; height: 100%;" viewBox="0 0 48 44" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M23.9999 33.0001C24.3835 33.0001 24.7675 32.8535 25.0604 32.5606L40.0604 17.5606C40.6465 16.9745 40.6465 16.0253 40.0604 15.4396C39.4743 14.8538 38.5252 14.8535 37.9394 15.4396L23.9999 29.3791L10.0604 15.4396C9.47428 14.8535 8.52515 14.8535 7.9394 15.4396C7.35365 16.0257 7.35328 16.9748 7.9394 17.5606L22.9394 32.5606C23.2323 32.8535 23.6163 33.0001 23.9999 33.0001Z" fill="currentColor"></path>
      </svg>
    </button>
    <!-- End Footer -->

    <!-- Scripts -->
    <script src="code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/datepicker.min.js"></script>
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/lightgallery.min.js"></script>
    <script src="assets/js/fontawesome.min.js"></script>
    <script src="assets/js/main.js"></script>
    
    <?php if (count($heroBackgrounds) > 1): ?>
    <script>
    // Hero Slider with Auto-Slide and Fade Transitions
    (function() {
        const slides = document.querySelectorAll('.hero-slide');
        if (slides.length <= 1) return;
        
        let currentIndex = 0;
        const totalSlides = slides.length;
        const slideInterval = 6000; // 6 seconds per slide
        
        function nextSlide() {
            // Remove active class from current slide
            slides[currentIndex].classList.remove('active');
            
            // Move to next slide
            currentIndex = (currentIndex + 1) % totalSlides;
            
            // Add active class to new slide
            slides[currentIndex].classList.add('active');
        }
        
        // Start auto-slide
        setInterval(nextSlide, slideInterval);
    })();
    </script>
    <?php endif; ?>
    
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
    
    <script>
    // Hero title fade-out animation - runs on every page load
    document.addEventListener('DOMContentLoaded', function() {
        const heroTitle = document.getElementById('hero-title');
        if (heroTitle) {
            // Reset opacity to 1 on page load
            heroTitle.style.opacity = '1';
            heroTitle.classList.remove('fade-out');
            
            // Fade out after 5 seconds
            setTimeout(function() {
                heroTitle.classList.add('fade-out');
            }, 5000);
        }
    });
    </script>
  </body>
</html>

