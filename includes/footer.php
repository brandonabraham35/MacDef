<?php
$footer = db()->query("SELECT * FROM footer_settings WHERE id=1")->fetch();
?>
<footer class="footer">
    <div class="container pb-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-logo">
                    <img
                        id="macdefFooterAdminLogo"
                        src="<?= e(!empty($footer['footer_logo']) ? $footer['footer_logo'] : 'assets/images/macdef-logo.png') ?>"
                        alt="MACDEF Logo"
                        style="cursor:pointer;"
                        data-admin-url="<?= SITE_URL ?>/admin/login.php"
                        title="MACDEF"
                    >
                </div>

                <p class="text-muted mb-4"><?= e($footer['footer_description'] ?? "Ma'di Cultural and Development Foundation is dedicated to preserving heritage, empowering communities, and building a prosperous future for the Ma'di people.") ?></p>
                <div class="footer-social">
                    <?php if(!empty($footer['social_facebook'])): ?><a href="<?= e($footer['social_facebook']) ?>"><i class="ri-facebook-fill"></i></a><?php endif; ?>
                    <?php if(!empty($footer['social_instagram'])): ?><a href="<?= e($footer['social_instagram']) ?>"><i class="ri-instagram-line"></i></a><?php endif; ?>
                    <?php if(!empty($footer['social_twitter'])): ?><a href="<?= e($footer['social_twitter']) ?>"><i class="ri-twitter-x-fill"></i></a><?php endif; ?>
                    <?php if(!empty($footer['social_linkedin'])): ?><a href="<?= e($footer['social_linkedin']) ?>"><i class="ri-linkedin-fill"></i></a><?php endif; ?>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1">
                <h5 class="footer-title">Membership</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="contact.php">Membership Benefits</a></li>
                    <li><a href="contact.php">Membership Directory</a></li>
                    <li><a href="mission.php">Membership Charter</a></li>
                    <li><a href="contact.php">Membership Form</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h5 class="footer-title">Useful Links</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="mission.php">Our Story</a></li>
                    <li><a href="goals.php">What We Do</a></li>
                    <li><a href="gallery.php">Resources</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5 class="footer-title">Address & Contacts</h5>
                <ul class="footer-links list-unstyled">
                    <li class="text-muted mb-3">
                        <i class="ri-map-pin-line me-2 text-gold"></i>
                        <?= e(!empty($footer['address']) ? $footer['address'] : getSetting('contact_address', 'Uganda')) ?>
                    </li>
                    <li class="text-muted mb-3">
                        <i class="ri-mail-line me-2 text-gold"></i>
                        Email: <?= e(!empty($footer['email']) ? $footer['email'] : getSetting('contact_email', 'info@macdef.org')) ?>
                    </li>
                    <li class="text-muted">
                        <i class="ri-phone-line me-2 text-gold"></i>
                        Phone: <?= e(!empty($footer['phone']) ? $footer['phone'] : getSetting('contact_phone', '+256 000 000 000')) ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted"><?= e($footer['copyright_text'] ?? "Copyright &copy; " . date('Y') . " " . $site_name . ". All Rights Reserved") ?></p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#" class="text-muted text-decoration-none">Terms of Use</a></li>
                        <li class="list-inline-item ms-3"><a href="#" class="text-muted text-decoration-none">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const hero = document.querySelector('#macdefHero');
    if (hero) {
        new bootstrap.Carousel(hero, {
            interval: 5000,
            ride: 'carousel',
            pause: false,
            wrap: true
        });
    }

    // Admin Shortcut
    const adminLogo = document.getElementById('macdefFooterAdminLogo');
    if (adminLogo) {
        let lastTap = 0;
        const adminUrl = adminLogo.getAttribute('data-admin-url');

        adminLogo.addEventListener('dblclick', function(e) {
            e.preventDefault();
            window.location.href = adminUrl;
        });

        adminLogo.addEventListener('touchend', function(e) {
            const currentTime = new Date().getTime();
            const tapLength = currentTime - lastTap;
            if (tapLength < 450 && tapLength > 0) {
                e.preventDefault();
                window.location.href = adminUrl;
            }
            lastTap = currentTime;
        });
    }
});
</script>
<script src="assets/js/main.js"></script>
</body>
</html>
