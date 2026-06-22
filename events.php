<?php
$page_title = 'Events';
require_once __DIR__ . '/includes/header.php';
$events = [];
if ($pdo) {
    try { $events = $pdo->query('SELECT * FROM events ORDER BY created_at DESC')->fetchAll(); } catch (PDOException $e) { $events = []; }
}
?>
<section class="page-header bg-navy text-white py-5"><div class="container py-4 text-center"><h1 class="display-4 fw-bold mb-3">Community Events</h1></div></section>
<main class="container py-5">
    <?php if(!$pdo): ?><div class="alert alert-warning">Events will appear after the database is imported.</div><?php endif; ?>
    <div class="row g-4">
        <?php foreach($events as $row): ?>
            <div class="col-md-6"><div class="card border-0 shadow-sm rounded-4 p-4 h-100"><h4 class="text-navy fw-bold"><?php echo e($row['title']); ?></h4><p class="text-gold fw-bold"><?php echo e($row['event_date']); ?></p><p><?php echo e($row['description']); ?></p></div></div>
        <?php endforeach; ?>
        <?php if(empty($events)): ?><div class="col-12 text-center text-muted">No events have been added yet.</div><?php endif; ?>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
