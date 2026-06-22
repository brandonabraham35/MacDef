<?php
$page_title = 'Resource Centre';
require_once __DIR__ . '/includes/header.php';

try {
    $resources = db()->query("SELECT * FROM resources ORDER BY created_at DESC")->fetchAll();
} catch (Exception $e) {
    $resources = [];
}
?>

<section class="section-padding bg-navy text-white">
    <div class="container text-center">
        <span class="section-tag text-gold">Knowledge Base</span>
        <h1 class="display-4 fw-bold mb-3">Resource Centre</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 700px;">Explore our collection of reports, research papers, policy briefs, and guides.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <?php if (empty($resources)): ?>
            <div class="text-center py-5">
                <i class="ri-folder-open-line display-1 text-muted opacity-25"></i>
                <p class="lead mt-3 text-muted">No resources available at the moment.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($resources as $res): ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 border shadow-sm resource-card">
                            <div class="position-relative">
                                <img src="<?= e(!empty($res['cover_image']) ? $res['cover_image'] : 'assets/images/res-placeholder.jpg') ?>" class="card-img-top" alt="<?= e($res['title']) ?>">
                                <span class="position-absolute top-0 end-0 bg-gold text-white px-2 py-1 small m-2 rounded"><?= e($res['resource_type']) ?></span>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold text-navy mb-3"><?= e($res['title']) ?></h5>
                                <p class="card-text text-muted small mb-4"><?= e(mb_strimwidth($res['description'], 0, 100, '...')) ?></p>
                                <a href="<?= e($res['file_path']) ?>" target="_blank" class="btn btn-outline-navy btn-sm w-100 mt-auto"><i class="ri-eye-line me-1"></i> View Resource</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
