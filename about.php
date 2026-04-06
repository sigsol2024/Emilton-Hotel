<?php
/**
 * About Page - Dynamic Content
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

// Load about page sections
$pageHeaderTitle = getPageSection('about', 'page_header_title', 'ABOUT EMILTON');
$pageHeaderImage = getPageSection('about', 'page_header_image', 'assets/img/about1.jpg');
$mainTitle = getPageSection('about', 'main_title', 'Welcome to Emilton Hotel - Your Premier Destination in Ajao Estate');
$mainDescription = getPageSection('about', 'main_description', 'Emilton Hotel offers exceptional luxury accommodations in the heart of Ajao Estate, Lagos. Our fully serviced apartments combine modern elegance with traditional hospitality,<br>providing the perfect setting for both business travelers and leisure guests seeking comfort, security, and world-class amenities.');
$counter1Percentage = getPageSection('about', 'counter_1_percentage', '100%');
$counter1Title = getPageSection('about', 'counter_1_title', 'Guest Satisfaction');
$counter2Percentage = getPageSection('about', 'counter_2_percentage', '100%');
$counter2Title = getPageSection('about', 'counter_2_title', 'Luxury Amenities');
$counter3Percentage = getPageSection('about', 'counter_3_percentage', '100%');
$counter3Title = getPageSection('about', 'counter_3_title', 'Secure Environment');
$whyChooseSubtitle = getPageSection('about', 'why_choose_subtitle', 'Luxury Hotel in Ajao Estate, Lagos');
$whyChooseTitle = getPageSection('about', 'why_choose_title', 'Why Choose Emilton Hotel?');
$whyChooseDescription = getPageSection('about', 'why_choose_description', 'At Emilton Hotel, we are committed to providing an unparalleled hospitality experience. Our thoughtfully designed spaces, attentive service, and prime location near the airport make us the ideal choice for discerning travelers. Every detail has been carefully curated to ensure your stay is not just comfortable, but truly exceptional.');
$videoBackground = getPageSection('about', 'video_background', 'assets/img/about1.jpg');
$awardImage1 = getPageSection('about', 'award_image_1', 'assets/rooms/2bedroom_tokyo_palour.webp');
$awardImage2 = getPageSection('about', 'award_image_2', 'assets/img/about1.jpg');
$awardImage3 = getPageSection('about', 'award_image_3', 'assets/rooms/2Bedroom_parisPalour.webp');
$awardTitle1 = getPageSection('about', 'award_title_1', 'Luxury Accommodation');
$awardTitle2 = getPageSection('about', 'award_title_2', 'Premium Service');
$awardTitle3 = getPageSection('about', 'award_title_3', 'Prime Location');
$testimonialBackground = getPageSection('about', 'testimonial_background', 'assets/rooms/2Bedroom_parisPalour.webp');

// Load testimonials
$testimonials = getTestimonials(4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Discover Emilton Hotel in Ajao Estate, Lagos. Experience luxury accommodations, exceptional service, and world-class amenities in the heart of the city." />
    <meta name="author" content="<?= e($siteName) ?>" />
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
    <!-- Site Title -->
    <title><?= e($siteName) ?> | About Us</title>
</head>
<body>
    <?php require_once __DIR__ . '/includes/body-scripts.php'; ?>
    <!-- Include Header Template -->
    <?php require_once __DIR__ . '/includes/header.php'; ?>
    
    <!-- Start Page Heading Section -->
    <div class="relative w-full">
        <div class="@container">
            <div class="flex min-h-screen flex-col gap-6 bg-cover bg-center bg-no-repeat items-center justify-center p-4 relative hero-font-serif" style='background-image: linear-gradient(rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.3) 100%), url("<?= e($pageHeaderImage) ?>");'>
                <div class="flex flex-col gap-6 text-center max-w-[1200px] animate-fade-in-up">
                    <ol class="breadcrumb flex justify-center items-center gap-4 mb-4" style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="index.php" class="text-white/80 hover:text-white transition-colors" style="text-decoration: none;">Home</a></li>
                        <li class="text-white/60">/</li>
                        <li class="text-white">About</li>
                    </ol>
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight tracking-[-0.033em] italic" data-aos="zoom-in"><?= e($pageHeaderTitle) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Heading Section -->
    
    <!-- Start About Section - Enhanced Design -->
    <section class="cs_cream_bg">
      <div class="cs_height_120 cs_height_lg_80"></div>
      <div class="container">
        <div class="row cs_gap_y_30 align-items-center">
          <div class="col-lg-6" data-aos="fade-right">
            <div class="cs_section_heading cs_style_1">
              <h2 class="cs_section_title cs_fs_48 cs_mb_30" data-aos="fade-down"><?= $mainTitle ?></h2>
              <div class="cs_mb_30">
                <?= $mainDescription ?>
              </div>
              <a href="rooms.php" aria-label="View rooms" class="cs_btn cs_style_1 cs_heading_bg cs_white_color cs_medium text-uppercase" data-aos="fade-up">
                <span>Explore Our Rooms</span>
              </a>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <div class="cs_card cs_style_8 position-relative">
              <div class="cs_video_block cs_style_3 cs_center cs_bg_filed" data-src="<?= e($videoBackground) ?>" style="background-image: url('<?= e($videoBackground) ?>'); background-size: cover; background-position: center; min-height: 500px; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End About Section -->
    
    <!-- Start Counter Section - Enhanced with Cards -->
    <section>
      <div class="container">
        <div class="cs_height_80 cs_height_lg_60"></div>
        <div class="row cs_gap_y_30">
          <div class="col-lg-4 col-md-6">
            <div class="cs_counter cs_style_1 cs_center_column text-center" data-aos="fade-up" data-aos-delay="0">
              <div class="cs_counter_number cs_fs_64 cs_accent_color cs_heading_font cs_mb_20">
                <span></span><?= e($counter1Percentage) ?>
              </div>
              <h2 class="cs_counter_title cs_fs_48 mb-0"><?= e($counter1Title) ?></h2>
              <p class="cs_fs_16 cs_mt_20" style="color: var(--body-color);">We are committed to exceeding your expectations with every stay.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="cs_counter cs_style_1 cs_center_column text-center" data-aos="fade-up" data-aos-delay="200">
              <div class="cs_counter_number cs_fs_64 cs_accent_color cs_heading_font cs_mb_20">
                <span></span><?= e($counter2Percentage) ?>
              </div>
              <h2 class="cs_counter_title cs_fs_48 mb-0"><?= e($counter2Title) ?></h2>
              <p class="cs_fs_16 cs_mt_20" style="color: var(--body-color);">World-class facilities designed for your comfort and convenience.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="cs_counter cs_style_1 cs_center_column text-center" data-aos="fade-up" data-aos-delay="400">
              <div class="cs_counter_number cs_fs_64 cs_accent_color cs_heading_font cs_mb_20">
                <span></span><?= e($counter3Percentage) ?>
              </div>
              <h2 class="cs_counter_title cs_fs_48 mb-0"><?= e($counter3Title) ?></h2>
              <p class="cs_fs_16 cs_mt_20" style="color: var(--body-color);">Your safety and security are our top priorities at all times.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Counter Section -->
    
    <!-- Start Why Choose Us - Enhanced Design -->
    <section class="cs_heading_bg">
      <div class="cs_height_120 cs_height_lg_80"></div>
      <div class="container">
        <div class="cs_section_heading cs_style_1 text-center cs_mb_60">
          <p class="cs_section_subtitle cs_fs_24 cs_white_color cs_mb_16 text-uppercase"><?= e($whyChooseSubtitle) ?></p>
          <h2 class="cs_section_title cs_fs_64 cs_white_color mb-0" data-aos="fade-down"><?= e($whyChooseTitle) ?></h2>
        </div>
        <div class="row cs_gap_y_30 align-items-center">
          <div class="col-lg-6" data-aos="fade-right">
            <div class="cs_card cs_style_8">
              <div class="cs_video_block cs_style_3 cs_center cs_bg_filed" data-src="<?= e($videoBackground) ?>" style="background-image: url('<?= e($videoBackground) ?>'); background-size: cover; background-position: center; min-height: 450px; border-radius: 12px;">
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <div class="cs_section_heading cs_style_1">
              <p class="cs_fs_20 cs_white_color cs_light cs_mb_30" style="line-height: 1.8;"><?= $whyChooseDescription ?></p>
              <div class="cs_height_40"></div>
              <a href="rooms.php" aria-label="Room booking link" class="cs_btn cs_style_1 cs_accent_bg cs_white_color cs_medium text-uppercase" data-aos="fade-up">
                <span>Book Now</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Why Choose Us -->
    
    <!-- Start Award Section - Enhanced -->
    <section class="cs_cream_bg" id="awards">
      <div class="cs_height_120 cs_height_lg_80"></div>
      <div class="container">
        <div class="cs_section_heading cs_style_1 text-center cs_mb_60">
          <p class="cs_section_subtitle cs_fs_24 cs_accent_color cs_mb_16 text-uppercase"><?= e(getPageSection('about', 'awards_subtitle', 'Emilton Hotel Located in Ajao Estate Airport Rd.')) ?></p>
          <h2 class="cs_section_title cs_fs_64 mb-0" data-aos="fade-down"><?= e(getPageSection('about', 'awards_title', 'Only Excellence Just For You')) ?></h2>
        </div>
        <div class="cs_height_73 cs_height_lg_45"></div>
        <div class="row cs_gap_y_30">
          <div class="col-lg-4 col-md-6">
            <div class="cs_award_item cs_style_1 cs_center_column text-center" data-aos="fade-up" data-aos-delay="0">
              <div class="cs_award_year cs_center cs_radius_100 cs_fs_64 cs_accent_color cs_mb_30 cs_mb_lg_24 position-relative" style="width: 200px; height: 200px; margin: 0 auto 30px;">
                <img src="<?= e($awardImage1) ?>" style="border-radius:100px;width:100%;height:100%;object-fit:cover;box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
              </div>
              <div class="cs_award_info">
                <h3 class="cs_award_title cs_fs_48 cs_mb_27 cs_mb_lg_20"><?= e($awardTitle1) ?></h3>
                <p class="cs_fs_16" style="color: var(--body-color);">Experience the epitome of luxury in every detail of our accommodations.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="cs_award_item cs_style_1 cs_center_column text-center" data-aos="fade-up" data-aos-delay="200">
              <div class="cs_award_year cs_center cs_radius_100 cs_fs_64 cs_accent_color cs_mb_30 cs_mb_lg_24 position-relative" style="width: 200px; height: 200px; margin: 0 auto 30px;">
                <img src="<?= e($awardImage2) ?>" style="border-radius:100px;width:100%;height:100%;object-fit:cover;box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
              </div>
              <div class="cs_award_info">
                <h3 class="cs_award_title cs_fs_48 cs_mb_27 cs_mb_lg_20"><?= e($awardTitle2) ?></h3>
                <p class="cs_fs_16" style="color: var(--body-color);">Dedicated staff committed to providing exceptional service.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="cs_award_item cs_style_1 cs_center_column text-center" data-aos="fade-up" data-aos-delay="400">
              <div class="cs_award_year cs_center cs_radius_100 cs_fs_64 cs_accent_color cs_mb_30 cs_mb_lg_24 position-relative" style="width: 200px; height: 200px; margin: 0 auto 30px;">
                <img src="<?= e($awardImage3) ?>" style="border-radius:100px;width:100%;height:100%;object-fit:cover;box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
              </div>
              <div class="cs_award_info">
                <h3 class="cs_award_title cs_fs_48 cs_mb_27 cs_mb_lg_20"><?= e($awardTitle3) ?></h3>
                <p class="cs_fs_16" style="color: var(--body-color);">Strategically located for easy access to major destinations.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Award Section -->
    
    <!-- Start Testimonial Section -->
    <?php if (!empty($testimonials)): ?>
    <section class="cs_slider cs_style_1 cs_slider_gap_30 cs_bg_filed" data-src="<?= e($testimonialBackground) ?>">
      <div class="cs_height_100 cs_height_lg_80"></div>
      <div class="container">
        <div class="cs_section_heading cs_style_1 text-center cs_mb_60">
          <p class="cs_section_subtitle cs_fs_24 cs_accent_color cs_mb_16 text-uppercase">Guest Experiences</p>
          <h2 class="cs_section_title cs_fs_64 cs_white_color mb-0" data-aos="fade-down">What Our Guests Say</h2>
        </div>
        <div class="cs_height_60"></div>
        <div class="cs_testimonial_wrapper_2">
          <div class="cs_slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-center="0" data-variable-width="0" data-slides-per-view="1">
            <div class="cs_slider_wrapper">
              <?php foreach ($testimonials as $testimonial): ?>
              <div class="cs_slide">
                <div class="cs_testimonial cs_style_2 cs_white_bg">
                  <div class="cs_rating cs_mb_24" data-rating="<?= $testimonial['rating'] ?>">
                    <div class="cs_rating_percentage"></div>
                  </div>
                  <blockquote>"<?= e($testimonial['quote']) ?>"</blockquote>
                  <div class="cs_avatar cs_style_1">
                    <div class="cs_avatar_icon cs_center cs_radius_100"></div>
                    <div class="cs_avatar_info">
                      <h3 class="cs_avatar_title cs_fs_20 cs_medium cs_body_font cs_mb_3"><?= e($testimonial['author_name']) ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="cs_height_54 cs_height_lg_50"></div>
          <div class="cs_pagination_wrapper d-flex align-items-center justify-content-end">
            <div class="cs_left_arrow cs_center cs_radius_100 slick-arrow cs_heading_color">
              <i class="fa-solid fa-chevron-left"></i>
            </div>
            <div class="cs_pagination cs_style_1 custom_pagination"></div>
            <div class="cs_right_arrow cs_center cs_radius_100 slick-arrow cs_heading_color">
              <i class="fa-solid fa-chevron-right"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="cs_height_88 cs_height_lg_80"></div>
    </section>
    <!-- End Testimonial Section -->
    <?php endif; ?>
    
    <!-- Include Footer Template -->
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <!-- Start Scroll Top Button -->
    <button type="button" class="cs_scrollup" id="scrollToTopBtn">
      <svg style="width: 100%; height: 100%;" viewBox="0 0 48 44" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M23.9999 33.0001C24.3835 33.0001 24.7675 32.8535 25.0604 32.5606L40.0604 17.5606C40.6465 16.9745 40.6465 16.0253 40.0604 15.4396C39.4743 14.8538 38.5252 14.8535 37.9394 15.4396L23.9999 29.3791L10.0604 15.4396C9.47428 14.8535 8.52515 14.8535 7.9394 15.4396C7.35365 16.0257 7.35328 16.9748 7.9394 17.5606L22.9394 32.5606C23.2323 32.8535 23.6163 33.0001 23.9999 33.0001Z" fill="currentColor"></path>
      </svg>
    </button>
    <!-- End Footer -->
    
    <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.html"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/aos.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/datepicker.min.js"></script>
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/lightgallery.min.js"></script>
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
