<?php
$page_title = 'Gallery';
require_once __DIR__ . '/includes/header.php';
$items = [];
if ($pdo) {
    try { $items = $pdo->query('SELECT * FROM gallery ORDER BY created_at DESC')->fetchAll(); } catch (PDOException $e) { $items = []; }
}
?>
<section class="page-header bg-navy text-white py-5"><div class="container py-4 text-center"><h1 class="display-4 fw-bold mb-3">Photo Gallery</h1></div></section>
<main class="container py-5"><div class="row g-4">
    <?php foreach($items as $row): ?>
        <div class="col-md-4"><div class="card border-0 shadow-sm overflow-hidden rounded-4 h-100"><img src="<?php echo e($row['image_path']); ?>" class="img-fluid" style="height:260px;width:100%;object-fit:cover" alt="<?php echo e($row['title']); ?>"><div class="p-3"><h6 class="fw-bold text-navy"><?php echo e($row['title']); ?></h6></div></div></div>
    <?php endforeach; ?>
    <?php if(empty($items)): ?><div class="col-12 text-center text-muted">No gallery images have been added yet.</div><?php endif; ?>
</div></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
