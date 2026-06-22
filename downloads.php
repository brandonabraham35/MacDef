<?php
$page_title = 'Downloads Centre';
require_once __DIR__ . '/includes/header.php';

// Handle download tracking
if (isset($_GET['file'])) {
    $id = (int)$_GET['file'];
    db()->prepare("UPDATE downloads SET download_count = download_count + 1 WHERE id = ?")->execute([$id]);
    $dl = db()->query("SELECT file_path FROM downloads WHERE id = $id")->fetch();
    if ($dl) {
        header('Location: ' . $dl['file_path']);
        exit;
    }
}

try {
    $downloads = db()->query("SELECT * FROM downloads WHERE is_active=1 ORDER BY created_at DESC")->fetchAll();
} catch (Exception $e) {
    $downloads = [];
}
?>

<section class="section-padding bg-light">
    <div class="container text-center">
        <span class="section-tag">Media Centre</span>
        <h1 class="display-4 fw-bold mb-3 text-navy">Downloads Centre</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">Download forms, brochures, and other informational materials.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-navy text-white">
                        <tr>
                            <th class="ps-4 py-3">Document Title</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Description</th>
                            <th class="py-3 text-center">Downloads</th>
                            <th class="pe-4 py-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($downloads)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No downloads available.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($downloads as $dl): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-navy"><?= e($dl['title']) ?></td>
                                    <td><span class="badge bg-light text-navy border"><?= e($dl['category'] ?: 'General') ?></span></td>
                                    <td class="text-muted small"><?= e($dl['description']) ?></td>
                                    <td class="text-center"><?= $dl['download_count'] ?></td>
                                    <td class="pe-4 text-end">
                                        <a href="?file=<?= $dl['id'] ?>" class="btn btn-gold btn-sm"><i class="ri-download-line"></i> Download</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
