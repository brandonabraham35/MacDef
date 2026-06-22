<?php
// Local XAMPP settings. Change these on hosting.
define('DB_HOST', 'localhost');
define('DB_PORT', '4000'); // Your XAMPP MySQL port. Use 3306 on normal hosting if needed.
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'macdef');

define('SITE_URL', 'http://localhost/MACDEF');
define('SITE_NAME', 'MACDEF');
define('BASE_PATH', dirname(__DIR__));
define('UPLOADS_PATH', 'uploads/');

// Mailing Settings
define('SMTP_HOST', '');
define('SMTP_PORT', '587');
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_AUTH', true);
define('SMTP_SECURE', 'tls');
define('SMTP_FROM_EMAIL', 'info@macdef.org');
define('SMTP_FROM_NAME', 'MACDEF');
define('ADMIN_EMAIL', 'info@macdef.org');
?>