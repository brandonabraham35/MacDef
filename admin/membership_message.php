<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/EmailService.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$res = db()->prepare("SELECT * FROM memberships WHERE id = ?");
$res->execute([$id]);
$member = $res->fetch();

if (!$member) redirect('memberships.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if ($subject && $message) {
        $sent = EmailService::sendMemberReply($member['email'], $member['full_name'], $subject, $message);

        if ($sent) {
            $_SESSION['flash'] = 'Message sent to applicant successfully.';
            redirect('memberships.php');
        } else {
            $error = 'The email could not be sent. Check Email Logs for details.';
        }
    } else {
        $error = 'All fields are required.';
    }
}

$pageTitle = 'Message Applicant';
include __DIR__ . '/includes/header.php';
?>

<div class="content-head">
    <h2>Message Applicant</h2>
    <a href="memberships.php" class="btn-ghost">Back to Memberships</a>
</div>

<?php if ($error): ?><div class="flash err"><?= e($error) ?></div><?php endif; ?>

<div class="dash-cols">
    <div class="panel">
        <h3>Application Details</h3>
        <div style="font-size: 0.9rem; line-height: 1.6;">
            <p><strong>Applicant:</strong> <?= e($member['full_name']) ?></p>
            <p><strong>Email:</strong> <?= e($member['email']) ?></p>
            <p><strong>Type:</strong> <?= e($member['membership_type']) ?></p>
            <p><strong>Status:</strong> <?= e($member['status']) ?></p>
            <p><strong>Applied On:</strong> <?= date('d M Y', strtotime($member['created_at'])) ?></p>
            <p><strong>Occupation:</strong> <?= e($member['occupation']) ?></p>
            <p><strong>Address:</strong> <?= e($member['address']) ?></p>
        </div>
    </div>

    <div class="panel">
        <h3>Send Message</h3>
        <form method="post" class="resource-form" style="max-width: 100%; box-shadow: none; padding: 0;">
            <?= csrf_field() ?>
            <div class="form-field">
                <label>Subject</label>
                <input type="text" name="subject" value="Regarding your MACDEF membership application" required>
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
