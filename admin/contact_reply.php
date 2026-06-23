<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/EmailService.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$msg = db()->prepare("SELECT * FROM contact_submissions WHERE id = ?");
$msg->execute([$id]);
$message = $msg->fetch();

if (!$message) redirect('contact_messages.php');

// Mark as read if it was new
if ($message['status'] === 'New') {
    db()->prepare("UPDATE contact_submissions SET status = 'Read' WHERE id = ?")->execute([$id]);
    $message['status'] = 'Read';
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $subject = sanitize($_POST['subject'] ?? '');
    $reply_body = sanitize($_POST['message'] ?? '');

    if ($subject && $reply_body) {
        $name = $message['first_name'] . ' ' . $message['last_name'];
        $sent = EmailService::sendContactReply($message['email'], $name, $subject, $reply_body);

        // Save reply to database regardless of email success
        db()->prepare("UPDATE contact_submissions SET status = 'Replied', replied_at = CURRENT_TIMESTAMP, reply_subject = ?, reply_body = ? WHERE id = ?")
          ->execute([$subject, $reply_body, $id]);

        if ($sent) {
            $_SESSION['flash'] = 'Reply sent successfully.';
            redirect('contact_messages.php');
        } else {
            $error = 'Reply saved, but the email could not be sent. Check Email Logs for details.';
        }
    } else {
        $error = 'All fields are required.';
    }
}

$pageTitle = 'Reply to Message';
include __DIR__ . '/includes/header.php';
?>

<div class="content-head">
    <h2>Reply to Message</h2>
    <a href="contact_messages.php" class="btn-ghost">Back to Messages</a>
</div>

<?php if ($error): ?><div class="flash err"><?= e($error) ?></div><?php endif; ?>

<div class="dash-cols">
    <div class="panel">
        <h3>Original Message</h3>
        <div style="font-size: 0.9rem; line-height: 1.6;">
            <p><strong>From:</strong> <?= e($message['first_name'] . ' ' . $message['last_name']) ?> (<?= e($message['email']) ?>)</p>
            <p><strong>Date:</strong> <?= date('d M Y, H:i', strtotime($message['created_at'])) ?></p>
            <p><strong>Subject:</strong> <?= e($message['subject']) ?></p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            <p><?= nl2br(e($message['message'])) ?></p>
        </div>
    </div>

    <div class="panel">
        <h3>Your Reply</h3>
        <form method="post" class="resource-form" style="max-width: 100%; box-shadow: none; padding: 0;">
            <?= csrf_field() ?>
            <div class="form-field">
                <label>Subject</label>
                <input type="text" name="subject" value="Re: <?= e($message['subject']) ?>" required>
            </div>
            <div class="form-field">
                <label>Message</label>
                <textarea name="message" rows="8" required placeholder="Type your reply here..."></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">Send Reply</button>
            </div>
        </form>
    </div>
</div>

<?php if ($message['status'] === 'Replied'): ?>
<div class="panel" style="margin-top: 20px; border-left: 4px solid #1cc88a;">
    <h3>Previous Reply</h3>
    <div style="font-size: 0.9rem;">
        <p><strong>Replied on:</strong> <?= date('d M Y, H:i', strtotime($message['replied_at'])) ?></p>
        <p><strong>Subject:</strong> <?= e($message['reply_subject']) ?></p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 10px 0;">
        <p><?= nl2br(e($message['reply_body'])) ?></p>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
