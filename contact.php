<?php
$page_title = 'Contact Us';
require_once __DIR__ . '/includes/header.php';

$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';

// Get admin settings
$contact_address = getSetting('contact_address', 'Uganda');
$contact_email = getSetting('contact_email', 'info@macdef.org');
$contact_phone = getSetting('contact_phone', '+256 000 000 000');
$office_hours = getSetting('office_hours', 'Mon - Fri: 9:00 AM - 5:00 PM');
$google_maps = getSetting('google_maps_embed');
$hero_title = getSetting('contact_hero_title', 'Get In Touch With MACDEF');
$hero_subtitle = getSetting('contact_hero_subtitle', 'We would love to hear from you. Contact us, support our mission, or partner with us in preserving culture and community development.');
?>

<!-- Section 1: Hero Banner -->
<section class="contact-hero section-padding bg-navy text-white position-relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="container position-relative z-index-2 text-center">
        <nav aria-label="breadcrumb" class="mb-4 d-flex justify-content-center">
            <ol class="breadcrumb bg-transparent p-0 m-0">
                <li class="breadcrumb-item"><a href="index.php" class="text-gold">Home</a></li>
                <li class="breadcrumb-item active text-white opacity-75" aria-current="page">Contact</li>
            </ol>
        </nav>
        <h1 class="display-3 fw-bold mb-3"><?= e($hero_title) ?></h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 800px;"><?= e($hero_subtitle) ?></p>
    </div>
</section>

<!-- Section 2: Quick Contact Cards -->
<section class="section-padding bg-white mt-n5 position-relative z-index-10">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="contact-quick-card text-center">
                    <div class="cq-icon"><i class="ri-phone-fill"></i></div>
                    <h3>Call Us</h3>
                    <p><?= e($contact_phone) ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contact-quick-card text-center">
                    <div class="cq-icon"><i class="ri-mail-fill"></i></div>
                    <h3>Email Us</h3>
                    <p><?= e($contact_email) ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contact-quick-card text-center">
                    <div class="cq-icon"><i class="ri-map-pin-2-fill"></i></div>
                    <h3>Visit Us</h3>
                    <p><?= e($contact_address) ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="contact-quick-card text-center">
                    <div class="cq-icon"><i class="ri-time-fill"></i></div>
                    <h3>Office Hours</h3>
                    <p><?= e($office_hours) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<main class="section-padding pt-0">
    <div class="container">
        <div class="row g-5">
            <!-- Section 3: Contact Form Redesign -->
            <div class="col-lg-7">
                <div class="contact-form-card bg-white p-4 p-md-5">
                    <div class="mb-4">
                        <h2 class="fw-bold text-navy">Send Us a Message</h2>
                        <p class="text-muted">Our team will respond as soon as possible.</p>
                    </div>

                    <?php if ($msg): ?>
                        <div class="alert alert-<?php echo $status === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show">
                            <?= e($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="contact_submit.php" method="POST" class="row g-3">
                        <?= csrf_field() ?>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label">First Name</label>
                                <div class="input-with-icon">
                                    <i class="ri-user-line"></i>
                                    <input type="text" name="first_name" class="form-control" placeholder="John" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label">Last Name</label>
                                <div class="input-with-icon">
                                    <i class="ri-user-line"></i>
                                    <input type="text" name="last_name" class="form-control" placeholder="Doe" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group-modern">
                                <label class="form-label">Email Address</label>
                                <div class="input-with-icon">
                                    <i class="ri-mail-line"></i>
                                    <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group-modern">
                                <label class="form-label">Subject</label>
                                <div class="input-with-icon">
                                    <i class="ri-bookmark-line"></i>
                                    <input type="text" name="subject" class="form-control" placeholder="How can we help?" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group-modern">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold shadow-sm">
                                <i class="ri-send-plane-fill me-2"></i> SEND MESSAGE
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section 4: Contact Information Card -->
            <div class="col-lg-5">
                <div class="contact-info-card bg-navy text-white p-4 p-md-5 h-100">
                    <h3 class="fw-bold mb-4 border-bottom border-gold pb-3">Contact Information</h3>

                    <div class="info-item mb-4 d-flex">
                        <div class="info-icon"><i class="ri-map-pin-2-fill"></i></div>
                        <div>
                            <h5 class="mb-1 text-gold">Our Address</h5>
                            <p class="opacity-75 mb-0"><?= e($contact_address) ?></p>
                        </div>
                    </div>

                    <div class="info-item mb-4 d-flex">
                        <div class="info-icon"><i class="ri-mail-fill"></i></div>
                        <div>
                            <h5 class="mb-1 text-gold">Email Us</h5>
                            <p class="opacity-75 mb-0"><?= e($contact_email) ?></p>
                        </div>
                    </div>

                    <div class="info-item mb-4 d-flex">
                        <div class="info-icon"><i class="ri-phone-fill"></i></div>
                        <div>
                            <h5 class="mb-1 text-gold">Call Us</h5>
                            <p class="opacity-75 mb-0"><?= e($contact_phone) ?></p>
                        </div>
                    </div>

                    <div class="info-item mb-4 d-flex">
                        <div class="info-icon"><i class="ri-time-fill"></i></div>
                        <div>
                            <h5 class="mb-1 text-gold">Office Hours</h5>
                            <p class="opacity-75 mb-0"><?= e($office_hours) ?></p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h5 class="mb-3 text-gold">Follow Us</h5>
                        <div class="social-links d-flex">
                            <a href="<?= e(getSetting('facebook_url', '#')) ?>" class="social-btn"><i class="ri-facebook-fill"></i></a>
                            <a href="<?= e(getSetting('instagram_url', '#')) ?>" class="social-btn"><i class="ri-instagram-line"></i></a>
                            <a href="<?= e(getSetting('twitter_url', '#')) ?>" class="social-btn"><i class="ri-twitter-x-fill"></i></a>
                            <a href="<?= e(getSetting('linkedin_url', '#')) ?>" class="social-btn"><i class="ri-linkedin-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 5: Google Maps Section -->
    <?php if ($google_maps): ?>
    <div class="container mt-5 pt-4">
        <div class="text-center mb-4">
            <span class="section-tag">Find Us</span>
            <h2 class="fw-bold text-navy">Our Location</h2>
        </div>
        <div class="map-container shadow-sm overflow-hidden rounded-4">
            <?php if (strpos($google_maps, '<iframe') !== false): ?>
                <div class="ratio ratio-21x9">
                    <?= $google_maps ?>
                </div>
            <?php else: ?>
                <iframe src="<?= e($google_maps) ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Section 6: CTA Section -->
    <section class="section-padding mt-5 bg-light rounded-4 mx-3">
        <div class="container text-center">
            <h2 class="display-5 fw-bold text-navy mb-3">Support Our Mission</h2>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 700px;">Join us in preserving the Ma'di cultural heritage and fostering development in our community.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="donate.php" class="btn btn-gold btn-lg px-5 py-3 fw-bold">DONATE NOW</a>
                <a href="membership_apply.php" class="btn btn-navy btn-lg px-5 py-3 fw-bold">BECOME A MEMBER</a>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
