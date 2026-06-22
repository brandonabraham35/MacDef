<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | MACDEF Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>body { background-color: #f8f9fa; }.sidebar { min-height: 100vh; background-color: #002D62; color: white; }.sidebar .nav-link { color: rgba(255,255,255,0.7); }.sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background-color: rgba(255,255,255,0.1); }</style>
</head>
<body>
<div class="container-fluid"><div class="row">
    <div class="col-md-3 col-lg-2 p-0 sidebar position-fixed d-none d-md-block">
        <div class="p-4 text-center"><img src="../assets/images/macdef-logo.png" height="50" class="brightness-0 invert mb-2"><h6 class="fw-bold">MACDEF Admin</h6></div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link p-3 active" href="dashboard.php"><i class="ri-dashboard-line me-2"></i> Dashboard</a>
            <a class="nav-link p-3" href="contact_messages.php"><i class="ri-mail-line me-2"></i> Messages</a>
            <a class="nav-link p-3" href="events.php"><i class="ri-calendar-line me-2"></i> Events</a>
            <a class="nav-link p-3" href="gallery.php"><i class="ri-image-line me-2"></i> Gallery</a>
            <a class="nav-link p-3" href="settings.php"><i class="ri-settings-3-line me-2"></i> Settings</a>
            <hr class="mx-3 opacity-20">
            <a class="nav-link p-3 text-danger" href="logout.php"><i class="ri-logout-box-line me-2"></i> Logout</a>
        </nav>
    </div>
    <div class="col-md-9 col-lg-10 ms-auto p-4 p-md-5">
        <h2 class="fw-bold">Dashboard Overview</h2>
        <p>Welcome back, <?php echo $_SESSION['full_name']; ?>!</p>
    </div>
</div></div>
</body>
</html>
