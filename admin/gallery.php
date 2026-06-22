<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

if (isset($_GET['delete']) && $pdo) {
    $id = (int)$_GET['delete'];
    $pdo->prepare('DELETE FROM gallery WHERE id = ?')->execute([$id]);
    redirect('gallery.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title'] ?? '');
    if (!$title) $error = 'Title is required.';
    elseif (!$pdo) $error = 'Database not connected.';
    else {
        $upload = uploadImage($_FILES['image'] ?? null, __DIR__ . '/../uploads/gallery/');
        if ($upload['success']) {
            $db_path = str_replace(str_replace('\\','/', realpath(__DIR__ . '/..')) . '/', '', $upload['path']);
            $pdo->prepare('INSERT INTO gallery (title, image_path) VALUES (?, ?)')->execute([$title, $db_path]);
            redirect('gallery.php');
        } else { $error = $upload['message']; }
    }
}
$items = $pdo ? $pdo->query('SELECT * FROM gallery ORDER BY created_at DESC')->fetchAll() : [];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Gallery | MACDEF Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/css/style.css"></head><body class="bg-light"><div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h2 class="fw-bold">Manage Gallery</h2><a href="dashboard.php" class="btn btn-navy rounded-pill">Back to Dashboard</a></div><?php if($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?><div class="card border-0 shadow-sm p-4 rounded-4 mb-4"><form method="POST" enctype="multipart/form-data"><input type="text" name="title" placeholder="Image title" class="form-control mb-2" required><input type="file" name="image" class="form-control mb-2" accept="image/*" required><button type="submit" class="btn btn-gold">Upload Image</button></form></div><div class="row g-4"><?php foreach($items as $row): ?><div class="col-md-3"><div class="card border-0 shadow-sm h-100"><img src="../<?php echo e($row['image_path']); ?>" class="card-img-top" style="height:170px;object-fit:cover"><div class="card-body"><h6><?php echo e($row['title']); ?></h6><a onclick="return confirm('Delete this image?')" href="?delete=<?php echo (int)$row['id']; ?>" class="text-danger">Delete</a></div></div></div><?php endforeach; ?><?php if(empty($items)): ?><div class="col-12 text-center text-muted">No gallery images yet.</div><?php endif; ?></div></div></body></html>
