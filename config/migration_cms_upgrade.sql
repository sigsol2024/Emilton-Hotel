-- CMS Upgrade Migration
-- This migration adds default values for new settings introduced in the CMS upgrade
-- Run this migration after deploying the CMS upgrade code
-- Date: Current

-- Note: No table schema changes are needed. All new features use existing tables:
-- - Profile management uses existing admin_users table (email, password_hash, created_at, last_login columns already exist)
-- - New settings use existing site_settings table (key-value store, no schema changes needed)

-- Insert new default settings (using ON DUPLICATE KEY UPDATE to avoid errors if settings already exist)

-- Currency Symbol
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('currency_symbol', '$')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- Footer Email (if not already set)
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('footer_email', '')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- Contact Form Email (if not already set, will use footer_email as fallback)
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('contact_email', '')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- WhatsApp Number (if not already set)
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('whatsapp_number', '')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- SMTP Settings (empty by default - must be configured in admin panel)
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('smtp_host', ''),
('smtp_port', '587'),
('smtp_username', ''),
('smtp_password', ''),
('smtp_encryption', 'tls'),
('smtp_from_email', ''),
('smtp_from_name', 'Hotel Contact Form')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- Social Media Links (empty JSON array by default)
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('social_media_json', '[]')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- Google Maps API Key (empty by default - must be configured in admin panel)
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('google_maps_api_key', '')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

-- Migration complete message
SELECT 'CMS Upgrade Migration Completed Successfully!' AS message;
