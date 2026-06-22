<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    if (empty($email) || empty($password)) { $error = "Please enter both email and password."; }
    else {
        if ($pdo) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                redirect('dashboard.php');
            } else { $error = "Invalid email or password."; }
        } else { $error = "Database connection failed."; }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | MACDEF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>body { background-color: #f8f9fa; height: 100vh; display: flex; align-items: center; justify-content: center; }.login-card { width: 100%; max-width: 400px; }</style>
</head>
<body>
<div class="login-card p-4">
    <div class="text-center mb-4"><img src="../assets/images/macdef-logo.png" alt="Logo" height="70" class="mb-3"><h4 class="fw-bold text-navy">MACDEF Admin</h4></div>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <?php if ($error): ?><div class="alert alert-danger small py-2 mb-4"><?php echo $error; ?></div><?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group mb-3"><label class="form-label small fw-bold">Email Address</label><input type="email" name="email" class="form-control" required></div>
            <div class="form-group mb-4"><label class="form-label small fw-bold">Password</label><input type="password" name="password" class="form-control" required></div>
            <button type="submit" class="btn btn-navy w-100 rounded-pill py-2">Sign In</button>
        </form>
    </div>
</div>
</body>
</html>
