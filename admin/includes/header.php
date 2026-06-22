<?php
require_once dirname(__DIR__, 2) . '/includes/auth.php';
require_login();
$admin=current_admin();
function nav_active($f){ return basename($_SERVER['PHP_SELF'])===$f ? 'active' : ''; }
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle ?? 'Dashboard') ?> · MACDEF Admin</title>
<link rel="stylesheet" href="../css/admin.css">
</head><body class="admin-body"><div class="admin-shell">
<aside class="admin-sidebar" id="adminSidebar">
  <div class="sidebar-brand"><img src="../assets/images/macdef-logo.png" alt="MACDEF"><span>MACDEF Admin</span></div>
  <nav class="sidebar-nav">
    <a class="<?= nav_active('dashboard.php') || nav_active('index.php') ?>" href="dashboard.php">Dashboard</a>
    <div class="nav-group">Content Management</div>
    <a class="<?= nav_active('homepage.php') ?>" href="homepage.php">Homepage</a>
    <a class="<?= nav_active('footer.php') ?>" href="footer.php">Footer</a>
    <a class="<?= nav_active('contact_settings.php') ?>" href="contact_settings.php">Contact Info</a>
    <a class="<?= nav_active('hero.php') ?>" href="hero.php">Hero Slider</a>
    <a class="<?= nav_active('programs.php') ?>" href="programs.php">Programs</a>
    <a class="<?= nav_active('events.php') ?>" href="events.php">Events</a>
    <a class="<?= nav_active('gallery.php') ?>" href="gallery.php">Gallery</a>

    <div class="nav-group">News & Media</div>
    <a class="<?= nav_active('news.php') ?>" href="news.php">News</a>
    <a class="<?= nav_active('publications.php') ?>" href="publications.php">Publications</a>
    <a class="<?= nav_active('resources.php') ?>" href="resources.php">Resources</a>
    <a class="<?= nav_active('downloads.php') ?>" href="downloads.php">Downloads</a>

    <div class="nav-group">Interactions</div>
    <a class="<?= nav_active('opportunities.php') ?>" href="opportunities.php">Opportunities</a>
    <a class="<?= nav_active('donations.php') || nav_active('donation_methods.php') ?>" href="donations.php">Donations</a>
    <a class="<?= nav_active('memberships.php') ?>" href="memberships.php">Memberships</a>
    <a class="<?= nav_active('newsletter.php') ?>" href="newsletter.php">Newsletter</a>
    <a class="<?= nav_active('contact_messages.php') ?>" href="contact_messages.php">Messages</a>

    <div class="nav-group">System</div>
    <a class="<?= nav_active('media.php') ?>" href="media.php">Media Library</a>
    <a class="<?= nav_active('seo.php') ?>" href="seo.php">SEO</a>
    <a class="<?= nav_active('email_logs.php') ?>" href="email_logs.php">Email Logs</a>
    <a class="<?= nav_active('settings.php') ?>" href="settings.php">Settings / Mailing</a>
  </nav>
</aside>
<div class="admin-main"><header class="admin-topbar">
<button class="sb-toggle" onclick="document.getElementById('adminSidebar').classList.toggle('open')">☰</button>
<h1><?= e($pageTitle ?? 'Dashboard') ?></h1><div class="topbar-right"><span>Hi, <?= e($admin['name'] ?? 'Admin') ?></span><a class="logout-btn" href="logout.php">Logout</a></div>
</header><main class="admin-content">
