<?php
$page_title = "Contact Us";
require_once 'includes/header.php';
?>
<section class="page-header bg-navy text-white py-5"><div class="container py-4 text-center"><h1 class="display-4 fw-bold mb-3">Contact Us</h1></div></section>
<main class="container py-5"><div class="row g-5">
    <div class="col-lg-7">
        <form action="contact_submit.php" method="POST">
            <input type="text" name="first_name" placeholder="First Name" class="form-control mb-3" required>
            <input type="text" name="last_name" placeholder="Last Name" class="form-control mb-3" required>
            <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
            <input type="text" name="subject" placeholder="Subject" class="form-control mb-3" required>
            <textarea name="message" placeholder="Message" class="form-control mb-3" required></textarea>
            <button type="submit" class="btn btn-gold w-100">Send</button>
        </form>
    </div>
    <div class="col-lg-5">
        <p><strong>Address:</strong> <?php echo getSetting('contact_address'); ?></p>
        <p><strong>Email:</strong> <?php echo getSetting('contact_email'); ?></p>
    </div>
</div></main>
<?php require_once 'includes/footer.php'; ?>
