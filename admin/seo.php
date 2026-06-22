<?php
require_once dirname(__DIR__).'/includes/auth.php';
require_login();

$keys = [
    'site_title',
    'meta_description',
    'meta_keywords',
    'og_image',
    'og_title'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (verify_csrf($_POST['csrf_token'] ?? '')) {
        foreach ($keys as $k) {
            if ($k === 'og_image' && !empty($_FILES['og_image']['name'])) {
                $up = handle_upload($_FILES['og_image'], 'image');
                if ($up['ok']) setSetting('og_image', $up['path']);
                continue;
            }
            setSetting($k, $_POST[$k] ?? '');
        }
        $_SESSION['flash'] = 'SEO settings saved.';
    } else {
        $_SESSION['flash_err'] = 'Invalid token.';
    }
    redirect('seo.php');
}

$pageTitle = 'SEO Management';
include __DIR__.'/includes/header.php';
$flash = $_SESSION['flash'] ?? '';
$err = $_SESSION['flash_err'] ?? '';
unset($_SESSION['flash'], $_SESSION['flash_err']);
?>

<?php if($flash):?><div class="flash ok"><?= e($flash) ?></div><?php endif;?>
<?php if($err):?><div class="flash err"><?= e($err) ?></div><?php endif;?>

<form method="post" class="panel resource-form" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <h3>Search Engine Optimization (SEO)</h3>
    <div class="form-field">
        <label>Site Meta Title</label>
        <input type="text" name="site_title" value="<?= e(getSetting('site_title', '')) ?>">
    </div>
    <div class="form-field">
        <label>Meta Description</label>
        <textarea name="meta_description" rows="3"><?= e(getSetting('meta_description', '')) ?></textarea>
    </div>
    <div class="form-field">
        <label>Meta Keywords</label>
        <textarea name="meta_keywords" rows="2"><?= e(getSetting('meta_keywords', '')) ?></textarea>
    </div>
    <hr>
    <h3>Social Sharing (Open Graph)</h3>
    <div class="form-field">
        <label>OG Title (Social Title)</label>
        <input type="text" name="og_title" value="<?= e(getSetting('og_title', '')) ?>">
    </div>
    <div class="form-field">
        <label>OG Image (Share Image)</label>
        <?php if($img = getSetting('og_image')): ?>
            <div class="mb-2"><img src="../<?= e($img) ?>" style="max-height: 100px;"></div>
        <?php endif; ?>
        <input type="file" name="og_image" accept="image/*">
    </div>

    <button class="btn-primary">Save SEO Settings</button>
</form>

<?php include __DIR__.'/includes/footer.php'; ?>
