<?php
require_once __DIR__.'/includes/crud.php';

$cfg = [
    'table' => 'memberships',
    'title' => 'Membership Applications',
    'singular' => 'Member',
    'fields' => [
        ['name' => 'created_at', 'label' => 'Applied On', 'type' => 'text', 'list' => true],
        ['name' => 'full_name', 'label' => 'Full Name', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'email', 'label' => 'Email', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'phone', 'label' => 'Phone', 'type' => 'text', 'list' => true],
        ['name' => 'membership_type', 'label' => 'Type', 'type' => 'text', 'list' => true],
        ['name' => 'status', 'label' => 'Status', 'type' => 'text', 'list' => true],
    ]
];

// Custom handle for status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_action'] ?? '') === 'update_status') {
    require_login();
    db()->prepare("UPDATE memberships SET status = ? WHERE id = ?")->execute([$_POST['status'], $_POST['id']]);
    $_SESSION['flash'] = 'Application status updated.';
    redirect('memberships.php');
}

crud_handle($cfg);
$pageTitle = 'Memberships';
include __DIR__.'/includes/header.php';
?>

<div class="content-head">
    <h2>Membership Applications</h2>
</div>

<?php
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
if ($flash): ?><div class="flash ok"><?= e($flash) ?></div><?php endif; ?>

<div class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = db()->query("SELECT * FROM memberships ORDER BY created_at DESC")->fetchAll();
            foreach ($rows as $r): ?>
            <tr>
                <td><?= formatDate($r['created_at']) ?></td>
                <td><?= e($r['full_name']) ?></td>
                <td><?= e($r['email']) ?></td>
                <td><?= e($r['membership_type']) ?></td>
                <td>
                    <form method="post" style="display:inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_action" value="update_status">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <select name="status" onchange="this.form.submit()" style="padding: 2px; border-radius: 4px; font-size: 12px;">
                            <?php foreach(['Pending', 'Approved', 'Rejected'] as $st): ?>
                                <option value="<?= $st ?>" <?= $r['status']===$st?'selected':'' ?>><?= $st ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="?edit=<?= $r['id'] ?>">Edit</a> |
                    <form method="post" class="confirm-delete" style="display:inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_action" value="delete">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button class="link-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__.'/includes/footer.php'; ?>
