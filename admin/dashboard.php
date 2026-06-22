<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireLogin();

// Fetch some stats
$submissions_count = 0;
$events_count = 0;
$gallery_count = 0;

if ($pdo) {
    $submissions_count = $pdo->query("SELECT COUNT(*) FROM contact_submissions")->fetchColumn();
    $events_count = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
    $gallery_count = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | MACDEF Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #002D62; color: white; }
        .sidebar .nav-link { color: rgba(255,255,255,0.7); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background-color: rgba(255,255,255,0.1); }
        .stat-card { border: none; border-radius: 15px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0 sidebar position-fixed d-none d-md-block">
            <div class="p-4 text-center">
                <img src="../assets/images/macdef-logo.png" height="50" class="brightness-0 invert mb-2">
                <h6 class="fw-bold">MACDEF Admin</h6>
            </div>
            <nav class="nav flex-column mt-3">
                <a class="nav-link p-3 active" href="dashboard.php"><i class="ri-dashboard-line me-2"></i> Dashboard</a>
                <a class="nav-link p-3" href="contact_messages.php"><i class="ri-mail-line me-2"></i> Messages</a>
                <a class="nav-link p-3" href="events.php"><i class="ri-calendar-line me-2"></i> Events</a>
                <a class="nav-link p-3" href="gallery.php"><i class="ri-image-line me-2"></i> Gallery</a>
                <a class="nav-link p-3" href="settings.php"><i class="ri-settings-3-line me-2"></i> Settings</a>
                <hr class="mx-3 opacity-20">
                <a class="nav-link p-3" href="../index.php" target="_blank"><i class="ri-external-link-line me-2"></i> View Site</a>
                <a class="nav-link p-3 text-danger" href="logout.php"><i class="ri-logout-box-line me-2"></i> Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-auto p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Dashboard Overview</h2>
                <div class="dropdown">
                    <button class="btn btn-white shadow-sm dropdown-toggle rounded-pill px-3" data-bs-toggle="dropdown">
                        <i class="ri-user-line me-1"></i> <?php echo $_SESSION['full_name']; ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card stat-card shadow-sm p-4 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small fw-bold text-uppercase mb-1">Messages</p>
                                <h3 class="fw-bold mb-0"><?php echo $submissions_count; ?></h3>
                            </div>
                            <div class="icon-circle bg-primary-subtle text-primary">
                                <i class="ri-mail-line fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card shadow-sm p-4 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small fw-bold text-uppercase mb-1">Events</p>
                                <h3 class="fw-bold mb-0"><?php echo $events_count; ?></h3>
                            </div>
                            <div class="icon-circle bg-success-subtle text-success">
                                <i class="ri-calendar-line fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card shadow-sm p-4 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small fw-bold text-uppercase mb-1">Gallery</p>
                                <h3 class="fw-bold mb-0"><?php echo $gallery_count; ?></h3>
                            </div>
                            <div class="icon-circle bg-warning-subtle text-warning">
                                <i class="ri-image-line fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Recent Contact Messages</h5>
                    <a href="contact_messages.php" class="btn btn-sm btn-light rounded-pill px-3">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="px-4 py-3 border-0">Date</th>
                                <th class="px-4 py-3 border-0">Sender</th>
                                <th class="px-4 py-3 border-0">Subject</th>
                                <th class="px-4 py-3 border-0 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($pdo) {
                                $stmt = $pdo->query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5");
                                while ($msg = $stmt->fetch()) {
                                    ?>
                                    <tr>
                                        <td class="px-4 py-3 border-top-0"><?php echo date('M j, Y', strtotime($msg['created_at'])); ?></td>
                                        <td class="px-4 py-3 border-top-0">
                                            <div class="fw-bold"><?php echo $msg['first_name'] . ' ' . $msg['last_name']; ?></div>
                                            <small class="text-muted"><?php echo $msg['email']; ?></small>
                                        </td>
                                        <td class="px-4 py-3 border-top-0"><?php echo $msg['subject']; ?></td>
                                        <td class="px-4 py-3 border-top-0 text-end">
                                            <a href="contact_messages.php?id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-navy rounded-pill px-3">View</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
