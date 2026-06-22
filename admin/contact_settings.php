<?php
require_once dirname(__DIR__).'/includes/auth.php';
require_login();

$keys = [
    'contact_address',
    'contact_phone',
    'contact_email',
    'google_maps_embed',
    'office_hours'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (verify_csrf($_POST['csrf_token'] ?? '')) {
        foreach ($keys as $k) {
            setSetting($k, $_POST[$k] ?? '');
        }
        $_SESSION['flash'] = 'Contact settings saved.';
    } else {
        $_SESSION['flash_err'] = 'Invalid token.';
    }
    redirect('contact_settings.php');
}

$pageTitle = 'Contact Settings';
include __DIR__.'/includes/header.php';
$flash = $_SESSION['flash'] ?? '';
$err = $_SESSION['flash_err'] ?? '';
unset($_SESSION['flash'], $_SESSION['flash_err']);
?>

<?php if($flash):?><div class="flash ok"><?= e($flash) ?></div><?php endif;?>
<?php if($err):?><div class="flash err"><?= e($err) ?></div><?php endif;?>

<form method="post" class="panel resource-form">
    <?= csrf_field() ?>
    <h3>Contact Information & Map</h3>
    <div class="form-field">
        <label>Physical Address</label>
        <textarea name="contact_address" rows="2"><?= e(getSetting('contact_address', '')) ?></textarea>
    </div>
    <div class="form-field">
        <label>Phone Number(s)</label>
        <input type="text" name="contact_phone" value="<?= e(getSetting('contact_phone', '')) ?>">
    </div>
    <div class="form-field">
        <label>Email Address</label>
        <input type="text" name="contact_email" value="<?= e(getSetting('contact_email', '')) ?>">
    </div>
    <div class="form-field">
        <label>Office Hours</label>
        <input type="text" name="office_hours" value="<?= e(getSetting('office_hours', '')) ?>">
    </div>
    <div class="form-field">
        <label>Google Maps Embed (Iframe URL or full code)</label>
        <textarea name="google_maps_embed" rows="4"><?= e(getSetting('google_maps_embed', '')) ?></textarea>
        <small class="text-muted">Paste the 'src' URL from Google Maps embed code or the entire <code>&lt;iframe&gt;</code> tag.</small>
    </div>
    <button class="btn-primary">Save Contact Settings</button>
</form>

<?php include __DIR__.'/includes/footer.php'; ?>
