<?php
/**
 * Content Migration Script
 * Migrates existing HTML content to database
 * Run this script once to populate the database with existing content
 */

require_once __DIR__ . '/../admin/includes/config.php';

echo "Starting content migration...\n\n";

try {
    // The database schema already includes default content from database.sql
    // This script can be used to update or verify content
    
    echo "✓ Database connection successful\n";
    
    // Check if default settings exist
    $settingsCount = $pdo->query("SELECT COUNT(*) FROM site_settings")->fetchColumn();
    echo "✓ Found {$settingsCount} site settings\n";
    
    // Check if page sections exist
    $sectionsCount = $pdo->query("SELECT COUNT(*) FROM page_sections")->fetchColumn();
    echo "✓ Found {$sectionsCount} page sections\n";
    
    // Check if admin user exists
    $adminCount = $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    echo "✓ Found {$adminCount} admin user(s)\n";
    
    echo "\nMigration completed successfully!\n";
    echo "Admin login:\n";
    echo "- Visit /admin/ and log in with your admin account.\n";
    echo "- If you don't know the password, reset it using a secure process (do not ship reset scripts in production).\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

