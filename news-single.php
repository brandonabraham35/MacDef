<?php
$slug = $_GET['slug'] ?? '';
if (!$slug) { header('Location: news.php'); exit; }

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

try {
    $stmt = db()->prepare("SELECT * FROM news WHERE slug = ? AND is_active = 1 LIMIT 1");
    $stmt->execute([$slug]);
    $article = $stmt->fetch();
} catch (Exception $e) {
    $article = null;
}

if (!$article) { header('Location: news.php'); exit; }

$page_title = $article['title'];
require_once __DIR__ . '/includes/header.php';
?>

<section class="section-padding bg-navy text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item"><a href="news.php" class="text-white-50">News</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Article</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-4"><?= e($article['title']) ?></h1>
                <div class="d-flex justify-content-center align-items-center opacity-75">
                    <span class="me-4"><i class="ri-calendar-line me-2 text-gold"></i> <?= formatDate($article['published_at']) ?></span>
                    <?php if ($article['author']): ?>
                    <span><i class="ri-user-line me-2 text-gold"></i> By <?= e($article['author']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <?php if ($article['featured_image']): ?>
                <div class="mb-5">
                    <img src="<?= e($article['featured_image']) ?>" class="img-fluid w-100 rounded shadow-sm" alt="<?= e($article['title']) ?>">
                </div>
                <?php endif; ?>

                <div class="article-content fs-5 text-muted lh-lg">
                    <?= nl2br($article['content']) ?>
                </div>

                <div class="mt-5 pt-5 border-top d-flex justify-content-between align-items-center">
                    <div class="share-links">
                        <span class="fw-bold text-navy me-3">Share:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL . '/news-single.php?slug=' . $article['slug']) ?>" target="_blank" class="text-navy me-3 fs-4"><i class="ri-facebook-fill"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(SITE_URL . '/news-single.php?slug=' . $article['slug']) ?>&text=<?= urlencode($article['title']) ?>" target="_blank" class="text-navy me-3 fs-4"><i class="ri-twitter-x-fill"></i></a>
                    </div>
                    <a href="news.php" class="btn btn-outline-navy"><i class="ri-arrow-left-line me-2"></i> Back to News</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
