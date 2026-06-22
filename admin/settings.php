<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    foreach (($_POST['settings'] ?? []) as $key => $value) {
        $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)')->execute([sanitize($key), sanitize($value)]);
    }
    redirect('settings.php?saved=1');
}
$settings = [];
if ($pdo) {
    foreach ($pdo->query('SELECT * FROM settings ORDER BY setting_key ASC') as $row) { $settings[$row['setting_key']] = $row['setting_value']; }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Settings | MACDEF Admin</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/css/style.css"></head><body class="bg-light"><div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h2 class="fw-bold">Website Settings</h2><a href="dashboard.php" class="btn btn-navy rounded-pill">Back to Dashboard</a></div><?php if(isset($_GET['saved'])): ?><div class="alert alert-success">Settings saved.</div><?php endif; ?><?php if(!$pdo): ?><div class="alert alert-danger">Database not connected.</div><?php endif; ?><div class="card border-0 shadow-sm p-4 rounded-4"><form method="POST"><?php foreach($settings as $key=>$val): ?><div class="mb-3"><label class="form-label fw-bold"><?php echo e(str_replace('_',' ',ucwords($key,'_'))); ?></label><input type="text" name="settings[<?php echo e($key); ?>]" value="<?php echo e($val); ?>" class="form-control"></div><?php endforeach; ?><button type="submit" class="btn btn-gold">Save Settings</button></form></div></div></body></html>
