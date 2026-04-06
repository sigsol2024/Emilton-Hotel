# Hotel CMS - Admin Backend System

A comprehensive PHP/MySQL content management system for managing hotel/apartment websites with a WordPress-style admin panel.

## Features

- **WordPress-style Admin Panel** - Mobile-responsive sidebar navigation
- **Room Management** - Full CRUD operations for rooms/suites
- **Content Management** - Edit homepage, about page, and other content sections
- **Media Library** - Secure image upload and management
- **Site Settings** - Manage site name, logo, favicon, contact info, footer content
- **Testimonials** - Manage customer testimonials with ratings
- **Dynamic Frontend** - PHP pages that load content from database
- **Secure Authentication** - Password hashing, CSRF protection, session management

## Requirements

- PHP 7.4+ (recommended 8.0+)
- MySQL 5.7+ / MariaDB 10.3+
- Apache/Nginx web server with mod_rewrite
- PHP Extensions: PDO, PDO_MySQL, GD/ImageMagick

## Installation

1. **Database Setup**
   ```bash
   # Import the database schema
   mysql -u root -p < config/database.sql
   ```

2. **Configuration**
   - Edit `admin/includes/config.php`
   - Update database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'hotel_cms');
     ```

3. **Permissions**
   ```bash
   # Ensure uploads directory is writable
   chmod 755 assets/uploads
   ```

4. **Default Login**
   - URL: `http://your-domain/admin/`
   - Username: `admin`
   - Password: `Admin@123`
   - ⚠️ **Change password immediately after first login!**

## File Structure

```
/
├── admin/                    # Admin panel
│   ├── api/                  # API endpoints
│   ├── assets/               # Admin CSS/JS
│   ├── includes/             # Core files (config, auth, etc.)
│   ├── pages/                # Admin pages
│   └── index.php             # Login page
├── assets/
│   └── uploads/              # User uploaded files
├── includes/
│   └── content-loader.php    # Frontend content helper
├── config/
│   └── database.sql          # Database schema
├── index.php                 # Dynamic homepage
├── about.php                 # Dynamic about page
├── gallery.php               # Dynamic gallery/rooms page
└── details.php               # Dynamic room details page
```

## Admin Panel Features

### Dashboard
- Statistics overview
- Quick actions
- Recent rooms list

### Room Management
- Add/Edit/Delete rooms
- Upload main image and gallery
- Set pricing, room type, max guests
- Mark as featured
- Manage display order

### Content Editors
- **Homepage Editor**: Edit hero, about, rooms sections, awards, CTAs
- **About Page Editor**: Edit page header, content, counters, testimonials

### Settings
- Site name, tagline
- Logo and favicon upload
- Contact information
- Footer content
- Developer credits

### Media Library
- Upload images
- Browse and delete media
- Copy image URLs

### Testimonials
- Add/edit/delete testimonials
- Set ratings (1-5 stars)
- Control display order

## Security Features

- Password hashing using PHP `password_hash()`
- CSRF token protection
- SQL injection prevention via PDO prepared statements
- XSS prevention via output escaping
- Session timeout (30 minutes)
- Rate limiting for login attempts
- Secure file upload validation

## Development Notes

- All database queries use PDO prepared statements
- Output is escaped using `htmlspecialchars()` or helper functions
- File uploads are validated for type and size
- Mobile-responsive admin panel with sidebar toggle

## Support

For issues or questions, please contact the development team.

---

**Developed with ❤️ for TM Luxury Apartments**

