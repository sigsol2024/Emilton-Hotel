-- Migration: Add new fields to rooms table for enhanced room detail page
-- Run this SQL to add the new fields required for the redesigned room detail page

ALTER TABLE `rooms` 
ADD COLUMN `rating` INT(1) DEFAULT 5 COMMENT 'Star rating (1-5)' AFTER `max_guests`,
ADD COLUMN `rating_score` DECIMAL(3,1) DEFAULT NULL COMMENT 'Rating score (e.g., 9.8)' AFTER `rating`,
ADD COLUMN `location` VARCHAR(255) DEFAULT NULL COMMENT 'Room location/wing (e.g., "Ocean Wing, 5th Floor")' AFTER `rating_score`,
ADD COLUMN `size` VARCHAR(50) DEFAULT NULL COMMENT 'Room size (e.g., "55 m²")' AFTER `location`,
ADD COLUMN `tags` TEXT DEFAULT NULL COMMENT 'JSON array of tags (e.g., ["Sustainable", "Ocean Front", "Soundproof"])' AFTER `size`,
ADD COLUMN `included_items` TEXT DEFAULT NULL COMMENT 'JSON array of included items' AFTER `tags`,
ADD COLUMN `good_to_know` TEXT DEFAULT NULL COMMENT 'JSON object with check-in/out, cancellation, pets, children policies' AFTER `included_items`,
ADD COLUMN `book_url` VARCHAR(500) DEFAULT NULL COMMENT 'Custom URL for Book Now button' AFTER `good_to_know`,
ADD COLUMN `original_price` DECIMAL(10,2) DEFAULT NULL COMMENT 'Original price for discount display' AFTER `book_url`,
ADD COLUMN `urgency_message` VARCHAR(255) DEFAULT NULL COMMENT 'Optional urgency message (e.g., "High demand! Only 2 rooms left.")' AFTER `original_price`;

