<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['settings'] as $key => $value) {
        $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?")->execute([sanitize($value), $key]);
    }
    header("Location: settings.php"); exit();
}

$settings = [];
$stmt = $pdo->query("SELECT * FROM settings");
while ($row = $stmt->fetch()) { $settings[$row['setting_key']] = $row['setting_value']; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings | MACDEF Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <h2>Settings</h2>
    <form method="POST">
        <?php foreach ($settings as $key => $val): ?>
            <div class="mb-3">
                <label><?php echo $key; ?></label>
                <input type="text" name="settings[<?php echo $key; ?>]" value="<?php echo $val; ?>" class="form-control">
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
