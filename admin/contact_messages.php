<?php
require_once dirname(__DIR__).'/includes/auth.php';
require_login();

if($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['_action']??'')==='delete'){
    if(verify_csrf($_POST['csrf_token']??'')) db()->prepare('DELETE FROM contact_submissions WHERE id=?')->execute([(int)$_POST['id']]);
    redirect('contact_messages.php');
}

$pageTitle='Contact Messages';
$rows=db()->query('SELECT * FROM contact_submissions ORDER BY created_at DESC')->fetchAll();
include __DIR__.'/includes/header.php';
?>

<div class="content-head">
    <h2>Contact Messages</h2>
</div>

<?php
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
if ($flash): ?><div class="flash ok"><?= e($flash) ?></div><?php endif; ?>

<div class="panel">
    <table class="data-table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!$rows):?>
                <tr><td colspan="6" class="empty">No messages yet.</td></tr>
            <?php endif;
            foreach($rows as $r):?>
                <tr class="<?= $r['status'] === 'New' ? 'unread' : '' ?>">
                    <td>
                        <span class="badge b-<?= strtolower($r['status'] === 'Replied' ? 'accepted' : ($r['status'] === 'Read' ? 'reviewing' : 'pending')) ?>">
                            <?= e($r['status']) ?>
                        </span>
                    </td>
                    <td><?= e($r['first_name'].' '.$r['last_name']) ?></td>
                    <td><?= e($r['email']) ?></td>
                    <td><?= e(mb_strimwidth($r['subject'], 0, 50, '...')) ?></td>
                    <td><?= e(date('d M Y', strtotime($r['created_at']))) ?></td>
                    <td class="row-actions">
                        <a href="contact_reply.php?id=<?= $r['id'] ?>" class="btn-sm btn-primary" style="text-decoration:none; font-size:11px;">Reply</a>
                        <form method="post" class="confirm-delete" style="display:inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                            <button class="link-danger" style="font-size:11px; cursor:pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<?php include __DIR__.'/includes/footer.php'; ?>
