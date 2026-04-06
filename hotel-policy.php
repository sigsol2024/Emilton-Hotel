<?php
/**
 * Hotel Policy Page
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

// Load hotel policy page sections
$heroTitle = getPageSection('hotel-policy', 'hero_title', 'Hotel Policy');
$heroBackground = getPageSection('hotel-policy', 'hero_background', 'assets/img/about1.jpg');
$mainContent = getPageSection('hotel-policy', 'main_content', '<ul style="list-style: none; padding: 0;">
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> Check in time is 2PM.</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> Check out time is 12 noon. If you wish to delay your departure, a charge of 50% until 6pm and 100% after 6pm applies</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> No extra charge for children under 2 years of age with parent</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> Complimentary breakfast for one person, additional breakfast will be charged ₦15,000.</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> Food and drinks from outside the hotel are not permitted in the hotel.</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> Unrestricted access to the swimming pools</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> No-Show charge applies for bookings not cancelled before 6pm on the arrival date. No Show will charged full rate.</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> A deposit covering the estimated amount of your expenses for the entire length of stay is requested.</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> Only two persons is allowed to stay in the room.</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> NO SMOKING IN THE ROOM. SMOKING IS ONLY ALLOWED AT THE DESIGNATED AREA.</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> GUEST WILL BE ASKED TO CHECK OUT AND FINED IF FOUND SMOKING IN ANY OF THE AREAS NOT DESIGNATED (FINE ₦100,000)</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> Breakfast is served from 6am to 10am, no guest will be served after 10am</li>
<li style="margin-bottom: 20px; padding-left: 30px; position: relative;"><span style="position: absolute; left: 0;">✓</span> Cancellation Policy: Room booking cancellation must be done 24hours before Check In time. NO refund will be made after 24hours.</li>
</ul>');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Hotel Policy for <?= e($siteName) ?>. Review our check-in, check-out, cancellation, and other important policies.">
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
    <title><?= e($siteName) ?> | Hotel Policy</title>
</head>
<body>
    <?php require_once __DIR__ . '/includes/body-scripts.php'; ?>
    <!-- Include Header Template -->
    <?php require_once __DIR__ . '/includes/header.php'; ?>
    
    <!-- Start Page Heading Section -->
    <div class="relative w-full">
        <div class="@container">
            <div class="flex min-h-screen flex-col gap-6 bg-cover bg-center bg-no-repeat items-center justify-center p-4 relative hero-font-serif" style='background-image: linear-gradient(rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.3) 100%), url("<?= e($heroBackground) ?>");'>
                <div class="flex flex-col gap-6 text-center max-w-[1200px] animate-fade-in-up">
                    <ol class="breadcrumb flex justify-center items-center gap-4 mb-4" style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="index.php" class="text-white/80 hover:text-white transition-colors" style="text-decoration: none;">Home</a></li>
                        <li class="text-white/60">/</li>
                        <li class="text-white">Hotel Policy</li>
                    </ol>
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight tracking-[-0.033em] italic" data-aos="zoom-in"><?= e($heroTitle) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Heading Section -->
    
    <!-- Start Hotel Policy Section -->
    <section class="cs_white_bg">
      <div class="cs_height_80 cs_height_lg_80"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="cs_card cs_style_1 cs_type_1">
              <div class="cs_card_info" style="padding: 60px 40px;">
                <div class="cs_fs_20 cs_body_color" style="line-height: 1.8;">
                  <?= $mainContent ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Hotel Policy Section -->

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

