<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireLogin();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
    header("Location: gallery.php"); exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $upload = uploadImage($_FILES['image'], "../uploads/gallery/");
    if ($upload['success']) {
        $db_path = str_replace("../", "", $upload['path']);
        $pdo->prepare("INSERT INTO gallery (title, image_path) VALUES (?, ?)")->execute([$title, $db_path]);
    }
    header("Location: gallery.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery | MACDEF Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <h2>Manage Gallery</h2>
    <form method="POST" enctype="multipart/form-data" class="mb-5">
        <input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
        <input type="file" name="image" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
    <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
        while ($row = $stmt->fetch()) {
            echo "<div class='col-md-3'><img src='../{$row['image_path']}' class='img-fluid'><p>{$row['title']} <a href='?delete={$row['id']}'>Delete</a></p></div>";
        }
        ?>
    </div>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
