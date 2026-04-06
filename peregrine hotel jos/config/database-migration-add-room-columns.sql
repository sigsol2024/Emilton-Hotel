-- Migration: Add missing columns to rooms table
-- Run this if your database already exists and you're getting "Column not found" errors
-- This adds all the columns that the rooms API expects
-- 
-- IMPORTANT: If you get "Duplicate column name" errors, it means the columns already exist
-- and you can ignore those errors or comment out those lines

ALTER TABLE `rooms` 
ADD COLUMN `rating` INT(1) DEFAULT 5 AFTER `display_order`,
ADD COLUMN `rating_score` DECIMAL(3,1) DEFAULT NULL AFTER `rating`,
ADD COLUMN `location` VARCHAR(255) DEFAULT NULL AFTER `rating_score`,
ADD COLUMN `size` VARCHAR(50) DEFAULT NULL AFTER `location`,
ADD COLUMN `tags` TEXT DEFAULT NULL COMMENT 'JSON array of tags' AFTER `size`,
ADD COLUMN `included_items` TEXT DEFAULT NULL COMMENT 'JSON array of included items' AFTER `tags`,
ADD COLUMN `good_to_know` TEXT DEFAULT NULL COMMENT 'JSON object of good to know info' AFTER `included_items`,
ADD COLUMN `book_url` VARCHAR(500) DEFAULT NULL AFTER `good_to_know`,
ADD COLUMN `original_price` DECIMAL(10,2) DEFAULT NULL AFTER `book_url`,
ADD COLUMN `urgency_message` VARCHAR(255) DEFAULT NULL AFTER `original_price`;
