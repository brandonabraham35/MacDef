<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_login();
$pageTitle = 'Dashboard';
include __DIR__ . '/includes/header.php';

// Stats
$stats = [
    ['label' => 'Total News', 'count' => count_rows('news'), 'icon' => 'ri-article-line', 'color' => '#002D62'],
    ['label' => 'Total Events', 'count' => count_rows('events'), 'icon' => 'ri-calendar-event-line', 'color' => '#D4AF37'],
    ['label' => 'Total Gallery', 'count' => count_rows('gallery'), 'icon' => 'ri-gallery-line', 'color' => '#1cc88a'],
    ['label' => 'Contact Messages', 'count' => count_rows('contact_submissions'), 'icon' => 'ri-chat-3-line', 'color' => '#36b9cc'],
    ['label' => 'Total Donations', 'count' => count_rows('donations'), 'icon' => 'ri-hand-heart-line', 'color' => '#f6c23e'],
    ['label' => 'Total Members', 'count' => count_rows('memberships'), 'icon' => 'ri-team-line', 'color' => '#e74a3b'],
    ['label' => 'Newsletter', 'count' => count_rows('newsletter_subscribers'), 'icon' => 'ri-mail-line', 'color' => '#858796'],
    ['label' => 'Publications', 'count' => count_rows('publications'), 'icon' => 'ri-book-open-line', 'color' => '#4e73df'],
    ['label' => 'Downloads', 'count' => count_rows('downloads'), 'icon' => 'ri-download-cloud-line', 'color' => '#1cc88a'],
    ['label' => 'Opportunities', 'count' => count_rows('opportunities'), 'icon' => 'ri-briefcase-line', 'color' => '#f6c23e'],
    ['label' => 'Emails Sent', 'count' => count_rows('email_logs'), 'icon' => 'ri-send-plane-line', 'color' => '#002D62'],
];

// Dashboard Alerts / Counts
$unreplied_count = (int)db()->query("SELECT COUNT(*) FROM contact_submissions WHERE status != 'Replied'")->fetchColumn();
$failed_emails_count = (int)db()->query("SELECT COUNT(*) FROM email_logs WHERE status='failed'")->fetchColumn();
$pending_donations_count = (int)db()->query("SELECT COUNT(*) FROM donations WHERE status='Pending'")->fetchColumn();
$pending_memberships_count = (int)db()->query("SELECT COUNT(*) FROM memberships WHERE status='Pending'")->fetchColumn();

