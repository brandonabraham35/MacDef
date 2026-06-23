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

                <div class="nav-group">Content</div>
                <a class="<?= nav_active('homepage.php') ?>" href="homepage.php"><i class="ri-home-4-line ic"></i> Homepage</a>
                <a class="<?= nav_active('footer.php') ?>" href="footer.php"><i class="ri-layout-bottom-line ic"></i> Footer</a>
                <a class="<?= nav_active('contact_settings.php') ?>" href="contact_settings.php"><i class="ri-map-pin-user-line ic"></i> Contact Info</a>
                <a class="<?= nav_active('hero.php') ?>" href="hero.php"><i class="ri-slideshow-line ic"></i> Hero Slider</a>

                <div class="nav-group">Media</div>
                <a class="<?= nav_active('gallery.php') ?>" href="gallery.php"><i class="ri-gallery-line ic"></i> Gallery</a>
                <a class="<?= nav_active('media.php') ?>" href="media.php"><i class="ri-folder-image-line ic"></i> Media Library</a>

                <div class="nav-group">News & Resources</div>
                <a class="<?= nav_active('news.php') ?>" href="news.php"><i class="ri-article-line ic"></i> News</a>
                <a class="<?= nav_active('publications.php') ?>" href="publications.php"><i class="ri-book-open-line ic"></i> Publications</a>
                <a class="<?= nav_active('resources.php') ?>" href="resources.php"><i class="ri-folder-open-line ic"></i> Resources</a>
                <a class="<?= nav_active('downloads.php') ?>" href="downloads.php"><i class="ri-download-cloud-line ic"></i> Downloads</a>

                <div class="nav-group">Community</div>
                <a class="<?= nav_active('programs.php') ?>" href="programs.php"><i class="ri-heart-pulse-line ic"></i> Programs</a>
                <a class="<?= nav_active('events.php') ?>" href="events.php"><i class="ri-calendar-event-line ic"></i> Events</a>
                <a class="<?= nav_active('opportunities.php') ?>" href="opportunities.php"><i class="ri-briefcase-line ic"></i> Opportunities</a>
                <a class="<?= nav_active(['donations.php', 'donation_methods.php']) ?>" href="donations.php"><i class="ri-hand-heart-line ic"></i> Donations</a>
                <a class="<?= nav_active('memberships.php') ?>" href="memberships.php"><i class="ri-team-line ic"></i> Memberships</a>
                <a class="<?= nav_active('newsletter.php') ?>" href="newsletter.php"><i class="ri-mail-line ic"></i> Newsletter</a>

                <div class="nav-group">System</div>
                <a class="<?= nav_active(['contact_messages.php', 'contact_reply.php']) ?>" href="contact_messages.php"><i class="ri-chat-3-line ic"></i> Messages</a>
                <a class="<?= nav_active('email_logs.php') ?>" href="email_logs.php"><i class="ri-mail-send-line ic"></i> Email Logs</a>
                <a class="<?= nav_active('settings.php') ?>" href="settings.php"><i class="ri-settings-4-line ic"></i> Settings</a>
                <a class="<?= nav_active('seo.php') ?>" href="seo.php"><i class="ri-search-line ic"></i> SEO</a>
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
