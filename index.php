<?php
$page_title = 'Home';
require_once 'includes/header.php';

try {
    $slides = db()->query("SELECT * FROM hero_slides WHERE is_active=1 ORDER BY sort_order ASC, id DESC")->fetchAll();
} catch (Exception $e) {
    die("Slides Error: " . $e->getMessage());
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
    $welcome = db()->query("SELECT * FROM content_blocks WHERE block_key='welcome'")->fetch();
} catch (Exception $e) {
    die("Welcome Content Error: " . $e->getMessage());
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
                    <h3>Our Work</h3>
                    <p class="text-muted mb-4">Discover how MACDEF is making a difference through cultural preservation and community development.</p>
                    <a href="goals.php" class="btn btn-link text-gold fw-bold text-decoration-none">Learn More <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="action-card h-100" style="border-bottom-color: var(--navy);">
                    <i class="ri-user-heart-line"></i>
                    <h3>Membership</h3>
                    <p class="text-muted mb-4">Join our community and contribute to the empowerment of the Ma'di people home and abroad.</p>
                    <a href="contact.php" class="btn btn-link text-gold fw-bold text-decoration-none">Learn More <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="action-card h-100">
                    <i class="ri-folder-open-line"></i>
                    <h3>Resources</h3>
                    <p class="text-muted mb-4">Access our latest reports, publications, and cultural resources for the Ma'di community.</p>
                    <a href="mission.php" class="btn btn-link text-gold fw-bold text-decoration-none">Learn More <i class="ri-arrow-right-line"></i></a>
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
                    <h2 class="section-title display-5"><?= e($welcome['title'] ?? "Ma'di Cultural and Development Foundation") ?></h2>
                    <p class="lead text-muted mb-4"><?= nl2br(e($welcome['body'] ?? '')) ?></p>
                    <a href="mission.php" class="btn btn-navy px-4 py-3">More About Us</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="uploads/gallery/madi-community-celebration.jpg" class="img-fluid shadow-lg" alt="MACDEF Community">
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
                    <?php foreach($events as $ev): ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="card news-card h-100">
                            <?php
$eventImg = !empty($ev['image_path']) ? $ev['image_path'] : 'uploads/gallery/youth-cultural-activity.jpg';
?>
<img src="<?= e($eventImg) ?>" class="card-img-top" alt="<?= e($ev['title']) ?>">
                            <div class="card-body">
                                <small class="text-muted d-block mb-2"><?= e($ev['event_date']) ?></small>
                                <h5 class="card-title fw-bold h6"><?= e($ev['title']) ?></h5>
                                <a href="events.php" class="btn btn-link text-gold p-0 text-decoration-none fw-bold mt-3">Read More</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
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
<section class="newsletter-section section-padding">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-7">
                <h2 class="fw-bold mb-3">STAY UPDATED</h2>
                <p class="mb-4 opacity-75">Signup for our newsletter to stay updated on the latest news and events from the Ma'di community.</p>
                <form class="row g-2 justify-content-center">
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-lg border-0" placeholder="Your Name">
                    </div>
                    <div class="col-md-5">
                        <input type="email" class="form-control form-control-lg border-0" placeholder="Your Email">
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
