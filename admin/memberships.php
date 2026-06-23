<?php
require_once __DIR__.'/includes/crud.php';
require_once dirname(__DIR__).'/includes/EmailService.php';

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
    $id = (int)$_POST['id'];
    $new_status = $_POST['status'];

    // Get member details for email
    $stmt = db()->prepare("SELECT * FROM memberships WHERE id = ?");
    $stmt->execute([$id]);
    $member = $stmt->fetch();

    if ($member) {
        db()->prepare("UPDATE memberships SET status = ? WHERE id = ?")->execute([$new_status, $id]);

        // Send email notification
        $sent = EmailService::sendMembershipStatusUpdate($member['email'], $member['full_name'], $new_status);

        $_SESSION['flash'] = 'Application status updated.' . ($sent ? ' Email notification sent.' : ' Email notification failed, but status was updated.');
    }
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
                <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                <td>
                    <strong><?= e($r['full_name']) ?></strong><br>
                    <small style="color:#667"><?= e($r['email']) ?></small>
                </td>
                <td><?= e($r['membership_type']) ?></td>
                <td>
                    <form method="post" style="display:inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_action" value="update_status">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <select name="status" onchange="this.form.submit()" class="badge b-<?= strtolower($r['status']==='Approved'?'accepted':($r['status']==='Rejected'?'rejected':'pending')) ?>" style="border:1px solid #ccc; cursor:pointer;">
                            <?php foreach(['Pending', 'Approved', 'Rejected', 'Contacted'] as $st): ?>
                                <option value="<?= $st ?>" <?= $r['status']===$st?'selected':'' ?>><?= $st ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
                <td class="row-actions">
                    <a href="membership_message.php?id=<?= $r['id'] ?>" class="btn-sm btn-primary" style="text-decoration:none; font-size:11px;">Message</a>
                    <a href="?edit=<?= $r['id'] ?>" style="font-size:11px;">Edit</a>
                    <form method="post" class="confirm-delete" style="display:inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_action" value="delete">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button class="link-danger" type="submit" style="font-size:11px; cursor:pointer;">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__.'/includes/footer.php'; ?>
