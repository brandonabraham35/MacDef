<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/EmailService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = sanitize($_POST['first_name'] ?? '');
    $last = sanitize($_POST['last_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if ($first && $last && $email && $subject && $message) {
        try {
            $stmt = db()->prepare("INSERT INTO contact_submissions (first_name, last_name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$first, $last, $email, $subject, $message]);

            // Send Confirmation to User
            EmailService::sendUserConfirmation($email, $first . ' ' . $last, 'Message');

            // Send Notification to Admin
            EmailService::sendAdminNotification('New Contact Message', [
                'Sender' => $first . ' ' . $last,
                'Email' => $email,
                'Subject' => $subject
            ], $message);

            header('Location: contact.php?status=success#contact-form');
        } catch (Exception $e) {
            header('Location: contact.php?status=error&msg=' . urlencode($e->getMessage()) . '#contact-form');
        }
    } else {
        header('Location: contact.php?status=error&msg=Please fill all fields.#contact-form');
    }
} else {
    header('Location: contact.php');
}
