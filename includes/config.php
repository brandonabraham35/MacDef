
<?php

/*
|--------------------------------------------------------------------------
| Database Configuration
|--------------------------------------------------------------------------
*/

define('DB_HOST', 'sql103.infinityfree.com');
define('DB_PORT', '3306');
define('DB_USER', 'if0_41906047');
define('DB_PASS', '');
define('DB_NAME', 'if0_41906047_macdef');
define('DB_CHARSET', 'utf8mb4');

/*
|--------------------------------------------------------------------------
| Website Configuration
|--------------------------------------------------------------------------
*/

define('SITE_URL', 'https://macdef.fast-page.org');
define('SITE_NAME', 'MACDEF');

/*
|--------------------------------------------------------------------------
| Paths
|--------------------------------------------------------------------------
*/

define('BASE_PATH', dirname(__DIR__));
define('UPLOADS_PATH', BASE_PATH . '/uploads');
define('UPLOADS_URL', 'uploads');

/*
|--------------------------------------------------------------------------
| Upload Rules
|--------------------------------------------------------------------------
*/

define('MAX_IMAGE_SIZE', 5 * 1024 * 1024); // 5MB
define('MAX_DOC_SIZE', 10 * 1024 * 1024); // 10MB

$GLOBALS['ALLOWED_IMAGE_EXT'] = [
    'jpg',
    'jpeg',
    'png',
    'webp'
];

$GLOBALS['ALLOWED_DOC_EXT'] = [
    'pdf',
    'doc',
    'docx'
];

/*
|--------------------------------------------------------------------------
| Session Settings
|--------------------------------------------------------------------------
*/

define('SESSION_TIMEOUT', 30 * 60); // 30 Minutes

/*
|--------------------------------------------------------------------------
| SMTP / Mailing Configuration
|--------------------------------------------------------------------------
| These values are fallback defaults.
| The Admin Dashboard should override them from database settings.
|--------------------------------------------------------------------------
*/

define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_PORT', getenv('SMTP_PORT') ?: 587);

define('SMTP_USER', getenv('SMTP_USER') ?: 'brandonabraham35@gmail.com');
define('SMTP_PASS', getenv('SMTP_PASS') ?: 'zxmntmlbnvbefign');

define('SMTP_AUTH', true);
define('SMTP_SECURE', 'tls');

define('SMTP_FROM_EMAIL', getenv('SMTP_FROM_EMAIL') ?: 'brandonabraham35@gmail.com');
define('SMTP_FROM_NAME', 'MACDEF');

define('ADMIN_EMAIL', getenv('ADMIN_EMAIL') ?: 'brandonabraham35@gmail.com');

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Africa/Kampala');

?>
