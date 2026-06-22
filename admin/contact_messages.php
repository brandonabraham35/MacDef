<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

if (isset($_GET['delete']) && $pdo) {
    $id = (int)$_GET['delete'];
    $pdo->prepare('DELETE FROM contact_submissions WHERE id = ?')->execute([$id]);
    redirect('contact_messages.php');
}
$messages = [];
if ($pdo) {
    try { $messages = $pdo->query('SELECT * FROM contact_submissions ORDER BY created_at DESC')->fetchAll(); } catch (PDOException $e) { $messages = []; }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Messages | MACDEF Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/css/style.css"></head>
<body class="bg-light"><div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h2 class="fw-bold">Contact Messages</h2><a href="dashboard.php" class="btn btn-navy rounded-pill">Back to Dashboard</a></div><?php if(!$pdo): ?><div class="alert alert-danger">Database not connected.</div><?php endif; ?><div class="card border-0 shadow-sm rounded-4"><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Date</th><th>Sender</th><th>Email</th><th>Subject</th><th>Message</th><th>Action</th></tr></thead><tbody><?php foreach($messages as $msg): ?><tr><td><?php echo e(formatDate($msg['created_at'])); ?></td><td><?php echo e($msg['first_name'].' '.$msg['last_name']); ?></td><td><?php echo e($msg['email']); ?></td><td><?php echo e($msg['subject']); ?></td><td><?php echo e($msg['message']); ?></td><td><a onclick="return confirm('Delete this message?')" href="?delete=<?php echo (int)$msg['id']; ?>" class="text-danger">Delete</a></td></tr><?php endforeach; ?><?php if(empty($messages)): ?><tr><td colspan="6" class="text-center text-muted py-4">No messages yet.</td></tr><?php endif; ?></tbody></table></div></div></div></body></html>