// Recent Activity
$recent_messages = db()->query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recent_donations = db()->query("SELECT * FROM donations ORDER BY created_at DESC LIMIT 5")->fetchAll();
$email_failures = db()->query("SELECT * FROM email_logs WHERE status='failed' ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recent_memberships = db()->query("SELECT * FROM memberships ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<!-- Alerts & Quick Actions -->
<div class="row" style="margin-bottom: 30px;">
    <div class="col-12" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
        <?php if ($unreplied_count > 0): ?>
        <div class="panel" style="border-left: 4px solid #f6c23e; padding: 15px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0;">
            <div>
                <strong style="color: #f6c23e;"><?= $unreplied_count ?> Unreplied Messages</strong>
                <div style="font-size: 12px; margin-top: 5px;"><a href="contact_messages.php">View Messages →</a></div>
            </div>
            <i class="ri-chat-3-line" style="font-size: 24px; color: #f6c23e;"></i>
        </div>
        <?php endif; ?>

        <?php if ($failed_emails_count > 0): ?>
        <div class="panel" style="border-left: 4px solid #e74a3b; padding: 15px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0;">
            <div>
                <strong style="color: #e74a3b;"><?= $failed_emails_count ?> Failed Emails</strong>
                <div style="font-size: 12px; margin-top: 5px;"><a href="email_logs.php">View Logs →</a></div>
            </div>
            <i class="ri-error-warning-line" style="font-size: 24px; color: #e74a3b;"></i>
        </div>
        <?php endif; ?>

        <?php if ($pending_donations_count > 0): ?>
        <div class="panel" style="border-left: 4px solid #36b9cc; padding: 15px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0;">
            <div>
                <strong style="color: #36b9cc;"><?= $pending_donations_count ?> Pending Donations</strong>
                <div style="font-size: 12px; margin-top: 5px;"><a href="donations.php">View Donations →</a></div>
            </div>
            <i class="ri-hand-heart-line" style="font-size: 24px; color: #36b9cc;"></i>
        </div>
        <?php endif; ?>

        <?php if ($pending_memberships_count > 0): ?>
        <div class="panel" style="border-left: 4px solid #4e73df; padding: 15px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0;">
            <div>
                <strong style="color: #4e73df;"><?= $pending_memberships_count ?> Pending Memberships</strong>
                <div style="font-size: 12px; margin-top: 5px;"><a href="memberships.php">View Applications →</a></div>
            </div>
            <i class="ri-team-line" style="font-size: 24px; color: #4e73df;"></i>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="stat-grid">
    <?php foreach ($stats as $s): ?>
    <div class="stat-card" style="border-bottom: 4px solid <?= $s['color'] ?>;">
        <div>
            <div class="stat-label"><?= $s['label'] ?></div>
            <div class="stat-num"><?= $s['count'] ?></div>
        </div>
        <i class="<?= $s['icon'] ?>" style="font-size: 28px; color: #dddfeb;"></i>
    </div>
    <?php endforeach; ?>
</div>

<div class="dash-cols">
    <!-- Recent Messages -->
    <div class="panel">
        <h3 style="display: flex; align-items: center; gap: 8px; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 12px; margin-bottom: 15px;">
            <i class="ri-chat-3-line"></i> Recent Messages
        </h3>
        <?php if (empty($recent_messages)): ?>
            <p style="color: #889; text-align: center; padding: 20px;">No messages found.</p>
        <?php else: ?>
            <table class="data-table" style="font-size: 13px;">
                <thead>
                    <tr><th>Sender</th><th>Subject</th><th>Status</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php foreach($recent_messages as $m): ?>
                    <tr class="<?= $m['status'] === 'New' ? 'unread' : '' ?>">
                        <td><?= e($m['first_name'] . ' ' . $m['last_name']) ?></td>
                        <td><?= e(mb_strimwidth($m['subject'], 0, 30, '...')) ?></td>
                        <td><span class="badge b-<?= strtolower($m['status'] === 'Replied' ? 'accepted' : ($m['status'] === 'Read' ? 'reviewing' : 'pending')) ?>"><?= e($m['status']) ?></span></td>
                        <td><?= date('d M', strtotime($m['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;"><a href="contact_messages.php" style="font-size: 12px; color: #002D62; font-weight: 600;">View All Messages →</a></div>
        <?php endif; ?>
    </div>

    <!-- Recent Donations -->
    <div class="panel">
        <h3 style="display: flex; align-items: center; gap: 8px; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 12px; margin-bottom: 15px;">
            <i class="ri-hand-heart-line"></i> Recent Donations
        </h3>
        <?php if (empty($recent_donations)): ?>
            <p style="color: #889; text-align: center; padding: 20px;">No donations found.</p>
        <?php else: ?>
            <table class="data-table" style="font-size: 13px;">
                <thead>
                    <tr><th>Donor</th><th>Amount</th><th>Status</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php foreach($recent_donations as $d): ?>
                    <tr>
                        <td><?= e($d['donor_name']) ?></td>
                        <td><?= number_format((float)$d['amount'], 2) ?></td>
                        <td><span class="badge b-<?= strtolower($d['status'] === 'Received' ? 'accepted' : ($d['status'] === 'Cancelled' ? 'rejected' : 'pending')) ?>"><?= e($d['status']) ?></span></td>
                        <td><?= date('d M', strtotime($d['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;"><a href="donations.php" style="font-size: 12px; color: #002D62; font-weight: 600;">View All Donations →</a></div>
        <?php endif; ?>
    </div>

    <!-- Membership Activity -->
    <div class="panel">
        <h3 style="display: flex; align-items: center; gap: 8px; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 12px; margin-bottom: 15px;">
            <i class="ri-team-line"></i> Membership Activity
        </h3>
        <?php if (empty($recent_memberships)): ?>
            <p style="color: #889; text-align: center; padding: 20px;">No applications found.</p>
        <?php else: ?>
            <table class="data-table" style="font-size: 13px;">
                <thead>
                    <tr><th>Applicant</th><th>Type</th><th>Status</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php foreach($recent_memberships as $mem): ?>
                    <tr>
                        <td><?= e($mem['full_name']) ?></td>
                        <td><?= e($mem['membership_type']) ?></td>
                        <td><span class="badge b-<?= strtolower($mem['status'] === 'Approved' ? 'accepted' : ($mem['status'] === 'Rejected' ? 'rejected' : 'pending')) ?>"><?= e($mem['status']) ?></span></td>
                        <td><?= date('d M', strtotime($mem['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;"><a href="memberships.php" style="font-size: 12px; color: #002D62; font-weight: 600;">View All Applications →</a></div>
        <?php endif; ?>
    </div>

    <!-- Email Failures -->
    <div class="panel">
        <h3 style="display: flex; align-items: center; gap: 8px; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 12px; margin-bottom: 15px; color: #e74a3b;">
            <i class="ri-error-warning-line"></i> Recent Email Failures
        </h3>
        <?php if (empty($email_failures)): ?>
            <p style="color: #889; text-align: center; padding: 20px;">No failures recorded.</p>
        <?php else: ?>
            <table class="data-table" style="font-size: 13px;">
                <thead>
                    <tr><th>Recipient</th><th>Subject</th><th>Error</th></tr>
                </thead>
                <tbody>
                    <?php foreach($email_failures as $f): ?>
                    <tr>
                        <td><?= e($f['recipient']) ?></td>
                        <td><?= e(mb_strimwidth($f['subject'], 0, 20, '...')) ?></td>
                        <td style="color: #e74a3b;"><?= e(mb_strimwidth($f['error_message'], 0, 40, '...')) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;"><a href="email_logs.php" style="font-size: 12px; color: #e74a3b; font-weight: 600;">View All Logs →</a></div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
