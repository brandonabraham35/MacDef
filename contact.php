<?php
$page_title = 'Contact Us';
require_once __DIR__ . '/includes/header.php';
$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';
?>
<section class="section-padding bg-light">
    <div class="container text-center">
        <span class="section-tag">Get in touch</span>
        <h1 class="display-4 fw-bold mb-3 text-navy">Contact Us</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">Have questions about our programs or want to get involved? Send us a message and we'll get back to you as soon as possible.</p>
    </div>
</section>

<main class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="bg-white p-4 p-md-5 shadow-sm border">
                    <h3 class="fw-bold mb-4 text-navy">Send us a Message</h3>
                    <?php if ($msg): ?>
                        <div class="alert alert-<?php echo $status === 'success' ? 'success' : 'danger'; ?>"><?php echo e($msg); ?></div>
                    <?php endif; ?>
                    <form action="contact_submit.php" method="POST" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">First Name</label>
                            <input type="text" name="first_name" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Last Name</label>
                            <input type="text" name="last_name" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase">Subject</label>
                            <input type="text" name="subject" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase">Message</label>
                            <textarea name="message" class="form-control form-control-lg bg-light border-0" rows="5" required></textarea>
                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-gold btn-lg px-5">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="bg-navy text-white p-4 p-md-5 h-100">
                    <h3 class="fw-bold mb-4">Contact Information</h3>

                    <div class="d-flex mb-4">
                        <div class="me-3">
                            <i class="ri-map-pin-2-fill fs-3 text-gold"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Our Address</h5>
                            <p class="opacity-75 mb-0"><?= e(getSetting('contact_address', 'Uganda')) ?></p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="me-3">
                            <i class="ri-mail-fill fs-3 text-gold"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Email Us</h5>
                            <p class="opacity-75 mb-0"><?= e(getSetting('contact_email', 'info@macdef.org')) ?></p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="me-3">
                            <i class="ri-phone-fill fs-3 text-gold"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Call Us</h5>
                            <p class="opacity-75 mb-0"><?= e(getSetting('contact_phone', '+256 000 000 000')) ?></p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h5 class="mb-3">Follow Us</h5>
                        <div class="footer-social d-flex">
                            <a href="<?= e(getSetting('facebook_url', '#')) ?>" class="bg-white-transparent me-2 text-white border p-2 rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;"><i class="ri-facebook-fill"></i></a>
                            <a href="<?= e(getSetting('instagram_url', '#')) ?>" class="bg-white-transparent me-2 text-white border p-2 rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;"><i class="ri-instagram-line"></i></a>
                            <a href="<?= e(getSetting('twitter_url', '#')) ?>" class="bg-white-transparent me-2 text-white border p-2 rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;"><i class="ri-twitter-x-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
