# ISKCON Burla Admin Panel

## Overview
This admin panel allows authorized users to manage content for the ISKCON Burla website, specifically for Daily Darshan and Events pages.

## Admin Access
- **Login URL**: `admin/login.php`
- **Username**: `admin`
- **Password**: `iskcon2025`

## Features

### Daily Darshan Admin Panel
Located at: `DailyDarshan.php` (visible when logged in)

**Features:**
1. **YouTube Live Stream Management**
   - Update YouTube live stream URL
   - URL validation for YouTube links

2. **Gallery Image Management**
   - Upload new images directly from PC
   - Supported formats: JPG, PNG, GIF, WebP
   - Maximum file size: 5MB
   - Add captions for each image
   - Delete existing images with confirmation

### Events Admin Panel
Located at: `UpcomingEvents&Festivals.php` (visible when logged in)

**Features:**
1. **Add New Events**
   - Event title, time, location
   - Upload event image (optional)
   - Date display (day and month)
   - Event description
   - Register and donate links (optional)

2. **Edit Existing Events**
   - Full editing capabilities
   - Update all event details
   - Change or keep existing images

3. **Delete Events**
   - Remove events with confirmation
   - Automatic image cleanup

## File Structure

```
admin/
├── config.php              # Database configuration and admin functions
├── login.php               # Admin login page
├── logout.php              # Logout handler
├── upload_image.php        # Image upload for Daily Darshan
├── delete_image.php        # Image deletion for Daily Darshan
├── update_youtube.php      # YouTube URL update
├── add_event.php           # Add new events
├── edit_event.php          # Edit existing events
├── delete_event.php        # Delete events
└── get_event.php           # Get event data for editing

uploads/
├── gallery/                # Daily Darshan images
└── events/                 # Event images
```

## Database Tables

### darshan_gallery
- `id` (auto increment)
- `image_path` (varchar)
- `caption` (text)
- `uploaded_at` (timestamp)

### darshan_youtube
- `id` (auto increment)
- `youtube_url` (varchar)
- `updated_at` (timestamp)

### events
- `id` (auto increment)
- `title` (varchar)
- `event_time` (varchar)
- `location` (varchar)
- `short_description` (text)
- `image_url` (varchar)
- `register_link` (varchar)
- `donate_link` (varchar)
- `date_day` (varchar)
- `date_month` (varchar)
- `created_at` (timestamp)
- `updated_at` (timestamp)

## Security Features

1. **Session-based Authentication**
   - Admin login required for all admin functions
   - Automatic redirect for unauthorized access

2. **File Upload Security**
   - File type validation
   - File size limits
   - Secure file naming
   - Directory traversal protection

3. **Database Security**
   - Prepared statements to prevent SQL injection
   - Input validation and sanitization

## Usage Instructions

1. **Access Admin Panel**
   - Navigate to `admin/login.php`
   - Enter credentials: admin/iskcon2025
   - You'll be redirected to DailyDarshan.php

2. **Daily Darshan Management**
   - Update YouTube live stream URL
   - Upload gallery images with captions
   - Delete unwanted images

3. **Events Management**
   - Add new events with full details
   - Edit existing events using the edit modal
   - Delete events as needed

4. **Logout**
   - Click the logout button in the admin panel
   - Or visit `admin/logout.php`

## Technical Notes

- All admin operations use AJAX for smooth user experience
- Images are automatically resized and optimized
- Error handling with user-friendly messages
- Responsive design for mobile admin access
- Automatic cleanup of deleted files

## Important Notes

⚠️ **Security**: Change the default admin credentials in production
⚠️ **Backup**: Regularly backup the database and uploaded files
⚠️ **Permissions**: Ensure upload directories have proper write permissions

## Support

For technical support or questions about the admin panel, contact the development team. 