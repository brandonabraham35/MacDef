<?php
require_once dirname(__DIR__, 2) . '/includes/auth.php';
require_login();
$admin = current_admin();

function nav_active($f) {
    if (is_array($f)) {
        return in_array(basename($_SERVER['PHP_SELF']), $f) ? 'active' : '';
    }
    return basename($_SERVER['PHP_SELF']) === $f ? 'active' : '';
}

function group_active($files) {
    foreach ($files as $f) {
        if (basename($_SERVER['PHP_SELF']) === $f) return 'open';
    }
    return '';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? 'Dashboard') ?> · MACDEF Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-brand">
                <img src="../assets/images/macdef-logo.png" alt="MACDEF">
                <span>MACDEF Admin</span>
            </div>
            <nav class="sidebar-nav">
                <a class="<?= nav_active(['dashboard.php', 'index.php']) ?>" href="dashboard.php">
                    <i class="ri-dashboard-line ic"></i> Dashboard
                </a>

                <div class="nav-item-group <?= group_active(['homepage.php', 'footer.php', 'contact_settings.php', 'hero.php']) ?>">
                    <div class="nav-group-header">
                        <span><i class="ri-layout-grid-line ic"></i> Content</span>
                        <i class="ri-arrow-right-s-line arrow"></i>
                    </div>
                    <div class="nav-group-items">
                        <a class="<?= nav_active('homepage.php') ?>" href="homepage.php">Homepage</a>
                        <a class="<?= nav_active('footer.php') ?>" href="footer.php">Footer</a>
                        <a class="<?= nav_active('contact_settings.php') ?>" href="contact_settings.php">Contact Info</a>
                        <a class="<?= nav_active('hero.php') ?>" href="hero.php">Hero Slider</a>
                    </div>
                </div>

                <div class="nav-item-group <?= group_active(['gallery.php', 'media.php']) ?>">
                    <div class="nav-group-header">
                        <span><i class="ri-image-line ic"></i> Media</span>
                        <i class="ri-arrow-right-s-line arrow"></i>
                    </div>
                    <div class="nav-group-items">
                        <a class="<?= nav_active('gallery.php') ?>" href="gallery.php">Gallery</a>
                        <a class="<?= nav_active('media.php') ?>" href="media.php">Media Library</a>
                    </div>
                </div>

                <div class="nav-item-group <?= group_active(['news.php', 'publications.php', 'resources.php', 'downloads.php']) ?>">
                    <div class="nav-group-header">
                        <span><i class="ri-file-list-3-line ic"></i> News & Resources</span>
                        <i class="ri-arrow-right-s-line arrow"></i>
                    </div>
                    <div class="nav-group-items">
                        <a class="<?= nav_active('news.php') ?>" href="news.php">News</a>
                        <a class="<?= nav_active('publications.php') ?>" href="publications.php">Publications</a>
                        <a class="<?= nav_active('resources.php') ?>" href="resources.php">Resources</a>
                        <a class="<?= nav_active('downloads.php') ?>" href="downloads.php">Downloads</a>
                    </div>
                </div>

                <div class="nav-item-group <?= group_active(['programs.php', 'events.php', 'opportunities.php', 'donations.php', 'donation_methods.php', 'memberships.php', 'newsletter.php']) ?>">
                    <div class="nav-group-header">
                        <span><i class="ri-community-line ic"></i> Community</span>
                        <i class="ri-arrow-right-s-line arrow"></i>
                    </div>
                    <div class="nav-group-items">
                        <a class="<?= nav_active('programs.php') ?>" href="programs.php">Programs</a>
                        <a class="<?= nav_active('events.php') ?>" href="events.php">Events</a>
                        <a class="<?= nav_active('opportunities.php') ?>" href="opportunities.php">Opportunities</a>
                        <a class="<?= nav_active(['donations.php', 'donation_methods.php']) ?>" href="donations.php">Donations</a>
                        <a class="<?= nav_active('memberships.php') ?>" href="memberships.php">Memberships</a>
                        <a class="<?= nav_active('newsletter.php') ?>" href="newsletter.php">Newsletter</a>
                    </div>
                </div>

                <div class="nav-item-group <?= group_active(['contact_messages.php', 'contact_reply.php', 'email_logs.php', 'settings.php', 'seo.php']) ?>">
                    <div class="nav-group-header">
                        <span><i class="ri-settings-line ic"></i> System</span>
                        <i class="ri-arrow-right-s-line arrow"></i>
                    </div>
                    <div class="nav-group-items">
                        <a class="<?= nav_active(['contact_messages.php', 'contact_reply.php']) ?>" href="contact_messages.php">Messages</a>
                        <a class="<?= nav_active('email_logs.php') ?>" href="email_logs.php">Email Logs</a>
                        <a class="<?= nav_active('settings.php') ?>" href="settings.php">Settings</a>
                        <a class="<?= nav_active('seo.php') ?>" href="seo.php">SEO</a>
                    </div>
                </div>
            </nav>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <button class="sb-toggle" onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                    <i class="ri-menu-line"></i>
                </button>
                <h1><?= e($pageTitle ?? 'Dashboard') ?></h1>
                <div class="topbar-right">
                    <div class="admin-user">
                        <div class="admin-avatar"><?= strtoupper(substr($admin['name'] ?? 'A', 0, 1)) ?></div>
                        <span>Hi, <?= e($admin['name'] ?? 'Admin') ?></span>
                    </div>
                    <a class="logout-btn" href="logout.php">Logout</a>
                </div>
            </header>
            <main class="admin-content">
