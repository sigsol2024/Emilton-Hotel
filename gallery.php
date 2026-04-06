<?php
/**
 * Gallery/Rooms Page - Dynamic Content
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

// Load gallery page sections
$heroTitle = getPageSection('gallery', 'hero_title', 'Our Gallery');
$heroSubtitle = getPageSection('gallery', 'hero_subtitle', 'Visual Journey');
$heroDescription = getPageSection('gallery', 'hero_description', 'Experience the elegance and comfort of ' . $siteName . ' through our lens. From our luxury suites to our award-winning facilities.');
$heroBackground = getPageSection('gallery', 'hero_background', 'assets/img/about1.jpg');

// Load gallery images from page_sections (stored as JSON)
$galleryImagesJson = getPageSection('gallery', 'gallery_images', '[]');
$galleryImages = json_decode($galleryImagesJson, true);
if (!is_array($galleryImages)) {
    $galleryImages = [];
}

// Gallery categories/filters
$galleryCategories = [
    'all' => 'All',
    'rooms' => 'Rooms & Suites',
    'dining' => 'Dining',
    'wellness' => 'Wellness',
    'experiences' => 'Experiences'
];
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
    <!-- Site Title -->
    <title><?= e($siteName) ?> | Gallery</title>
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
                        <li class="text-white">Gallery</li>
                    </ol>
                    <h1 class="text-white text-5xl md:text-7xl font-black leading-tight tracking-[-0.033em] italic" data-aos="zoom-in"><?= e($heroTitle) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Heading Section -->
    
    <!-- Start Gallery Section -->
    <section class="cs_white_bg" style="padding-top: 80px; padding-bottom: 80px;">
      <div class="container" style="max-width: 1440px;">
        <!-- Hero Header -->
        <header class="text-center mb-10 md:mb-16" style="max-width: 768px; margin-left: auto; margin-right: auto;" data-aos="fade-up">
          <span class="cs_fs_12 cs_accent_color" style="font-weight: 700; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 16px;"><?= e($heroSubtitle) ?></span>
          <p class="cs_fs_18 cs_body_color" style="max-width: 600px; margin: 0 auto; line-height: 1.7;"><?= e($heroDescription) ?></p>
        </header>

        <!-- Filters -->
        <?php
        // Count images per category
        $categoryCounts = [
          'all' => count($galleryImages),
          'rooms' => 0,
          'dining' => 0,
          'wellness' => 0,
          'experiences' => 0
        ];
        foreach ($galleryImages as $image) {
          $category = is_array($image) ? ($image['category'] ?? 'all') : 'all';
          if ($category !== 'all' && isset($categoryCounts[$category])) {
            $categoryCounts[$category]++;
          }
        }
        ?>
        <div class="d-flex flex-wrap justify-content-center gap-3 mb-10 md:mb-14" data-aos="fade-up" data-aos-delay="100">
          <?php if ($categoryCounts['all'] > 0): ?>
          <button class="gallery-filter-btn active" data-filter="all" style="height: 40px; padding: 0 20px; border-radius: 9999px; background: var(--accent-color); color: #fff; border: none; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: all 0.3s;">
            <span class="material-symbols-outlined" style="font-size: 20px;">grid_view</span>
            <span>All</span>
          </button>
          <?php endif; ?>
          <?php 
          $categoryConfig = [
            'rooms' => ['label' => 'Rooms & Suites', 'icon' => 'bed'],
            'dining' => ['label' => 'Dining', 'icon' => 'restaurant'],
            'wellness' => ['label' => 'Wellness', 'icon' => 'spa'],
            'experiences' => ['label' => 'Experiences', 'icon' => 'photo_camera']
          ];
          foreach ($categoryConfig as $key => $config): 
            if ($categoryCounts[$key] > 0): // Only show if category has images
          ?>
          <button class="gallery-filter-btn" data-filter="<?= $key ?>" style="height: 40px; padding: 0 20px; border-radius: 9999px; background: #fff; color: var(--heading-color); border: 1px solid var(--border-color); font-weight: 500; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: all 0.3s;">
            <span class="material-symbols-outlined" style="font-size: 20px; color: var(--body-color);"><?= e($config['icon']) ?></span>
            <span><?= e($config['label']) ?></span>
          </button>
          <?php 
            endif;
          endforeach; 
          ?>
        </div>

        <!-- Gallery Grid -->
        <?php if (empty($galleryImages)): ?>
          <div class="text-center" style="padding: 80px 20px;">
            <p class="cs_fs_18 cs_body_color">No gallery images available yet. Please add images via the admin panel.</p>
          </div>
        <?php else: ?>
          <div class="cs_lightgallery gallery-grid" style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 16px; grid-auto-rows: 280px;">
            <?php 
            $gridLayouts = [
              ['col' => 'span 2', 'row' => 'span 2'], // Large featured (first item)
              ['col' => 'span 1', 'row' => 'span 1'], // Regular
              ['col' => 'span 1', 'row' => 'span 1'], // Regular
              ['col' => 'span 1', 'row' => 'span 2'], // Tall
              ['col' => 'span 1', 'row' => 'span 1'], // Regular
              ['col' => 'span 2', 'row' => 'span 1'], // Wide
              ['col' => 'span 1', 'row' => 'span 1'], // Regular
              ['col' => 'span 1', 'row' => 'span 1'], // Regular
              ['col' => 'span 2', 'row' => 'span 1'], // Wide
            ];
            foreach ($galleryImages as $index => $image): 
              $imagePath = is_array($image) ? ($image['path'] ?? '') : $image;
              $imageTitle = is_array($image) ? ($image['title'] ?? '') : '';
              $imageCategory = is_array($image) ? ($image['category'] ?? 'all') : 'all';
              $layout = $gridLayouts[$index % count($gridLayouts)];
              if (empty($imagePath)) continue;
            ?>
            <div class="gallery-item" data-category="<?= e($imageCategory) ?>" 
                 style="grid-column: <?= $layout['col'] ?>; grid-row: <?= $layout['row'] ?>; position: relative; cursor: pointer; overflow: hidden; border-radius: 12px; background: #f3f3f3;"
                 data-aos="fade-up" data-aos-delay="<?= ($index % 4) * 100 ?>">
              <a href="<?= e($imagePath) ?>" class="cs_lightbox_item" style="display: block; width: 100%; height: 100%; position: relative;">
                <div class="gallery-image-bg" style="position: absolute; inset: 0; background-image: url('<?= e($imagePath) ?>'); background-size: cover; background-position: center; transition: transform 0.7s ease; transform: scale(1);"></div>
                <div class="gallery-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0.2), transparent); opacity: 0.8; transition: opacity 0.3s;"></div>
                <?php if ($index === 0): ?>
                <div class="gallery-content" style="position: absolute; bottom: 0; left: 0; padding: 24px; width: 100%; transform: translateY(8px); transition: transform 0.3s;">
                  <span class="d-inline-block px-2 py-1 mb-2 cs_fs_12" style="background: var(--accent-color); color: #fff; font-weight: 700; border-radius: 4px; text-transform: uppercase; letter-spacing: 1px;">Featured</span>
                  <h3 class="text-white cs_fs_24 mb-1" style="font-weight: 700;"><?= e($imageTitle ?: 'Gallery Image') ?></h3>
                  <p class="text-white cs_fs_14 mb-0" style="opacity: 0; transition: opacity 0.3s 0.075s;">Experience luxury like never before.</p>
                </div>
                <button class="gallery-expand-btn" style="position: absolute; bottom: 24px; right: 24px; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.2); color: #fff; border: none; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px); transition: all 0.3s;">
                  <span class="material-symbols-outlined">open_in_full</span>
                </button>
                <?php else: ?>
                <div class="gallery-content" style="position: absolute; bottom: 16px; left: 16px; right: 16px; transform: translateY(16px); opacity: 0; transition: all 0.3s;">
                  <h3 class="text-white cs_fs_18 mb-1" style="font-weight: 700;"><?= e($imageTitle ?: 'Gallery Image') ?></h3>
                  <p class="cs_accent_color cs_fs_14 mb-0"><?= e(ucfirst($imageCategory)) ?></p>
                </div>
                <?php endif; ?>
              </a>
            </div>
            <?php endforeach; ?>
          </div>
          
          <div class="text-center mt-12">
            <button class="gallery-load-more cs_btn cs_style_1" style="border: 1px solid var(--border-color); color: var(--heading-color); background: transparent; padding: 12px 32px; border-radius: 12px; font-weight: 600; transition: all 0.3s;">
              Load More Photos
            </button>
          </div>
        <?php endif; ?>
      </div>
    </section>
    <!-- End Gallery Section -->

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
    /* Gallery Grid Responsive */
    @media (min-width: 640px) {
      .gallery-grid {
        grid-template-columns: repeat(2, 1fr) !important;
      }
      .gallery-item[style*="span 2"] {
        grid-column: span 2 !important;
      }
      .gallery-item[style*="span 1"] {
        grid-column: span 1 !important;
      }
    }
    @media (min-width: 1024px) {
      .gallery-grid {
        grid-template-columns: repeat(3, 1fr) !important;
      }
    }
    @media (min-width: 1280px) {
      .gallery-grid {
        grid-template-columns: repeat(4, 1fr) !important;
      }
    }
    
    /* Gallery Item Hover Effects */
    .gallery-item:hover .gallery-image-bg {
      transform: scale(1.1) !important;
    }
    .gallery-item:hover .gallery-overlay {
      opacity: 1 !important;
    }
    .gallery-item:hover .gallery-content {
      transform: translateY(0) !important;
      opacity: 1 !important;
    }
    .gallery-item:hover .gallery-content p {
      opacity: 1 !important;
    }
    .gallery-item:hover .gallery-expand-btn {
      background: rgba(255,255,255,0.3) !important;
    }
    
    /* Filter Button Active State */
    .gallery-filter-btn.active {
      background: var(--accent-color) !important;
      color: #fff !important;
      border-color: var(--accent-color) !important;
    }
    .gallery-filter-btn.active .material-symbols-outlined {
      color: #fff !important;
    }
    .gallery-filter-btn:hover {
      border-color: var(--accent-color) !important;
      box-shadow: 0 4px 12px rgba(38, 33, 97, 0.15) !important;
    }
    .gallery-filter-btn:hover .material-symbols-outlined {
      color: var(--accent-color) !important;
    }
    .gallery-filter-btn:hover span:not(.material-symbols-outlined) {
      color: var(--accent-color) !important;
    }
    
    /* Load More Button */
    .gallery-load-more:hover {
      border-color: var(--accent-color) !important;
      color: var(--accent-color) !important;
    }
    
    /* Hide items by default for filtering */
    .gallery-item.hidden {
      display: none !important;
    }
    </style>
    <script>
    // Gallery Filter Functionality
    document.addEventListener('DOMContentLoaded', function() {
      const filterButtons = document.querySelectorAll('.gallery-filter-btn');
      const galleryItems = document.querySelectorAll('.gallery-item');
      
      filterButtons.forEach(button => {
        button.addEventListener('click', function() {
          const filter = this.getAttribute('data-filter');
          
          // Update active button
          filterButtons.forEach(btn => btn.classList.remove('active'));
          this.classList.add('active');
          
          // Filter items
          galleryItems.forEach(item => {
            const category = item.getAttribute('data-category');
            if (filter === 'all' || category === filter) {
              item.classList.remove('hidden');
              item.style.display = '';
            } else {
              item.classList.add('hidden');
              item.style.display = 'none';
            }
          });
        });
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

