-- Peregrine Hotel CMS Database Schema
-- MySQL 5.7+ / MariaDB 10.3+
-- For Shared Hosting: Create the database through cPanel first, then import this file
-- This file contains both the schema and initial content for Peregrine Hotel

-- ============================================
-- TABLE STRUCTURES
-- ============================================

-- Admin Users Table
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `idx_username` (`username`),
  INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Site Settings Table
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Rooms Table
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `price` DECIMAL(10,2) NOT NULL,
  `room_type` VARCHAR(50) DEFAULT NULL,
  `max_guests` INT(11) DEFAULT NULL,
  `description` TEXT,
  `short_description` TEXT,
  `main_image` VARCHAR(255) DEFAULT NULL,
  `gallery_images` TEXT DEFAULT NULL COMMENT 'JSON array of image paths',
  `features` TEXT DEFAULT NULL COMMENT 'JSON array of features',
  `amenities` TEXT DEFAULT NULL COMMENT 'JSON array of amenities',
  `is_featured` TINYINT(1) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `display_order` INT(11) DEFAULT 0,
  `rating` INT(1) DEFAULT 5,
  `rating_score` DECIMAL(3,1) DEFAULT NULL,
  `location` VARCHAR(255) DEFAULT NULL,
  `size` VARCHAR(50) DEFAULT NULL,
  `tags` TEXT DEFAULT NULL COMMENT 'JSON array of tags',
  `included_items` TEXT DEFAULT NULL COMMENT 'JSON array of included items',
  `good_to_know` TEXT DEFAULT NULL COMMENT 'JSON object of good to know info',
  `book_url` VARCHAR(500) DEFAULT NULL,
  `original_price` DECIMAL(10,2) DEFAULT NULL,
  `urgency_message` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_is_active` (`is_active`),
  INDEX `idx_is_featured` (`is_featured`),
  INDEX `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Page Sections Table
CREATE TABLE IF NOT EXISTS `page_sections` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `page` VARCHAR(50) NOT NULL,
  `section_key` VARCHAR(100) NOT NULL,
  `content_type` ENUM('text', 'html', 'image', 'json') DEFAULT 'text',
  `content` TEXT,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_page_section` (`page`, `section_key`),
  INDEX `idx_page` (`page`),
  INDEX `idx_section_key` (`section_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Testimonials Table
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `author_name` VARCHAR(255) NOT NULL,
  `quote` TEXT NOT NULL,
  `rating` INT(1) DEFAULT 5 CHECK (`rating` >= 1 AND `rating` <= 5),
  `is_active` TINYINT(1) DEFAULT 1,
  `display_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_is_active` (`is_active`),
  INDEX `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Media Table
CREATE TABLE IF NOT EXISTS `media` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `filename` VARCHAR(255) NOT NULL,
  `original_name` VARCHAR(255) DEFAULT NULL,
  `file_path` VARCHAR(500) NOT NULL,
  `file_type` VARCHAR(50) DEFAULT NULL,
  `file_size` INT(11) DEFAULT NULL COMMENT 'Size in bytes',
  `uploaded_by` INT(11) DEFAULT NULL,
  `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_file_path` (`file_path`),
  INDEX `idx_uploaded_by` (`uploaded_by`),
  FOREIGN KEY (`uploaded_by`) REFERENCES `admin_users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Navigation Menu Table
