<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireLogin();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM events WHERE id = ?")->execute([$id]);
    header("Location: events.php"); exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $date = sanitize($_POST['event_date']);
    $desc = sanitize($_POST['description']);
    $pdo->prepare("INSERT INTO events (title, event_date, description) VALUES (?, ?, ?)")->execute([$title, $date, $desc]);
    header("Location: events.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events | MACDEF Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="p-5">
    <h2>Manage Events</h2>
    <form method="POST" class="mb-5">
        <input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
        <input type="text" name="event_date" placeholder="Date" class="form-control mb-2" required>
        <textarea name="description" placeholder="Description" class="form-control mb-2" required></textarea>
        <button type="submit" class="btn btn-primary">Add Event</button>
    </form>
    <table class="table">
        <?php
        $stmt = $pdo->query("SELECT * FROM events ORDER BY created_at DESC");
        while ($row = $stmt->fetch()) {
            echo "<tr><td>{$row['title']}</td><td>{$row['event_date']}</td><td><a href='?delete={$row['id']}'>Delete</a></td></tr>";
        }
        ?>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
