<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

$site_name = getSetting('site_name', 'MACDEF');
$site_title = getSetting('site_title', 'Ma\'di Cultural and Development Foundation');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . " | " . $site_name : $site_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="top-bar py-2 d-none d-lg-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex gap-4 info-items">
                    <span class="d-flex align-items-center gap-2"><i class="ri-phone-fill text-gold"></i> <?php echo getSetting('contact_phone'); ?></span>
                    <span class="d-flex align-items-center gap-2"><i class="ri-mail-fill text-gold"></i> <?php echo getSetting('contact_email'); ?></span>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="social-links d-flex gap-3 justify-content-end">
                    <a href="<?php echo getSetting('facebook_url'); ?>" class="text-white"><i class="ri-facebook-fill"></i></a>
                    <a href="<?php echo getSetting('twitter_url'); ?>" class="text-white"><i class="ri-twitter-fill"></i></a>
                    <a href="<?php echo getSetting('instagram_url'); ?>" class="text-white"><i class="ri-instagram-fill"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <img src="assets/images/macdef-logo.png" alt="MACDEF Logo" height="50">
            <div class="brand-text">
                <span class="d-block fw-bold fs-4 lh-1">MACDEF</span>
                <small class="d-block text-muted text-uppercase fw-semibold" style="font-size: 0.6rem; letter-spacing: 1px;">Ma'di Cultural Foundation</small>
            </div>
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Who We Are</a>
                    <ul class="dropdown-menu border-0 shadow">
                        <li><a class="dropdown-item" href="mission.php">About MACDEF</a></li>
                        <li><a class="dropdown-item" href="mission.php#values">Mission & Vision</a></li>
                        <li><a class="dropdown-item" href="organisation.php">Structure</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">What We Do</a>
                    <ul class="dropdown-menu border-0 shadow">
                        <li><a class="dropdown-item" href="goals.php">Our Goals</a></li>
                        <li><a class="dropdown-item" href="goals.php#objectives">Thematic Areas</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                <li class="nav-item ms-lg-3 mt-3 mt-lg-0"><a href="contact.php" class="btn btn-gold rounded-pill px-4">Get Involved</a></li>
            </ul>
        </div>
    </div>
</nav>
