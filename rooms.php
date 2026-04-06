<?php
/**
 * Rooms Page - Display All Rooms
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

// Load all active rooms
$rooms = getRooms(['is_active' => 1]);

// Load rooms page hero section
$heroTitle = getPageSection('rooms', 'hero_title', 'All Rooms &amp; Suites');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Browse all available rooms and suites at <?= e($siteName) ?>. Book your perfect luxury accommodation today.">
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
    <!-- Site Title -->
    <title><?= e($siteName) ?> | Rooms</title>
</head>
<body>
    <?php require_once __DIR__ . '/includes/body-scripts.php'; ?>
    <!-- Include Header Template -->
    <?php require_once __DIR__ . '/includes/header.php'; ?>
    
    <!-- Start Page Heading Section -->
    <div class="relative w-full">
        <div class="@container">
            <div class="flex min-h-screen flex-col gap-6 bg-cover bg-center bg-no-repeat items-center justify-center p-4 relative hero-font-serif" style='background-image: linear-gradient(rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.3) 100%), url("<?= e(getPageSection('rooms', 'hero_background', 'assets/img/about1.jpg')) ?>");'>
                <div class="flex flex-col gap-6 text-center max-w-[1200px] animate-fade-in-up">
                    <ol class="breadcrumb flex justify-center items-center gap-4 mb-4" style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="index.php" class="text-white/80 hover:text-white transition-colors" style="text-decoration: none;">Home</a></li>
                        <li class="text-white/60">/</li>
                        <li class="text-white">Rooms</li>
                    </ol>
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight tracking-[-0.033em] italic" data-aos="zoom-in"><?= $heroTitle ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Heading Section -->
    
    <!-- Start Rooms Section -->
    <section class="cs_heading_bg">
      <div class="container">
        <div class="cs_height_66 cs_height_lg_45"></div>
        <div class="row cs_gap_y_30">
          <?php foreach ($rooms as $room): ?>
          <div class="col-xl-4 col-lg-6">
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
        <div class="cs_height_120 cs_height_lg_80"></div>
      </div>
    </section>
    <!-- End Rooms Section -->

        <!-- Include Footer Template -->
        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    
    <!-- Start Scroll Top Button -->
    <button type="button" class="cs_scrollup" id="scrollToTopBtn">
      <svg style="width: 100%; height: 100%;" viewBox="0 0 48 44" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M23.9999 33.0001C24.3835 33.0001 24.7675 32.8535 25.0604 32.5606L40.0604 17.5606C40.6465 16.9745 40.6465 16.0253 40.0604 15.4396C39.4743 14.8538 38.5252 14.8535 37.9394 15.4396L23.9999 29.3791L10.0604 15.4396C9.47428 14.8535 8.52515 14.8535 7.9394 15.4396C7.35365 16.0257 7.35328 16.9748 7.9394 17.5606L22.9394 32.5606C23.2323 32.8535 23.6163 33.0001 23.9999 33.0001Z" fill="currentColor"></path>
      </svg>
    </button>

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

