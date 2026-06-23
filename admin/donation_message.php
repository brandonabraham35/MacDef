<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/EmailService.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$res = db()->prepare("SELECT * FROM donations WHERE id = ?");
$res->execute([$id]);
$donation = $res->fetch();

if (!$donation) redirect('donations.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if ($subject && $message) {
        $sent = EmailService::sendDonorReply($donation['email'], $donation['donor_name'], $subject, $message);

        if ($sent) {
            $_SESSION['flash'] = 'Message sent to donor successfully.';
            redirect('donations.php');
        } else {
            $error = 'The email could not be sent. Check Email Logs for details.';
        }
    } else {
        $error = 'All fields are required.';
    }
}

$pageTitle = 'Message Donor';
include __DIR__ . '/includes/header.php';
?>

<div class="content-head">
    <h2>Message Donor</h2>
    <a href="donations.php" class="btn-ghost">Back to Donations</a>
</div>

<?php if ($error): ?><div class="flash err"><?= e($error) ?></div><?php endif; ?>

<div class="dash-cols">
    <div class="panel">
        <h3>Donation Details</h3>
        <div style="font-size: 0.9rem; line-height: 1.6;">
            <p><strong>Donor:</strong> <?= e($donation['donor_name']) ?></p>
            <p><strong>Email:</strong> <?= e($donation['email']) ?></p>
            <p><strong>Amount:</strong> <?= number_format((float)$donation['amount'], 2) ?></p>
            <p><strong>Status:</strong> <?= e($donation['status']) ?></p>
            <p><strong>Date:</strong> <?= date('d M Y', strtotime($donation['created_at'])) ?></p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            <p><strong>Donor Message:</strong><br><?= nl2br(e($donation['message'])) ?></p>
        </div>
    </div>

    <div class="panel">
        <h3>Send Message</h3>
        <form method="post" class="resource-form" style="max-width: 100%; box-shadow: none; padding: 0;">
            <?= csrf_field() ?>
            <div class="form-field">
                <label>Subject</label>
                <input type="text" name="subject" value="Message regarding your donation to MACDEF" required>
            </div>
            <div class="form-field">
                <label>Message Body</label>
                <textarea name="message" rows="8" required placeholder="Type your message here..."></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">Send Message</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