CREATE TABLE IF NOT EXISTS `navigation_menu` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(255) NOT NULL,
  `url` VARCHAR(500) NOT NULL,
  `parent_id` INT(11) DEFAULT NULL,
  `display_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `idx_parent_id` (`parent_id`),
  INDEX `idx_display_order` (`display_order`),
  FOREIGN KEY (`parent_id`) REFERENCES `navigation_menu`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INITIAL DATA
-- ============================================

-- Insert default admin user (password: Admin@123 - CHANGE THIS AFTER FIRST LOGIN)
-- Password hash generated using: password_hash('Admin@123', PASSWORD_BCRYPT)
INSERT INTO `admin_users` (`username`, `email`, `password_hash`, `is_active`) VALUES
('admin', 'admin@peregrinehotel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Insert site settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'Peregrine Hotel Rayfield'),
('site_tagline', 'Luxury Hotel in Jos'),
('site_logo', ''),
('site_favicon', ''),
('footer_address', '12 Rayfield Avenue,<br/>Jos, Plateau State,<br/>Nigeria'),
('footer_phone', '+234 800 123 4567'),
('footer_email', 'reservations@peregrinehotel.com'),
('footer_copyright', '© 2024 Peregrine Hotel Rayfield. All rights reserved.'),
('whatsapp_link', '#'),
('currency_symbol', '₦'),
('social_media_json', '[{"icon":"facebook","url":"#"},{"icon":"instagram","url":"#"}]');

-- ============================================
-- HOMEPAGE (index) CONTENT
-- ============================================
INSERT INTO `page_sections` (`page`, `section_key`, `content_type`, `content`) VALUES
-- Hero Section
('index', 'hero_title', 'text', 'Experience Jos.'),
('index', 'hero_subtitle', 'text', 'Stay in Comfort.'),
('index', 'hero_description', 'text', 'A sanctuary of modern luxury in the heart of Rayfield.'),
('index', 'hero_background', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuB9XXXbQdZQX_DSKfvOFjS6DzDFvRLPTQz11cwQVPId5SiSGjUKHegaIaE99DcfIMUE86x85uuPs3uTi5KVYcCWbsD-_VD2sWtHMHxgeUXXucKFTUp8V-g6CYIJePgR3EDI2EycLJsN_coiLRcxsAqeZDHGA4yDMgl_VRlQCJzcIRrLUkJ8wzYHufaV2H1BmYbF7pKncmCex-k3Q1hc7HoefvfAOMT21Vvsgz5HmiMdsz4zXUk4mvwoqsYA6cLEnPO5Ai_bSmMH5t4'),
('index', 'hero_cta_text', 'text', 'Book Your Stay'),
('index', 'hero_cta_link', 'text', 'rooms_&_suites.php'),
('index', 'hero_cta2_text', 'text', 'Explore Our Rooms'),
('index', 'hero_cta2_link', 'text', 'rooms_&_suites.php'),

-- About Section
('index', 'about_label', 'text', 'Boulevard Hotel Group'),
('index', 'about_title', 'text', 'A Refined Stay in the Heart of Rayfield'),
('index', 'about_description_1', 'text', 'Peregrine Hotel brings world-class hospitality to Jos. Part of the esteemed Boulevard Hotel Group, we offer generous spaces, modern amenities, and a serene atmosphere tailored for both business and leisure travelers seeking a moment of respite.'),
('index', 'about_description_2', 'text', 'Immerse yourself in elegance where every detail is curated for your comfort. From our signature dining experiences to our plush, tailored suites.'),
('index', 'about_image', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBXwfL--8AQE85elH-Wh25m9jRbCtgY2FgmOXTL9ydZHwgmGs3LxjFYOjp4PI73wd73yvIMF61YHb90MD1_XlTfLINbKB1O0TXDSy-8SPDBe0xAc5Kg1non_vCjzI0XPlt-XgOcM8PIrDUagyBBP3ym1sH-n1ogESWv2dOq9nCwgnfV0CidgkGsTfe56nxHYOpX03Z2pI4GEhiXzwfDsLuDQUPuoklZCrcXh-UUoogRhIEnSqH63LE8fWBT9slURc5KAYs8REtcjWc'),
('index', 'about_cta_text', 'text', 'Learn More About Us'),
('index', 'about_cta_link', 'text', 'about_us.php'),

-- Rooms Section
('index', 'rooms_title', 'text', 'Accommodations'),
('index', 'rooms_subtitle', 'text', 'Designed for tranquility and style. Choose the space that fits your journey.'),
('index', 'rooms_cta_text', 'text', 'View All Rooms'),
('index', 'rooms_cta_link', 'text', 'rooms_&_suites.php'),

-- Amenities Section
('index', 'amenities_title', 'text', 'Premium Amenities'),
('index', 'amenities_description', 'text', 'We have curated every aspect of your stay to ensure maximum comfort and convenience.'),
('index', 'amenities_cta_text', 'text', 'View All Amenities'),
('index', 'amenities_cta_link', 'text', 'amenities.php'),
('index', 'amenities_list', 'json', '[{"icon":"wifi","title":"High-Speed Wi-Fi"},{"icon":"pool","title":"Swimming Pool"},{"icon":"restaurant","title":"Fine Dining"},{"icon":"fitness_center","title":"Fitness Center"},{"icon":"room_service","title":"24/7 Room Service"},{"icon":"local_parking","title":"Secure Parking"}]'),

-- Final CTA Section
('index', 'cta_title', 'text', 'Your Perfect Stay in Jos Awaits'),
('index', 'cta_description', 'text', 'Experience the perfect blend of luxury, comfort, and Nigerian hospitality. Book directly with us for the best rates.'),
('index', 'cta_button_text', 'text', 'Book Your Stay'),
('index', 'cta_button_link', 'text', 'rooms_&_suites.php');

-- ============================================
-- ABOUT PAGE CONTENT
-- ============================================
INSERT INTO `page_sections` (`page`, `section_key`, `content_type`, `content`) VALUES
('about', 'page_subtitle', 'text', 'About Peregrine Hotel'),
('about', 'hero_title', 'text', 'The Essence of'),
('about', 'hero_title_italic', 'text', 'Rayfield Luxury'),
('about', 'hero_background', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBTf78SDLBYRls1ySmKF4WsCAN-qDa13xSezqXFEbPdgfNaAW8L5dxckdgCczLiYlMG46wFqh-jR60JPMyjP8gFRiLZ__fMcBEj_DieB42pe8T9tF0P0u412FPC34nTB5vh5Sfx8RDM4gTgLF610c5oEefiOcOiYLEcMX1yvB89Lg2U8Fu5eKKDL_wxOZ3cnPdAHaWcs9XY9b1d7lTY7Mm_S1vAxnrl38T3zZLEmbO2BfmgNvJDhZzJ5B6yYB4a42GZ8y-HvUDChII'),
('about', 'video_button_text', 'text', 'Play Experience Video'),
('about', 'video_button_url', 'text', '#'),
('about', 'intro_quote', 'text', '"We believe luxury is found in the quiet moments of perfect service, where every detail is curated for your peace of mind."'),
('about', 'story_label', 'text', 'Our Origins'),
('about', 'story_title', 'text', 'A Legacy of Hospitality'),
('about', 'story_description_1', 'text', 'Founded on the principles of timeless elegance and local warmth, Peregrine Hotel brings world-class standards to the serene district of Rayfield. Our story is one of passion for detail and a commitment to redefining luxury in Jos.'),
('about', 'story_description_2', 'text', 'Every corner of our establishment whispers a tale of dedication, designed to be a sanctuary for the discerning traveler seeking refuge and refinement.'),
('about', 'story_image', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAksFHXWWphepg4poMtCBNPzUBinkVYyEL87iw-tqz3AlPDoSKyN0aGmbjB00HfKKb2-7XXwh9YFhuEv-su8Lvb3bSa2lEwMl9zybSCqU2gk7bMDmerifblKxykfpvlgAZYYphbsvzkhwU-xW9PX_RmK2tKf8gnO1yD-LCQlsynB8Lr1qKNnUv8zoGrT0_rQCIVdMh1KeqY_sq5rNMaMHrUGwXmEJ-BoifLu6aH-yQJzBd7x9jgQfry_G_N6wGAVYOm3KWPDmUSNtk'),
('about', 'boulevard_label', 'text', 'Boulevard Group'),
('about', 'boulevard_title', 'text', 'Boulevard Connection'),
('about', 'boulevard_description', 'text', 'As a proud member of the Boulevard Hotel Group family, we inherit a tradition of excellence that spans decades. This affiliation ensures that while our character remains uniquely local, our standards are globally recognized.'),
('about', 'boulevard_image', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC0WGC-WMnb65iH0ib4osE0z12xpuMmo9c3Vlqbmyc7_B_KnzhJhSJNuXw5cmeAqn1qCY_yWriMOXSteNKN0G86P2qN29BWPOM73KuLwrPtF4BqOrVqLGIJE6GBnmFLaj6EVQnb5s1sOXOrUa11-MJ2BFp2ZwoSF1aDeKEjJOcbO6Mpq4HLVI6m4j04ETAvI96t-Kgd5WWyM7YIz3h0rcFrHO4vLF3FID-bisEY04Dxxjm1Jt4K7EJy1I3QsCZyQldadfeW8CichZE'),
('about', 'location_title', 'text', 'In the Heart of Rayfield'),
('about', 'location_description', 'text', 'Located in the most secure and serene district of Jos, Peregrine Hotel offers a peaceful retreat from the city\'s bustle while remaining conveniently close to key landmarks.'),
('about', 'location_directions_text', 'text', 'Get Directions'),
('about', 'location_directions_link', 'text', 'contact_us.php'),
('about', 'map_image', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuCgZ7f76kqiv9y5zDBhpChmmdyc61o5FgkZ4RAcvKHa-97-TiE2WrVOIusxAJa5gMGtfsLajQ69sLRulVbWBbDVOQA0zNyJPGpw80XRW-cCgvHdDdjdXTNeYCc4ZYnv_s2CU_RTdIk4t25cCdhbktdfoBaUBRV29kLcU9pxdd2cfbk-hdkdKnRWxArfxfrMrn5QtntFWN6eKqRt8UQipEoxtXmMaupkCWjHu05En2Pyi0MqSGNA_AktdeQaKuIKf070N8pUjPTuPE4'),
('about', 'gallery_title', 'text', 'Designed for Tranquility'),
('about', 'gallery_subtitle', 'text', 'A glimpse into our aesthetic.'),
('about', 'gallery_image_1', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDCkCeP7g4Dy8vikL6iWaGdUfpeiDSGmAuI1TbcKwZ1XaTU59JRFuVIWuFXPiDm0dJsCQsGToWf7FkGVP0_DPxO0jm8cc8SK0PVZYG_h6UJ0sf-hP5Ks73Li7bsUt7Z--gAe_4KTz2nvPsDp1v_x_JrgFqfGlgY0llAFbrukqpqEEaUCSozcTCmy7MK39cJhPjcXJ1xQzrm-tJVJCEoRZ9TsX_ztFbbdGbk4GXC6mpTAAnJzGwUQXDxtJb8cX0YVKtvc4PEjHjBfV4'),
('about', 'gallery_image_2', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBQYHROmYzBpxOeOD3AYkKrH5sOVUvjAwQ_nD_29Rxzu9G6d0BWQmpq7XCKn8VjJZA23rA8xuNOY1ZnCyHDfy-GbihzEIS1v9ZDixMtJovu5pRGK7MRiZOsoz0F9xcnBJKJlNy-sn5OSk7bUXTeXVkuvhl9dWOshU-8cLJ_NguD6LcF2DNPDH679_QA_QolMMvBjmJeFnd180lduCfNJZshAW8NEq6Qiho2xXXO-PNnDKKcILAT10cp-IXBtgQ89C5ntpTcqaHYjCA'),
('about', 'gallery_image_3', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_Bo9tfEtOKvkdOWIML9xfH78nzBOu_WVObwHMsfhf5WfSOKwSeuNKZTmaaSKA4EB8SkxbA9P6Be-8iSgRzMNXWSSQY5CpBUMTRqgi98MXai_-czHGwQP0xfZGMwVeXHj_zWpy6aLHxlnZguAaE3GC25YtTKSyTQUJnzp5TvnKWEs-ddUyFJleWF6qD7oQ7crJtCr0-sDlVnn8QUHueV3_YnQpra9OMfeeSCNxgIMaRi9XkvHqF0LMUGhPPXb5cvB0F6-F7x7py5A');

-- ============================================
-- ROOMS PAGE CONTENT
-- ============================================
INSERT INTO `page_sections` (`page`, `section_key`, `content_type`, `content`) VALUES
('rooms', 'page_title', 'text', 'Accommodations'),
('rooms', 'page_subtitle', 'text', 'Designed for tranquility and style. Choose the space that fits your journey.'),
('rooms', 'hero_background', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBTf78SDLBYRls1ySmKF4WsCAN-qDa13xSezqXFEbPdgfNaAW8L5dxckdgCczLiYlMG46wFqh-jR60JPMyjP8gFRiLZ__fMcBEj_DieB42pe8T9tF0P0u412FPC34nTB5vh5Sfx8RDM4gTgLF610c5oEefiOcOiYLEcMX1yvB89Lg2U8Fu5eKKDL_wxOZ3cnPdAHaWcs9XY9b1d7lTY7Mm_S1vAxnrl38T3zZLEmbO2BfmgNvJDhZzJ5B6yYB4a42GZ8y-HvUDChII');

-- ============================================
-- AMENITIES PAGE CONTENT
-- ============================================
INSERT INTO `page_sections` (`page`, `section_key`, `content_type`, `content`) VALUES
('amenities', 'page_title', 'text', 'Hotel Amenities & Facilities'),
('amenities', 'page_subtitle', 'text', 'Experience the pinnacle of relaxation and luxury at Peregrine Hotel Rayfield. Every detail is curated for your comfort.'),
('amenities', 'hero_background', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAsmyb7g_tD4XW07hxKcTqm7MDe-AUkrmF4sWpS4fI1XA6rKavcGNAxJSlQAqTKmTXXqth1fb3EoYR3-QvbSM4arG70wlFkMX3Ho2EpKWhMRMIsoTIRlLFk5lGcEZcXRIv2y21Fh2adICmEmuLgqItbIrlgOGqDx7ssOc_axZB1s2fCq0qijtgkhR5pS9WoFJg2p25o8lZJRHIPDAyGopkVgApMInS42toZqxf-8WYyQjD2Ho9WV5NIUoaghunKTmPiH5-mPvACg-8'),
('amenities', 'pool_label', 'text', 'Relaxation'),
('amenities', 'pool_title', 'text', 'Serene Swimming Pool'),
('amenities', 'pool_description', 'text', 'Unwind by our crystal-clear pool, perfect for a refreshing dip or lounging with a cocktail from the poolside bar. Enjoy the sunset in a tranquil atmosphere designed for ultimate relaxation. Our infinity edge design merges seamlessly with the horizon.'),
('amenities', 'pool_image', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuA88ADkK70NmHq6yyWJ4c8Viy3XtPEbiMLSRzsRED8Ku4rt9hqNM0B-LZs6oUfrYsypmjFMtf7QGRsjH0oZGFmVEwXYSBvnBzm1try3m5kOLM7XDmAJ31XzErvNs3d6cbENuJ31AvJBFi2i9PFdIMh-RwyNmOOFCbsh1mR6yP3FOkJokm-eDCxcREh70mOX9kjvQRjRxFVhlrFsJ7om0WR9ahLMjPyXw3BQ71U48nj7JOeMtXAvnQiyPtyyNGAz0rTScvu4AXIy4AY'),
('amenities', 'pool_cta_text', 'text', 'View Gallery'),
('amenities', 'pool_cta_link', 'text', 'gallery.php'),
('amenities', 'restaurant_label', 'text', 'Culinary'),
('amenities', 'restaurant_title', 'text', 'Gourmet Restaurant & Dining'),
('amenities', 'restaurant_description', 'text', 'Savor exquisite flavors from our world-class chefs. Our restaurant offers a blend of local Rayfield delicacies and international cuisine, served in an elegant setting perfect for intimate dinners or business lunches.'),
('amenities', 'restaurant_image', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC4g4bR8wjsbceMk7dsVqNIzYdthe_J_RBqj2qoN8n7FnudQlYLxmxhMPtLyrQzuAvwhph08EWUgD4u2u1xuziB88sNxezVViWRsi8JDtJdK6mjkIdT9MxZjCt-cNRL71ZNftyja4q1dQM8EASQeHqbe-0CzEwKWmCNfa56SjxifNkN7aCnumFiBV0FQjYBA76skPTtxm9vyO--TGg4Ai5HQnA9t6wir17iO-WarJDzwnB8kUardoRAr367UF7uo2aU4JbVVyCrA8s'),
('amenities', 'restaurant_cta_text', 'text', 'Download Menu'),
('amenities', 'restaurant_cta_link', 'text', '#'),
('amenities', 'leisure_label', 'text', 'Lifestyle'),
('amenities', 'leisure_title', 'text', 'Exclusive Leisure Spaces'),
('amenities', 'leisure_description', 'text', 'Discover our curated leisure spaces, including a private lounge and manicured gardens. Whether you seek a quiet corner to read or a social space to connect, our hotel offers the perfect environment for rejuvenation.'),
('amenities', 'leisure_image', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDjlooDD4eFlVpovEsmee3i8e4iHNaS0HkA08QfSZ2qimz7H2uCXfph_H7bVnZxN4Mz4uPOhQojSwAeDq2QejTkPhU-myFWxDNFMPQru2lDapWP-Tpw7veEKS-Vx2gxAZLeJTfqWokWrsQ_1SOvY0VhgLEn3SdM6CSGcmFGcCCiKdh9qHZBSWcTlYqKAK6We1VlllkIZN52Xu-hZFNtYst2aihKHUcS4dNHnVbGIg-2NaKGQTY6O7krvyikwcsX2ehMhVzxNbyqzaY'),
('amenities', 'events_label', 'text', 'Business'),
('amenities', 'events_title', 'text', 'Meetings & Events'),
('amenities', 'events_description', 'text', 'Host successful business meetings, conferences, or social events in our versatile venues. Equipped with high-speed Wi-Fi, modern AV technology, and dedicated support staff to ensure your event runs smoothly.'),
('amenities', 'events_image', 'image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBRUilBAkTIsJ_s9b02T-72z2gVNx_Azp3p_DcRdF3lt9gc1Tm0pVZ8zMnHrXmuMYpXPe6AbEToruawTiGWoGp4mPN0rIwHkeq1qhjAEIfXIyDCKKBFDhUSGUQDnWpbyrcG_nXtFwBZiHZ2rfh-0jYwWX-LulTpojGs4mcsBPHzGtMwMRWGSJH2z-onN2wwJ2XkvIq8sLLYVtYHOR0hmAzVPD91kCZkXQe-dgSarlKFT7YK9BZojC_Wfw8O2NWpAFwX5NeGdAsFnKc'),
('amenities', 'events_cta_text', 'text', 'Inquire Now'),
('amenities', 'events_cta_link', 'text', 'contact_us.php');

-- ============================================
-- CONTACT PAGE CONTENT
-- ============================================
INSERT INTO `page_sections` (`page`, `section_key`, `content_type`, `content`) VALUES
('contact', 'page_title', 'text', 'Get in Touch'),
('contact', 'page_subtitle', 'text', 'Experience luxury in the heart of Jos. Reach out for reservations, events, or general inquiries.'),
('contact', 'contact_address', 'text', '123 Rayfield Road,<br/>Jos, Plateau State,<br/>Nigeria'),
('contact', 'reservations_phone', 'text', '+234 123 456 7890'),
('contact', 'events_email', 'text', 'reservations@peregrinehotel.com'),
('contact', 'map_address', 'text', '123 Rayfield Road, Jos'),
('contact', 'map_embed_url', 'text', 'https://maps.google.com/maps?q=Rayfield,+Jos,+Nigeria&hl=en&z=14&output=embed');

-- ============================================
-- POLICIES PAGE CONTENT
-- ============================================
INSERT INTO `page_sections` (`page`, `section_key`, `content_type`, `content`) VALUES
('policies', 'page_title', 'text', 'Policies & Terms'),
('policies', 'last_updated', 'text', 'October 24, 2023'),
('policies', 'intro_text', 'text', 'Welcome to Peregrine Hotel Rayfield. Our policies are designed to ensure a seamless, luxurious, and safe experience for all our guests. Please review the following terms carefully before confirming your reservation.'),
('policies', 'check_in_time', 'text', '3:00 PM'),
('policies', 'check_out_time', 'text', '11:00 AM'),
('policies', 'cancellation_policy', 'text', 'Cancellations must be made at least 24 hours prior to arrival to avoid a penalty of one night\'s room and tax.'),
('policies', 'deposit_policy', 'text', 'A valid credit card is required at the time of booking to guarantee your reservation. A hold of $100 per night for incidentals will be placed upon check-in.'),
('policies', 'guest_conduct', 'text', 'Peregrine Hotel Rayfield is committed to providing a smoke-free environment. Smoking is strictly prohibited in all guest rooms and public areas. A cleaning fee of $500 will be charged to any guest who violates this policy.'),
('policies', 'privacy_policy', 'text', 'We value your privacy. Personal information collected during the reservation process is used solely for the purpose of your stay and internal records. We do not sell or share your data with third parties, except as required by law or to facilitate your transaction. For full details, please request our comprehensive Data Protection Addendum at the front desk.');

-- ============================================
-- DEFAULT ROOMS (From HTML Design)
-- ============================================
INSERT INTO `rooms` (`title`, `slug`, `price`, `room_type`, `max_guests`, `short_description`, `description`, `main_image`, `gallery_images`, `features`, `amenities`, `is_featured`, `is_active`, `display_order`) VALUES
('Deluxe King Room', 'deluxe-king-room', 85000.00, 'Deluxe', 2, 'Spacious 35sqm room featuring a king-size bed, workstation, and city views.', 'Spacious 35sqm room featuring a king-size bed, workstation, and city views. Perfect for business travelers and couples seeking comfort and elegance.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAbOMUrQubW3mPobJBh8z5BWm3QtR_by-b9-nP8UuATi9FQjyI08IFzyqzKcnFhHkbP0eoZ3Tk3SP9HN-3sZcO0XmJ3iWSzE2y_tPV4l88Z66fUFCvFcwSHhILQShzckwV6_-XuVmpjWgUDnHheWlAm4vVd5LTarIenKjj3Esy-l-5yMJOsYQqYTXMVlKRvI9o1UemWCOoK2_jIqgiBGG6O5xDSXqMB3Con3bDxw7WbFvozUNq4prjpJ9eKwMCDQtjYikStGLW9Rjg', '[]', '["35m²", "King Bed", "City View", "Workstation"]', '["Free Wi-Fi", "Air Conditioning", "Flat-screen TV", "Mini Bar", "Coffee Maker", "Safe", "Hair Dryer", "Premium Toiletries"]', 1, 1, 1),
('Executive Suite', 'executive-suite', 120000.00, 'Suite', 3, 'Separate living area, enhanced amenities, and access to the executive lounge.', 'Separate living area, enhanced amenities, and access to the executive lounge. Ideal for extended stays and business travelers who need extra space.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBX3aiV-DAYwFluI_or0WtUry5nB-bxd-XidtdQEUhNyXhv74W511n06LHYxi0YMi7fqbBRjS0Zm9GAGCd_xwpRgbj0DcRA-V695YVQhP3uUquZmA6bSyu0RJ73kWvHA24fGQ_m8WTKXjoode3HrJmYRribfnMyX9C28kIlvHDNEdum7_M4LQZveBsfCmFbeTJM-ZmNvyLI2PmadB8WDmB3xZGoMPEkYop1kxfoTPobRToX-uTCK4LAJOp3BcH5-D8TWM08Qnl83Mg', '[]', '["55m²", "King Bed", "Living Area", "Executive Lounge Access"]', '["Free Wi-Fi", "Air Conditioning", "Flat-screen TV", "Mini Bar", "Coffee Machine", "Safe", "Hair Dryer", "Premium Toiletries", "Room Service", "Breakfast Included"]', 1, 1, 2),
('Presidential Suite', 'presidential-suite', 250000.00, 'Presidential', 4, 'The ultimate luxury experience with panoramic views, private dining, and jacuzzi.', 'The ultimate luxury experience with panoramic views, private dining, and jacuzzi. This expansive suite offers the pinnacle of comfort and elegance for discerning guests.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuA8oIDYGfmXRAwk16BHoXPE4oprTnMcaQpqBeP2D4Fa2KDU_FvP5s-ebkdlGa_RxMs7ORi77xWekCNtIkHMQwQ5j0h2BqeUEEby_4ovD-Nay79cV4YR3P0ranJB3e2HFxz0ZJc9JwHz8Xyo34nKANf9I_4NopzUz-3ZRP1z95qaIZgjcZXrmI9R_1eCBWt6t8Md5_EN1YTHCF-ip0-Y9ZzEzr079n_bXTSp9xX5v98s-5ks_19j_eGowAEQ7B82j5m8ksU2C_1rykM', '[]', '["85m²", "King Bed", "Private Dining", "Jacuzzi", "Panoramic Views"]', '["Free Wi-Fi", "Air Conditioning", "Multiple Flat-screen TVs", "Premium Mini Bar", "Coffee Machine", "Safe", "Hair Dryer", "Premium Toiletries", "24/7 Butler Service", "Premium Concierge", "Private Dining", "Breakfast Included", "Airport Transfer"]', 1, 1, 3);
