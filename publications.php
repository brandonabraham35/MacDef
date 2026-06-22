<?php
$page_title = 'Publications';
require_once __DIR__ . '/includes/header.php';

// Handle download tracking
if (isset($_GET['download'])) {
    $id = (int)$_GET['download'];
    db()->prepare("UPDATE publications SET download_count = download_count + 1 WHERE id = ?")->execute([$id]);
    $pub = db()->query("SELECT file_path FROM publications WHERE id = $id")->fetch();
    if ($pub) {
        header('Location: ' . $pub['file_path']);
        exit;
    }
}

try {
    $publications = db()->query("SELECT * FROM publications WHERE is_active=1 ORDER BY created_at DESC")->fetchAll();
} catch (Exception $e) {
    $publications = [];
}
?>

<section class="section-padding bg-light">
    <div class="container text-center">
        <span class="section-tag">Resources</span>
        <h1 class="display-4 fw-bold mb-3 text-navy">Publications</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">Access our library of reports, research papers, and cultural documents.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <?php if (empty($publications)): ?>
            <div class="text-center py-5">
                <i class="ri-book-open-line display-1 text-muted opacity-25"></i>
                <p class="lead mt-3 text-muted">No publications available at the moment.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($publications as $pub): ?>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm p-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-4">
                                    <img src="<?= e(!empty($pub['cover_image']) ? $pub['cover_image'] : 'assets/images/pub-placeholder.jpg') ?>" class="img-fluid rounded shadow-sm" alt="<?= e($pub['title']) ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <span class="badge bg-gold text-white"><?= e($pub['category'] ?: 'General') ?></span>
                                        </div>
                                        <h4 class="card-title fw-bold text-navy mb-2"><?= e($pub['title']) ?></h4>
                                        <p class="card-text text-muted small mb-4"><?= e($pub['description']) ?></p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="?download=<?= $pub['id'] ?>" class="btn btn-navy btn-sm"><i class="ri-download-2-line me-1"></i> Download PDF</a>
                                            <small class="text-muted"><i class="ri-eye-line me-1"></i> <?= $pub['download_count'] ?> downloads</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
