<?php
require_once __DIR__.'/includes/crud.php';
require_once dirname(__DIR__).'/includes/EmailService.php';

$cfg = [
    'table' => 'newsletter_subscribers',
    'title' => 'Newsletter Subscribers',
    'singular' => 'Subscriber',
    'fields' => [
        ['name' => 'subscribed_at', 'label' => 'Subscribed On', 'type' => 'text', 'list' => true],
        ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'list' => true],
        ['name' => 'email', 'label' => 'Email', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'status', 'label' => 'Status', 'type' => 'text', 'list' => true],
    ]
];

// Handle CSV Export
if (isset($_GET['export'])) {
    require_login();
    $rows = db()->query("SELECT subscribed_at, name, email, status FROM newsletter_subscribers ORDER BY subscribed_at DESC")->fetchAll();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="newsletter_subscribers_' . date('Ymd') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Subscribed On', 'Name', 'Email', 'Status']);
    foreach ($rows as $row) fputcsv($output, $row);
    fclose($output);
    exit;
}

// Handle Send Newsletter
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_newsletter'])) {
    if (verify_csrf($_POST['csrf_token'] ?? '')) {
        $subject = sanitize($_POST['subject']);
        $content = $_POST['content']; // HTML allowed here for newsletter
        $subscribers = db()->query("SELECT email FROM newsletter_subscribers WHERE status = 'Subscribed'")->fetchAll(PDO::FETCH_COLUMN);

        $emailService = new EmailService();
        $success = 0;
        foreach ($subscribers as $email) {
            if ($emailService->send($email, $subject, $content)) $success++;
        }
        $_SESSION['flash'] = "Newsletter sent to $success subscribers.";
    } else {
        $_SESSION['flash_err'] = 'Invalid token.';
    }
    redirect('newsletter.php');
}

crud_handle($cfg);
$pageTitle = 'Subscribers';
include __DIR__.'/includes/header.php';
$flash = $_SESSION['flash'] ?? ''; $err = $_SESSION['flash_err'] ?? ''; unset($_SESSION['flash'], $_SESSION['flash_err']);
?>

<?php if($flash):?><div class="flash ok"><?= e($flash) ?></div><?php endif; ?>
<?php if($err):?><div class="flash err"><?= e($err) ?></div><?php endif; ?>

<div class="content-head">
    <h2><?= e($cfg['title']) ?></h2>
    <div>
        <a href="?export=1" class="btn-ghost">Export CSV</a>
        <a class="btn-primary" href="?new=1">+ Add Subscriber</a>
    </div>
</div>

<div class="panel mb-4">
    <h3>Send Newsletter to All Subscribers</h3>
    <form method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="send_newsletter" value="1">
        <div class="form-field">
            <label>Subject</label>
            <input type="text" name="subject" required>
        </div>
        <div class="form-field">
            <label>Content (HTML allowed)</label>
            <textarea name="content" rows="10" required></textarea>
        </div>
        <button class="btn-primary" type="submit" onclick="return confirm('Are you sure you want to send this to ALL subscribers?')">Send Now</button>
    </form>
</div>

<?php
crud_render($cfg);
include __DIR__.'/includes/footer.php';
?>
