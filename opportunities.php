<?php
$page_title = 'Opportunities';
require_once __DIR__ . '/includes/header.php';

try {
    // Show active and non-expired opportunities
    $opportunities = db()->query("SELECT * FROM opportunities WHERE is_active=1 AND (deadline IS NULL OR deadline >= CURDATE()) ORDER BY deadline ASC")->fetchAll();
} catch (Exception $e) {
    $opportunities = [];
}
?>

<section class="section-padding bg-light">
    <div class="container text-center">
        <span class="section-tag">Career & Growth</span>
        <h1 class="display-4 fw-bold mb-3 text-navy">Opportunities</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">Join our team or partner with us. Explore the latest jobs, tenders, scholarships, and volunteer positions.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <?php if (empty($opportunities)): ?>
            <div class="text-center py-5">
                <i class="ri-briefcase-line display-1 text-muted opacity-25"></i>
                <p class="lead mt-3 text-muted">There are no open opportunities at the moment. Please check back later.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($opportunities as $opp): ?>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-navy text-white px-3 py-2"><?= e($opp['type']) ?></span>
                                <span class="text-danger small fw-bold"><i class="ri-time-line me-1"></i> Deadline: <?= formatDate($opp['deadline']) ?></span>
                            </div>
                            <h3 class="fw-bold text-navy mb-3"><?= e($opp['title']) ?></h3>
                            <div class="text-muted mb-4">
                                <?= nl2br(e($opp['description'])) ?>
                            </div>
                            <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                                <?php if ($opp['attachment']): ?>
                                    <a href="<?= e($opp['attachment']) ?>" class="btn btn-gold btn-sm"><i class="ri-attachment-line me-1"></i> View Details / Apply</a>
                                <?php else: ?>
                                    <span class="text-muted small">No attachment provided.</span>
                                <?php endif; ?>
                                <small class="text-muted">Posted on: <?= formatDate($opp['created_at']) ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
