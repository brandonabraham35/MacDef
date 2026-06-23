<?php
require_once __DIR__.'/includes/crud.php';
require_once dirname(__DIR__).'/includes/EmailService.php';

$cfg = [
    'table' => 'donations',
    'title' => 'Donation Records',
    'singular' => 'Donation',
    'fields' => [
        ['name' => 'created_at', 'label' => 'Date', 'type' => 'text', 'list' => true],
        ['name' => 'donor_name', 'label' => 'Donor Name', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'email', 'label' => 'Email', 'type' => 'text', 'required' => true, 'list' => true],
        ['name' => 'phone', 'label' => 'Phone', 'type' => 'text', 'list' => true],
        ['name' => 'donation_type', 'label' => 'Type', 'type' => 'text', 'list' => true],
        ['name' => 'amount', 'label' => 'Amount', 'type' => 'number', 'list' => true],
        ['name' => 'message', 'label' => 'Message', 'type' => 'textarea'],
        ['name' => 'status', 'label' => 'Status', 'type' => 'text', 'list' => true],
    ]
];

// Handle CSV Export
if (isset($_GET['export'])) {
    require_login();
    $rows = db()->query("SELECT created_at, donor_name, email, phone, donation_type, amount, status FROM donations ORDER BY created_at DESC")->fetchAll();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="donations_' . date('Ymd') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Date', 'Donor Name', 'Email', 'Phone', 'Type', 'Amount', 'Status']);
    foreach ($rows as $row) fputcsv($output, $row);
    fclose($output);
    exit;
}

// Custom handle for status update in list
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_action'] ?? '') === 'update_status') {
    require_login();
    $id = (int)$_POST['id'];
    $new_status = $_POST['status'];

    // Get donation details for email
    $stmt = db()->prepare("SELECT * FROM donations WHERE id = ?");
    $stmt->execute([$id]);
    $donation = $stmt->fetch();

    if ($donation) {
        db()->prepare("UPDATE donations SET status = ? WHERE id = ?")->execute([$new_status, $id]);

        // Send email notification
        $sent = EmailService::sendDonationStatusUpdate($donation['email'], $donation['donor_name'], $id, $new_status);

        $_SESSION['flash'] = 'Status updated.' . ($sent ? ' Email notification sent.' : ' Email notification failed, but status was updated.');
    }
    redirect('donations.php');
}

crud_handle($cfg);
$pageTitle = 'Donations';
include __DIR__.'/includes/header.php';
?>

<div class="content-head">
    <h2>Donation Records</h2>
    <a href="?export=1" class="btn-ghost">Export CSV</a>
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
                <th>Donor</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = db()->query("SELECT * FROM donations ORDER BY created_at DESC")->fetchAll();
            foreach ($rows as $r): ?>
            <tr>
                <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                <td>
                    <strong><?= e($r['donor_name']) ?></strong><br>
                    <small style="color:#667"><?= e($r['email']) ?></small>
                </td>
                <td><?= number_format((float)$r['amount'], 2) ?> <small><?= e($r['donation_type']) ?></small></td>
                <td>
                    <form method="post" style="display:inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_action" value="update_status">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <select name="status" onchange="this.form.submit()" class="badge b-<?= strtolower($r['status']==='Received'?'accepted':($r['status']==='Cancelled'?'rejected':'pending')) ?>" style="border:1px solid #ccc; cursor:pointer;">
                            <?php foreach(['Pending', 'Contacted', 'Received', 'Cancelled'] as $st): ?>
                                <option value="<?= $st ?>" <?= $r['status']===$st?'selected':'' ?>><?= $st ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
                <td class="row-actions">
                    <a href="donation_message.php?id=<?= $r['id'] ?>" class="btn-sm btn-primary" style="text-decoration:none; font-size:11px;">Message</a>
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
