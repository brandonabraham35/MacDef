<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = sanitize($_POST['first_name']); $last = sanitize($_POST['last_name']); $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']); $message = sanitize($_POST['message']);
    if ($pdo) {
        $pdo->prepare("INSERT INTO contact_submissions (first_name, last_name, email, subject, message) VALUES (?, ?, ?, ?, ?)")->execute([$first, $last, $email, $subject, $message]);
        header("Location: contact.php?status=success&msg=Sent"); exit();
    }
}
header("Location: contact.php"); exit();
?>
