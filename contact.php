<?php
$page_title = 'Contact Us';
require_once __DIR__ . '/includes/header.php';
$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';
?>
<section class="page-header bg-navy text-white py-5"><div class="container py-4 text-center"><h1 class="display-4 fw-bold mb-3">Contact Us</h1></div></section>
<main class="container py-5"><div class="row g-5">
    <div class="col-lg-7">
        <?php if ($msg): ?>
            <div class="alert alert-<?php echo $status === 'success' ? 'success' : 'danger'; ?>"><?php echo e($msg); ?></div>
        <?php endif; ?>
        <form action="contact_submit.php" method="POST">
            <input type="text" name="first_name" placeholder="First Name" class="form-control mb-3" required>
            <input type="text" name="last_name" placeholder="Last Name" class="form-control mb-3" required>
            <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
            <input type="text" name="subject" placeholder="Subject" class="form-control mb-3" required>
            <textarea name="message" placeholder="Message" class="form-control mb-3" rows="6" required></textarea>
            <button type="submit" class="btn btn-gold w-100">Send Message</button>
        </form>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h4 class="fw-bold text-navy mb-3">MACDEF Contact Information</h4>
            <p><strong>Address:</strong> <?php echo e(getSetting('contact_address', 'Uganda')); ?></p>
            <p><strong>Email:</strong> <?php echo e(getSetting('contact_email', 'info@macdef.org')); ?></p>
            <p><strong>Phone:</strong> <?php echo e(getSetting('contact_phone', '+256 000 000 000')); ?></p>
        </div>
    </div>
</div></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
