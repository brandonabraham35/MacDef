<footer class="footer pt-5 mt-auto">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-info">
                    <img src="assets/images/macdef-logo.png" alt="MACDEF Logo" height="60" class="mb-3 brightness-0 invert">
                    <p class="mb-4">Ma'di Cultural and Development Foundation is dedicated to preserving heritage, empowering communities, and building a prosperous future for the Ma'di people.</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-title">Quick Links</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="mission.php">About Us</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">Useful Links</h5>
                <ul class="footer-links list-unstyled">
                    <li><a href="organisation.php">Our Structure</a></li>
                    <li><a href="uploads/documents/MACDEF-Organogram.pdf" target="_blank">Download Organogram</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">Contact Info</h5>
                <ul class="footer-contact list-unstyled">
                    <li class="d-flex gap-3 mb-3"><i class="ri-map-pin-fill text-gold fs-5"></i><span><?php echo e(getSetting('contact_address', 'Uganda')); ?></span></li>
                    <li class="d-flex gap-3 mb-3"><i class="ri-mail-fill text-gold fs-5"></i><span><?php echo e(getSetting('contact_email', 'info@macdef.org')); ?></span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom py-3"><div class="container text-center"><p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo e(getSetting('site_title', "Ma'di Cultural and Development Foundation")); ?>. All Rights Reserved.</p></div></div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
