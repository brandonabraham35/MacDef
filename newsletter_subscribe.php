<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?status=error&msg=Invalid email address.');
        exit;
    }

    try {
        $stmt = db()->prepare("INSERT INTO newsletter_subscribers (name, email) VALUES (?, ?) ON DUPLICATE KEY UPDATE status = 'Subscribed'");
        $stmt->execute([$name, $email]);
        header('Location: index.php?status=success&msg=Thank you for subscribing to our newsletter!');
    } catch (Exception $e) {
        header('Location: index.php?status=error&msg=Sorry, we could not process your subscription.');
    }
} else {
    header('Location: index.php');
}
