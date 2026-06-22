<?php
$page_title = 'Latest News';
require_once __DIR__ . '/includes/header.php';

try {
    $news = db()->query("SELECT * FROM news WHERE is_active=1 ORDER BY published_at DESC, created_at DESC")->fetchAll();
} catch (Exception $e) {
    $news = [];
}
?>

<section class="section-padding bg-light">
    <div class="container text-center">
        <span class="section-tag">Media Centre</span>
        <h1 class="display-4 fw-bold mb-3 text-navy">Latest News</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">Stay updated with the latest happenings, stories, and updates from MACDEF and the Ma'di community.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <?php if (empty($news)): ?>
            <div class="text-center py-5">
                <i class="ri-article-line display-1 text-muted opacity-25"></i>
                <p class="lead mt-3 text-muted">No news articles found. Check back later!</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($news as $item): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 news-card border-0 shadow-sm">
                            <div class="news-img-wrapper" style="height: 240px; overflow: hidden;">
                                <img src="<?= e(!empty($item['featured_image']) ? $item['featured_image'] : 'assets/images/placeholder.jpg') ?>" class="card-img-top w-100 h-100 object-fit-cover" alt="<?= e($item['title']) ?>">
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <small class="text-gold fw-bold text-uppercase"><i class="ri-calendar-line me-1"></i> <?= formatDate($item['published_at']) ?></small>
                                </div>
                                <h4 class="card-title fw-bold h5 mb-3">
                                    <a href="news-single.php?slug=<?= e($item['slug']) ?>" class="text-navy text-decoration-none"><?= e($item['title']) ?></a>
                                </h4>
                                <p class="card-text text-muted mb-4"><?= e($item['excerpt']) ?></p>
                                <a href="news-single.php?slug=<?= e($item['slug']) ?>" class="btn btn-link text-gold p-0 text-decoration-none fw-bold">Read Full Story <i class="ri-arrow-right-line"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
