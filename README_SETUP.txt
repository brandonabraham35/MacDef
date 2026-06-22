MACDEF PHP SETUP
================

1. Copy the MacDef folder into your XAMPP htdocs folder.
   Example: C:/xampp/htdocs/MacDef

2. Start Apache and MySQL in XAMPP.

3. Open phpMyAdmin and import:
   database/macdef.sql

4. Check database settings in:
   includes/config.php

   Default XAMPP settings are:
   DB_HOST = localhost
   DB_USER = root
   DB_PASS = empty
   DB_NAME = macdef_db

5. Open the website:
   http://localhost/MacDef

6. Admin dashboard is hidden from the public menu.
   Access it manually through:
   http://localhost/MacDef/admin/login.php

7. Default admin login:
   Email: admin@macdef.org
   Password: admin123

8. Change the admin password immediately after first setup.

What was fixed:
- Added missing MySQL database SQL file.
- Added admin users, settings, contact_submissions, events, and gallery tables.
- Fixed admin login with email + password.
- Hid admin login from public footer/navigation.
- Fixed safer uploads with relative paths.
- Fixed contact form validation and message saving.
- Added safer output escaping to public dynamic pages.
- Added dashboard counts for messages, events, and gallery.
