<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_login();
$pageTitle = 'Dashboard';
include __DIR__ . '/includes/header.php';

// Stats
$stats = [
    ['label' => 'News', 'count' => count_rows('news'), 'icon' => 'ri-article-line', 'color' => '#4e73df'],
    ['label' => 'Publications', 'count' => count_rows('publications'), 'icon' => 'ri-book-open-line', 'color' => '#1cc88a'],
    ['label' => 'Resources', 'count' => count_rows('resources'), 'icon' => 'ri-folder-open-line', 'color' => '#36b9cc'],
    ['label' => 'Opportunities', 'count' => count_rows('opportunities'), 'icon' => 'ri-briefcase-line', 'color' => '#f6c23e'],
    ['label' => 'Members', 'count' => count_rows('memberships'), 'icon' => 'ri-team-line', 'color' => '#e74a3b'],
    ['label' => 'Subscribers', 'count' => count_rows('newsletter_subscribers'), 'icon' => 'ri-mail-line', 'color' => '#858796'],
    ['label' => 'Donations', 'count' => count_rows('donations'), 'icon' => 'ri-hand-heart-line', 'color' => '#5a5c69'],
    ['label' => 'Emails Sent', 'count' => count_rows('email_logs'), 'icon' => 'ri-send-plane-line', 'color' => '#f6c23e'],
];

// Recent Activity
$recent_contacts = db()->query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recent_donations = db()->query("SELECT * FROM donations ORDER BY created_at DESC LIMIT 5")->fetchAll();
$email_failures = db()->query("SELECT * FROM email_logs WHERE status='failed' ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <?php foreach ($stats as $s): ?>
    <div class="stat-card panel" style="border-left: 4px solid <?= $s['color'] ?>; display: flex; justify-content: space-between; align-items: center; padding: 20px;">
        <div>
            <div style="font-size: 12px; font-weight: bold; color: <?= $s['color'] ?>; text-transform: uppercase; margin-bottom: 5px;"><?= $s['label'] ?></div>
            <div style="font-size: 24px; font-weight: bold; color: #5a5c69;"><?= $s['count'] ?></div>
        </div>
        <i class="<?= $s['icon'] ?>" style="font-size: 32px; color: #dddfeb;"></i>
    </div>
    <?php endforeach; ?>
</div>

<div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <div class="panel">
        <h3 style="margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Recent Contact Messages</h3>
        <?php if (empty($recent_contacts)): ?>
            <p class="empty">No recent messages.</p>
        <?php else: ?>
            <table class="data-table" style="font-size: 13px;">
                <thead>
                    <tr><th>Name</th><th>Subject</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php foreach($recent_contacts as $c): ?>
                    <tr>
                        <td><?= e($c['first_name'] . ' ' . $c['last_name']) ?></td>
                        <td><?= e($c['subject']) ?></td>
                        <td><?= formatDate($c['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;"><a href="contact_messages.php" class="small">View all messages →</a></div>
        <?php endif; ?>
    </div>

    <div class="panel">
        <h3 style="margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Recent Donations</h3>
        <?php if (empty($recent_donations)): ?>
            <p class="empty">No recent donations.</p>
        <?php else: ?>
            <table class="data-table" style="font-size: 13px;">
                <thead>
                    <tr><th>Donor</th><th>Amount</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php foreach($recent_donations as $d): ?>
                    <tr>
                        <td><?= e($d['donor_name']) ?></td>
                        <td><?= number_format((float)$d['amount'], 2) ?></td>
                        <td><span class="badge"><?= e($d['status']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;"><a href="donations.php" class="small">View all donations →</a></div>
        <?php endif; ?>
    </div>

    <div class="panel" style="grid-column: span 2;">
        <h3 style="margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #e74a3b;">Email Failures</h3>
        <?php if (empty($email_failures)): ?>
            <p class="empty">No recent email failures.</p>
        <?php else: ?>
            <table class="data-table" style="font-size: 13px;">
                <thead>
                    <tr><th>Recipient</th><th>Subject</th><th>Error</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php foreach($email_failures as $f): ?>
                    <tr>
                        <td><?= e($f['recipient']) ?></td>
                        <td><?= e($f['subject']) ?></td>
                        <td style="color: #e74a3b;"><?= e(mb_strimwidth($f['error_message'], 0, 50, '...')) ?></td>
                        <td><?= formatDate($f['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;"><a href="email_logs.php" class="small">View all logs →</a></div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
