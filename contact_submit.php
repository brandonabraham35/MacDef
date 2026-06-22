<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('contact.php');
}

$first = sanitize($_POST['first_name'] ?? '');
$last = sanitize($_POST['last_name'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$subject = sanitize($_POST['subject'] ?? '');
$message = sanitize($_POST['message'] ?? '');

if (!$first || !$last || !$email || !$subject || !$message) {
    redirect('contact.php?status=error&msg=' . urlencode('Please fill in all fields.'));
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect('contact.php?status=error&msg=' . urlencode('Please enter a valid email address.'));
}

if (!$pdo) {
    redirect('contact.php?status=error&msg=' . urlencode('Database connection failed. Import database/macdef.sql first.'));
}

try {
    $stmt = $pdo->prepare('INSERT INTO contact_submissions (first_name, last_name, email, subject, message) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$first, $last, $email, $subject, $message]);
    redirect('contact.php?status=success&msg=' . urlencode('Your message has been sent successfully.'));
} catch (PDOException $e) {
    redirect('contact.php?status=error&msg=' . urlencode('Message could not be saved. Please try again.'));
}
?>
