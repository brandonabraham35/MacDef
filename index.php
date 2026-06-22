<?php
$page_title = 'Home';
require_once 'includes/header.php';

try {
    $slides = db()->query("SELECT * FROM hero_slides WHERE is_active=1 ORDER BY sort_order ASC, id DESC")->fetchAll();
} catch (Exception $e) {
    die("Slides Error: " . $e->getMessage());
}

try {
    $latest_news = db()->query("SELECT * FROM news WHERE is_active=1 ORDER BY published_at DESC, created_at DESC LIMIT 4")->fetchAll();
} catch (Exception $e) {
    $latest_news = [];
}

try {
    $programs = db()->query("SELECT * FROM programs WHERE is_active=1 ORDER BY sort_order ASC, id DESC LIMIT 3")->fetchAll();
} catch (Exception $e) {
    die("Programs Error: " . $e->getMessage());
}

try {
    $events = db()->query("SELECT * FROM events WHERE is_active=1 ORDER BY id DESC LIMIT 4")->fetchAll();
} catch (Exception $e) {
    die("Events Error: " . $e->getMessage());
}

try {
    $home = db()->query("SELECT * FROM homepage_content WHERE id=1")->fetch();
} catch (Exception $e) {
    die("Homepage Content Error: " . $e->getMessage());
}
?>

<!-- Hero Slider -->
<section id="macdefHero" class="carousel slide hero-carousel" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php foreach($slides as $i => $s):
            $img = $s['image_path'] ?: 'uploads/gallery/madi-community-celebration.jpg';
        ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <div class="hero-slide" style="background-image: url('<?= e($img) ?>')">
                <div class="container">
                    <div class="hero-content text-white">
                        <h1 class="display-3 fw-bold mb-4"><?= e($s['heading']) ?></h1>
                        <p class="lead mb-5 fs-4"><?= e($s['subheading']) ?></p>
                        <?php if($s['button_text']): ?>
                            <a href="<?= e($s['button_link'] ?: 'contact.php') ?>" class="btn btn-gold btn-lg px-5 py-3"><?= e($s['button_text']) ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#macdefHero" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
    <button class="carousel-control-next" type="button" data-bs-target="#macdefHero" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
</section>

<!-- Action Cards -->
<section class="action-cards">
    <div class="container">
        <div class="row g-0">
            <div class="col-lg-4">
                <div class="action-card h-100">
                    <i class="ri-team-line"></i>
                    <h3><?= e($home['card1_title'] ?? 'Our Work') ?></h3>
                    <p class="text-muted mb-4"><?= e($home['card1_body'] ?? 'Discover how MACDEF is making a difference through cultural preservation and community development.') ?></p>
                    <a href="<?= e($home['card1_button_link'] ?? 'goals.php') ?>" class="btn btn-link text-gold fw-bold text-decoration-none"><?= e($home['card1_button_text'] ?? 'Learn More') ?> <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="action-card h-100" style="border-bottom-color: var(--navy);">
                    <i class="ri-user-heart-line"></i>
                    <h3><?= e($home['card2_title'] ?? 'Membership') ?></h3>
                    <p class="text-muted mb-4"><?= e($home['card2_body'] ?? 'Join our community and contribute to the empowerment of the Ma\'di people home and abroad.') ?></p>
                    <a href="<?= e($home['card2_button_link'] ?? 'contact.php') ?>" class="btn btn-link text-gold fw-bold text-decoration-none"><?= e($home['card2_button_text'] ?? 'Learn More') ?> <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="action-card h-100">
                    <i class="ri-folder-open-line"></i>
                    <h3><?= e($home['card3_title'] ?? 'Resources') ?></h3>
                    <p class="text-muted mb-4"><?= e($home['card3_body'] ?? 'Access our latest reports, publications, and cultural resources for the Ma\'di community.') ?></p>
                    <a href="<?= e($home['card3_button_link'] ?? 'mission.php') ?>" class="btn btn-link text-gold fw-bold text-decoration-none"><?= e($home['card3_button_text'] ?? 'Learn More') ?> <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Welcome Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="pe-lg-5">
                    <span class="section-tag">Welcome to</span>
                    <h2 class="section-title display-5"><?= e($home['welcome_title'] ?? "Ma'di Cultural and Development Foundation") ?></h2>
                    <p class="lead text-muted mb-4"><?= nl2br(e($home['welcome_body'] ?? '')) ?></p>
                    <a href="mission.php" class="btn btn-navy px-4 py-3">More About Us</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="<?= e(!empty($home['welcome_image']) ? $home['welcome_image'] : 'uploads/gallery/madi-community-celebration.jpg') ?>" class="img-fluid shadow-lg" alt="MACDEF Community">
                    <div class="position-absolute bottom-0 start-0 bg-gold p-4 d-none d-md-block" style="margin-left: -30px; margin-bottom: -30px;">
                        <i class="ri-double-quotes-l text-white fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Media Centre -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">Media Centre</span>
            <h2 class="section-title">Latest Updates & Events</h2>
        </div>

        <ul class="nav nav-tabs media-tabs justify-content-center mb-5" id="mediaTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="news-tab" data-bs-toggle="tab" data-bs-target="#news-content">Latest News</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events-content">Upcoming Events</button>
            </li>
        </ul>

        <div class="tab-content" id="mediaTabsContent">
            <div class="tab-pane fade show active" id="news-content">
                <div class="row g-4">
                    <?php if(empty($latest_news)): ?>
                        <div class="col-12 text-center py-4">
                            <p class="text-muted">No news articles published yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($latest_news as $nw): ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="card news-card h-100">
                                <img src="<?= e(!empty($nw['featured_image']) ? $nw['featured_image'] : 'uploads/gallery/youth-cultural-activity.jpg') ?>" class="card-img-top" alt="<?= e($nw['title']) ?>" style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    <small class="text-muted d-block mb-2"><?= formatDate($nw['published_at']) ?></small>
                                    <h5 class="card-title fw-bold h6"><?= e($nw['title']) ?></h5>
                                    <a href="news-single.php?slug=<?= e($nw['slug']) ?>" class="btn btn-link text-gold p-0 text-decoration-none fw-bold mt-3">Read More</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane fade" id="events-content">
                <div class="text-center py-5">
                    <p class="text-muted">Check our calendar for upcoming cultural celebrations and development meetings.</p>
                    <a href="events.php" class="btn btn-outline-navy">View Events Calendar</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section id="newsletter-section" class="newsletter-section section-padding">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-7">
                <h2 class="fw-bold mb-3"><?= e($home['newsletter_title'] ?? 'STAY UPDATED') ?></h2>
                <p class="mb-4 opacity-75"><?= e($home['newsletter_body'] ?? 'Signup for our newsletter to stay updated on the latest news and events from the Ma\'di community.') ?></p>

                <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                    <div class="alert alert-success"><?= e($_GET['msg']) ?></div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
                    <div class="alert alert-danger"><?= e($_GET['msg']) ?></div>
                <?php endif; ?>

                <form action="newsletter_subscribe.php" method="POST" class="row g-2 justify-content-center">
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control form-control-lg border-0" placeholder="Your Name" required>
                    </div>
                    <div class="col-md-5">
                        <input type="email" name="email" class="form-control form-control-lg border-0" placeholder="Your Email" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-gold btn-lg w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
