<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/auth.php';

// Security Headers
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; img-src 'self' data: " . SITE_URL . " https://www.google.com; frame-src https://www.google.com;");

$site_name = getSetting('site_name', 'MACDEF');
$site_title = getSetting('site_title', 'Ma\'di Cultural and Development Foundation');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(isset($page_title) ? $page_title . ' | ' . $site_name : $site_title); ?></title>

    <meta name="description" content="<?= e(getSetting('meta_description', 'Ma\'di Cultural and Development Foundation')) ?>">
    <meta name="keywords" content="<?= e(getSetting('meta_keywords', 'MACDEF, Ma\'di, Culture, Development, Uganda')) ?>">

    <meta property="og:title" content="<?= e(getSetting('og_title', $site_title)) ?>">
    <meta property="og:description" content="<?= e(getSetting('meta_description', 'Ma\'di Cultural and Development Foundation')) ?>">
    <?php if ($og_img = getSetting('og_image')): ?>
    <meta property="og:image" content="<?= SITE_URL . '/' . $og_img ?>">
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="navbar-brand">
                <a href="index.php">
                    <img src="assets/images/macdef-logo.png" alt="MACDEF Logo">
                </a>
            </div>
            <div class="top-bar-links d-none d-lg-block">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item me-4"><a href="events-calendar.php"><i class="ri-calendar-event-line me-1"></i> Events Calendar</a></li>
                    <li class="list-inline-item me-4"><a href="#newsletter-section"><i class="ri-mail-send-line me-1"></i> Newsletter</a></li>
                    <li class="list-inline-item me-4"><a href="contact.php"><i class="ri-contacts-line me-1"></i> Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Who We Are</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="mission.php">About MACDEF</a></li>
                        <li><a class="dropdown-item" href="mission.php#values">Mission & Vision</a></li>
                        <li><a class="dropdown-item" href="organisation.php">Board of Directors</a></li>
                        <li><a class="dropdown-item" href="organisation.php">The Secretariat</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">What We Do</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="goals.php">Our Programs</a></li>
                        <li><a class="dropdown-item" href="goals.php#objectives">Thematic Areas</a></li>
                        <li><a class="dropdown-item" href="gallery.php">Projects Showcase</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Membership</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="contact.php">Membership Benefits</a></li>
                        <li><a class="dropdown-item" href="contact.php">Membership Application</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Resources</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="news.php">Latest News</a></li>
                        <li><a class="dropdown-item" href="publications.php">Reports & Publications</a></li>
                        <li><a class="dropdown-item" href="resources.php">Resource Centre</a></li>
                        <li><a class="dropdown-item" href="downloads.php">Downloads</a></li>
                        <li><a class="dropdown-item" href="gallery.php">Gallery</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="opportunities.php">Opportunities</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="donate.php" class="btn btn-gold px-4 py-2 me-2">DONATE</a>
                <a href="contact.php" class="btn btn-navy px-4 py-2">GET INVOLVED</a>
            </div>
        </div>
    </div>
</nav>
