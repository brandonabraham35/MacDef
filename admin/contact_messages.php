<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireLogin();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM contact_submissions WHERE id = ?")->execute([$id]);
    header("Location: contact_messages.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Messages | MACDEF Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>body { background-color: #f8f9fa; }.sidebar { min-height: 100vh; background-color: #002D62; color: white; }.sidebar .nav-link { color: rgba(255,255,255,0.7); }</style>
</head>
<body>
<div class="container-fluid"><div class="row">
    <div class="col-md-3 col-lg-2 p-0 sidebar position-fixed d-none d-md-block">
        <nav class="nav flex-column mt-3">
            <a class="nav-link p-3 text-white" href="dashboard.php">Dashboard</a>
            <a class="nav-link p-3 text-white fw-bold" href="contact_messages.php">Messages</a>
        </nav>
    </div>
    <div class="col-md-9 col-lg-10 ms-auto p-5">
        <h2 class="fw-bold">Messages</h2>
        <table class="table">
            <thead><tr><th>Date</th><th>Sender</th><th>Subject</th><th>Action</th></tr></thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM contact_submissions ORDER BY created_at DESC");
                while ($msg = $stmt->fetch()) {
                    echo "<tr><td>".date('M j, Y', strtotime($msg['created_at']))."</td><td>{$msg['first_name']} {$msg['last_name']}</td><td>{$msg['subject']}</td><td><a href='?delete={$msg['id']}' class='text-danger'>Delete</a></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div></div>
</body>
</html>
