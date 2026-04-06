# CMS Upgrade Database Migration

## Overview
This migration adds default values for new settings introduced in the CMS upgrade. **No table schema changes are required** - all new features use existing database tables.

## What This Migration Does

### ✅ No Schema Changes Required
The existing database schema already supports all new features:
- **Profile Management**: Uses existing `admin_users` table (email, password_hash, created_at, last_login columns already exist)
- **New Settings**: Uses existing `site_settings` table (key-value store, no schema changes needed)

### New Settings Added
This migration adds default values for the following new settings:

1. **Currency Symbol** (`currency_symbol`) - Default: `$`
2. **Footer Email** (`footer_email`) - Default: empty
3. **Contact Form Email** (`contact_email`) - Default: empty
4. **WhatsApp Number** (`whatsapp_number`) - Default: empty
5. **SMTP Settings**:
   - `smtp_host` - Default: empty
   - `smtp_port` - Default: `587`
   - `smtp_username` - Default: empty
   - `smtp_password` - Default: empty
   - `smtp_encryption` - Default: `tls`
   - `smtp_from_email` - Default: empty
   - `smtp_from_name` - Default: `Hotel Contact Form`
6. **Social Media Links** (`social_media_json`) - Default: `[]` (empty JSON array)
7. **Google Maps API Key** (`google_maps_api_key`) - Default: empty

## How to Run the Migration

### Option 1: Using MySQL Command Line
```bash
mysql -u your_username -p your_database_name < config/migration_cms_upgrade.sql
```

### Option 2: Using phpMyAdmin
1. Log in to phpMyAdmin
2. Select your database
3. Click on the "SQL" tab
4. Copy and paste the contents of `config/migration_cms_upgrade.sql`
5. Click "Go" to execute

### Option 3: Using MySQL Workbench
1. Open MySQL Workbench
2. Connect to your database
3. Open `config/migration_cms_upgrade.sql`
4. Execute the script

## Important Notes

1. **Safe to Run Multiple Times**: The migration uses `ON DUPLICATE KEY UPDATE`, so it's safe to run multiple times without errors.

2. **No Data Loss**: This migration only adds new settings with default values. It does not modify or delete existing data.

3. **Configuration Required**: After running the migration, you must configure:
   - SMTP settings (in Admin Panel > Settings > SMTP Email Settings)
   - Google Maps API Key (in Admin Panel > Settings > Google Maps)
   - Social Media Links (in Admin Panel > Settings > Social Media Links)
   - Contact Email and Footer Email (in Admin Panel > Settings > Footer Settings)

4. **Existing Settings**: If any of these settings already exist in your database, they will not be overwritten.

## Verification

After running the migration, you can verify it worked by checking:

```sql
SELECT setting_key, setting_value 
FROM site_settings 
WHERE setting_key IN (
    'currency_symbol',
    'footer_email',
    'contact_email',
    'whatsapp_number',
    'smtp_host',
    'smtp_port',
    'smtp_username',
    'smtp_password',
    'smtp_encryption',
    'smtp_from_email',
    'smtp_from_name',
    'social_media_json',
    'google_maps_api_key'
)
ORDER BY setting_key;
```

## Rollback

If you need to remove these settings (not recommended), you can run:

```sql
DELETE FROM site_settings 
WHERE setting_key IN (
    'currency_symbol',
    'footer_email',
    'contact_email',
    'whatsapp_number',
    'smtp_host',
    'smtp_port',
    'smtp_username',
    'smtp_password',
    'smtp_encryption',
    'smtp_from_email',
    'smtp_from_name',
    'social_media_json',
    'google_maps_api_key'
);
```

**Note**: This will remove the settings but won't break the application - they will just use empty defaults.

---

**Migration File**: `config/migration_cms_upgrade.sql`
**Created**: Current
**Status**: Ready to deploy
