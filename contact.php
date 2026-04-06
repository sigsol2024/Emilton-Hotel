<?php
/**
 * Contact Page - Contact Form and Information
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

// Load contact page sections
$heroTitle = getPageSection('contact', 'hero_title', 'Contact Us');
$heroBackground = getPageSection('contact', 'hero_background', 'assets/img/about1.jpg');
$heroSubtitle = getPageSection('contact', 'hero_subtitle', 'We’re here to help with bookings, questions, and special requests.');
$contactIntroTitle = getPageSection('contact', 'contact_intro_title', 'Let’s talk');
$contactIntroText = getPageSection('contact', 'contact_intro_text', 'Send us a message and our team will respond as quickly as possible.');
$formTitle = getPageSection('contact', 'form_title', 'Send a message');
$formSubtitle = getPageSection('contact', 'form_subtitle', 'Fill the form and we’ll get back to you shortly.');
$contactHotelName = getPageSection('contact', 'contact_hotel_name', $siteName);
$contactAddress = getPageSection('contact', 'contact_address', $footerAddress);
$contactPhone = getPageSection('contact', 'contact_phone', $footerPhone);
$contactEmail = getPageSection('contact', 'contact_email', 'info@emiltonhotels.com');
$contactFrontDesk = getPageSection('contact', 'contact_front_desk', '24 Hours / 7 Days');
$mapAddress = getPageSection('contact', 'map_address', '');
$mapEmbedUrl = getPageSection('contact', 'map_embed_url', '');
$mapApiKey = 'AIzaSyDcWKVHACCy6CVx8H5a7djYjixjMhozsjQ';

$mapUrl = '';
if (!empty($mapAddress)) {
    $mapUrl = 'https://www.google.com/maps/embed/v1/place?key=' . $mapApiKey . '&q=' . urlencode($mapAddress);
} elseif (!empty($mapEmbedUrl)) {
    $mapUrl = $mapEmbedUrl;
} else {
    // Default to Lagos, Nigeria if admin hasn't set an address yet
    $mapUrl = 'https://www.google.com/maps/embed/v1/place?key=' . $mapApiKey . '&q=' . urlencode('Lagos, Nigeria');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Get in touch with <?= e($siteName) ?>. Contact us for bookings, inquiries, or more information about our luxury accommodations.">
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
    <title><?= e($siteName) ?> | Contact</title>
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
                        <li class="text-white">Contact</li>
                    </ol>
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight tracking-[-0.033em] italic" data-aos="zoom-in"><?= e($heroTitle) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Heading Section -->
    
    <!-- Start Contact Section -->
    <section class="cs_white_bg" style="padding-top: 80px; padding-bottom: 80px;">
      <div class="container">
        <!-- Intro Section -->
        <div class="text-center" data-aos="fade-up">
          <p class="cs_fs_24 cs_body_color cs_light" style="max-width: 600px; margin: 0 auto;"><?= e($heroSubtitle) ?></p>
        </div>

        <div class="cs_height_60 cs_height_lg_40"></div>

        <!-- Main Content Grid -->
        <div class="row g-4 align-items-start">
          <!-- Left Column: Contact Information -->
          <div class="col-lg-5">
            <div class="cs_card cs_style_1" style="padding: 40px; background: #fff; border: 1px solid var(--border-color); border-radius: 12px;" data-aos="fade-right">
              <h3 class="cs_fs_24 cs_heading_color mb-4" style="border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">Hotel Information</h3>
              <div class="d-flex flex-column" style="gap: 24px;">
                <!-- Item 1 -->
                <div class="d-flex align-items-start" style="gap: 16px;">
                  <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(38, 33, 97, 0.1); color: var(--accent-color); flex-shrink: 0;">
                    <span class="material-symbols-outlined" style="font-size: 20px;">apartment</span>
                  </div>
                  <div>
                    <p class="cs_fs_12 cs_body_color mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Hotel Name</p>
                    <p class="cs_fs_16 cs_heading_color mb-0"><?= e($contactHotelName) ?></p>
                  </div>
                </div>
                <!-- Item 2 -->
                <div class="d-flex align-items-start" style="gap: 16px;">
                  <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(38, 33, 97, 0.1); color: var(--accent-color); flex-shrink: 0;">
                    <span class="material-symbols-outlined" style="font-size: 20px;">location_on</span>
                  </div>
                  <div>
                    <p class="cs_fs_12 cs_body_color mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Address</p>
                    <p class="cs_fs_16 cs_heading_color mb-0" style="line-height: 1.6;"><?= nl2br(e($contactAddress)) ?></p>
                  </div>
                </div>
                <!-- Item 3 -->
                <div class="d-flex align-items-start" style="gap: 16px;">
                  <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(38, 33, 97, 0.1); color: var(--accent-color); flex-shrink: 0;">
                    <span class="material-symbols-outlined" style="font-size: 20px;">call</span>
                  </div>
                  <div>
                    <p class="cs_fs_12 cs_body_color mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Phone</p>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $contactPhone) ?>" class="cs_fs_16 cs_heading_color" style="text-decoration: none;"><?= e($contactPhone) ?></a>
                  </div>
                </div>
                <!-- Item 4 -->
                <div class="d-flex align-items-start" style="gap: 16px;">
                  <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(38, 33, 97, 0.1); color: var(--accent-color); flex-shrink: 0;">
                    <span class="material-symbols-outlined" style="font-size: 20px;">mail</span>
                  </div>
                  <div>
                    <p class="cs_fs_12 cs_body_color mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Email</p>
                    <a href="mailto:<?= e($contactEmail) ?>" class="cs_fs_16 cs_heading_color" style="text-decoration: none;"><?= e($contactEmail) ?></a>
                  </div>
                </div>
                <!-- Item 5 -->
                <div class="d-flex align-items-start" style="gap: 16px;">
                  <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(38, 33, 97, 0.1); color: var(--accent-color); flex-shrink: 0;">
                    <span class="material-symbols-outlined" style="font-size: 20px;">schedule</span>
                  </div>
                  <div>
                    <p class="cs_fs_12 cs_body_color mb-1" style="text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Front Desk</p>
                    <p class="cs_fs_16 cs_heading_color mb-0"><?= e($contactFrontDesk) ?></p>
                  </div>
                </div>
              </div>
              <div class="mt-5 pt-4" style="border-top: 1px solid var(--border-color);">
                <a href="<?= e($mapUrl) ?>" target="_blank" rel="noopener" class="cs_btn cs_style_1 cs_accent_bg cs_white_color cs_medium" style="width: 100%; justify-content: center;">
                  <span class="material-symbols-outlined" style="font-size: 18px;">map</span>
                  <span>Find Route</span>
                </a>
              </div>
            </div>
          </div>
          <!-- Right Column: Contact Form -->
          <div class="col-lg-7">
            <div class="cs_card cs_style_1" style="padding: 40px; background: #fff; border: 1px solid var(--border-color); border-radius: 12px;" data-aos="fade-left">
              <h3 class="cs_fs_24 cs_heading_color mb-2"><?= e($formTitle) ?></h3>
              <p class="cs_fs_16 cs_body_color mb-4"><?= e($formSubtitle) ?></p>
              <form id="contactForm" method="POST" action="" class="cs_contact_form cs_style_1">
                <div class="cs_input_wrapper">
                  <label for="name">Full Name *</label>
                  <input type="text" id="name" name="name" required class="cs_form_field" placeholder="Enter your full name">
                </div>
                <div class="cs_input_wrapper">
                  <label for="email">Email Address *</label>
                  <input type="email" id="email" name="email" required class="cs_form_field" placeholder="name@example.com">
                </div>
                <div class="cs_input_wrapper">
                  <label for="phone">Phone Number <span style="font-weight: 400; font-size: 14px;">(Optional)</span></label>
                  <input type="tel" id="phone" name="phone" class="cs_form_field" placeholder="+234...">
                </div>
                <div class="cs_input_wrapper">
                  <label for="message">Message *</label>
                  <textarea id="message" name="message" rows="5" required class="cs_form_field" placeholder="How can we help you?"></textarea>
                </div>
                <div class="cs_input_wrapper">
                  <p class="cs_fs_12 cs_body_color mb-0" style="flex: 1;">By sending this message, you agree to be contacted by <?= e($siteName) ?>.</p>
                  <button type="submit" class="cs_btn cs_style_1 cs_accent_bg cs_white_color cs_medium">
                    <span>Send Message</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Map Section -->
        <div class="cs_height_60 cs_height_lg_40"></div>
        <div class="cs_card cs_style_1" style="border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden;" data-aos="fade-up">
          <iframe
            title="Map location of <?= e($siteName) ?>"
            src="<?= e($mapUrl) ?>"
            style="border: 0; width: 100%; height: 400px; display: block;"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
          ></iframe>
        </div>

        <div class="cs_height_60 cs_height_lg_40"></div>
      </div>
    </section>
    <!-- End Contact Section -->

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
    <style>
    /* Contact Form - Clean and Simple */
    #contactForm {
      display: grid !important;
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 20px 24px !important;
      align-items: start !important;
      width: 100% !important;
      text-align: left !important;
    }
    
    /* Form Field Styling */
    #contactForm .cs_form_field {
      border: 1px solid var(--border-color) !important;
      background: #fff !important;
      transition: all 0.3s ease;
      padding: 12px 16px !important;
      min-height: 52px !important;
      height: auto !important;
      width: 100% !important;
      box-sizing: border-box !important;
      line-height: 1.4;
    }
    #contactForm .cs_form_field:focus {
      border-color: var(--accent-color) !important;
      outline: none;
    }
    #contactForm select.cs_form_field {
      padding-right: 45px !important;
    }
    #contactForm textarea.cs_form_field {
      padding: 12px 16px !important;
      min-height: 140px !important;
      resize: vertical;
      line-height: 1.5;
    }
    
    /* Input Wrapper */
    #contactForm .cs_input_wrapper {
      display: flex !important;
      flex-direction: column !important;
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;
      align-self: stretch !important;
    }
    #contactForm .cs_input_wrapper label {
      margin-bottom: 10px !important;
      margin-top: 0 !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding: 0 !important;
      font-weight: 500;
      color: var(--heading-color);
      font-size: 16px;
      display: block;
      line-height: 1.4;
      height: auto;
      text-align: left !important;
      width: 100%;
    }
    
    /* Position-relative wrapper for select - no extra spacing */
    #contactForm .cs_input_wrapper .position-relative {
      width: 100% !important;
      margin: 0 !important;
      padding: 0 !important;
      display: block;
      text-align: left;
    }
    
    /* Ensure all input wrappers have consistent alignment */
    #contactForm .cs_input_wrapper:nth-child(3),
    #contactForm .cs_input_wrapper:nth-child(4) {
      text-align: left !important;
    }
    
    /* Full Name and Email - Row 1 */
    #contactForm .cs_input_wrapper:nth-child(1),
    #contactForm .cs_input_wrapper:nth-child(2) {
      grid-column: auto;
    }
    
    /* Phone Number - Row 2 (full width) */
    #contactForm .cs_input_wrapper:nth-child(3) {
      grid-column: 1 / -1;
      align-self: start;
      text-align: left !important;
      display: flex !important;
      flex-direction: column !important;
      height: fit-content !important;
      min-height: auto !important;
    }
    
    /* Message - Row 3 (full width) */
    #contactForm .cs_input_wrapper:nth-child(4) {
      grid-column: 1 / -1;
    }
    
    /* Button Row - Row 4 (full width, separated) */
    #contactForm .cs_input_wrapper:nth-child(5) {
      grid-column: 1 / -1;
      display: flex !important;
      flex-direction: row !important;
      align-items: center !important;
      justify-content: space-between !important;
      gap: 20px;
      margin-top: 10px;
      padding-top: 20px;
      border-top: 1px solid var(--border-color);
    }
    
    /* Select field with icon */
    #contactForm .position-relative {
      width: 100%;
    }
    #contactForm select.cs_form_field {
      padding-right: 45px !important;
    }
    
    /* Button sizes */
    @media (min-width: 992px) {
      #contactForm .cs_btn.cs_style_1 {
        padding: 23px 40px !important;
        flex: none !important;
      }
      .cs_card .cs_btn.cs_style_1 {
        padding: 23px 40px !important;
      }
    }
    
    /* Mobile - Single column, full width */
    @media (max-width: 991px) {
      #contactForm {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
      }
      #contactForm .cs_input_wrapper {
        grid-column: 1 !important;
        width: 100% !important;
      }
      #contactForm .cs_input_wrapper:nth-child(5) {
        flex-direction: column !important;
        align-items: stretch !important;
      }
      #contactForm .cs_btn.cs_style_1 {
        padding: 17px 40px !important;
        width: 100% !important;
      }
      .cs_card .cs_btn.cs_style_1 {
        padding: 17px 40px !important;
      }
    }
    </style>
    <script>
    // Contact form submission with AJAX
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Get form data
        const formData = {
            name: document.getElementById('name').value.trim(),
            email: document.getElementById('email').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            subject: 'Contact Form Submission',
            message: document.getElementById('message').value.trim()
        };
        
        // Basic validation
        if (!formData.name || !formData.email || !formData.message) {
            alert('Please fill in all required fields.');
            return;
        }
        
        // Validate email
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
            alert('Please enter a valid email address.');
            return;
        }
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Sending...</span>';
        
        // Send to API
        fetch('<?= SITE_URL ?>api/contact-form.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + response.statusText);
            }
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Invalid JSON response:', text);
                    throw new Error('Server returned invalid response. Please check server logs.');
                }
            });
        })
        .then(data => {
            if (data.success) {
                alert(data.message || 'Thank you for your message! We will get back to you soon.');
                form.reset();
            } else {
                alert(data.message || 'Failed to send message. Please try again later.');
            }
        })
        .catch(error => {
            console.error('Contact form error:', error);
            alert('Error: ' + error.message + '. Please try again later or contact us directly.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    </script>
    
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
