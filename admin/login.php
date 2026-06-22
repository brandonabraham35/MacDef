<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } elseif (!$pdo) {
        $error = 'Database connection failed. Import database/macdef.sql first.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND role = ? LIMIT 1');
        $stmt->execute([$email, 'admin']);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            redirect('dashboard.php');
        }
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin Login | MACDEF</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/css/style.css"><style>body{background:#f8f9fa;min-height:100vh;display:flex;align-items:center;justify-content:center}.login-card{width:100%;max-width:420px}</style></head><body><div class="login-card p-4"><div class="text-center mb-4"><img src="../assets/images/macdef-logo.png" alt="Logo" height="70" class="mb-3"><h4 class="fw-bold text-navy">MACDEF Admin</h4><p class="text-muted small">Use the direct admin URL to access this dashboard.</p></div><div class="card border-0 shadow-sm rounded-4 p-4"><?php if($error): ?><div class="alert alert-danger small py-2 mb-4"><?php echo e($error); ?></div><?php endif; ?><form method="POST"><div class="mb-3"><label class="form-label small fw-bold">Email Address</label><input type="email" name="email" class="form-control" required></div><div class="mb-4"><label class="form-label small fw-bold">Password</label><input type="password" name="password" class="form-control" required></div><button type="submit" class="btn btn-navy w-100 rounded-pill py-2">Sign In</button></form></div></div></body></html>
