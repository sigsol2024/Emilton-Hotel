-- Hotel CMS Database Schema
-- MySQL 5.7+ / MariaDB 10.3+
-- For Shared Hosting: Create the database through cPanel first, then import this file

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

-- Insert default admin user (password: Admin@123 - CHANGE THIS AFTER FIRST LOGIN)
-- Password hash generated using: password_hash('Admin@123', PASSWORD_BCRYPT)
INSERT INTO `admin_users` (`username`, `email`, `password_hash`, `is_active`) VALUES
('admin', 'admin@hotel.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1)
ON DUPLICATE KEY UPDATE `username` = `username`;

-- Insert default site settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'TM Luxury Apartments'),
('site_tagline', 'Luxury Apartment in Ajao Estate, Lagos'),
('site_logo', 'assets/img/logo1.png'),
('site_favicon', 'assets/img/logo1.png'),
('footer_address', '11 Akpofe Street, Ajao Estate, Off Int\'l Airport Road.'),
('footer_phone', '+234 813 480 7718 | +234 907 676 0923'),
('footer_copyright', 'TM'),
('header_location', '11 Okpofe Street, Ajoa Estate, Off Int\'l Airport Road'),
('whatsapp_link', 'https://wa.me/2348134807718?text=Greetings%20TM%20Luxury%20Apartment'),
('developer_link', 'https://wa.me/2347068057873?text=Greetings%20Brilliant%20Developers'),
('developer_text', 'Brilliant Developers - 07068057873')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- Insert default page sections for homepage
INSERT INTO `page_sections` (`page`, `section_key`, `content_type`, `content`) VALUES
('index', 'hero_title', 'html', 'YOUR HOME <span class="cs_accent_color cs_ternary_font cs_hover_layer_2" style="color:#343a40;">away</span> FROM HOME'),
('index', 'hero_background', 'image', 'assets/rooms/luxury-apartment-ajao-estate-bedroom.webp'),
('index', 'hero_cta_text', 'text', 'Book Now'),
('index', 'hero_cta_link', 'text', 'gallery.html'),
('index', 'about_title', 'html', 'EXPERIENCE THE BEAUTY OF CHRISTMAS AT TM Luxury Apartments - Ajoa Estate Airport Road, <span class="cs_accent_color cs_ternary_font"> Lagos.</span>'),
('index', 'about_description', 'html', 'TM is a premiere luxury apartment crafted for comfort, elegance, and a memorable stay. We are committed to give you <br> the best vacation experience you will ever have and truly cherish.'),
('index', 'about_image', 'image', 'assets/rooms/beautiful-short-let-apartment-in-ajao-estate-lagos.webp'),
('index', 'featured_rooms_title', 'text', 'We provide luxury & fully serviced apartments in Ajao Estate designed for guests who value comfort and privacy.'),
('index', 'rooms_section_subtitle', 'text', 'Experience luxury living in a fully smart Apartment'),
('index', 'rooms_section_title', 'text', 'Truly luxury — just for you.'),
('index', 'rooms_section_description', 'text', 'TM Luxury Apartments provides premium luxury apartments in Ajao Estate, Lagos, offering comfort, security,and modern living for short-let and serviced apartment guests. All available for booking rightaway.'),
('index', 'why_choose_title', 'text', 'Why Choose TM Luxury Apartments in Ajao Estate?'),
('index', 'why_choose_description', 'html', 'At Tm, we provide luxury range of accommodations to make your stay comfortable and enjoyable. <br> We make sure you have the most memorable experience staying at TM luxury apartment.'),
('index', 'awards_subtitle', 'text', 'TM Luxury Apartment Located in Ajao Estate Airport Rd.'),
('index', 'awards_title', 'text', 'Only Excellence Just For You'),
('index', 'booking_cta_title', 'text', 'Shanghai Suite'),
('index', 'booking_cta_description', 'text', 'Availability is Limited — Book Your Stay Today.')
ON DUPLICATE KEY UPDATE `page` = `page`;

-- Insert default page sections for about page
INSERT INTO `page_sections` (`page`, `section_key`, `content_type`, `content`) VALUES
('about', 'page_header_title', 'text', 'ABOUT TM'),
('about', 'page_header_image', 'image', 'assets/img/about1.jpg'),
('about', 'main_title', 'html', 'Looking for a serviced luxury apartment in Ajao Estate near the airport?'),
('about', 'main_description', 'html', 'TM Luxury Apartments provides well-maintained apartments with professional housekeeping services,<br>making it perfect for short stays, long stays, and corporate bookings.'),
('about', 'counter_1_percentage', 'text', '100%'),
('about', 'counter_1_title', 'text', 'Quest Satisfaction'),
('about', 'counter_2_percentage', 'text', '100%'),
('about', 'counter_2_title', 'text', 'Luxury Features'),
('about', 'counter_3_percentage', 'text', '100%'),
('about', 'counter_3_title', 'text', 'Secure Environment'),
('about', 'why_choose_subtitle', 'text', 'Luxury Apartment in Ajoa Estate, Lagos'),
('about', 'why_choose_title', 'text', 'Why Choose TM Luxury Apartments in Ajao Estate?'),
('about', 'why_choose_description', 'html', 'At TM, we ensure your stay is comfortable, enjoyable, and truly memorable, with every detail of the apartment designed for your convenience and delight.')
ON DUPLICATE KEY UPDATE `page` = `page`;

