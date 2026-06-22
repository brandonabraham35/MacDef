<?php
$page_title = 'Search Results';
require_once __DIR__ . '/includes/header.php';

$q = sanitize($_GET['q'] ?? '');
$results = [];

if ($q) {
    // Search News
    $news = db()->prepare("SELECT 'news' as source, title, slug as link_param, excerpt as description, featured_image as image FROM news WHERE is_active=1 AND (title LIKE ? OR content LIKE ?)");
    $news->execute(["%$q%", "%$q%"]);
    $results = array_merge($results, $news->fetchAll());

    // Search Publications
    $pubs = db()->prepare("SELECT 'publication' as source, title, id as link_param, description, cover_image as image FROM publications WHERE is_active=1 AND (title LIKE ? OR description LIKE ?)");
    $pubs->execute(["%$q%", "%$q%"]);
    $results = array_merge($results, $pubs->fetchAll());

    // Search Resources
    $res = db()->prepare("SELECT 'resource' as source, title, file_path as link_param, description, cover_image as image FROM resources WHERE title LIKE ? OR description LIKE ?");
    $res->execute(["%$q%", "%$q%"]);
    $results = array_merge($results, $res->fetchAll());

    // Search Downloads
    $dls = db()->prepare("SELECT 'download' as source, title, id as link_param, description, NULL as image FROM downloads WHERE is_active=1 AND (title LIKE ? OR description LIKE ?)");
    $dls->execute(["%$q%", "%$q%"]);
    $results = array_merge($results, $dls->fetchAll());

    // Search Opportunities
    $opps = db()->prepare("SELECT 'opportunity' as source, title, id as link_param, description, NULL as image FROM opportunities WHERE is_active=1 AND (title LIKE ? OR description LIKE ?)");
    $opps->execute(["%$q%", "%$q%"]);
    $results = array_merge($results, $opps->fetchAll());
}

function getLink($item) {
    if ($item['source'] === 'news') return "news-single.php?slug=" . $item['link_param'];
    if ($item['source'] === 'publication') return "publications.php?download=" . $item['link_param'];
    if ($item['source'] === 'resource') return $item['link_param'];
    if ($item['source'] === 'download') return "downloads.php?file=" . $item['link_param'];
    if ($item['source'] === 'opportunity') return "opportunities.php";
    return "#";
}
?>

<section class="section-padding bg-light">
    <div class="container text-center">
        <h1 class="display-5 fw-bold mb-4 text-navy">Search Results</h1>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="search.php" method="GET" class="input-group input-group-lg shadow-sm">
                    <input type="text" name="q" class="form-control border-0" placeholder="Search again..." value="<?= e($q) ?>">
                    <button class="btn btn-gold px-4" type="submit"><i class="ri-search-line"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <?php if (!$q): ?>
            <p class="text-center text-muted">Please enter a search term.</p>
        <?php elseif (empty($results)): ?>
            <div class="text-center py-5">
                <i class="ri-search-eye-line display-1 text-muted opacity-25"></i>
                <p class="lead mt-3 text-muted">No results found for "<strong><?= e($q) ?></strong>".</p>
            </div>
        <?php else: ?>
            <div class="mb-4">
                <p class="text-muted">Found <?= count($results) ?> result(s) for "<strong><?= e($q) ?></strong>"</p>
            </div>
            <div class="row g-4">
                <?php foreach ($results as $item): ?>
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <?php if ($item['image']): ?>
                                <div class="col-md-2">
                                    <img src="<?= e($item['image']) ?>" class="img-fluid h-100 object-fit-cover" style="min-height: 120px;" alt="">
                                </div>
                                <?php endif; ?>
                                <div class="<?= $item['image'] ? 'col-md-10' : 'col-md-12' ?>">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-gold text-white me-3 text-uppercase"><?= e($item['source']) ?></span>
                                        </div>
                                        <h4 class="fw-bold mb-2"><a href="<?= getLink($item) ?>" class="text-navy text-decoration-none"><?= e($item['title']) ?></a></h4>
                                        <p class="text-muted small mb-0"><?= e(mb_strimwidth($item['description'], 0, 200, '...')) ?></p>
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
