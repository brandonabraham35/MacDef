<?php
$page_title = 'Events Calendar';
require_once __DIR__ . '/includes/header.php';

try {
    $events = db()->query("SELECT * FROM events WHERE is_active=1 ORDER BY created_at DESC")->fetchAll();
} catch (Exception $e) {
    $events = [];
}
?>

<section class="section-padding bg-navy text-white">
    <div class="container text-center">
        <span class="section-tag text-gold">Save the Date</span>
        <h1 class="display-4 fw-bold mb-3">Events Calendar</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 700px;">Stay updated on our community gatherings, cultural celebrations, and development meetings.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <?php if (empty($events)): ?>
            <div class="text-center py-5">
                <i class="ri-calendar-line display-1 text-muted opacity-25"></i>
                <p class="lead mt-3 text-muted">No upcoming events scheduled. Please check back later.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($events as $ev): ?>
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm overflow-hidden event-list-card">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <div class="h-100 bg-gold d-flex flex-column align-items-center justify-content-center text-white p-4">
                                        <i class="ri-calendar-check-fill fs-1 mb-2"></i>
                                        <h4 class="fw-bold mb-0 text-center"><?= e($ev['event_date']) ?></h4>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body p-4 p-md-5">
                                        <h3 class="fw-bold text-navy mb-3"><?= e($ev['title']) ?></h3>
                                        <p class="text-muted fs-5 mb-4"><?= nl2br(e($ev['description'])) ?></p>
                                        <?php if ($ev['image_path']): ?>
                                            <div class="mb-4">
                                                <img src="<?= e($ev['image_path']) ?>" class="img-fluid rounded" style="max-height: 300px;" alt="">
                                            </div>
                                        <?php endif; ?>
                                        <a href="contact.php?subject=Inquiry about <?= urlencode($ev['title']) ?>" class="btn btn-outline-navy">Inquire About Event <i class="ri-arrow-right-line ms-2"></i></a>
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
