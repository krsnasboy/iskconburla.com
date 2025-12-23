# ISKCON Portal

Public pages: Events, Daily Darshan, Services. Admin panel with secure login, global lockout after 5 failed attempts for 1 hour, and CRUD management.

## Requirements
- PHP 8.0+
- MySQL 8.x (Hostinger compatible)
- Apache/Nginx with PHP

## Setup
1. Configure database in `config.php` (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`).
2. Create schema: import `init_db.sql` into MySQL.
3. Create first admin user: visit `/admin/seed_admin.php` once, then delete the file.
4. Ensure `uploads/darshan` is writable by the web server.
5. On Apache, keep `.htaccess` to prevent script execution in uploads.

## Pages
- `/events.php`: Lists events (title, short description, date/time).
- `/daily-darshan.php`: Public image upload with caption and gallery.
- `/services.php`: List services and registration form stored in DB.
- `/admin/login.php`: Admin login with CSRF and global lockout.
- `/admin/dashboard.php`: Links to management pages.
- `/admin/events.php`: Create/delete events.
- `/admin/darshan.php`: Moderate uploads (delete).
- `/admin/services.php`: Create/delete services and view registrations.

## Security
- CSRF protection on all forms.
- Prepared statements everywhere.
- Session hardening and `session_regenerate_id` on login.
- MIME-check on uploads, 5MB max, non-executable uploads dir.
- Global lockout after 5 consecutive failed attempts for 1 hour.

## Notes
- Replace default admin password immediately after seeding.
- Customize styling in `assets/css/styles.css`.
- Base URL assumes project is at web root. If in subdirectory, update links or use a base tag. 