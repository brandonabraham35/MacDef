<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

if (isset($_GET['delete']) && $pdo) {
    $id = (int)$_GET['delete'];
    $pdo->prepare('DELETE FROM events WHERE id = ?')->execute([$id]);
    redirect('events.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title'] ?? '');
    $date = sanitize($_POST['event_date'] ?? '');
    $desc = sanitize($_POST['description'] ?? '');
    if (!$title || !$date || !$desc) $error = 'All fields are required.';
    elseif (!$pdo) $error = 'Database not connected.';
    else { $pdo->prepare('INSERT INTO events (title, event_date, description) VALUES (?, ?, ?)')->execute([$title, $date, $desc]); redirect('events.php'); }
}
$events = $pdo ? $pdo->query('SELECT * FROM events ORDER BY created_at DESC')->fetchAll() : [];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Events | MACDEF Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/css/style.css"></head><body class="bg-light"><div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h2 class="fw-bold">Manage Events</h2><a href="dashboard.php" class="btn btn-navy rounded-pill">Back to Dashboard</a></div><?php if($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?><div class="card border-0 shadow-sm p-4 rounded-4 mb-4"><form method="POST"><input type="text" name="title" placeholder="Event title" class="form-control mb-2" required><input type="text" name="event_date" placeholder="Date, e.g. 20 July 2026" class="form-control mb-2" required><textarea name="description" placeholder="Description" class="form-control mb-2" rows="4" required></textarea><button type="submit" class="btn btn-gold">Add Event</button></form></div><div class="card border-0 shadow-sm rounded-4"><table class="table mb-0"><thead><tr><th>Title</th><th>Date</th><th>Description</th><th>Action</th></tr></thead><tbody><?php foreach($events as $row): ?><tr><td><?php echo e($row['title']); ?></td><td><?php echo e($row['event_date']); ?></td><td><?php echo e($row['description']); ?></td><td><a onclick="return confirm('Delete this event?')" href="?delete=<?php echo (int)$row['id']; ?>" class="text-danger">Delete</a></td></tr><?php endforeach; ?><?php if(empty($events)): ?><tr><td colspan="4" class="text-center text-muted py-4">No events yet.</td></tr><?php endif; ?></tbody></table></div></div></body></html>
