<?php
$page_title = 'Media Centre';
require_once __DIR__ . '/includes/header.php';
$items = [];
try {
    $items = db()->query('SELECT * FROM gallery WHERE is_active=1 ORDER BY created_at DESC')->fetchAll();
} catch (Exception $e) {
    $items = [];
}
?>
<section class="section-padding bg-light">
    <div class="container text-center">
        <span class="section-tag">Visual Resources</span>
        <h1 class="display-4 fw-bold mb-3 text-navy">Media Centre</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">A collection of moments from our community celebrations, traditional performances, and development activities.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <div class="row g-4">
            <?php foreach($items as $row): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card news-card border-0 overflow-hidden h-100">
                        <img src="<?= e($row['image_path']); ?>" class="img-fluid" style="height:300px; width:100%; object-fit:cover" alt="<?= e($row['title']); ?>">
                        <div class="p-3 bg-white">
                            <h6 class="fw-bold text-navy mb-0"><?= e($row['title']); ?></h6>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if(empty($items)): ?>
                <div class="col-12 text-center py-5">
                    <i class="ri-image-line display-1 text-light mb-4 d-block"></i>
                    <p class="text-muted fs-5">No gallery images have been added yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
