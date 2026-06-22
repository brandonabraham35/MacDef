<?php
$page_title = 'Events';
require_once __DIR__ . '/includes/header.php';
$events = [];
try {
    $events = db()->query('SELECT * FROM events WHERE is_active=1 ORDER BY created_at DESC')->fetchAll();
} catch (Exception $e) {
    $events = [];
}
?>
<section class="section-padding bg-light">
    <div class="container text-center">
        <span class="section-tag">MACDEF Updates</span>
        <h1 class="display-4 fw-bold mb-3 text-navy">Events & News</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">Stay informed about our upcoming cultural gatherings, community development projects, and organization announcements.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <div class="row g-4">
            <?php foreach($events as $row): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card news-card h-100">
                        <?php
$eventImage = $row['image_path'] ?? 'uploads/gallery/youth-cultural-activity.jpg';
?>

<img src="<?= e($eventImage) ?>"
     class="card-img-top"
     alt="<?= e($row['title']) ?>">
                        <div class="card-body">
                            <small class="text-gold fw-bold mb-2 d-block"><?= e($row['event_date']) ?></small>
                            <h4 class="card-title fw-bold text-navy h5"><?= e($row['title']) ?></h4>
                            <p class="text-muted small"><?= e(mb_strimwidth($row['description'], 0, 150, '...')) ?></p>
                            <a href="#" class="btn btn-link text-gold p-0 text-decoration-none fw-bold">Read Full Story</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if(empty($events)): ?>
                <div class="col-12 text-center py-5">
                    <i class="ri-calendar-todo-line display-1 text-light mb-4 d-block"></i>
                    <p class="text-muted fs-5">No events have been added yet. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
