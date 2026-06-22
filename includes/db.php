<?php
require_once __DIR__ . '/config.php';
$pdo = null;
try {
    $port = defined('DB_PORT') && DB_PORT !== '' ? ';port=' . DB_PORT : '';
    $dsn = 'mysql:host=' . DB_HOST . $port . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) { $pdo = null; }
function db(){ global $pdo; if(!$pdo){ die('Database connection failed. Check includes/config.php, MySQL port, and import database/macdef.sql first.'); } return $pdo; }
function getSetting($key, $default = '') {
    global $pdo; if (!$pdo) return $default;
    try { $stmt = $pdo->prepare('SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1'); $stmt->execute([$key]); $r=$stmt->fetch(); return $r ? $r['setting_value'] : $default; } catch (PDOException $e) { return $default; }
}
function setSetting($key,$value){ $stmt=db()->prepare('INSERT INTO settings(setting_key,setting_value) VALUES(?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)'); return $stmt->execute([$key,$value]); }
?>