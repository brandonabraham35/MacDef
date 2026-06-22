<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'homepage_content',
    'title' => 'Homepage Management',
    'singular' => 'Homepage Data',
    'fields' => [
        ['name' => 'welcome_title', 'label' => 'Welcome Title', 'type' => 'text'],
        ['name' => 'welcome_body', 'label' => 'Welcome Body', 'type' => 'textarea'],
        ['name' => 'welcome_image', 'label' => 'Welcome Image', 'type' => 'image'],

        ['name' => 'card1_title', 'label' => 'Card 1 Title', 'type' => 'text'],
        ['name' => 'card1_body', 'label' => 'Card 1 Body', 'type' => 'textarea'],
        ['name' => 'card1_button_text', 'label' => 'Card 1 Button Text', 'type' => 'text'],
        ['name' => 'card1_button_link', 'label' => 'Card 1 Button Link', 'type' => 'text'],

        ['name' => 'card2_title', 'label' => 'Card 2 Title', 'type' => 'text'],
        ['name' => 'card2_body', 'label' => 'Card 2 Body', 'type' => 'textarea'],
        ['name' => 'card2_button_text', 'label' => 'Card 2 Button Text', 'type' => 'text'],
        ['name' => 'card2_button_link', 'label' => 'Card 2 Button Link', 'type' => 'text'],

        ['name' => 'card3_title', 'label' => 'Card 3 Title', 'type' => 'text'],
        ['name' => 'card3_body', 'label' => 'Card 3 Body', 'type' => 'textarea'],
        ['name' => 'card3_button_text', 'label' => 'Card 3 Button Text', 'type' => 'text'],
        ['name' => 'card3_button_link', 'label' => 'Card 3 Button Link', 'type' => 'text'],

        ['name' => 'newsletter_title', 'label' => 'Newsletter Title', 'type' => 'text'],
        ['name' => 'newsletter_body', 'label' => 'Newsletter Body', 'type' => 'textarea'],
    ]
];

// Special handle for single row table
function ensure_homepage_exists() {
    $db = db();
    $exists = $db->query("SELECT id FROM homepage_content LIMIT 1")->fetch();
    if (!$exists) {
        $db->exec("INSERT INTO homepage_content (id, welcome_title) VALUES (1, 'Welcome to MACDEF')");
    }
}
ensure_homepage_exists();

// Override crud_render to only show edit form for ID 1
$_GET['edit'] = 1;

crud_handle($cfg);

$pageTitle = 'Homepage Management';
include __DIR__.'/includes/header.php';
?>

<div class="content-head">
    <h2><?= e($cfg['title']) ?></h2>
</div>

<?php
// We manually render the form since we only want to edit row 1
$edit = crud_find($cfg['table'], 1);
?>

<form class="resource-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="_action" value="update">
    <input type="hidden" name="id" value="1">

    <div class="panel">
        <h3>Welcome Section</h3>
        <div class="form-field">
            <label>Welcome Title</label>
            <input type="text" name="welcome_title" value="<?= e($edit['welcome_title'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label>Welcome Body</label>
            <textarea name="welcome_body" rows="4"><?= e($edit['welcome_body'] ?? '') ?></textarea>
        </div>
        <div class="form-field">
            <label>Welcome Image</label>
            <?php if(!empty($edit['welcome_image'])): ?>
                <div><img src="../<?= e($edit['welcome_image']) ?>" style="max-height:100px; margin-bottom:10px;"></div>
            <?php endif; ?>
            <input type="file" name="welcome_image">
        </div>
    </div>

    <div class="row" style="display:flex; gap:20px; margin-top:20px;">
        <div class="panel" style="flex:1;">
            <h3>Card 1</h3>
            <div class="form-field">
                <label>Title</label>
                <input type="text" name="card1_title" value="<?= e($edit['card1_title'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>Body</label>
                <textarea name="card1_body" rows="3"><?= e($edit['card1_body'] ?? '') ?></textarea>
            </div>
            <div class="form-field">
                <label>Button Text</label>
                <input type="text" name="card1_button_text" value="<?= e($edit['card1_button_text'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>Button Link</label>
                <input type="text" name="card1_button_link" value="<?= e($edit['card1_button_link'] ?? '') ?>">
            </div>
        </div>
        <div class="panel" style="flex:1;">
            <h3>Card 2</h3>
            <div class="form-field">
                <label>Title</label>
                <input type="text" name="card2_title" value="<?= e($edit['card2_title'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>Body</label>
                <textarea name="card2_body" rows="3"><?= e($edit['card2_body'] ?? '') ?></textarea>
            </div>
            <div class="form-field">
                <label>Button Text</label>
                <input type="text" name="card2_button_text" value="<?= e($edit['card2_button_text'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>Button Link</label>
                <input type="text" name="card2_button_link" value="<?= e($edit['card2_button_link'] ?? '') ?>">
            </div>
        </div>
        <div class="panel" style="flex:1;">
            <h3>Card 3</h3>
            <div class="form-field">
                <label>Title</label>
                <input type="text" name="card3_title" value="<?= e($edit['card3_title'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>Body</label>
                <textarea name="card3_body" rows="3"><?= e($edit['card3_body'] ?? '') ?></textarea>
            </div>
            <div class="form-field">
                <label>Button Text</label>
                <input type="text" name="card3_button_text" value="<?= e($edit['card3_button_text'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label>Button Link</label>
                <input type="text" name="card3_button_link" value="<?= e($edit['card3_button_link'] ?? '') ?>">
            </div>
        </div>
    </div>

    <div class="panel" style="margin-top:20px;">
        <h3>Newsletter Section</h3>
        <div class="form-field">
            <label>Title</label>
            <input type="text" name="newsletter_title" value="<?= e($edit['newsletter_title'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label>Body</label>
            <textarea name="newsletter_body" rows="3"><?= e($edit['newsletter_body'] ?? '') ?></textarea>
        </div>
    </div>

    <div style="margin-top:20px;">
        <button type="submit" class="btn-primary">Update Homepage</button>
    </div>
</form>

<?php include __DIR__.'/includes/footer.php'; ?>
