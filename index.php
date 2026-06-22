<?php
$page_title = "Home";
require_once 'includes/header.php';
?>
<section class="hero-section text-white d-flex align-items-center">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-content">
                    <span class="badge bg-gold-transparent text-gold px-3 py-2 rounded-pill mb-4 fw-bold">Welcome to MACDEF</span>
                    <h1 class="display-3 fw-bold mb-4">Ma'di Cultural and Development Foundation</h1>
                    <p class="lead mb-5 opacity-90">Preserving our rich heritage, empowering our community, and building a prosperous future.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="mission.php" class="btn btn-gold btn-lg rounded-pill px-5">Explore Our Mission</a>
                        <a href="contact.php" class="btn btn-outline-light btn-lg rounded-pill px-5">Get In Touch</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="welcome-section py-5">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="section-tag mb-3">About Us</div>
                <h2 class="display-5 fw-bold mb-4 text-navy">Building a Stronger Ma'di Community</h2>
                <p class="text-muted mb-4 lead">Built on strong values and a commitment to the Ma'di people, our foundation guides everything we do.</p>
                <a href="mission.php" class="btn btn-navy rounded-pill px-4 py-2">Read More About Us</a>
            </div>
            <div class="col-lg-6">
                <img src="uploads/gallery/madi-community-celebration.jpg" alt="MACDEF Community" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>
