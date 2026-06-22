<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'footer_settings',
    'title' => 'Footer Management',
    'singular' => 'Footer Data',
    'fields' => [
        ['name' => 'footer_logo', 'label' => 'Footer Logo', 'type' => 'image'],
        ['name' => 'footer_description', 'label' => 'Footer Description', 'type' => 'textarea'],
        ['name' => 'copyright_text', 'label' => 'Copyright Text', 'type' => 'text'],
        ['name' => 'social_facebook', 'label' => 'Facebook URL', 'type' => 'text'],
        ['name' => 'social_twitter', 'label' => 'Twitter URL', 'type' => 'text'],
        ['name' => 'social_instagram', 'label' => 'Instagram URL', 'type' => 'text'],
        ['name' => 'social_linkedin', 'label' => 'LinkedIn URL', 'type' => 'text'],
        ['name' => 'address', 'label' => 'Address', 'type' => 'textarea'],
        ['name' => 'phone', 'label' => 'Phone', 'type' => 'text'],
        ['name' => 'email', 'label' => 'Email', 'type' => 'text'],
    ]
];

function ensure_footer_exists() {
    $db = db();
    $exists = $db->query("SELECT id FROM footer_settings LIMIT 1")->fetch();
    if (!$exists) {
        $db->exec("INSERT INTO footer_settings (id, copyright_text) VALUES (1, '© 2024 MACDEF')");
    }
}
ensure_footer_exists();

$_GET['edit'] = 1;
crud_handle($cfg);

$pageTitle = 'Footer Management';
include __DIR__.'/includes/header.php';
$edit = crud_find($cfg['table'], 1);
?>

<div class="content-head">
    <h2><?= e($cfg['title']) ?></h2>
</div>

<form class="resource-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="_action" value="update">
    <input type="hidden" name="id" value="1">

    <div class="panel">
        <h3>General Settings</h3>
        <div class="form-field">
            <label>Footer Logo</label>
            <?php if(!empty($edit['footer_logo'])): ?>
                <div><img src="../<?= e($edit['footer_logo']) ?>" style="max-height:80px; margin-bottom:10px;"></div>
            <?php endif; ?>
            <input type="file" name="footer_logo">
        </div>
        <div class="form-field">
            <label>Footer Description</label>
            <textarea name="footer_description" rows="4"><?= e($edit['footer_description'] ?? '') ?></textarea>
        </div>
        <div class="form-field">
            <label>Copyright Text</label>
            <input type="text" name="copyright_text" value="<?= e($edit['copyright_text'] ?? '') ?>">
        </div>
    </div>

    <div class="panel" style="margin-top:20px;">
        <h3>Contact Information</h3>
        <div class="form-field">
            <label>Address</label>
            <textarea name="address" rows="2"><?= e($edit['address'] ?? '') ?></textarea>
        </div>
        <div class="form-field">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= e($edit['phone'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label>Email</label>
            <input type="text" name="email" value="<?= e($edit['email'] ?? '') ?>">
        </div>
    </div>

    <div class="panel" style="margin-top:20px;">
        <h3>Social Links</h3>
        <div class="form-grid">
            <div class="form-field">
                <label>Facebook</label>
                <input type="text" name="social_facebook" value="<?= e($edit['social_facebook'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>Twitter</label>
                <input type="text" name="social_twitter" value="<?= e($edit['social_twitter'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>Instagram</label>
                <input type="text" name="social_instagram" value="<?= e($edit['social_instagram'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>LinkedIn</label>
                <input type="text" name="social_linkedin" value="<?= e($edit['social_linkedin'] ?? '') ?>">
            </div>
        </div>
    </div>

    <div style="margin-top:20px;">
        <button type="submit" class="btn-primary">Update Footer Settings</button>
    </div>
</form>

<?php include __DIR__.'/includes/footer.php'; ?>
